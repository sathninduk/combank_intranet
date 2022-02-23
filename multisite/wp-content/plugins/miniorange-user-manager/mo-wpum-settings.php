<?php
/**
* Plugin Name: User Management (Manage User Roles, Capabilities, Membership)
* Plugin URI: http://miniorange.com
* Description: User Management plugin to manage your users, roles and capabilities. Create custom registration forms fields and approve users after registration. Simple and customizable with active support.
* Version: 1.1.1
* Author: miniOrange
* Author URI: http://miniorange.com
* License: GPL2
*/

require('pages/mo-wpum-main-pages.php');
require('pages/mo-wpum-role-editor-pages.php');
require('pages/mo-wpum-user-signup-pages.php');
require('resources/mo-wpum-utility.php');
require('resources/mo-wpum-user-list.php');
require('resources/mo-wpum-global-variables.php');
require('actions/mo-wpum-role-editor-actions.php');
require('actions/mo-wpum-signup-actions.php');
require('resources/mo-wpum-db-queries.php');
require('actions/mo-wpum-notification-actions.php');
require('actions/mo-wpum-login-actions.php');
require('actions/mo-wpum-registration-actions.php');
require('mo-wpum-table-setup.php');
require('pages/mo-wpum-default-template.php');
require('pages/mo-wpum-custom-fields-frontend.php');
require('actions/mo-wpum-custom-fields-actions.php');

class Mo_Manager_Plugin{

	function __construct() {
		global $pluginDir,$template;
		new Mo_Wpum_Global_Variables();
		add_action( 'admin_menu', array( $this, 'mo_wpum_menu' ) );
		add_filter( 'plugin_action_links', array($this, 'mo_wpum_plugin_actions'), 10, 2 );
		add_action( 'admin_init',  array( $this, 'mo_wpum_admin_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'mo_wpum_settings_style' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'mo_wpum_settings_script' ) );
		add_action( 'enqueue_scripts', array( $this, 'mo_wpum_settings_style' ) );
		add_action( 'enqueue_scripts', array( $this, 'mo_wpum_settings_script' ) );
		register_activation_hook( __FILE__, array( $this, 'mo_wpum_activate' ));
		register_deactivation_hook(__FILE__, array( $this, 'mo_wpum_deactivate'));
		register_activation_hook(__FILE__, array( $template, 'setup_fields_table'));
		register_deactivation_hook(__FILE__, array( $template, 'setup_fields_table'));
		add_option( 'field_type', 'textbox');
		add_option( 'mo_wpum_send_email_enable', 1);
         
	
		global $sign_up_actions,$role_cap_actions,$mo_manager_utility, $custom_fields_actions;
		add_filter( 'views_users', 'mo_wpum_signup_filter_view', 10, 1 );
		//add_filter( 'users_list_table_query_args', array( $sign_up_actions, 'mo_wpum_table_query_args'), 10, 1 );
		add_filter( 'user_row_actions', array( $role_cap_actions, 'mo_wpum_show_edit_action_link'), 10, 2);
		add_filter( 'set-screen-option', array($role_cap_actions, 'mo_wpum_signup_set_option'), 10, 3);
		
		add_action( 'user_register', array( $sign_up_actions, 'mo_wpum_new_user_signup' ),1, 1);
		
		remove_action( 'admin_notices', array( $this, 'mo_wpum_success_message') );
	    remove_action( 'admin_notices', array( $this, 'mo_wpum_error_message') );
		
		add_action('register_form','mo_register_form', 5);
		add_action('show_user_profile',array( $custom_fields_actions, 'wpum_custom_profile_fields'),1,1);
		add_action('edit_user_profile',array( $custom_fields_actions, 'wpum_custom_profile_fields'),1,1);
		
		add_action('delete_user_form',array($sign_up_actions,'mo_wpum_delete_user_from_pending'),1,2); 
		
		add_action('personal_options_update',array( $custom_fields_actions, 'wpum_custom_profile_fields_update' ),1,1);
		add_action('edit_user_profile_update',array( $custom_fields_actions, 'wpum_custom_profile_fields_update' ),1,1);
		add_action('registration_errors',array( $custom_fields_actions, 'wpum_user_registration_errors'),1,3);
		add_action('user_register',array( $custom_fields_actions, 'wpum_custom_profile_fields_update'),1,3);
		$pluginDir = plugin_dir_path(__FILE__);
	}	
	
	function mo_wpum_menu() {
		$page = add_menu_page( 'WP User Management' . __( 'Configure WP User Management Settings', 'mo_wpum_settings' ), 'WP User Manager', 'administrator',
		'mo_wpum_settings', array( $this, 'mo_wpum_options' ),plugin_dir_url(__FILE__) . 'includes/images/miniorange.png');

		$page = add_submenu_page('users.php', 'Roles & Capabilities', 'Roles & Capabilities', 'administrator',
		'mo_wpum_role_caps_settings', array( $this, 'mo_wpum_role_cap_settings' ));

		$page = add_submenu_page('users.php', 'Manage Signups', 'Manage Signups', 'administrator',
		'mo_wpum_user_signups', array( $this, 'mo_wpum_user_signups' ));
		add_action( "load-$page", 'mo_wpum_signup_screen_options');
	}

	function mo_wpum_plugin_actions( $links, $file ) {
	 	if( $file == 'miniorange-user-manager/mo-wpum-settings.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'tools.php?page=mo_wpum_settings' ) . '">' . __('Settings') . '</a>';
			array_unshift( $links, $settings_link ); // before other links
		}
		return $links;
	}

	function mo_wpum_options() {
		mo_wpum_show_plugin_settings();
	}

	function mo_wpum_role_cap_settings(){
		mo_wpum_show_role_cap_edit_page();
	}

	function mo_wpum_user_signups(){
		mo_wpum_show_user_signups_page();
	}

	function mo_wpum_settings_style() {
		wp_enqueue_style( 'mo_wpum_admin_settings_style', plugins_url('includes/css/mo-wpum-style.css?version=1.0', __FILE__));
		wp_enqueue_style( 'mo_wpum_admin_settings_phone_style', plugins_url('includes/css/phone.css', __FILE__));
		wp_enqueue_style( 'mo_wpum_admin_settings_datatable_style', plugins_url('includes/css/jquery.dataTables.min.css', __FILE__));
	}

	function mo_wpum_settings_script() {
		wp_enqueue_script( 'mo_wpum_admin_settings_phone_script', plugins_url('includes/js/phone.js', __FILE__ ));
		wp_enqueue_script( 'mo_wpum_admin_settings_script', plugins_url('includes/js/settings.js?version=1.0', __FILE__ ), array('jquery'));
		wp_enqueue_script( 'mo_wpum_admin_datatable_script', plugins_url('includes/js/jquery.dataTables.min.js', __FILE__ ), array('jquery'));
	}

	function mo_wpum_activate(){
		update_option( 'mo_wpum_host_name', 'https://login.xecurify.com' );
		add_rewrite_rule( '^user/(.+)','index.php?user=$matches[1]','top' );
		add_rewrite_rule( '^admin/(.+)','index.php?admin=$matches[1]','top' );
		flush_rewrite_rules();
		
		$dbSetup = new Mo_Database_Setup();
		if(!get_option('mo_wpum_version')){
			update_option('mo_wpum_version', '1.0.0' );
			$dbSetup->setup_signups_table();
			$dbSetup->setup_fields_table();
			$dbSetup->fields_insert_default();
		}
		
	}
	
	function mo_wpum_deactivate() {
		delete_option('mo_wpum_host_name');
		delete_option('mo_wpum_transactionId');
		delete_option('mo_wpum_admin_password');
		delete_option('mo_wpum_registration_status');
		delete_option('mo_wpum_admin_phone');
		delete_option('mo_wpum_new_registration');
		delete_option('mo_wpum_admin_customer_key');
		delete_option('mo_wpum_admin_api_key');
		delete_option('mo_wpum_customer_token');
		delete_option('mo_wpum_verify_customer');
		delete_option('mo_wpum_message');
		flush_rewrite_rules();
	}

	function mo_wpum_admin_init(){
		global $template;
		if ( current_user_can( 'manage_options' )){
			global $role_cap_actions,$sign_up_actions,$mo_manager_utility,$notification_actions;
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_role_edit_settings" )
				$role_cap_actions->mo_wpum_save_role_settings($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_cap_edit_settings" )
				$role_cap_actions->mo_wpum_update_user_capabilties($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_role_cap_edit_settings" )
				$role_cap_actions->mo_wpum_update_role_capabilities($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_add_role" )
				$role_cap_actions->mo_wpum_add_role($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_delete_role" )
				$role_cap_actions->mo_wpum_delete_role($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_change_default_role" )
				$role_cap_actions->mo_wpum_change_default_role($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_add_cap" )
				$role_cap_actions->mo_wpum_add_custom_capabilities($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_delete_cap" )
				$role_cap_actions->mo_wpum_delete_custom_capabilities($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "wpum_rename_role" )
				$role_cap_actions->mo_wpum_rename_role($_POST);
			if( isset( $_POST['option'] ) && $_POST['option'] == "confirm_activation" )
				$sign_up_actions->mo_wpum_activate_user( $_POST['user_id'],$_POST['signup_id'] );
			if( isset( $_POST['option'] ) && $_POST['option'] == "confirm_delete" )
				$sign_up_actions->mo_wpum_delete_user( $_POST['user_id'],$_POST['signup_id'] );
			if( isset( $_POST['option'] ) && $_POST['option'] == "send_activation_mail" ){
				$notification_actions->mo_wpum_send_activation_email($_POST['user_id'],$_POST['signup_id']);
			}if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_field_edit" ){
				$id = $_POST['id'];
				$label = sanitize_text_field($_POST['field_label']);
				$field_type = $_POST['field_type'];
				$option = sanitize_text_field($_POST['field_option']);
				$meta_key = $_POST['field_key'];
				$template->fields_update_data($id,$label,$meta_key,$field_type,$option);	
			}
		}

		global $registration,$wpdb;
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_register_customer" )
			$registration->mo_wpum_register_customer($_POST);
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_login_page" )
			$registration->mo_wpum_login_page();
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_validate_otp" )
			$registration->mo_wpum_validate_otp($_POST);	
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_connect_verify_customer" )
			$registration->mo_wpum_verify_customer($_POST);	
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_go_back" )
			$registration->mo_wpum_go_back();
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_resend_otp" )
			$registration->mo_wpum_resend_otp();	
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_phone_verification" )
			$registration->mo_wpum_phone_verification($_POST);
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_forgot_password" )
			$registration->mo_wpum_forgot_password();
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_contact_us_query_option" )
			$registration->mo_wpum_send_contact_us_query($_POST);
		if( isset( $_POST['option'] ) && $_POST['option'] == "mo_wpum_field_save" ){
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
			$label = sanitize_text_field($_POST['field_label']);
			$field_type = $_POST['field_type'];
			$option = sanitize_text_field($_POST['field_option']);
			$meta_key = $_POST['field_key'];
			$custom_meta_key = $_POST['field_custom_meta'];
			add_user_meta($user_id,$custom_meta_key,NULL);
			$fields_entry = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wpum_fields WHERE title = %s",$label));
			$mo_wpum_config = new Mo_Database_Setup();
			if($fields_entry == NULL){
				if($meta_key == NULL || $meta_key == "*"){
					$mo_wpum_config->fields_insert_data($label,$custom_meta_key,$field_type,$option);
				}else{
					$mo_wpum_config->fields_insert_data($label,$meta_key,$field_type,$option);
				}
			}
		}	
	}
}

new Mo_Manager_Plugin;
?>