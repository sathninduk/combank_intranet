<?php
/*
Plugin Name: Active Directory Integration for Intranet sites
Plugin URI: https://miniorange.com
Description: Active Directory Integration for Intranet sites plugin provides login to WordPress using credentials stored in your Active Directory / other LDAP Directory.
Author: miniOrange
Version: 3.7.1
Author URI: https://miniorange.com
*/

require_once 'mo_ldap_pages.php';
require_once 'Plugin-tour-UI.php';
require('mo_ldap_support.php');
require('class-mo-ldap-customer-setup.php');
require('class-mo-ldap-utility.php');
require('class-mo-ldap-config.php');
require('class-mo-ldap-role-mapping.php');
require ('mo_ldap_licensing_plans.php');
require('ldap_feedback_form.php');
require_once "PointersManager_ldap.php";
require_once dirname( __FILE__ ) . '/includes/lib/Mo_Pointer_Ldap.php';
require_once dirname( __FILE__ ) . '/includes/lib/export.php';

define( "Tab_ldap_Class_Names", serialize( array(
    "ldap_Login"  => 'mo_options_ldap_acc_details',
    "ldap_config" => 'mo_options_ldap_config_details',
) ) );


class MoLdapLocalLogin
{

    const LDAPFIELDS = 'All the fields are required. Please enter valid entries.';
    const LDAPCONN = 'LDAP CONNECTION TEST';
    function __construct()
    {
        $current_version = '3.7.1';
        add_option('mo_ldap_local_register_user', 1);
        add_option('mo_ldap_local_cust', 0);
        add_action('admin_menu', array($this, 'mo_ldap_local_login_widget_menu'));
        add_action('admin_init', array($this, 'login_widget_save_options'));
        add_action('init', array($this, 'test_attribute_configuration'));
        add_action('admin_enqueue_scripts', array($this, 'mo_ldap_local_settings_style'));
        add_action('admin_enqueue_scripts', array($this, 'mo_ldap_local_settings_script'));
        remove_action('admin_notices', array($this, 'success_message'));
        remove_action('admin_notices', array($this, 'error_message'));
        register_deactivation_hook(__FILE__, array($this, 'mo_ldap_local_deactivate'));
        add_action('show_user_profile', array($this, 'show_user_profile'));
        if (get_option('mo_ldap_local_enable_login') == 1) {
            remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
            remove_filter('authenticate', 'wp_authenticate_email_password', 20, 3);
            add_filter('authenticate', array($this, 'ldap_login'), 7, 3);
        }

        $version_in_db = get_option('mo_ldap_local_current_plugin_version');
        if($version_in_db!=$current_version){
            update_option('mo_ldap_local_current_plugin_version',$current_version);
        }
        register_activation_hook(__FILE__, array($this, 'mo_ldap_activate'));
        add_action('admin_footer', array($this, 'ldap_feedback_request'));
    }

    function ldap_feedback_request()
    {
        display_ldap_feedback_form();
    }

    function show_user_profile($user)
    {

        if ($this->is_administrator_user($user)) {
            ?>
            <h3>Extra profile information</h3>

            <table class="form-table" aria-hidden="true">

                <tr>
                    <td><strong><label for="user_dn">User DN</label></strong></td>

                    <td>
                        <strong><?php echo esc_attr(get_the_author_meta('mo_ldap_user_dn', $user->ID)); ?></strong></td>
                </tr>
            </table>

            <?php
        }
    }


    function ldap_login($wpuser, $username, $password)
    {

        if (empty($username) || empty ($password)) {
            $error = new WP_Error();

            if (empty($username)) {
                $error->add('empty_username', __('<strong>ERROR</strong>: Email field is empty.'));
            }

            if (empty($password)) {
                $error->add('empty_password', __('<strong>ERROR</strong>: Password field is empty.'));
            }
            return $error;
        }


        $enable_wp_admin_login = get_option('mo_ldap_local_enable_admin_wp_login');
        if ($enable_wp_admin_login == 1 && username_exists($username)) {
                $user = get_user_by("login", $username);
                if ($user && $this->is_administrator_user($user) && wp_check_password($password, $user->data->user_pass, $user->ID)){
                        return $user;
                }
        }

        $mo_ldap_local_ldap_username_attribute = get_option("mo_ldap_local_username_attribute");
        $mo_ldap_local_ldap_email_domain=get_option("mo_ldap_local_email_domain");

        $mo_ldap_config = new MoLdapLocalConfig();
        $auth_response = $mo_ldap_config->ldap_login($username, $password);

        if ($auth_response->statusMessage == 'LDAP_USER_BIND_SUCCESS') {

            if (username_exists($username) || email_exists($username)) {
                $user = get_user_by("login", $username);
                if (empty($user)) {
                    $user = get_user_by("email", $username);
                }
                if (empty($user)) {
					$this->mo_ldap_report_update($username,'ERROR','<strong>Login Error:</strong> Invalid Username/Password combination');
                    $error = new WP_Error();
                    $error->add('error_fetching_user', __('<strong>ERROR</strong>: Invalid Username/Password combination.'));
                    return $error;
                }

                if(get_option('mo_ldap_local_enable_role_mapping')) {
                    $mo_ldap_role_mapping = new MoLdapLocalRoleMapping();
                    $mo_ldap_role_mapping->mo_ldap_local_update_role_mapping($user->ID);
                }


                update_user_meta($user->ID, 'mo_ldap_user_dn', $auth_response->userDn, false);

                $profile_attributes = $auth_response->profileAttributesList;


                $user_data['ID'] = $user->ID;
                if(!empty($profile_attributes['mail'])) {
                    $user_data['user_email'] = $profile_attributes['mail'];
                }

                if(strcasecmp($mo_ldap_local_ldap_username_attribute,"samaccountname")==0 && !empty($mo_ldap_local_ldap_email_domain) && empty($profile_attributes['mail']))
                {
                        $user_data['user_email'] = $username . '@' . $mo_ldap_local_ldap_email_domain;
                }

                wp_update_user($user_data);
                return $user;
            } else {

                if (!get_option('mo_ldap_local_register_user')) {
					 $this->mo_ldap_report_update($username,'ERROR','<strong>Login Error:</strong> Your Administrator has not enabled Auto Registration. Please contact your Administrator.');
                    $error = new WP_Error();
                    $error->add('registration_disabled_error', __('<strong>ERROR</strong>: Your Administrator has not enabled Auto Registration. Please contact your Administrator.'));
                    return $error;
                } else {
                    $user_password = wp_generate_password(10, false);
                    $profile_attributes = $auth_response->profileAttributesList;

                    $email = !empty($profile_attributes['mail'])?$profile_attributes['mail']:'';

                    if(strcasecmp($mo_ldap_local_ldap_username_attribute,"samaccountname")==0 && !empty($mo_ldap_local_ldap_email_domain) && empty($profile_attributes['mail']))
                    {
                            $email = $username . '@' . $mo_ldap_local_ldap_email_domain;
                    }


                    $userdata = array(
                        'user_login' => $username,
                        'user_email' => $email,
                        'user_pass' => $user_password
                    );
                    $user_id = wp_insert_user($userdata);

                    if (!is_wp_error($user_id)) {
                        $user = get_user_by("login", $username);

                        update_user_meta($user->ID, 'mo_ldap_user_dn', $auth_response->userDn, false);

                        if(get_option('mo_ldap_local_enable_role_mapping')) {
                            $mo_ldap_role_mapping = new MoLdapLocalRoleMapping();
                            $mo_ldap_role_mapping->mo_ldap_local_update_role_mapping($user->ID);
                        }

                        return $user;
                    } else {
                        $error_string = $user_id->get_error_message();
                        $email_exists_error = "Sorry, that email address is already used!";
                        if (email_exists($email) && $error_string == $email_exists_error) {
                            $error = new WP_Error();
                            $this->mo_ldap_report_update($username, $auth_response->statusMessage, '<strong>Login Error:</strong> There was an error registering your account. The email is already registered, please choose another one and try again.');
                            $error->add('registration_error', __('<strong>ERROR</strong>: There was an error registering your account. The email is already registered, please choose another one and try again.'));
                            return $error;
                        }else{
                            $error = new WP_Error();
                            $this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> There was an error registering your account. Please try again.');
                            $error->add('registration_error', __('<strong>ERROR</strong>: There was an error registering your account. Please try again.'));
                            return $error;
                        }
                    }
                }
            }
        } elseif ($auth_response->statusMessage == 'LDAP_USER_BIND_ERROR' || $auth_response->statusMessage == 'LDAP_USER_NOT_EXIST') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> Invalid username or password entered.');
            $error = new WP_Error();
            $error->add('LDAP_USER_BIND_ERROR', __('<strong>ERROR</strong>: Invalid username or password entered.'));
            return $error;
        } elseif ($auth_response->statusMessage == 'LDAP_ERROR') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> <a target="_blank" rel="noopener" href="http://php.net/manual/en/ldap.installation.php">PHP LDAP extension</a> is not installed or disabled. Please enable it.');
            $error = new WP_Error();
            $error->add('LDAP_ERROR', __('<strong>ERROR</strong>: <a target="_blank" rel="noopener" href="http://php.net/manual/en/ldap.installation.php">PHP LDAP extension</a> is not installed or disabled. Please enable it.'));
            return $error;
        } elseif ($auth_response->statusMessage == 'OPENSSL_ERROR') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> <a target="_blank" rel="noopener" href="http://php.net/manual/en/openssl.installation.php">PHP OpenSSL extension</a> is not installed or disabled.');
            $error = new WP_Error();
            $error->add('OPENSSL_ERROR', __('<strong>ERROR</strong>: <a target="_blank" rel="noopener" href="http://php.net/manual/en/openssl.installation.php">PHP OpenSSL extension</a> is not installed or disabled.'));
            return $error;
        } elseif ($auth_response->statusMessage == 'LDAP_PING_ERROR') {
            $this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error: </strong> LDAP server is not responding ');
            $error = new WP_Error();
            $error->add('LDAP_PING_ERROR', __('<strong>ERROR</strong>:LDAP server is not reachable. Fallback to local wordpress authentication is not supported.'));
        } else {
            $error = new WP_Error();
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,"<strong>Login Error:</strong> Unknown error occurred during authentication. Please contact your administrator.");
            $error->add('UNKNOWN_ERROR', __('<strong>ERROR</strong>: Unknown error occurred during authentication. Please contact your administrator.'));
            return $error;
        }
    }

    function mo_ldap_local_login_widget_menu()
    {
        add_menu_page('LDAP/AD Login for Intranet', 'LDAP/AD Login for Intranet', 'activate_plugins', 'mo_ldap_local_login', array($this, 'mo_ldap_local_login_widget_options'), plugin_dir_url(__FILE__) . 'includes/images/miniorange_icon.png');
        add_submenu_page( 'mo_ldap_local_login'	,'LDAP/AD plugin','Licensing Plans','manage_options','mo_ldap_local_login&amp;tab=pricing', array( $this, 'mo_ldap_show_licensing_page'));

    }

    function mo_ldap_local_login_widget_options()
    {
        update_option('mo_ldap_local_host_name', 'https://login.xecurify.com');

        if (!get_option('load_static_UI')) {
            add_option('load_static_UI','true');
        }
        if (get_option('load_static_UI') && get_option('load_static_UI') == 'true') {
            plugin_tour_ui();
        } else {
            mo_ldap_local_settings();
        }
    }

    public static function checkPasswordpattern($password){
        $pattern = '/^[(\w)*(\!\@\#\$\%\^\&\*\.\-\_)*]+$/';

        return !preg_match($pattern,$password);
    }

    function create_customer() {
        $customer    = new MoLdapLocalCustomer();
        $customerKey = $customer->create_customer();

        $response = array();

        if (!empty($customerKey)) {
            $customerKey = json_decode($customerKey,true);

          if (strcasecmp($customerKey['status'],'CUSTOMER_USERNAME_ALREADY_EXISTS') == 0) {
              $api_response = $this->get_current_customer();
                  if($api_response){
                      $response['status'] = "SUCCESS";
                  }
                  else {
                $response['status'] = "ERROR";
                  }
            } elseif (strcasecmp($customerKey['status'], 'SUCCESS') == 0 && strpos($customerKey['message'], 'Customer successfully registered.') !== false) {
                $this->save_success_customer_config($customerKey['id'], $customerKey['apiKey'], $customerKey['token'], 'Thanks for registering with the miniOrange.');
                $response['status'] = "SUCCESS";
                return $response;
            }
            update_option('mo_ldap_local_password', '');
        return $response;
    }
    }

    function get_current_customer() {
        $customer    = new MoLdapLocalCustomer();
        $content     = $customer->get_customer_key();

        $response = array();

        if (!empty($content)) {
            $customerKey = json_decode($content, true);
            if (json_last_error() == JSON_ERROR_NONE) {
                $this->save_success_customer_config($customerKey['id'], $customerKey['apiKey'], $customerKey['token'], 'Your account has been retrieved successfully.');
                update_option('mo_ldap_local_password', '');
                $response['status'] = "SUCCESS";
            }else{
                update_option('mo_ldap_local_message', 'You already have an account with miniOrange. Please enter a valid password.');
                $this->show_error_message();
            }
        }
        }

    function login_widget_save_options()
    {
        if (isset($_POST['option'])) {
            $post_option = sanitize_text_field(trim($_POST['option']));
            if ($post_option == "mo_ldap_local_register_customer" && check_admin_referer('mo_ldap_local_register_customer')) {
                $phone = '';
                if (MoLdapLocalUtil::check_empty_or_null($_POST['email']) || MoLdapLocalUtil::check_empty_or_null($_POST['password'])) {
                    update_option('mo_ldap_local_message', MoLdapLocalLogin::LDAPFIELDS);
                    $this->show_error_message();
                    return;
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    update_option('mo_ldap_local_message', 'Please enter a valid email address.');
                    $this->show_error_message();
                    return;
                } elseif ($this->checkPasswordpattern(strip_tags($_POST['password']))) {
                    update_option('mo_ldap_local_message', 'Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*-_) should be present.');
                    $this->show_error_message();
                    return;
                } else {
                    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
                    $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
                    $confirmPassword = isset($_POST['confirmPassword']) ? sanitize_text_field($_POST['confirmPassword']) : '';
                }

                update_option('mo_ldap_local_admin_email', $email);

                if (strcmp($password, $confirmPassword) == 0) {
                    update_option('mo_ldap_local_password', $password);
                    $customer = new MoLdapLocalCustomer();
                    $content = $customer->check_customer();

                    if (!empty($content)) {
                        $content = json_decode($content, true);

                        if (strcasecmp($content['status'], 'CUSTOMER_NOT_FOUND') == 0) {
                            $content = $this->create_customer();
                            if (is_array($content) && array_key_exists('status', $content) && $content['status'] == 'SUCCESS') {
                                $pricing_url = add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] );
                                $message = 'Your account has been created successfully. <a href="' . esc_url($pricing_url) . '">Click here to see our Premium Plans</a> ';
                                update_option('mo_ldap_local_message', $message);
                                $this->show_success_message();
                                return;
                            }
                        } else {
                            $response = $this->get_current_customer();
                            if (is_array($response) && array_key_exists('status', $response) && $response['status'] == 'SUCCESS') {
                                $pricing_url = add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] );
                                $message = 'Your account has been retrieved successfully. <a href="' . esc_url($pricing_url) . '">Click here to see our Premium Plans</a> ';
                                update_option('mo_ldap_local_message', $message);
                                $this->show_success_message();
                                return;
                            }
                        }
                    }
                } else {
                    update_option('mo_ldap_local_message', 'Password and Confirm password do not match.');
                    delete_option('mo_ldap_local_verify_customer');
                    $this->show_error_message();
                    return;
                }

            } elseif ($post_option == "mo_ldap_local_verify_customer" && check_admin_referer('mo_ldap_local_verify_customer')) {
                $email = '';
                $password = '';
                if (MoLdapLocalUtil::check_empty_or_null($_POST['email']) || MoLdapLocalUtil::check_empty_or_null($_POST['password'])) {
                    update_option('mo_ldap_local_message', MoLdapLocalLogin::LDAPFIELDS);
                    $this->show_error_message();
                    return;
                } else {
                    $email = isset($_POST['email'])?sanitize_email($_POST['email']):'';
                    $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
                }

                update_option('mo_ldap_local_admin_email', $email);
                update_option('mo_ldap_local_password', $password);

                $customer    = new MoLdapLocalCustomer();
                $content     = $customer->get_customer_key();

                if(!is_null($content)) {
                    $customerKey = json_decode($content, true);
                    if (json_last_error() == JSON_ERROR_NONE) {
                        $this->save_success_customer_config($customerKey['id'], $customerKey['apiKey'], $customerKey['token'], 'Your account has been retrieved successfully.');
                    }
                    else {
                        $message = 'Invalid username or password. Please try again.';
                    update_option('mo_ldap_local_message', $message);
                    $this->show_error_message();
                    }
                    update_option( 'mo_ldap_local_password', '' );
                }
            }elseif($post_option == "clear_ldap_pointers"){
                $uid = get_current_user_id();
                $Ldap_array_dissmised_pointers = explode( ',', (string) get_user_meta( $uid, 'dismissed_wp_pointers', TRUE ) );
                if ( isset( $_GET['tab'] ) ) {
                    $active_tab = sanitize_text_field($_GET['tab']);
                }else {
                    $active_tab = 'default';
                }
                if (isset($_POST['restart_plugin_tour']) && sanitize_text_field($_POST['restart_plugin_tour'])=='true') {
                    update_option('overall_plugin_tour','true');
                    update_option('load_static_UI','true');
                    $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers,MoLdapEnumPointers::$LDAP_PLUGIN_TOUR);
                    unset($Ldap_array_dissmised_pointers[array_search('custom_admin_pointers4_8_52_miniorange-support-ldap',$Ldap_array_dissmised_pointers)]);
                }
                elseif (isset($_POST['restart_tour']) && sanitize_text_field($_POST['restart_tour'])=='true') {
                    if (get_option('load_static_UI') && get_option('load_static_UI') == 'true')
                    {
                         update_option('load_static_UI','false');
                    }
                    if($active_tab == 'default') {
                        $remaining_dismissed_pointers = array_diff(MoLdapEnumPointers::$SERVICE_PROVIDER_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }

                    elseif ($active_tab == 'rolemapping') {
                        $remaining_dismissed_pointers = array_diff(MoLdapEnumPointers::$ROLE_MAPPING_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }
                    elseif ($active_tab == 'attributemapping') {
                        $remaining_dismissed_pointers = array_diff(MoLdapEnumPointers::$ATTRIBUTE_MAPPING_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }
                    elseif ($active_tab == 'config_settings') {
                        $remaining_dismissed_pointers = array_diff(MoLdapEnumPointers::$EXPORT_IMPORT_CONFIG_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }
                }
                else {
                    if ($active_tab == 'default') {
                        update_option('restart_ldap_tour','true');
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, MoLdapEnumPointers::$SERVICE_PROVIDER_LDAP);
                    }
                    elseif ($active_tab == 'rolemapping') {
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, MoLdapEnumPointers::$ROLE_MAPPING_LDAP);
                    }
                    elseif ($active_tab == 'attributemapping') {
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, MoLdapEnumPointers::$ATTRIBUTE_MAPPING_LDAP);
                    }
                    elseif ($active_tab == 'config_settings') {
                        update_option('config_settings_tour','true');
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, MoLdapEnumPointers::$EXPORT_IMPORT_CONFIG_LDAP);
                    }
                }
                update_user_meta($uid,'dismissed_wp_pointers',implode(",",$Ldap_array_dissmised_pointers));
                return;
            } 
            elseif ($post_option == "mo_ldap_local_enable" && check_admin_referer('mo_ldap_local_enable') && current_user_can('manage_options')) {

                $enable_ldap_login = (isset($_POST['enable_ldap_login']) && sanitize_text_field($_POST['enable_ldap_login'])==1) ? 1 : 0;

                update_option('mo_ldap_local_enable_login', $enable_ldap_login);
                update_option('mo_ldap_local_enable_admin_wp_login', $enable_ldap_login);

                if (get_option('mo_ldap_local_enable_login')) {
                    update_option('mo_ldap_local_message', 'Login through your LDAP has been enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'Login through your LDAP has been disabled.');
                    $this->show_error_message();
                }

            } elseif($post_option == 'user_report_logs' && check_admin_referer('user_report_logs')){

                $enable_user_report_logs = (isset($_POST['mo_ldap_local_user_report_log']) && sanitize_text_field($_POST['mo_ldap_local_user_report_log'])==1)? 1 : 0;

                update_option( 'mo_ldap_local_user_report_log', $enable_user_report_logs);
                $user_logs_table_exists = get_option('user_logs_table_exists');
                $user_reporting = get_option('mo_ldap_local_user_report_log');
                if($user_reporting == 1 && $user_logs_table_exists != 1) {
                    $this->prefix_update_table();
                }

            } elseif ($post_option == "mo_ldap_local_register_user" && check_admin_referer('mo_ldap_local_register_user') && current_user_can('manage_options')) {

                $enable_user_auto_register = (isset($_POST['mo_ldap_local_register_user']) && sanitize_text_field($_POST['mo_ldap_local_register_user'])==1)? 1:0;

                update_option('mo_ldap_local_register_user', $enable_user_auto_register);
                if (get_option('mo_ldap_local_register_user')) {
                    update_option('mo_ldap_local_message', 'Auto Registering users has been enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'Auto Registering users has been disabled.');
                    $this->show_error_message();
                }

            } elseif ($post_option == "mo_ldap_local_save_config" && check_admin_referer('mo_ldap_local_save_config') && current_user_can('manage_options')) {
                $server_name = '';
                $dn = '';
                $admin_ldap_password = '';
                if (MoLdapLocalUtil::check_empty_or_null($_POST['ldap_server']) || MoLdapLocalUtil::check_empty_or_null($_POST['dn']) || MoLdapLocalUtil::check_empty_or_null($_POST['admin_password']) || MoLdapLocalUtil::check_empty_or_null($_POST['mo_ldap_protocol']) || MoLdapLocalUtil::check_empty_or_null($_POST['mo_ldap_server_port_no'])) {
                    update_option('mo_ldap_local_message', MoLdapLocalLogin::LDAPFIELDS);
                    $this->show_error_message();
                    return;
                } else {
                    $ldap_protocol = isset($_POST['mo_ldap_protocol']) ? sanitize_text_field($_POST['mo_ldap_protocol']):'';
                    $port_number = isset($_POST['mo_ldap_server_port_no'])?sanitize_text_field($_POST['mo_ldap_server_port_no']):'';
                    $server_address = isset($_POST['ldap_server'])?sanitize_text_field($_POST['ldap_server']):'';
                    $server_name = $ldap_protocol."://".$server_address.":".$port_number;
                    $dn = isset($_POST['dn']) ?sanitize_text_field($_POST['dn']):'';
                    $admin_ldap_password = isset($_POST['admin_password'])?sanitize_text_field($_POST['admin_password']):'';
                     
                }

                if (!MoLdapLocalUtil::is_extension_installed('openssl')) {
                    update_option('mo_ldap_local_message', 'PHP openssl extension is not installed or disabled. Please enable it first.');
                    $this->show_error_message();
                } else {
                    $directory_server_value = isset($_POST['mo_ldap_directory_server_value'])?sanitize_text_field($_POST['mo_ldap_directory_server_value']):'';
                    if (strcasecmp($directory_server_value,'other')==0){
                        $directory_server_custom_value = isset($_POST['mo_ldap_directory_server_custom_value']) && !empty($_POST['mo_ldap_directory_server_custom_value']) ? sanitize_text_field($_POST['mo_ldap_directory_server_custom_value']) : 'other';
                        update_option('mo_ldap_directory_server_custom_value', $directory_server_custom_value);
                    }
                    update_option('mo_ldap_directory_server_value',$directory_server_value);

                    if(strcasecmp($directory_server_value,"msad")==0){
                        $directory_server = "Microsoft Active Directory";
                    }elseif (strcasecmp($directory_server_value,"openldap")==0){
                        $directory_server = "OpenLDAP";
                    }elseif (strcasecmp($directory_server_value,"freeipa")==0){
                        $directory_server = "FreeIPA";
                    }elseif (strcasecmp($directory_server_value,"jumpcloud")==0){
                        $directory_server = "JumpCloud";
                    }elseif (strcasecmp($directory_server_value,"other")==0){
                        $directory_server = get_option("mo_ldap_directory_server_custom_value");
                    }else{
                        $directory_server = "Not Configured";
                    }

                    update_option('mo_ldap_local_directory_server',$directory_server);
                    update_option('mo_ldap_local_ldap_protocol',$ldap_protocol);
                    update_option('mo_ldap_local_ldap_server_address',MoLdapLocalUtil::encrypt($server_address));
                    if ($ldap_protocol == "ldap") {
                    update_option('mo_ldap_local_ldap_port_number',$port_number);
                    } elseif($ldap_protocol == "ldaps") {
                        update_option('mo_ldap_local_ldaps_port_number',$port_number);
                    }

                    update_option('mo_ldap_local_server_url', MoLdapLocalUtil::encrypt($server_name));
                    update_option('mo_ldap_local_server_dn', MoLdapLocalUtil::encrypt($dn));
                    update_option('mo_ldap_local_server_password', MoLdapLocalUtil::encrypt($admin_ldap_password));

                    delete_option('mo_ldap_local_message');
					update_option('refresh',0);
                    $mo_ldap_config = new MoLdapLocalConfig();

                    $content = $mo_ldap_config->test_connection();
                    $response = json_decode($content, true);
                    if (isset($response['statusCode']) && strcasecmp($response['statusCode'], 'BIND_SUCCESS') == 0) {
                        add_option('mo_ldap_local_save_config_status','VALID','','no');
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_success_message();
                    } elseif (isset($response['statusCode']) && strcasecmp($response['statusCode'], 'BIND_ERROR') == 0) {
                        $this->mo_ldap_report_update(MoLdapLocalLogin::LDAPCONN,'ERROR','<strong>Test Connection Error: </strong>'. $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (isset($response['statusCode']) && strcasecmp($response['statusCode'], 'PING_ERROR') == 0) {
                        $this->mo_ldap_report_update(MoLdapLocalLogin::LDAPCONN,'ERROR','<strong>Test Connection Error: </strong>Cannot connect to LDAP Server. Make sure you have entered correct LDAP server hostname or IP address.');
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (isset($response['statusCode']) && strcasecmp($response['statusCode'], 'LDAP_ERROR') == 0) {
                        $this->mo_ldap_report_update(MoLdapLocalLogin::LDAPCONN,'ERROR','<strong>Test Connection Error: </strong>'. $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (isset($response['statusCode']) && strcasecmp($response['statusCode'], 'OPENSSL_ERROR') == 0) {
                        $this->mo_ldap_report_update(MoLdapLocalLogin::LDAPCONN,'ERROR','<strong>Test Connection Error: </strong>'. $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (isset($response['statusCode']) && strcasecmp($response['statusCode'], 'ERROR') == 0){
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->mo_ldap_report_update(MoLdapLocalLogin::LDAPCONN,'Error','<strong>Test Connection Error: </strong>'. $response['statusMessage']);
                        $this->show_error_message();
                    }


                }
            } elseif ($post_option == "mo_ldap_local_save_user_mapping" && check_admin_referer('mo_ldap_local_save_user_mapping') && current_user_can('manage_options')) {
                
                delete_option('mo_ldap_local_user_mapping_status');

                if (MoLdapLocalUtil::check_empty_or_null($_POST['search_base'])) {
                    update_option('mo_ldap_local_message', MoLdapLocalLogin::LDAPFIELDS);
                     add_option('mo_ldap_local_user_mapping_status','INVALID','','no');
                    $this->show_error_message();
                    return;
                } else {
                    $search_base = isset($_POST['search_base'])?sanitize_text_field($_POST['search_base']):'';
                        if (strpos($search_base, ';')) {
                            $pricing_url = add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] );
                            $message = 'You have entered multiple search bases. Multiple Search Bases are supported in the <strong>Premium version</strong> of the plugin. <a href="' . esc_url($pricing_url) . '">Click here to upgrade</a>.';
                            update_option('mo_ldap_local_message', $message);
                            $this->show_error_message();
                            return;
                        }
                }

                if (!MoLdapLocalUtil::is_extension_installed('openssl')) {
                    update_option('mo_ldap_local_message', 'PHP OpenSSL extension is not installed or disabled. Please enable it first.');
                     add_option('mo_ldap_local_user_mapping_status','INVALID','','no');
                    $this->show_error_message();
                } else {
                    $ldap_username_attribute = isset($_POST['ldap_username_attribute'])?sanitize_text_field($_POST['ldap_username_attribute']):'';
                    if (!MoLdapLocalUtil::check_empty_or_null($ldap_username_attribute)) {
                        update_option('mo_ldap_local_username_attribute',$ldap_username_attribute);
                        if ($ldap_username_attribute == 'custom_ldap_attribute') {
                            $custom_ldap_username_attribute = isset($_POST['custom_ldap_username_attribute'])?sanitize_text_field($_POST['custom_ldap_username_attribute']):'';
                            if(MoLdapLocalUtil::check_empty_or_null($custom_ldap_username_attribute)){
                                $directory_server_value = get_option('mo_ldap_directory_server_value');
                                if($directory_server_value == 'openldap' || $directory_server_value == 'freeipa' ){
                                    $ldap_username_attribute = "uid";
                                }
                                else{
                                    $ldap_username_attribute = "samaccountname";
                                }
                            }else{
                            $multiple_username_attributes = explode(';',$custom_ldap_username_attribute);
                            if (count($multiple_username_attributes) > 1) {
                                $pricing_url = add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] );
                                $message = 'You have entered multiple attributes for "Username Attribute" field. Logging in with multiple attributes are supported in the <strong>Premium version</strong> of the plugin. <a href="' . esc_url($pricing_url) . '">Click here to upgrade</a> ';
                                update_option('mo_ldap_local_message', $message);
                                $this->show_error_message();
                                return;
                            } else {
                                $ldap_username_attribute = $custom_ldap_username_attribute;
                            }
                            }
                        }
                        $generated_search_filter = '(&(objectClass=*)(' . $ldap_username_attribute . '=?))';
                        update_option('Filter_search', $ldap_username_attribute);
                        update_option('mo_ldap_local_search_filter', MoLdapLocalUtil::encrypt($generated_search_filter));
                    }

                    update_option('mo_ldap_local_search_base', MoLdapLocalUtil::encrypt($search_base));
                    delete_option('mo_ldap_local_message');
                    $message = 'LDAP User Mapping Configuration has been saved. Please proceed for Test Authentication to verify LDAP user authentication.';
                    add_option('mo_ldap_local_message', $message, '', 'no');
                    add_option('mo_ldap_local_user_mapping_status','VALID','','no');
                    $this->show_success_message();
					update_option('import_flag', 1);
                }
            }elseif($post_option == "mo_ldap_save_attribute_config" && check_admin_referer('mo_ldap_save_attribute_config') && current_user_can('manage_options')){
                $email_attribute= isset($_POST['mo_ldap_email_attribute'])?sanitize_text_field($_POST['mo_ldap_email_attribute']):'';
                $email_domain = isset($_POST['mo_ldap_email_domain'])?sanitize_text_field($_POST['mo_ldap_email_domain']):'';
                $domain_validation_regex = "/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/";
                if(!preg_match($domain_validation_regex,$email_domain) && !empty($email_domain))
                {
                    update_option( 'mo_ldap_local_message', 'Please enter the domain name in valid format');
                    $this->show_error_message();
                }else{
                    update_option("mo_ldap_local_email_attribute",$email_attribute);
                    update_option("mo_ldap_local_email_domain",$email_domain);
                    update_option( 'mo_ldap_local_message', 'Successfully saved LDAP Attribute Configuration');
                    $this->show_success_message();
                }
                
            }elseif($post_option == "mo_ldap_local_enable_role_mapping" && check_admin_referer('mo_ldap_local_enable_role_mapping') && current_user_can('manage_options')){

                $enable_role_mapping = (isset($_POST['enable_ldap_role_mapping']) && sanitize_text_field($_POST['enable_ldap_role_mapping'])==1)? 1 : 0;
                update_option('mo_ldap_local_enable_role_mapping', $enable_role_mapping);
                if ($enable_role_mapping == 1) {
                    update_option('mo_ldap_local_message', 'LDAP to WP role mapping has been enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'LDAP to WP role mapping has been disabled.');
                    $this->show_error_message();
                }
            }
            elseif($post_option == "mo_ldap_local_save_mapping" && check_admin_referer('mo_ldap_local_save_mapping') && current_user_can('manage_options')){

                if (isset($_POST['mapping_value_default'])) {
                    update_option('mo_ldap_local_mapping_value_default', sanitize_text_field($_POST['mapping_value_default']));
                }

                $statusMessage = '';
                $enable_role_mapping = get_option('mo_ldap_local_enable_role_mapping');
                if ($enable_role_mapping == 0) {
                    $statusMessage = ' Please check <strong>"Enable Role Mapping"</strong> to activate it.';
                }
                update_option('mo_ldap_local_message', 'Default WP role has been updated.' . $statusMessage);
                $this->show_success_message();
            }
            elseif ($post_option == "mo_ldap_local_test_auth" && check_admin_referer('mo_ldap_local_test_auth')) {
                $server_name = get_option('mo_ldap_local_server_url');
                $dn = get_option('mo_ldap_local_server_dn');
                $admin_ldap_password = get_option('mo_ldap_local_server_password');
                $search_base = get_option('mo_ldap_local_search_base');
                $search_filter = get_option('mo_ldap_local_search_filter');

                delete_option('mo_ldap_local_message');

                if (MoLdapLocalUtil::check_empty_or_null($_POST['test_username']) || MoLdapLocalUtil::check_empty_or_null($_POST['test_password'])) {
					$this->mo_ldap_report_update('Test Authentication ','ERROR','<strong>ERROR</strong>: All the fields are required. Please enter valid entries.');
                    add_option('mo_ldap_local_message', MoLdapLocalLogin::LDAPFIELDS);
                    $this->show_error_message();
                    return;
                }
                elseif (MoLdapLocalUtil::check_empty_or_null($server_name) || MoLdapLocalUtil::check_empty_or_null($dn) || MoLdapLocalUtil::check_empty_or_null($admin_ldap_password) || MoLdapLocalUtil::check_empty_or_null($search_base) || MoLdapLocalUtil::check_empty_or_null($search_filter)) {
					$this->mo_ldap_report_update('Test authentication','ERROR','<strong>Test Authentication Error</strong>: Please save LDAP Configuration to test authentication.');
                    add_option('mo_ldap_local_message', 'Please save LDAP Configuration to test authentication.', '', 'no');
                    $this->show_error_message();
                    return;
                } else {
                    $test_username = isset($_POST['test_username']) ? sanitize_text_field($_POST['test_username']):'';
                    $test_password = isset($_POST['test_password'])?sanitize_text_field($_POST['test_password']):'';
                }
                $mo_ldap_config = new MoLdapLocalConfig();
                $content = $mo_ldap_config->test_authentication($test_username, $test_password);
                $response = json_decode($content, true);

                if(isset($response['statusCode'])) {
                    if (strcasecmp($response['statusCode'], 'LDAP_USER_BIND_SUCCESS') == 0 || strcasecmp($response['statusCode'], 'LDAP_ERROR') == 0) {
                        $message = 'You have successfully configured your LDAP settings.<br>
								You can set login via directory credentials by checking the Enable LDAP Login in the <strong>Sign-In Settings Tab</strong> and then <a href="' . esc_url(wp_logout_url(get_permalink())) . '">Logout</a> from wordpress and login again with your LDAP credentials.<br>';
                        update_option('mo_ldap_local_message', $message);
                        $this->show_success_message();
                    } elseif (strcasecmp($response['statusCode'], 'LDAP_USER_BIND_ERROR') == 0) {
                        $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']), 'ERROR', '<strong>Test Authentication Error: </strong>' . $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (strcasecmp($response['statusCode'], 'LDAP_USER_SEARCH_ERROR') == 0) {
                        $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']), 'ERROR', '<strong>Test Authentication Error: </strong>' . $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif ( strcasecmp($response['statusCode'], 'LDAP_USER_NOT_EXIST') == 0) {
                        $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']), 'ERROR', '<strong>Test Authentication Error: </strong>' . $response['statusMessage']);
                        update_option('mo_ldap_local_message', ($response['statusMessage']));
                        $this->show_error_message();
                    } elseif (strcasecmp($response['statusCode'], 'ERROR') == 0) {
                        $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']), 'ERROR', '<strong>Test Authentication Error: </strong>' . $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (strcasecmp($response['statusCode'], 'OPENSSL_ERROR') == 0) {
                        $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']), 'ERROR', '<strong>Test Authentication Error: </strong>' . $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    } elseif (strcasecmp($response['statusCode'], 'LDAP_LOCAL_SERVER_NOT_CONFIGURED') == 0) {
                        $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']), 'ERROR', '<strong>Test Authentication Error: </strong>' . $response['statusMessage']);
                        update_option('mo_ldap_local_message', $response['statusMessage']);
                        $this->show_error_message();
                    }
                }else {
                    $this->mo_ldap_report_update(sanitize_text_field($_POST['test_username']),'ERROR','<strong>Test Authentication Error: </strong> There was an error processing your request. Please verify the Search Base(s) and Username attribute. Your user should be present in the Search base defined.');
					update_option('mo_ldap_local_message', 'There was an error processing your request. Please verify the Search Base(s) and Username attribute. Your user should be present in the Search base defined.');
                    $this->show_error_message();
                }
            }elseif($post_option=='mo_ldap_pass' && check_admin_referer('mo_ldap_pass')){
                update_option( 'mo_ldap_export', isset($_POST['enable_ldap_login']) ? 1 : 0);

                if(get_option('mo_ldap_export')){
                    update_option( 'mo_ldap_local_message', 'Service account password will be exported in encrypted fashion');
                    $this->show_success_message();
                }
                else{
                    update_option( 'mo_ldap_local_message', 'Service account password will not be exported.');
                    $this->show_error_message();
                }
            } 
			elseif($post_option=='mo_ldap_export' && check_admin_referer('mo_ldap_export')){


                $ldap_server_url = get_option('mo_ldap_local_server_url');
                if(!empty($ldap_server_url)) {

                    
                    $this->miniorange_ldap_export();
                }
                else{
                    update_option( 'mo_ldap_local_message', 'LDAP Configuration not set. Please configure LDAP Connection settings.');
                    $this->show_success_message();
                }


            } elseif($post_option=='enable_config' && check_admin_referer('enable_config')){
                update_option( 'en_save_config', isset($_POST['enable_save_config']) ? 1 : 0);
				 if(get_option('en_save_config')){
                    update_option( 'mo_ldap_local_message', 'Plugin configuration will be persisted upon uninstall.');
                    $this->show_success_message();
                }
                else{
                    update_option( 'mo_ldap_local_message', 'Plugin configuration will not be persisted upon uninstall');
                    $this->show_error_message();
                }
            }  elseif ($post_option == 'reset_password' && check_admin_referer('reset_password')) {
                $admin_email = get_option('mo_ldap_local_admin_email');
                $customer = new MoLdapLocalCustomer();
                $forgot_password_response = $customer->mo_ldap_local_forgot_password($admin_email);
                if (!empty($forgot_password_response)) {
                    $forgot_password_response = json_decode($forgot_password_response,'true');
                    if ($forgot_password_response->status == 'SUCCESS') {
                        $message = 'You password has been reset successfully and sent to your registered email. Please check your mailbox.';
                        update_option('mo_ldap_local_message', $message);
                        $this->show_success_message();
                    }
                } else {
                    update_option('mo_ldap_local_message', 'Error in request');
                    $this->show_error_message();
                }
            }  elseif ($post_option == 'mo_ldap_local_enable_admin_wp_login' && check_admin_referer('mo_ldap_local_enable_admin_wp_login') && current_user_can('manage_options')) {
                update_option('mo_ldap_local_enable_admin_wp_login', (isset($_POST['mo_ldap_local_enable_admin_wp_login']) && sanitize_text_field($_POST['mo_ldap_local_enable_admin_wp_login'])==1) ? 1 : 0);
                if (get_option('mo_ldap_local_enable_admin_wp_login')) {
                    update_option('mo_ldap_local_message', 'Allow administrators to login with WordPress Credentials is enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'Allow administrators to login with WordPress Credentials is disabled.');
                    $this->show_error_message();
                }
            } elseif ($post_option == 'mo_ldap_local_cancel' && check_admin_referer('mo_ldap_local_cancel')) {
                delete_option('mo_ldap_local_admin_email');
                delete_option('mo_ldap_local_registration_status');
                delete_option('mo_ldap_local_verify_customer');
                delete_option('mo_ldap_local_email_count');
                delete_option('mo_ldap_local_sms_count');
            } elseif ($post_option == "mo_ldap_goto_login" && check_admin_referer('mo_ldap_goto_login')) {
                delete_option('mo_ldap_local_new_registration');
                update_option('mo_ldap_local_verify_customer', 'true');
            } elseif ($post_option == 'change_miniorange_account' && check_admin_referer('change_miniorange_account')) {
                delete_option('mo_ldap_local_admin_customer_key');
                delete_option('mo_ldap_local_admin_api_key');
                delete_option('mo_ldap_local_password', '');
                delete_option('mo_ldap_local_message');
                delete_option('mo_ldap_local_verify_customer');
                delete_option('mo_ldap_local_new_registration');
                delete_option('mo_ldap_local_registration_status');
            } elseif($post_option == 'mo_ldap_login_send_query'){
                $email = isset($_POST['inner_form_email_id'])?sanitize_text_field($_POST['inner_form_email_id']):'';
                $phone = isset($_POST['inner_form_phone_id'])?sanitize_text_field($_POST['inner_form_phone_id']):'';
                $query = isset($_POST['inner_form_query_id'])?sanitize_text_field($_POST['inner_form_query_id']):'';

                $choice = isset($_POST['export_configuration_choice'])?sanitize_text_field($_POST['export_configuration_choice']):'';
                if($choice=='yes'){
                    $configuration=$this->auto_email_ldap_export();
                    $configuration = implode(" <br>",$configuration);
                    $query = $query." ,<br><br>Plugin Configuration:<br> " . $configuration;
                }
                elseif($choice=='no'){
                    $configuration = "Configuration was not uploaded by user";
                    $query = $query." ,<br><br>Plugin Configuration:<br> " . $configuration;
                }
                $query = '[WP LDAP for Intranet (Free Plugin)]: ' . $query;
                $this->mo_ldap_send_query($email, $phone, $query);
            }elseif($post_option == 'mo_ldap_call_setup' && check_admin_referer('mo_ldap_call_setup')){
                $time_zone = isset($_POST['mo_ldap_setup_call_timezone'])?sanitize_text_field($_POST['mo_ldap_setup_call_timezone']):'';
                $call_date = isset($_POST['mo_ldap_setup_call_date'])?sanitize_text_field($_POST['mo_ldap_setup_call_date']):'';
				$call_time = isset($_POST['mo_ldap_setup_call_time'])?date("g:i A", strtotime(sanitize_text_field($_POST['mo_ldap_setup_call_time']))):'';
                $call_reason = isset($_POST['ldap-call-query'])?sanitize_text_field($_POST['ldap-call-query']):'';
                $call_email = isset($_POST['setup-call-email'])?sanitize_text_field($_POST['setup-call-email']):'';
                $current_version = get_option('mo_ldap_local_current_plugin_version');
                $phone = get_option( 'mo_ldap_local_admin_phone' );
                $query =  $call_reason . "<br><br> Time Zone: ".$time_zone . "<br> <br>Date: " .$call_date . "<br> <br>Time: " .$call_time . "<br><br>Current Version Installed : ".$current_version . " <br>";
                $feedback_reasons = new MoLdapLocalCustomer();

                if(!is_null($feedback_reasons)) {
                    if (!MoLdapLocalUtil::is_curl_installed()) {
                        $curl_warning_msg = 'Warning: PHP cURL extension is not installed or disabled. Please install/enable this extension to submit the meeting request.';
                        update_option('mo_ldap_local_message', $curl_warning_msg);
                        $this->show_error_message();
                    } else {
                        $submited = json_decode($feedback_reasons->send_email_alert($call_email, $phone, $query, true), true);
                        if (json_last_error() == JSON_ERROR_NONE) {
                            if (is_array($submited) && array_key_exists('status', $submited) && $submited['status'] == 'ERROR') {
                                update_option('mo_ldap_local_message', $submited['message']);
                                $this->show_error_message();
                            } else {
                                if (!$submited) {
                                    update_option('mo_ldap_local_message', 'Error while submitting request for the call.');
                                    $this->show_error_message();
                                }
                            }
                        }
                        update_option('mo_ldap_local_message', 'Your request for the call has been successfully sent. An executive from the miniOrange team will soon reach out to you.');
                        $this->show_success_message();
                    }
                }
            }elseif ($post_option == 'mo_ldap_login_send_feature_request_query') {
                $email = isset($_POST['query_email'])? sanitize_text_field($_POST['query_email']): '';
                $phone = isset($_POST['query_phone'])? sanitize_text_field($_POST['query_phone']): '';
                $query = isset($_POST['query'])? sanitize_text_field($_POST['query']) : '';
                $query = '[WP LDAP for Intranet (Free Plugin)]: ' . $query;
                $this->mo_ldap_send_query($email, $phone, $query);
            }elseif ($post_option == 'mo_ldap_plugin_tour_start' && check_admin_referer('mo_ldap_plugin_tour_start')) {
                update_option('mo_tour_skipped','true');
                update_option('overall_plugin_tour','true');
            }elseif ($post_option == 'mo_ldap_skip_ldap_tour' && check_admin_referer('mo_ldap_skip_ldap_tour')) {
                update_option('mo_tour_skipped','true');
                update_option('load_static_UI','false');
            }
            if($post_option =="mo_ldap_trial_request" && check_admin_referer('mo_ldap_trial_request')){
                if(isset($_POST['mo_ldap_demo_email'])) {
                    $email = isset($_POST['mo_ldap_demo_email']) ? sanitize_email($_POST['mo_ldap_demo_email']) : '';
                }

                if(empty($email)) {
                    $email = get_option('mo_ldap_local_admin_email');
                }

                if(isset($_POST['mo_ldap_demo_plan'])) {
                    $demo_plan = isset($_POST['mo_ldap_demo_plan']) ? sanitize_text_field($_POST['mo_ldap_demo_plan']) : '';
                }

                if(isset($_POST['mo_ldap_demo_description'])) {
                    $demo_requirements = isset($_POST['mo_ldap_demo_description']) ? sanitize_textarea_field($_POST['mo_ldap_demo_description']) : '';
                }

                $phone='';

                $license_plans = array(
                    'basic-plan'                   => 'Basic LDAP Authentication Plan',
                    'kerbores-ntlm'                => 'Basic LDAP Authentication Plan + Kerberos/NTLM SSO',
                    'enterprise-plan'              => 'Enterprise/All-Inclusive Plan',
                    'multisite-basic-plan'         => 'Multisite Basic LDAP Authentication Plan',
                    'multisite-kerbores-ntlm'      => 'Multisite Basic LDAP Authentication Plan + Kerberos/NTLM SSO',
                    'enterprise-enterprise-plan'   => 'Multisite Enterprise/All-Inclusive Plan',
                );
                if(isset($license_plans[$demo_plan])) {
                    $demo_plan = $license_plans[$demo_plan];
                }
                $addons = array(
                    'directory-sync'          => 'Sync Users LDAP Directory',
                    'buddypress-integration'  => 'Sync BuddyPress Extended Profiles',
                    'password-sync'           => 'Password Sync with LDAP Server',
                    'profile-picture-map'     => 'Profile Picture Sync for WordPress and BuddyPress',
                    'ultimate-member-login'   => 'Ultimate Member Login Integration',
                    'page-post-restriction'   => 'Page/Post Restriction',
                    'search-staff'            => 'Search Staff from LDAP Directory',
                    'profile-sync'            => 'Third Party Plugin User Profile Integration',
                    'gravity-forms'           => 'Gravity Forms Integration',
                    'buddypress-group'        => 'Sync BuddyPress Groups',
                    'memberpress-integration' => 'MemberPress Plugin Integration',
                    'emember-integration'     => 'eMember Plugin Integration'
                );

                $addons_selected = array();
                foreach($addons as $key => $value){
                    if(isset($_POST[$key]) && $_POST[$key] == "true") {
                        $addons_selected[$key] = $value;
                    }
                }
                $directory_access = '';
                $query ='';
                if(!empty($demo_plan)) {
                    $query .= "<br><br>[Interested in plan] : " . $demo_plan;
                }

                if(!empty($addons_selected)){
                    $query .= "<br><br>[Interested in add-ons] : ";
                    foreach($addons_selected as $key => $value){
                        $query .= $value;
                        if(next($addons_selected)) {
                            $query .= ", ";
                        }
                    }
                }

                if(!empty($demo_requirements)) {
                    $query .= "<br><br>[Requirements] : " . $demo_requirements;
                }

                if(isset($_POST['get_directory_access'])) {
                    $directory_access = sanitize_text_field($_POST['get_directory_access']);
                }

                if($directory_access == "Yes"){
                    $directory_access = "Yes";
                }else{
                    $directory_access = "No";
                }
                $query.='<br><br>[Is your LDAP server publicly accessible?] : '.$directory_access.'';

                $query   = ' [Demo: WordPress LDAP/AD Plugin]: ' . $query;
                $this->mo_ldap_send_query($email, $phone, $query);
            }
            if ($post_option == 'mo_ldap_skip_feedback' && check_admin_referer('mo_ldap_skip_feedback')) {
                deactivate_plugins(__FILE__);
                update_option('mo_ldap_local_message', 'Plugin deactivated successfully');
                $this->show_success_message();
            }
            if ($post_option == 'mo_ldap_hide_msg' && check_admin_referer('mo_ldap_hide_msg')) {
                update_option('mo_ldap_local_multisite_message', 'true');
            }
            if ($post_option == 'mo_ldap_feedback' && check_admin_referer('mo_ldap_feedback')) {
                $user = wp_get_current_user();
                $message = 'Plugin Deactivated: ';
                $deactivate_reason_message = array_key_exists( 'query_feedback', $_POST ) ? sanitize_textarea_field($_POST['query_feedback']) : false;

                $reply_required = '';
                if(isset($_POST['get_reply'])) {
                    $reply_required = sanitize_text_field($_POST['get_reply']);
                }
                if(empty($reply_required)){
                    $reply_required = "NO";
                    $message.='<strong><span style="color: red;">[Follow up Needed : '.$reply_required.']</strong></span><br> ';
                }else{
                    $reply_required = "YES";
                    $message.='<strong><span style="color: green;">[Follow up Needed : '.$reply_required.']</strong></span><br>';
                }

                if (!empty($deactivate_reason_message)) {
                    $message.= '<br>Feedback : '.$deactivate_reason_message.'<br>';
                }

                $current_version = get_option('mo_ldap_local_current_plugin_version');
                $message.= '<br>Current Version Installed : '.$current_version.'<br>';

                if (isset($_POST['rate'])) {
                    $rate_value = sanitize_text_field($_POST['rate']);
                    $message.= '<br>[Rating : '.$rate_value.']<br>';
                }

                $email = $_POST['query_mail'];

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $email = get_option('mo_ldap_local_admin_email');
                    if(empty($email)) {
                        $email = $user->user_email;
                    }
                }
                $feedback_reasons = new MoLdapLocalCustomer();
                if(!is_null($feedback_reasons)){
                    if(!MoLdapLocalUtil::is_curl_installed()){
                        deactivate_plugins( __FILE__ );
                        wp_redirect('plugins.php');
                    } else {
                        $submited = json_decode( $feedback_reasons->send_email_alert( $email, '', $message ), true );
                        if ( json_last_error() == JSON_ERROR_NONE ) {
                            if ( is_array( $submited ) && array_key_exists( 'status', $submited ) && $submited['status'] == 'ERROR' ) {
                                update_option( 'mo_ldap_local_message', $submited['message'] );
                                $this->show_error_message();
                            }
                            else {
                                if (!$submited) {
                                    update_option( 'mo_ldap_local_message', 'Error while submitting the query.' );
                                    $this->show_error_message();
                                }
                            }
                        }

                        deactivate_plugins( __FILE__ );
                        update_option( 'mo_ldap_local_message', 'Thank you for the feedback.' );
                        $this->show_success_message();
                        wp_redirect('plugins.php');
                    }
                }
            }
        }
    }

    function mo_ldap_send_query($email, $phone, $query)
    {
        $current_version = get_option('mo_ldap_local_current_plugin_version');
        $query = $query."<br><br>[Current Version Installed] : ".$current_version;

        if (MoLdapLocalUtil::check_empty_or_null($email) || MoLdapLocalUtil::check_empty_or_null($query)) {
            update_option('mo_ldap_local_message', 'Please submit your query along with email.');
            $this->show_error_message();
        } else {
            $contact_us = new MoLdapLocalCustomer();
            $submited = json_decode($contact_us->submit_contact_us($email, $phone, $query), true);

            if (isset($submited['status']) && strcasecmp($submited['status'], 'CURL_ERROR') == 0) {
                update_option('mo_ldap_local_message', $submited['statusMessage']);
                $this->show_error_message();
            } elseif (isset($submited['status']) && strcasecmp($submited['status'], 'ERROR') == 0) {
                update_option('mo_ldap_local_message', 'There was an error in sending query. Please send us an email on <a href=mailto:info@xecurify.com><strong>info@xecurify.com</strong></a>.');
                $this->show_error_message();
            } else {
                update_option('mo_ldap_local_message', 'Your query successfully sent.<br>In case we dont get back to you, there might be email delivery failures. You can send us email on <a href=mailto:info@xecurify.com><strong>info@xecurify.com</strong></a> in that case.');
                $this->show_success_message();
            }
        }
    }

	function miniorange_ldap_export()
    {
        
        if (array_key_exists("option", $_POST) && sanitize_text_field($_POST['option']) == 'mo_ldap_export') {

            $tab_class_name = unserialize(Tab_ldap_Class_Names);
           
            $configuration_array = array();
            foreach ($tab_class_name as $key => $value) {
                $configuration_array[$key] = $this->mo_get_configuration_array($value);
            }
            
            header("Content-Disposition: attachment; filename=miniorange-ldap-config.json");
            echo json_encode($configuration_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            exit;

        }
    }
    function mo_get_configuration_array( $class_name ) {
        $class_object = call_user_func( $class_name . '::getConstants' );
        $mapping_count=get_option('mo_ldap_local_role_mapping_count');
        $mo_array = array();
        $mo_map_key= array();
        $mo_map_value=array();
        foreach ( $class_object as $key => $value ) {

            if($value=="mo_ldap_local_server_url" || $value=="mo_ldap_local_server_password" || $value=="mo_ldap_local_server_dn" || $value=="mo_ldap_local_search_base" || $value=="mo_ldap_local_search_filter" || $value=="mo_ldap_local_Filter_Search") {
                $flag = 1;
            }
            else {
                $flag = 0;
            }
            if($value=="mo_ldap_local_mapping_key_")
            {
                for($i = 1 ; $i <= $mapping_count ; $i++){
                    $mo_map_key[ $i ] = get_option($value.$i);
                }
                $mo_option_exists = $mo_map_key;
            }
            elseif($value=="mo_ldap_local_mapping_value_")
            {
                for($i = 1 ; $i <= $mapping_count ; $i++){
                  $mo_map_value[ $i ] = get_option($value.$i);
                }
                $mo_option_exists = $mo_map_value;

            }
            else {
                $mo_option_exists = get_option($value);
            }

            if($mo_option_exists){
                if(@unserialize($mo_option_exists)!==false){
                    $mo_option_exists = unserialize($mo_option_exists);
                }
                if($flag==1 ) {
                    if ($value == "mo_ldap_local_server_password" && get_option('mo_ldap_export') == '0') {
                        continue;
                    }
                    elseif ($value == "mo_ldap_local_server_password" && get_option('mo_ldap_export') == '1') {
                        $mo_array[$key] = $mo_option_exists;
                    }
                    else {
                        $mo_array[$key] = MoLdapLocalUtil::decrypt($mo_option_exists);
                    }
                }
                else {
                    $mo_array[$key] = $mo_option_exists;
                }

            }

        }
        return $mo_array;
    }
   
    function auto_email_ldap_export()
		{
		    $directory_name = get_option('mo_ldap_local_directory_server');
			$server_name = get_option('mo_ldap_local_server_url') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_server_url')) : '';
			$dn = get_option('mo_ldap_local_server_dn') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_server_dn')) : '';
			$search_base = get_option( 'mo_ldap_local_search_base') ? MoLdapLocalUtil::decrypt(get_option( 'mo_ldap_local_search_base')) : '';
			$search_filter = get_option( 'mo_ldap_local_search_filter') ? MoLdapLocalUtil::decrypt(get_option( 'mo_ldap_local_search_filter')) : '';
            return array("LDAP Directory Name"=>"LDAP Directory Name:  ".$directory_name,"LDAP Server"=>"LDAP Server:  ".$server_name,"Service Account DN"=>"Service Account DN:  ".$dn,"Search Base"=>"Search Base:  ".$search_base,"LDAP Search Filter"=>"LDAP Search Filter:  ".$search_filter);
		}

    function test_attribute_configuration()
    {
            if (is_user_logged_in() && current_user_can('administrator') && isset($_REQUEST['option'])) {
                if ($_REQUEST['option'] != null && sanitize_text_field($_REQUEST['option']) == 'testattrconfig') {
                    $username = sanitize_text_field($_REQUEST['user']);
                    $mo_ldap_config = new MoLdapLocalConfig();
                    $mo_ldap_config->test_attribute_configuration($username);
                } elseif(sanitize_text_field($_REQUEST['option']) == 'searchbaselist'){
                    $mo_ldap_config = new MoLdapLocalConfig();
                    $mo_ldap_config->show_search_bases_list();
                }
            }
    }


    function save_success_customer_config($id, $apiKey, $token, $message)
    {
        update_option('mo_ldap_local_admin_customer_key', $id);
        update_option('mo_ldap_local_admin_api_key', $apiKey);
        update_option('mo_ldap_local_admin_token', $token);
        update_option('mo_ldap_local_password', '');
        update_option('mo_ldap_local_message', $message);
        delete_option('mo_ldap_local_verify_customer');
        delete_option('mo_ldap_local_new_registration');
        delete_option('mo_ldap_local_registration_status');
        $this->show_success_message();
    }

    function mo_ldap_local_settings_style($page)
    {
		if($page != 'toplevel_page_mo_ldap_local_login'){
            return;
        }
        wp_enqueue_style('mo_ldap_admin_settings_style', plugins_url('includes/css/mo_ldap_plugin_style_settings.min.css', __FILE__));
        wp_enqueue_style('mo_ldap_admin_settings_phone_style', plugins_url('includes/css/phone.min.css', __FILE__));
        wp_enqueue_style('mo_ldap_admin_font_awsome', plugins_url('includes/fonts/css/font-awesome.min.css', __FILE__));
        wp_enqueue_style('mo_ldap_grid_layout', plugins_url('includes/css/mo_ldap_licensing_grid.min.css', __FILE__));

		$ldap_file = plugin_dir_path( __FILE__ ) . 'pointers_ldap.php';

        $ldap_manager = new MoLdapPointersManager( $ldap_file, '4.8.52', 'custom_admin_pointers' );
        $ldap_manager->parse();
        $ldap_pointers = $ldap_manager->filter( $page );
       $plugin_tour_over=get_option('mo_tour_skipped');
        if ($plugin_tour_over=="true" && empty( $ldap_pointers)) {
                update_option("mo_ldap_local_empty_pointers", "true");
                return;
        }

		 wp_enqueue_style( 'wp-pointer' );
        $js_url = plugins_url( 'includes/js/pointers.js', __FILE__ );
        wp_enqueue_script( 'custom_admin_pointers', $js_url, array('wp-pointer'), NULL, TRUE );
        $data = array(
            'next_label' => __( 'Next' ),
            'skip_label' => __('Skip'),
            'close_label'=> __( 'Close'),
            'pointers' => $ldap_pointers,
        );
        wp_localize_script('custom_admin_pointers', 'MyAdminPointers', $data);
    }

    function mo_ldap_local_settings_script()
    {
        wp_enqueue_script('mo_ldap_admin_settings_phone_script', plugins_url('includes/js/phone.js', __FILE__));
        wp_register_script('mo_ldap_admin_settings_script', plugins_url('includes/js/settings_page.js', __FILE__), array('jquery'));
        wp_enqueue_script('mo_ldap_admin_settings_script');
    }

    function error_message()
    {
        $class = "error";
        $message = get_option('mo_ldap_local_message');
        $esc_allowed = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'b' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
        );
        echo "<div id='error' class='" . esc_attr($class) . "'> <p>" . wp_kses($message,$esc_allowed) . "</p></div>";
    }

    function success_message()
    {
        $class = "updated";
        $message = get_option('mo_ldap_local_message');
        $esc_allowed = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'b' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
        );
        echo "<div id='success' class='" . esc_attr($class) . "'> <p>" . wp_kses($message,$esc_allowed) . "</p></div>";
    }

    function show_success_message()
    {
        remove_action('admin_notices', array($this, 'error_message'));
        add_action('admin_notices', array($this, 'success_message'));
    }

    function show_error_message()
    {
        remove_action('admin_notices', array($this, 'success_message'));
        add_action('admin_notices', array($this, 'error_message'));
    }

	function prefix_update_table() {
        global $prefix_my_db_version;
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE if not exists`{$wpdb->base_prefix}user_report` (
			  id int NOT NULL AUTO_INCREMENT,
			  user_name varchar(50) NOT NULL,
			  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  Ldap_status varchar(250) NOT NULL,
			  Ldap_error varchar(250) ,
			  PRIMARY KEY  (id)
			) $charset_collate;";


        if ( ! function_exists('dbDelta') ) {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        }

        dbDelta( $sql );

        update_option( 'user_logs_table_exists', 1 );

    }

    function mo_ldap_activate()
    {
        $mo_ldap_token_key = get_option('mo_ldap_local_customer_token');
        $email_attr = get_option("mo_ldap_local_email_attribute");

        if (empty($mo_ldap_token_key)) {
            update_option('mo_ldap_local_customer_token', MoLdapLocalUtil::generateRandomString(15));
        }

        if(empty($email_attr)) {
            update_option("mo_ldap_local_email_attribute", "mail");
        }
        ob_clean();
    }

	 function mo_ldap_report_update($username,$status,$ldapError)
    {
        if(get_option('mo_ldap_local_user_report_log')== 1){
            global $wpdb;
            $table_name = $wpdb->prefix . 'user_report';
            $wpdb->get_row("SELECT id FROM $table_name WHERE user_name ='" . $username . "'");

            $wpdb->insert(
                $table_name,
                array(
                    'user_name' => $username,
                    'time' => current_time('mysql'),
                    'Ldap_status' => $status,
                    'Ldap_error' => $ldapError
                )
            );
        }
    }


    function mo_ldap_local_deactivate()
    {
        delete_option('mo_ldap_local_message');
        delete_option('mo_ldap_local_enable_login');
        delete_option('mo_ldap_local_enable_role_mapping');
        delete_option('overall_plugin_tour');
        delete_option('load_static_UI');
        delete_user_meta(get_current_user_id(),'dismissed_wp_pointers');
        delete_option("mo_ldap_local_empty_pointers");
        delete_option('mo_tour_skipped');
        delete_option('restart_ldap_tour');
        delete_option('config_settings_tour');
        delete_option('load_support_tab');
        delete_option('mo_ldap_local_multisite_message');
    }

    function is_administrator_user($user)
    {
        $userRole = ($user->roles);
        return (!is_null($userRole) && in_array('administrator', $userRole));
    }
}
new MoLdapLocalLogin();
?>