<?php
class Mo_Wpum_Notification_Actions{
	
	public function mo_wpum_send_activation_email($user_ids,$signup_ids){
		global $db_queries,$mo_manager_utility,$wpdb,$default_template;
		$current_site = get_site_url();
		foreach($signup_ids as $signup_id)
		{ 
			$signup_details = $db_queries->get_customer_signup_detail($signup_id); 
			$activation_key = $signup_details->activation_key;
			$activation_link = $current_site.'/user/activate/?id='.$signup_id.'&key='.$activation_key;
			$site_name = get_bloginfo();
			$content = $default_template->activation_email_body;
			$content = str_replace('##Blog Name##',$site_name,$content);
			$content = str_replace('##Activation Link##',$activation_link,$content);
			$from_mail = get_option('admin_email');
			$to_mail = $wpdb->get_var( $wpdb->prepare( "SELECT user_email FROM {$wpdb->prefix}signups WHERE signup_id = %d", $signup_id ) );
			$subject = 'miniOrange User Management | '.get_bloginfo();
			$headers = "From: no-reply@xecurify.com\r\n";
			$headers .= "Content-Type: text/html";
			if((ini_get('SMTP')!= FALSE)  ||(ini_get('smtp_port') != FALSE)){
				$status = wp_mail($to_mail,$subject,$content,$headers);
				if($status){
					update_option( 'mo_wpum_message','Mail sent successfully.');
					$mo_manager_utility->mo_wpum_show_success_message();
				} else {
					update_option('mo_wpum_message', 'Mail not sent. Please make sure your PHP mail() is configured.');
					$mo_manager_utility->mo_wpum_show_error_message();
				}
			}
			
			$db_queries->update_notification_data($signup_id);
		}
	}

	public function mo_wpum_send_admin_notification($user_id){
		global $wpdb,$mo_manager_utility,$db_queries,$default_template;
		$user_name = $wpdb->get_var( $wpdb->prepare( "SELECT user_login FROM {$wpdb->users} WHERE ID = %d", $user_id ) );
		$user_email = $wpdb->get_var( $wpdb->prepare( "SELECT user_email FROM {$wpdb->users} WHERE ID = %d", $user_id ) );
		$signup_id = $wpdb->get_var( $wpdb->prepare( "SELECT signup_id FROM {$wpdb->prefix}signups WHERE user_email = %s", $user_email));
		//$to_mail = get_option('admin_email');
		$current_site = get_site_url();
		$signup_details = $db_queries->get_customer_signup_detail($signup_id); 
		$activation_key = $signup_details->activation_key;
		$admin_activate = $current_site.'/admin/activate?id='.$signup_id.'&key='.$activation_key;
		$site_name = get_bloginfo();
		$content = $default_template->admin_notification_body;
		$content = str_replace('##Blog Name##',$site_name,$content);
		$content = str_replace('##User Name##',$user_name,$content);
		$content = str_replace('##User Email##',$user_email,$content);
		$content = str_replace('##Activation Link##',$admin_activate,$content);
		$from_mail = 'no-reply@xecurify.com';
		$to_mail = get_option('mo_wpum_admin_email');
		$subject = 'miniOrange User Management | '.get_bloginfo();
		$headers = "From: no-reply@xecurify.com\r\n";
		$headers .= "Content-Type: text/html";
			
			if( get_option('mo_wpum_send_email_enable') == 1 )
			{ 
				if((ini_get('SMTP')!= FALSE)  ||(ini_get('smtp_port') != FALSE))
				{
					$status = wp_mail($to_mail,$subject,$content,$headers);
					if($status)
					{ 
						update_option( 'mo_wpum_message','Mail sent successfully.');
						$mo_manager_utility->mo_wpum_show_success_message(); 
					} 
				}
				else 
				{ 
					update_option('mo_wpum_message', 'Mail not sent. Please make sure your PHP mail() is configured.');
					$mo_manager_utility->mo_wpum_show_error_message();
				}
			}
	}
}
?>