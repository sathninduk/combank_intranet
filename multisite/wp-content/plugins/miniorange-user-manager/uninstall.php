<?php
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
	
	require('/resources/mo-wpum-utility.php');
	global $wpdb;

	delete_option('mo_wpum_admin_customer_key');
	delete_option('mo_wpum_admin_api_key');
	delete_option('mo_wpum_register_form_firstname');
	delete_option('mo_wpum_register_form_lastname');
	delete_option('mo_wpum_register_form_nickname');
	delete_option('mo_wpum_register_form_description');
	delete_option('mo_wpum_register_form_website');
	delete_option('mo_wpum_admin_dashboard_enable');
	delete_option('mo_wpum_send_email_enable');
	delete_option('mo_wpum_customer_token');
	delete_option('mo_wpum_message');
	delete_option('mo_wpum_notification_option_enable');
	delete_option('mo_wpum_registration_status');
	delete_option('mo_wpum_transactionId');
	delete_option('mo_wpum_verify_customer');
	delete_option('mo_wpum_new_registration');
	delete_option('mo_wpum_admin_phone');
	delete_option('mo_wpum_admin_password');
	delete_option('mo_wpum_admin_email');

	delete_option('mo_wpum_host_name');
	delete_option('mo_wpum_version');
	delete_option('mo_customer_email_transactions_remaining');
	delete_option('mo_customer_phone_transactions_remaining');
	delete_option('mo_wpum_admin_company_name');
	delete_option('mo_wpum_admin_first_name');
	delete_option('mo_wpum_admin_last_name');
	delete_option('mo_wpum_email_otp_count');
	delete_option('wpum_custom_caps');
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpum_fields" );
?>