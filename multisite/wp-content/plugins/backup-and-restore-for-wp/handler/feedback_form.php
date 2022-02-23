<?php
class BARFW_Feedback_Handler
{
    function __construct()
    {
        add_action('admin_init', array($this, 'barfw_feedback_actions'));
    }

function barfw_feedback_actions()
{
    global $moWpnsUtility, $MoBackupDirName;
    if (current_user_can('manage_options') && isset($_POST['option'])) {
        $option = sanitize_text_field(wp_unslash($_REQUEST['option']));
       switch ($option) {
        case 'mo_eb_skip_feedback':  
            $this->barfw_handle_feedback($_POST);
            break;
        case "mo_eb_feedback":                    
            $this->barfw_handle_feedback($_POST);
            break;
        case "mo_wpns_backup_download":
            $this->barfw_backup_download($_POST);
            break;
        }
    }
}


function barfw_handle_feedback($postdata)
{ 

   if(BARFW_TEST_MODE){
     deactivate_plugins(dirname(dirname(__FILE__ ))."\\miniorange_backup_setting.php");
         return;
    }
      if(sanitize_text_field(wp_unslash($postdata['option']))==='mo_eb_feedback'){
        $nonce = sanitize_text_field(wp_unslash($postdata['mo_eb_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-eb-feedback-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        }
       }else if(sanitize_text_field(wp_unslash($postdata['option']))==='mo_eb_skip_feedback'){
         $nonce = sanitize_text_field(wp_unslash($postdata['mo_eb_skip_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-eb-skip-nonce' ) ){
          do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        }
       } 

           
    $user = wp_get_current_user();
    $feedback_option = sanitize_text_field(wp_unslash($postdata['option']));
    $message = 'Plugin Deactivated';

    $deactivate_reason_message = array_key_exists('mo_eb_query_feedback', $postdata) ? sanitize_text_field(wp_unslash($postdata['mo_eb_query_feedback'])) : false;


    $reply_required = '';
    if (isset($postdata['get_reply']))
        $reply_required = sanitize_text_field(wp_unslash($postdata['get_reply']));
    if (empty($reply_required)) {
        $reply_required = "don't reply";
        $message .= '<b style="color:red";> &nbsp; [Reply :' . $reply_required . ']</b>';
    } else {
        $reply_required = "yes";
        $message .= '[Reply :' . $reply_required . ']';
    }


    $message .= ', Feedback : ' . $deactivate_reason_message . '';

  
    if (isset($postdata['rate'])){
        $rate_value = sanitize_text_field(wp_unslash($postdata['rate']));
        $message .= ', [Rating :' . $rate_value . ']';
   }
   else{
      $message .= ', [Rating :]';
   }

  if(isset($postdata['query_mail']))
   {
   $email = sanitize_email($postdata['query_mail']);
   }
   else
    $email='';
   

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = get_site_option('mo2f_email');
        if (empty($email))
            $email = $user->user_email;
    }
    $phone = get_site_option('mo_wpns_admin_phone');
    $feedback_reasons = new BARFW_Backup_Curl();
   
    if (!is_null($feedback_reasons)) {
        if (!$this->barfw_is_curl_installed()) {
            deactivate_plugins(dirname(dirname(__FILE__ ))."\\miniorange_backup_setting.php");
            wp_redirect('plugins.php');
        } else {
            $submited = json_decode($feedback_reasons->barfw_send_email_alert($email, $phone, $message, $feedback_option), true);
            if (json_last_error() == JSON_ERROR_NONE) {
                if (is_array($submited) && array_key_exists('status', $submited) && $submited['status'] == 'ERROR') {
                    do_action('mo_eb_show_message',$submited['message'],'ERROR');

                } else {
                    if ($submited == false) {
                        do_action('mo_eb_show_message','Error while submitting the query.','ERROR');
                    }
                }
            }

            deactivate_plugins(dirname(dirname(__FILE__ ))."\\miniorange_backup_setting.php");
            do_action('mo_eb_show_message','Thank you for the feedback.','SUCCESS');

        }
    }
}

public static function barfw_is_curl_installed()
{
    if  (in_array  ('curl', get_loaded_extensions()))
        return 1;
    else 
        return 0;
}


function barfw_backup_download($postdata){
    global $BackupDbQueries;
    
    $nonce = sanitize_text_field(wp_unslash($postdata['download_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-wpns-download-nonce' ) ){
         do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NONCE_ERROR'),'ERROR');
          return;
        }

     ob_start();
     if(current_user_can('administrator')){
        $file_name=sanitize_text_field(wp_unslash($postdata['file_name']));
        $file_path=sanitize_text_field(wp_unslash($postdata['file_path']));
        $file = explode('/', $file_name);
        $file_name = $file[0];
        $id = $file[1];
        $status = file_exists($file_path.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.$file_name);
        if($status){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=".$file_name);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($file_path.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.$file_name));
        while (ob_get_level()) {
            ob_end_clean();
            @readfile($file_path.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.$file_name);
        }
      }else{
	        $BackupDbQueries->barfw_delete_file($id);
        do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('DELETE_FILE'),'ERROR');
        return;
      } 
    }else{
        do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('NOT_ADMIN'),'ERROR');
        return;
    }
    
    }

}new BARFW_Feedback_Handler();
