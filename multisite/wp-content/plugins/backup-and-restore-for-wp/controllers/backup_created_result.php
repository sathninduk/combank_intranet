<?php
 function barfw_show_backup_results(){
 	global $BackupDbQueries;
    $array = $BackupDbQueries->barfw_get_table_content();
    $array_size = sizeof($array);
 	for($i=0; $i<(int)$array_size; $i++){
 		$backup_file_path = $array[$i]->plugin_path.DIRECTORY_SEPARATOR.$array[$i]->file_name;
 		if(file_exists($backup_file_path))
      barfw_show_backup_report($array[$i]->plugin_path, $array[$i]->file_name, $array[$i]->created_timestamp,$array[$i]->id);
       else
       	$BackupDbQueries->barfw_delete_file($array[$i]->id);
 	}
}
?>