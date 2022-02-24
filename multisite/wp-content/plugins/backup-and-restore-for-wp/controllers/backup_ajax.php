<?php
class BARFW_File_Db_Backup{

	function __construct(){

		add_action( 'admin_init'  , array( $this, 'barfw_file_db_backup_functions' ) );

}
public function barfw_file_db_backup_functions(){

		add_action('wp_ajax_barfw_backup_ajax_redirect', array( $this, 'barfw_backup_ajax_redirect' ));
}

public function barfw_backup_ajax_redirect(){
	   $call_type = sanitize_text_field(wp_unslash($_POST['call_type']));
     switch($call_type)
		  {
			case "submit_backup_settings_form":
				$this->barfw_save_backup_config_form($_POST);
				break;
			case "submit_schedule_settings_form":
        $this->barfw_save_schedule_backup_config_form($_POST);
        break;
      case "delete_backup":
         $this->barfw_delete_backup($_POST);
         break;
      
        
		 }
}

public function barfw_save_backup_config_form($postData){
      $nonce = sanitize_text_field(wp_unslash($postData['nonce']));
        if ( ! wp_verify_nonce( $nonce, 'wpns-backup-settings' ) ){
          wp_send_json('ERROR');
          return;
        }
		
		if(! isset($postData['backup_plugin']) && ! isset($postData['backup_themes']) && ! isset($postData['backup_wp_files'])  && ! isset($postData['database'])){
			wp_send_json('folder_error');
			return;
    } 

		isset($postData['backup_plugin']) ?  update_site_option( 'mo_file_manual_backup_plugins', sanitize_text_field(wp_unslash($postData['backup_plugin']))) : update_site_option( 'mo_file_manual_backup_plugins', 0);

		isset($postData['backup_themes']) ? update_site_option( 'mo_file_manual_backup_themes', sanitize_text_field(wp_unslash($postData['backup_themes']))) : update_site_option( 'mo_file_manual_backup_themes', 0);

		isset($postData['backup_wp_files']) ? update_site_option( 'mo_file_manual_backup_wp_files', sanitize_text_field(wp_unslash($postData['backup_wp_files']))) : update_site_option( 'mo_file_manual_backup_wp_files', 0);

		isset($postData['database']) ? update_site_option( 'mo_database_backup', sanitize_text_field(wp_unslash($postData['database']))) : update_site_option( 'mo_database_backup', 0);

    if(isset($postData['backup_plugin']) || isset($postData['backup_themes']) || isset($postData['backup_wp_files'])) {
      $handler_obj = new BARFW_Backup_Site;
      update_site_option('file_backup_created_time',date("l").' , '.date("d-m-Y") .'  '.date("h:i"));
      $handler_obj->barfw_manual_file_backup();
     
     }
     if(isset($postData['database'])) {

      $handler_obj = new BARFW_Backup_Site;
      update_site_option('db_backup_created_time',date("l").' , '.date("d-m-Y") .'  '.date("h:i"));
      $handler_obj->barfw_create_db_backup();
      
     }
   wp_send_json('created_backup');
   return;
		
}

function barfw_save_schedule_backup_config_form($postData){
    
     $nonce = sanitize_text_field(wp_unslash($postData['nonce']));
        if ( ! wp_verify_nonce( $nonce, 'wpns-schedule-backup' ) ){
          wp_send_json('ERROR');
          return;
        }

    $handler_obj = new BARFW_Backup_Site;
      if(!isset($postData['backup_plugin']) && ! isset($postData['backup_themes']) && ! isset($postData['backup_wp_files']) && ! isset($postData['database']))
      {
			wp_send_json('folder_error');
			return;
		 } 

	  isset($postData['backup_plugin']) ?  update_site_option( 'mo_file_backup_plugins', sanitize_text_field(wp_unslash($postData['backup_plugin']))) : update_site_option( 'mo_file_backup_plugins', 0);

	  isset($postData['backup_themes']) ? update_site_option( 'mo_file_backup_themes', sanitize_text_field(wp_unslash($postData['backup_themes']))) : update_site_option( 'mo_file_backup_themes', 0);

	  isset($postData['backup_wp_files']) ? update_site_option( 'mo_file_backup_wp_files', sanitize_text_field(wp_unslash($postData['backup_wp_files']))) : update_site_option( 'mo_file_backup_wp_files', 0);

    isset($postData['database']) ? update_site_option( 'mo_schedule_database_backup', sanitize_text_field(wp_unslash($postData['database']))) : update_site_option( 'mo_schedule_database_backup', 0);

    if(sanitize_text_field(wp_unslash($postData['backup_time']))==='12'|| sanitize_text_field(wp_unslash($postData['backup_time'])) ==='24'|| sanitize_text_field(wp_unslash($postData['backup_time']))==='168'|| sanitize_text_field(wp_unslash($postData['backup_time']))==='360'||sanitize_text_field(wp_unslash($postData['backup_time']==='720')))
    {
      isset($postData['backup_time']) ? update_site_option( 'mo_wpns_backup_time', sanitize_text_field(wp_unslash($postData['backup_time']))) : update_site_option( 'mo_wpns_backup_time', 0);
    }else{
      wp_send_json('invalid_hours');
      return;
    }

    isset($postData['enable_backup_schedule']) ? update_site_option( 'enable_backup_schedule', sanitize_text_field(wp_unslash($postData['enable_backup_schedule']))) : update_site_option( 'enable_backup_schedule', 0);

    isset($postData['local_storage']) ? update_site_option( 'storage_type', sanitize_text_field(wp_unslash($postData['local_storage']))) : update_site_option( 'storage_type', 0); 
     
     if(get_site_option('enable_backup_schedule') === '1'){
     
        if(isset($postData['backup_plugin']) || isset($postData['backup_themes']) || isset($postData['backup_wp_files'])){
            $handler_obj-> barfw_file_backup_cron_deactivate();
             if (!wp_next_scheduled( 'mo_eb_file_cron_hook')) {
                 wp_schedule_event( time(), 'file_eb_backup_time', 'mo_eb_file_cron_hook' );
                }
                update_site_option('file_backup_created_time',date("l").' , '.date("d-m-Y") .'  '.date("h:i"));
                update_site_option('scheduled_file_backup',1);
        } 
        else
                $handler_obj-> barfw_file_backup_cron_deactivate();

        if(get_site_option('mo_schedule_database_backup') === '1'){
               $handler_obj->barfw_db_cron_deactivate();
                if ( ! wp_next_scheduled( 'mo_eb_bl_cron_hook' ) ) {
                    wp_schedule_event( time(), 'db_eb_backup_time', 'mo_eb_bl_cron_hook' );
                } 
                update_site_option('db_backup_created_time',date("l").' , '.date("d-m-Y") .'  '.date("h:i"));
                update_site_option('scheduled_db_backup',1);
          }
          else
               $handler_obj->barfw_db_cron_deactivate();

        wp_send_json('success');
           
     }else{
       $handler_obj-> barfw_file_backup_cron_deactivate();
        $handler_obj->barfw_db_cron_deactivate();
        update_site_option('scheduled_db_backup',0);
        update_site_option('scheduled_file_backup',0);
        wp_send_json('disable');
      
     }

}





function barfw_delete_backup($postData){
      $nonce = sanitize_text_field(wp_unslash($postData['nonce']));
        if ( ! wp_verify_nonce( $nonce, 'delete_entry' ) ){
          wp_send_json('ERROR');
          
        }
    
    if(current_user_can('administrator')){ 
      global $BackupDbQueries;
      $id = $postData['id'];
      $row_exist = (int)$BackupDbQueries->barfw_row_exist($id);
      $status = file_exists(sanitize_text_field(wp_unslash($postData["folder_name"])).DIRECTORY_SEPARATOR. sanitize_text_field(wp_unslash($postData['file_name'])));
       if($status){
          unlink(sanitize_text_field(wp_unslash($postData["folder_name"])).DIRECTORY_SEPARATOR.sanitize_text_field(wp_unslash( $postData['file_name'])));
            if($row_exist)
	            $BackupDbQueries->barfw_delete_file($id);
          wp_send_json('success');
        
        }else{
	       $BackupDbQueries->barfw_delete_file($id);
          wp_send_json('notexist');
         
        }
        
     } 
  }
}new BARFW_File_Db_Backup();
?>