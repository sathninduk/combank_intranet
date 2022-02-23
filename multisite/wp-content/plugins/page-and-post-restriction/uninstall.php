<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

delete_option('papr_admin_email');
delete_option('papr_admin_customer_key');
delete_option('papr_host_name');
delete_option('papr_new_registration');
delete_option('papr_admin_phone');
delete_option('papr_admin_password');
delete_option('papr_admin_customer_key');
delete_option('papr_admin_api_key');
delete_option('papr_customer_token');
delete_option('papr_message');
delete_option('vl_check_s');
delete_option('pr_sml_lk');
delete_option('papr_allowed_roles_for_pages');
delete_option('papr_restricted_pages');
delete_option('papr_allowed_roles_for_posts');
delete_option('papr_restricted_posts');
delete_option('papr_allowed_redirect_for_pages');
delete_option('papr_allowed_redirect_for_posts');