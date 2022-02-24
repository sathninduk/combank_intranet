<?php

require_once "mo_ldap_pages.php";

$pointers = array();
$tab= 'default';

if (get_option('overall_plugin_tour') && get_option('overall_plugin_tour')=='true') {

    $pointers['miniorange-default-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('LDAP Configuration    [1 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can configure the LDAP connection and user search. You can test the configuration as well.')),
        'anchor_id' => '#ldap_default_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );
    
    $pointers['miniorange-signin-settings-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Sign-In settings    [2 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can configure different sign-in options for your website.')),
        'anchor_id' => '#ldap_signin_settings_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-multiple-directories-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Multiple Directories    [3 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can configure multiple LDAP directories.')),
        'anchor_id' => '#ldap_multiple_directories_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-role-mapping-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Role Mapping    [4 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can define the site access level for the user based on the LDAP security groups.')),
        'anchor_id' => '#ldap_role_mapping_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-attribute-mapping-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Attribute Mapping    [5 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can map the different LDAP attributes with the WordPress user profile fields.')),
        'anchor_id' => '#ldap_attribute_mapping_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-add-on-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Available Add-ons    [6 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>',"Get added functionality with these add-ons:
        <br><br><strong>1. Sync Users LDAP Directory</strong>
        <br><strong>2. Auto Login (SSO) using Kerberos/NTLM</strong>
        <br><strong>3. Password Sync with LDAP Server</strong>
        <br><strong>4. Profile Picture Sync for WordPress and BuddyPress</strong>
        <br>and many more..."),
        'anchor_id' => '#mo_ldap_add_on_layout',
        'edge' => 'right',
        'align' => 'top',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-feature-request-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Feature Request    [7 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Did we miss something? Reach out to us in case you have any additional requirements.')),
        'anchor_id' => '#ldap_feature_request_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-configuration-settings-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Configuration settings    [8 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Export the plugin configuration to send to us for debugging purposes.')),
        'anchor_id' => '#ldap_config_settings_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );
	 $pointers['miniorange-users-report-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Reports    [9 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can get authentication reports and logs.')),
        'anchor_id' => '#ldap_User_Report_tab_pointer',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-licensing-plans-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Licensing plans    [10 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here, you can check our LDAP premium plugin plans and add-ons.')),
        'anchor_id' => '#license_upgrade',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-troubleshooting-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Troubleshooting    [11 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Troubleshoot common issues faced during configuration of the plugin.')),
        'anchor_id' => '#ldap_troubleshooting_tab_pointer',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );


    $pointers['miniorange-account-setup-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Account setup (Registration is optional)    [12 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Register with miniOrange for upgrades to professional versions as well as for greater level of support.')),
        'anchor_id' => '#ldap_account_setup_tab_pointer',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-premium-plugin-trial-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Request for Demo  [13 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Contact us to get a trial of the LDAP premium plugin features.')),
        'anchor_id' => '#ldap_trial_for_premium_plugin',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    $pointers['miniorange-restart-plugin-tour'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Click when you need to restart this tour    [14 of 14 Steps]')),
        'content' => sprintf('<p>%s</p>', esc_html__('Revisit plugin tour.')),
        'anchor_id' => '#configure-restart-plugin-tour',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );

    update_option('overall_plugin_tour','false');
    update_option('load_support_tab','true');
}
elseif(get_option('load_support_tab') && get_option('load_support_tab') =='true') {
    $pointers['miniorange-support-ldap'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('We are here!')),
        'content' => sprintf('<p>%s</p>', esc_html__('Get in touch with us and we will help you setup the plugin in no time.')),
        'anchor_id' => '#mo_ldap_support_layout_ldap',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login'),
    );
    update_option('load_support_tab','false');

}
else {
    if (array_key_exists('tab', $_GET)){
        $tab = sanitize_text_field($_GET['tab']);
    }
    if ($tab == 'default' && get_option('restart_ldap_tour') && get_option('restart_ldap_tour')=='true') {

        $pointers['miniorange-select-your-ldap-directory'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Server    [1 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Select your Directory Server from dropdown list.')),
            'anchor_id' => '#mo_ldap_directory_servers',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

        $pointers['miniorange-select-your-ldap-server'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Server Protocol    [2 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Select ldap or ldaps from the dropdown list.')),
            'anchor_id' => '#ldap_server_url_pointer',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

        $pointers['miniorange-ldap-server-url'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Server URL   [3 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the hostname or IP address of the directory server.')),
            'anchor_id' => '#mo_ldap_directory_server_url',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

        $pointers['miniorange-select-your-ldap-server-port'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Server Port    [4 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__(' Enter your LDAP server port number.')),
            'anchor_id' => '#mo_ldap_server_port_number_div',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

        $pointers['miniorange-ldap-server-username'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Service Account Name    [5 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the username of Directory Service account which will be used to establish connection.')),
            'anchor_id' => '#ldap_server_username',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );
        $pointers['miniorange-ldap-server-password'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Service Account Password    [6 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the password of Directory Service Account')),
            'anchor_id' => '#ldap_server_password',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

        $pointers['miniorange-ldap-search-base'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Search Base    [7 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the distinguished name of Directory Container which contains all the users who will authenticate to the site.')),
            'anchor_id' => '#search_base_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );
        $pointers['miniorange-ldap-search-filter'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Username Attribute    [8 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Select the LDAP attribute from dropdown which will be used by Directory users to login.')),
            'anchor_id' => '#search_filter_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );
        $pointers['miniorange-test-auth'] = array(

            'title' => sprintf('<h3>%s</h3>', esc_html__('Test Authentication    [9 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Check the user authentication by entering the user credentials. Use the configured username attribute for testing')),
            'anchor_id' => '#Test_auth_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

        $pointers['configure-ldap-service-restart-tour'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Click when you need me!    [10 of 10 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Revisit tour')),
            'anchor_id' => '#configure-service-restart-tour',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );

    }

    if ($tab == 'config_settings'&& get_option('config_settings_tour') && get_option('config_settings_tour')=='true') {
        $pointers['minorange-ldap-save-config'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Save Config     [1 of 3 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enabling this option will ensure that the plugin configuration are not deleted when plugin is uninstalled')),
            'anchor_id' => '#enable_save_config_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );
        $pointers['miniorange-ldap-export-feature'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Export configuration    [2 of 3 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('If you are having trouble setting up the plugin, click here to export the configuration and mail it to us at info@xecurify.com.')),
            'anchor_id' => '#mo_export',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );
        $pointers['miniorange-redirection-ldap-config-restart-tour'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Click when you need me!    [3 of 3 Steps]')),
            'content' => sprintf('<p>%s</p>', esc_html__('Revisit tour')),
            'anchor_id' => '#export-config-service-restart-tour',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login'),
        );
    }
}

return $pointers;