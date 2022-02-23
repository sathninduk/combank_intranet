<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

if(get_option('en_save_config') == 0) {
    delete_option('mo_ldap_local_register_user');
    delete_option('mo_ldap_local_enable_admin_wp_login');
    delete_option('mo_ldap_local_anonymous_bind');
    delete_option('mo_ldap_local_anonymous_bind');
	delete_option('mo_ldap_local_admin_email');
	delete_option('mo_ldap_local_host_name');
	delete_option('mo_ldap_local_password');
	delete_option('mo_ldap_local_new_registration');
	delete_option('mo_ldap_local_admin_phone');
	delete_option('mo_ldap_local_verify_customer');
	delete_option('mo_ldap_local_admin_customer_key');
	delete_option('mo_ldap_local_admin_api_key');
	delete_option('mo_ldap_local_customer_token');
	delete_option('mo_ldap_local_message');
	delete_option('mo_ldap_local_registration_status');
	delete_option('mo_ldap_local_enable_login');
	delete_option('mo_ldap_local_enable_log_requests');
	delete_option('mo_ldap_local_server_url');
	delete_option('mo_ldap_local_server_dn');
	delete_option('mo_ldap_local_server_password');
	delete_option('mo_ldap_local_search_base');
	delete_option('mo_ldap_local_search_filter');
	delete_option('mo_ldap_local_username_attribute');
	delete_option('Filter_search');

    $role_mapping_count = get_option('mo_ldap_local_role_mapping_count');
    for($i=1;$i<=$role_mapping_count;$i++) {
        delete_option('mo_ldap_local_mapping_key_' . $i);
        delete_option('mo_ldap_local_mapping_value_' . $i);
    }

	delete_option('mo_ldap_local_role_mapping_count');
	delete_option('mo_ldap_local_mapping_value_default');
    delete_option('mo_ldap_local_enable_role_mapping');
	delete_option('mo_ldap_local_server_url_status');
	delete_option('mo_ldap_local_service_account_status');
	delete_option('mo_ldap_local_user_mapping_status');
	delete_option('mo_ldap_local_save_config_status');
	delete_option('mo_ldap_local_username_status');
	delete_option('mo_ldap_local_password_status');
	delete_option('mo_ldap_local_admin_fname');
	delete_option('mo_ldap_local_admin_lname');
	delete_option('mo_ldap_local_company');
    delete_option('overall_plugin_tour');
    delete_option('load_static_UI');
    delete_option('import_flag');
    delete_option('mo_ldap_export');
    delete_option('mo_ldap_local_mapping_memberof_attribute');
    delete_option('mo_ldap_local_skip_redirectto_parameter');
    delete_option("mo_ldap_local_empty_pointers");
    delete_option("mo_ldap_local_search_bases_list");
    delete_option('mo_tour_skipped');
    delete_option('restart_ldap_tour');
    delete_option('config_settings_tour');
    delete_option('load_support_tab');
    delete_option("mo_ldap_directory_server_value");
    delete_option("mo_ldap_directory_server_custom_value");
	delete_option('mo_ldap_curl_activation_status');
	delete_option('mo_ldap_ldap_activation_status');
	delete_option('mo_ldap_openssl_activation_status');
    delete_option('mo_ldap_local_multisite_message');

    global $wpdb;
    $table_name = $wpdb->prefix . 'user_report';
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );

    delete_option('user_logs_table_exists');
    delete_option('mo_ldap_local_user_report_log');
    delete_option('en_save_config');
	}
?>