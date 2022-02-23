<?php

class Mo_Wpum_Login_Actions{
	
	function __construct(){
		$this->mo_wpum_start_session();
		add_action('login_message',array($this,'mo_wpum_login_message'),1,1);
		add_action( 'admin_init',  array( $this, 'mo_wpum_save_settings' ) );

		//Setting default options
		add_option( 'mo_wpum_admin_dashboard_enable', 0 );
		add_option( 'mo_wpum_notification_option_enable', 'php' );
		add_option( 'mo_wpum_register_form_firstname', 0 );
		add_option( 'mo_wpum_register_form_lastname', 0 );
		add_option( 'mo_wpum_register_form_nickname', 0 );
		add_option( 'mo_wpum_register_form_description', 0 );
		add_option( 'mo_wpum_register_form_website', 0 );
		function admin_login(){
			return home_url();
		}
		if(get_option('mo_wpum_admin_dashboard_enable')==0){
			if( !is_admin() )		
				add_filter( 'login_redirect', 'admin_login');	
			add_action('after_setup_theme', array($this,'mo_wpum_remove_admin_bar'));
		}
	}
	
	function mo_wpum_start_session(){
		if (!session_id())
			session_start();
	}
	
	function mo_wpum_remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}
	
	function mo_wpum_login_message($message){
		if(array_key_exists('login_message',$_SESSION)){
			$message = $_SESSION['login_message'];
			unset($_SESSION['login_message']);
			return $message;
		}
	}
		
	function mo_wpum_save_settings(){
		global $mo_manager_utility,$wpdb;
		if( isset( $_POST['option'] ) and $_POST['option'] == "mo_wpum_save_enable" ) {
			if($mo_manager_utility->is_registered()){
				update_option( 'mo_wpum_admin_dashboard_enable', isset( $_POST['mo_wpum_admin_dashboard_enable']) ? $_POST['mo_wpum_admin_dashboard_enable'] : 0);
				update_option( 'mo_wpum_send_email_enable', isset( $_POST['mo_wpum_send_email_enable']) ? $_POST['mo_wpum_send_email_enable'] : 0);
				update_option( 'mo_wpum_message','Settings saved successfully.');
				if(isset($_POST['admin_email']))
				update_option('mo_wpum_admin_email',$_POST['admin_email']); 
				$mo_manager_utility->mo_wpum_show_success_message();
			} else {
				update_option('mo_wpum_message', 'Please register an account');
				$mo_manager_utility->mo_wpum_show_error_message();
			}
		}
		elseif( isset( $_POST['option'] ) and $_POST['option'] == "mo_wpum_fields_save_enable" ) {
			if($mo_manager_utility->is_registered()){
				$count = "SELECT COUNT(id) FROM {$wpdb->prefix}wpum_fields";
				$sql = $wpdb->get_var($count);
				for($i = 1 ; $i <= $sql ; $i++){
					$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $i ));
					if($field->title != NULL){
						update_option( 'field'.$i , isset( $_POST['field'.$i]) ? $_POST['field'.$i] : 0);
					}
				}
				update_option( 'mo_wpum_message','Registration fields saved successfully.');
				$mo_manager_utility->mo_wpum_show_success_message();
			} else {
				update_option('mo_wpum_message', 'Please register an account');
				$mo_manager_utility->mo_wpum_show_error_message();
			}
		}
	}
}
?>