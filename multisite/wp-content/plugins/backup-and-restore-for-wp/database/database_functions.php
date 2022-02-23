<?php
class BARFW_Backup_Query{
		
    function __construct(){
    	 global $wpdb;
    	 $this->userDetailsTable    = $wpdb->prefix . 'mo2f_user_details';
		$this->backupdetails		= $wpdb->base_prefix.'wpns_backup_created_report';
	}

function barfw_plugin_activate(){
require_once(ABSPATH . 'wp-admin'.DIRECTORY_SEPARATOR .'includes'.DIRECTORY_SEPARATOR .'upgrade.php');
    global $wpdb;
	if(!get_site_option('barfw_dbversion')||get_site_option('barfw_dbversion')<147)
	{
	    update_site_option('barfw_dbversion', BARFW_Backup_Constants::DB_VERSION );
		$this->barfw_generate_tables();
	}else{
		$current_db_version = get_site_option('barfw_dbversion');
		if($current_db_version < BARFW_Backup_Constants::DB_VERSION)
		update_site_option('barfw_dbversion', BARFW_Backup_Constants::DB_VERSION );
	}
}

function barfw_generate_tables(){
	global $wpdb;
	$tableName = $this->backupdetails;
	if($wpdb->get_var("show tables like '$tableName'") != $tableName){
		$sql = "CREATE TABLE " . $tableName . " (`id` int NOT NULL AUTO_INCREMENT,
		`backup_id` mediumtext NOT NULL, `file_name` mediumtext NOT NULL , `created_timestamp` bigint,`plugin_path` mediumtext NOT NULL , UNIQUE KEY id (id) );";
	    dbDelta($sql);
	}
}


function barfw_get_user_detail( $column_name, $user_id ) {
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '$this->userDetailsTable'")!==$this->userDetailsTable )
			return 'error';
		$user_column_detail = $wpdb->get_results( "SELECT " . $column_name . " FROM " . $this->userDetailsTable . " WHERE user_id = " . $user_id . ";" );
		$value              = empty( $user_column_detail ) ? '' : get_object_vars( $user_column_detail[0] );

		return $value == '' ? '' : $value[ $column_name ];
}


function barfw_insert_backup_detail($backup_id,$file_name,$backup_created_timestamp,$plugin_path){
	global $wpdb;
	$wpdb->insert(
	    $this->backupdetails,
	    array(
			'backup_id' =>$backup_id,
			'file_name' =>$file_name,
			'created_timestamp'=> $backup_created_timestamp,
			'plugin_path' => $plugin_path
	    ));
}

function barfw_get_table_content(){
    global $wpdb;
    return $wpdb->get_results("SELECT plugin_path,file_name,created_timestamp,id FROM ".$this->backupdetails);
}

function  barfw_get_number_of_plugin_backup(){
	global $wpdb;
			
	$plugin_count   =  $wpdb->get_var("SELECT COUNT(*) FROM ".$this->backupdetails." WHERE backup_id = 'plugin'");
	$themes_count   =  $wpdb->get_var("SELECT COUNT(*) FROM ".$this->backupdetails." WHERE backup_id = 'themes'");
	$wp_files_count =  $wpdb->get_var("SELECT COUNT(*) FROM ".$this->backupdetails." WHERE backup_id = 'wpfiles'");
	$db_count       =  $wpdb->get_var("SELECT COUNT(*) FROM ".$this->backupdetails." WHERE backup_id = 'db'");
	$total_backup   =  $wpdb->get_var("SELECT COUNT(*) FROM ".$this->backupdetails);
	$array          = array('plugin_count'=>$plugin_count,'themes_count'=>$themes_count,'wp_files_count'=>$wp_files_count,'db_count'=>$db_count,'total_backup'=>$total_backup);

	return $array;
}

function barfw_delete_file($id){
	global $wpdb;
	$wpdb->query(
		"DELETE FROM ".$this->backupdetails."
		WHERE id = ".$id
	);
	return;
}

function barfw_row_exist($id){
	global $wpdb;
	$is_exist = $wpdb->get_var("SELECT COUNT(*) FROM ".$this->backupdetails." WHERE id =".$id );
	return $is_exist;
}

}