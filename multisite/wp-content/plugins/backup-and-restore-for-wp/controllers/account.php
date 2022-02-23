<?php 
	global $moWpnsUtility,$MoBackupDirName,$BackupDbQueries;

	if ( current_user_can( 'manage_options' ) and isset( $_POST['option'] ) )
	{
		$option =sanitize_text_field( wp_unslash($_POST['option']));
		switch($option)
		{
			case "mo_wpns_register_customer":
				barfw_register_customer($_POST);        break;
			case "mo_wpns_verify_customer":
				barfw_verify_customer($_POST);		    break;
			case "mo_wpns_cancel":
				barfw_revert_back_registration($_POST);	break;
			case "mo_wpns_reset_password":
				barfw_reset_password($_POST); 		    break;
		    case "mo2f_goto_verifycustomer":
		        barfw_goto_sign_in_page($_POST);        break;
		}
	} 

	if  (isset($_POST['mo_eb_register_to_upgrade_nonce'] ) ) { 
	$nonce = sanitize_text_field( wp_unslash($_POST['mo_eb_register_to_upgrade_nonce']));
	if ( ! wp_verify_nonce( $nonce, 'miniorange-eb-user-reg-to-upgrade-nonce' ) ) {
		update_option( 'mo_eb_message', BARFW_Backup_Messages::barfw_show_essage( "INVALID_REQ" ) );
	} else {
		$requestOrigin = sanitize_text_field( wp_unslash($_POST['requestOrigin']));
		update_option( 'mo_eb_customer_selected_plan', $requestOrigin );
	}
}

	 $user   = wp_get_current_user();
	$status = $BackupDbQueries->barfw_get_user_detail( 'mo_2factor_user_registration_status', $user->ID);
	 $mo2f_current_registration_status = get_option('mo_2factor_user_registration_status');
	if($status == 'error')	
	{
		 $mo2f_current_registration_status = get_option('mo_2factor_user_registration_status');
		 if ((get_option ( 'mo_wpns_verify_customer' ) == 'true' || (get_option('mo2f_email') && !get_option('mo2f_customerKey'))) && $mo2f_current_registration_status == "MO_2_FACTOR_VERIFY_CUSTOMER")
		 {
		 	$admin_email = get_option('mo2f_email') ? get_option('mo2f_email') : "";		
		 	include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'login.php';
		 }
		 else if (!barfw_is_customer_register()) 
		 {
		 	delete_option ( 'password_mismatch' );
		 	update_option ( 'mo_wpns_new_registration', 'true' );
	    	update_option('mo_2factor_user_registration_status', 'REGISTRATION_STARTED');
	 	include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'register.php';
		 }
		else if(get_option('mo_2factor_admin_registration_status')=='MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS')
		{

		$email = get_option('mo2f_email');
		$key   = get_option('mo2f_customerKey');
		$api   = get_option('mo2f_api_key');
		$token = get_option('mo2f_customer_token');
		include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'profile.php';
		}
	}  
	else if(get_option('mo_2factor_admin_registration_status')=='MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS')
	{
		$email = get_option('mo2f_email');
		$key   = get_option('mo2f_customerKey');
		$api   = get_option('mo2f_api_key');
		$token = get_option('mo2f_customer_token');
		include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'profile.php';
	}
	else if ((get_option ( 'mo_wpns_verify_customer' ) == 'true' || (get_option('mo2f_email') && !get_option('mo2f_customerKey'))) && $mo2f_current_registration_status == "MO_2_FACTOR_VERIFY_CUSTOMER")
		 {
		 	$admin_email = get_option('mo2f_email') ? get_option('mo2f_email') : "";		
		 	include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'login.php';
		 }
	else
	{
			delete_option ( 'password_mismatch' );
			update_option ( 'mo_wpns_new_registration', 'true' );
	    	update_option('mo_2factor_user_registration_status', 'REGISTRATION_STARTED');
			include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'register.php';
	}





	 function barfw_is_customer_register() 
	{
		$email 			= get_option('mo2f_email');
		$customerKey 	= get_option('mo2f_customerKey');
		if( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) )
			return 0;
		else
			return 1;
	}

	
	function barfw_register_customer($post)
	{
		global $moWpnsUtility, $BackupdbQueries;
		$nonce = sanitize_text_field(wp_unslash($post['mo_eb_register_nonce']));
		 if ( ! wp_verify_nonce( $nonce, 'mo-eb-register-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        } 
		
		$user   = wp_get_current_user();
		$email 			 = sanitize_email(wp_unslash($post['email']));
		$company 		 = $_SERVER["SERVER_NAME"];

		$password 		 = sanitize_text_field(wp_unslash($post['password']));
		$confirmPassword = sanitize_text_field(wp_unslash($post['confirmPassword']));

		if( strlen( $password ) < 6 || strlen( $confirmPassword ) < 6)
		{
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('PASS_LENGTH'),'ERROR');
			return;
		}
		
		if( $password != $confirmPassword )
		{
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('PASS_MISMATCH'),'ERROR');
			return;
		}
		if( barfw_check_empty_or_null( $email ) || barfw_check_empty_or_null( $password ) 
			|| barfw_check_empty_or_null( $confirmPassword ) ) 
		{
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('REQUIRED_FIELDS'),'ERROR');
			return;
		} 

		update_option( 'mo2f_email', $email );
		
		update_option( 'mo_wpns_company'    , $company );
		
		update_option( 'mo_wpns_password'   , $password );

		$customer = new BARFW_Backup_Curl();
		$content  = json_decode($customer->barfw_check_customer($email), true);
		update_option('user_id', $user->ID );
		switch ($content['status'])
		{
			case 'CUSTOMER_NOT_FOUND':
			      $customerKey = json_decode($customer->barfw_create_customer($email, $company, $password, $phone = '', $first_name = '', $last_name = ''), true);
			   if(strcasecmp($customerKey['status'], 'SUCCESS') == 0) 
				{
					barfw_save_success_customer_config($email, $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']);
				}
				
				break;

			case 'SUCCESS':	
			{
			do_action('mo_eb_show_message','User already exist. Please SIGN IN','ERROR');
			}
			break;
			default:
				barfw_get_current_customer($email,$password);
				break;
		}

	}

	function barfw_check_empty_or_null( $value )
	{
		if( ! isset( $value ) || empty( $value ) )
			return true;
		return false;
	}

   function barfw_goto_sign_in_page($post){
   	   global  $BackupDbQueries;
   	   $nonce = sanitize_text_field(wp_unslash($post['mo2f_goto_verifycustomer_nonce']));
		 if ( ! wp_verify_nonce( $nonce, 'mo2f-goto-verifycustomer-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        } 
   	   $user   = wp_get_current_user();
   	   update_option('mo_wpns_verify_customer','true');
	   update_option( 'mo_2factor_user_registration_status','MO_2_FACTOR_VERIFY_CUSTOMER' );
   }

	function barfw_revert_back_registration($post)
	{
		 $nonce = sanitize_text_field(wp_unslash($post['mo_eb_cancel_nonce']));
         if ( ! wp_verify_nonce( $nonce, 'mo-eb-cancel-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        } 
		$user   = wp_get_current_user();
		delete_option('mo2f_email');
		delete_option('mo_wpns_registration_status');
		delete_option('mo_wpns_verify_customer');
		update_option('mo_2factor_user_registration_status' , '' );
	}

	function barfw_reset_password($post)
	{
		$nonce = sanitize_text_field(wp_unslash($post['mo_eb_forget_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-eb-forget-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        } 
		$customer = new BARFW_Backup_Curl();
		$forgot_password_response = json_decode($customer->barfw_forgot_password());
		if($forgot_password_response->status == 'SUCCESS')
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('RESET_PASS'),'SUCCESS');
	}

	function barfw_verify_customer($post)
	{   
		global $moWpnsUtility;
		$nonce = sanitize_text_field(wp_unslash($post['mo_eb_login_nonce']));
		 if ( ! wp_verify_nonce( $nonce, 'mo-eb-login-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        } 
		
		$email 	  = sanitize_email( wp_unslash($post['email'] ));
		$password = sanitize_text_field( wp_unslash($post['password'] ));

		if( barfw_check_empty_or_null( $email ) || barfw_check_empty_or_null( $password ) ) 
		{
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('REQUIRED_FIELDS'),'ERROR');
			return;
		} 
		barfw_get_current_customer($email,$password);
	}

	function barfw_get_current_customer($email,$password)
	{
		global $BackupDbQueries;
		$user   = wp_get_current_user();
		$customer 	 = new BARFW_Backup_Curl();
		$content     = $customer->barfw_get_customer_key($email, $password);
		$customerKey = json_decode($content, true);
		if(json_last_error() == JSON_ERROR_NONE) 
		{
			if($customerKey==NULL || $customerKey=='ERROR')
			do_action('mo_eb_show_message','ERROR','ERROR');	
		    else
		    {
			if(isset($customerKey['phone'])){
				update_option( 'mo_wpns_admin_phone', $customerKey['phone'] );
				update_option( 'mo2f_user_phone' , $customerKey['phone']  );
			}
			update_option('mo2f_email',$email);
			barfw_save_success_customer_config($email, $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']);
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('REG_SUCCESS'),'SUCCESS');
			}
		} 
		else 
		{
			update_option('mo_backup_user_registration_status','MO_2_FACTOR_VERIFY_CUSTOMER' );
			update_option('mo_wpns_verify_customer', 'true');
			delete_option('mo_wpns_new_registration');
			do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('INVALID_CREDENTIALS'),'ERROR');
		}
	}
	
		
	function barfw_save_success_customer_config($email, $id, $apiKey, $token, $appSecret)
	{
		global $BackupDbQueries;

		$user   = wp_get_current_user();
		update_option( 'mo2f_customerKey'  , $id 		  );
		update_option( 'mo2f_api_key'       , $apiKey    );
		update_option( 'mo2f_customer_token'		 , $token 	  );
		update_option( 'mo2f_app_secret'			 , $appSecret );
		update_option( 'mo_wpns_enable_log_requests' , true 	  );
		update_option( 'mo2f_miniorange_admin', $user->ID );
		update_option( 'mo_2factor_admin_registration_status', 'MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS' );
		delete_option('mo_wpns_verify_customer');
		delete_option('mo2f_current_registration_status');
		delete_option( 'mo_wpns_password'						  ); 	
	}