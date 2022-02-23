<?php
global $MoBackupDirName;
$MoBackupDirName = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR;

if(current_user_can( 'manage_options' )  && isset($_POST['option'])){
	$option = sanitize_text_field(wp_unslash($_POST['option']));
	
    switch($option)
	{
        case "mo_wpns_send_query":
		    barfw_handle_support_form(sanitize_email($_POST['query_email']), sanitize_text_field($_POST['query']), sanitize_text_field($_POST['query_phone']),sanitize_text_field(wp_unslash($_POST['mo_eb_support_nonce'])));
		    break;
		}
	}
	$current_user 	= wp_get_current_user();
	$email 			= get_site_option("mo2f_email");
	$phone 			= get_site_option("mo_wpns_admin_phone");
	if($phone =='false')
		$phone='';
	if(empty($email))
		$email 		= $current_user->user_email;

	include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'support.php';

function barfw_handle_support_form($email,$query,$phone,$nonce){

      
	 if ( ! wp_verify_nonce( $nonce, 'mo-eb-support-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        } 
	
	if( empty($email) || empty($query) )
	{
	    do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('SUPPORT_FORM_VALUES'),'SUCCESS');
		return;
	}
	
	if(!empty($phone) && !is_numeric($phone))
	{
		do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('INVALID_PHONE'),'SUCCESS');
		return;
	}
	$contact_us = new BARFW_Backup_Curl();
	$submited = $contact_us->barfw_submit_contact_us($email, $phone, $query);
    if(json_last_error() == JSON_ERROR_NONE) 
	{
		do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('SUPPORT_FORM_SENT'),'SUCCESS');
		return;
	}else if($submited === 'Query submitted.'){
		do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('SUPPORT_FORM_SENT'),'SUCCESS');
	}else{
		do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('SUPPORT_FORM_ERROR'),'ERROR');
	}
	
}