<?php

class BARFW_Backup_Site{

function __construct()
{
	add_filter( 'cron_schedules', array($this,'barfw_db_backup_interval'));
	add_action( 'mo_eb_bl_cron_hook', array($this,'barfw_db_cron_backup') );
	add_filter( 'cron_schedules', array($this,'barfw_file_backup_interval'));
	add_action( 'mo_eb_file_cron_hook', array($this,'barfw_cron_file_backup') );
}
    
function barfw_db_cron_backup(){

		$obj = new BARFW_Backup_Site;
		$obj->barfw_create_db_backup();
	
}

function barfw_db_backup_interval($schedules){
	$mo2f_cron_hours = get_site_option('mo_wpns_backup_time')*3600;
	$schedules['db_eb_backup_time'] = array(
		'interval' => $mo2f_cron_hours,
		'display'  => esc_html__( 'Cron Activated' ),
	);
    return $schedules;
}

function barfw_db_cron_deactivate() {
	$timestamp = wp_next_scheduled( 'mo_eb_bl_cron_hook' );
	wp_unschedule_event( $timestamp, 'mo_eb_bl_cron_hook' );
}

function barfw_cron_file_backup(){
  $backup_store_path =  wp_upload_dir();
  $backup_store_path = $backup_store_path['basedir'].DIRECTORY_SEPARATOR;
  $time = time();
  update_site_option('backup_created_time',$time);

	if(get_site_option('mo_file_backup_plugins') =='1'){
		$this->barfw_plugin_backup($backup_store_path, $time);
	}
	if(get_site_option('mo_file_backup_themes')=='1'){
      $this->barfw_themes_backup($backup_store_path ,$time);  
	}

	if(get_site_option('mo_file_backup_wp_files') == '1'){
		$this->barfw_wpfiles_backup($backup_store_path, $time);
	}
  		
}

function barfw_manual_file_backup(){
  $backup_store_path =  wp_upload_dir();
  $backup_store_path = $backup_store_path['basedir'].DIRECTORY_SEPARATOR;
  $time = time();
  update_site_option('backup_created_time',$time);

	if(get_site_option('mo_file_manual_backup_plugins') =='1'){
		$this->barfw_plugin_backup($backup_store_path, $time);
	}
	if(get_site_option('mo_file_manual_backup_themes')=='1'){
      $this->barfw_themes_backup($backup_store_path ,$time);  
	}

	if(get_site_option('mo_file_manual_backup_wp_files') == '1'){
		$this->barfw_wpfiles_backup($backup_store_path, $time);
	}
  		
}

function barfw_file_backup_interval($schedules){
	$mo2f_cron_file_backup_hours = get_site_option('mo_wpns_backup_time')*3600;
	$schedules['file_eb_backup_time'] = array(
		'interval' => $mo2f_cron_file_backup_hours,
		'display'  => esc_html__( 'Cron Activated' ),
	);
 return $schedules;
}

function barfw_file_backup_cron_deactivate(){
	$timestamp = wp_next_scheduled( 'mo_eb_file_cron_hook' );
	wp_unschedule_event( $timestamp, 'mo_eb_file_cron_hook' );
 }

 function barfw_plugin_backup($backup_store_path, $time){
    global $BackupDbQueries;
        $this->barfw_mkdirectory('plugins');
        $real_path= WP_PLUGIN_DIR;
        $backup_path =$backup_store_path.'miniorangebackup'.DIRECTORY_SEPARATOR.'file-backups'.DIRECTORY_SEPARATOR.'plugins';
		$filename = 'miniorange-plugins-backup-'.$time.'.zip';
		$this->barfw_create_files_backup($real_path,$filename,'plugins');
	 $BackupDbQueries->barfw_insert_backup_detail(BARFW_Backup_Constants::PLUGIN,$filename,$time,$backup_path);
}

 function barfw_themes_backup($backup_store_path ,$time){
    global $BackupDbQueries;
        $this->barfw_mkdirectory('themes');
		$real_path= get_theme_root();
        $backup_path =$backup_store_path.'miniorangebackup'.DIRECTORY_SEPARATOR.'file-backups'.DIRECTORY_SEPARATOR.'themes';
		$filename = 'miniorange-themes-backup-'.$time.'.zip';
		$this->barfw_create_files_backup($real_path,$filename,'themes');
	    $BackupDbQueries->barfw_insert_backup_detail(BARFW_Backup_Constants::THEMES,$filename,$time,$backup_path);

 }

 function barfw_wpfiles_backup($backup_store_path, $time){
    global $BackupDbQueries;
    $homepath = get_home_path();
 	    $this->barfw_mkdirectory('wp_files');
		$real_path= $homepath;
		$backup_path =$backup_store_path.'miniorangebackup'.DIRECTORY_SEPARATOR.'file-backups'.DIRECTORY_SEPARATOR.'wp_files';
		$filename = 'miniorange-wpfiles-backup-'.$time.'.zip';
		$this->barfw_create_files_backup($real_path,$filename, 'wp_files');
	    $BackupDbQueries->barfw_insert_backup_detail(BARFW_Backup_Constants::WPFILES,$filename,$time,$backup_path);
 }

 function barfw_mkdirectory($foldername){
    
   $homepath =  wp_upload_dir();
   $homepath = $homepath['basedir'].DIRECTORY_SEPARATOR;
   if(!is_writable($homepath)){
     wp_send_json('not_writable');
     return;
   }


   $basepath = $homepath;
   if(!file_exists($basepath."miniorangebackup")){
		mkdir($basepath."miniorangebackup");
    }

    $basepath = $homepath.'miniorangebackup'.DIRECTORY_SEPARATOR;
    $this-> barfw_create_index_file($basepath);
		      
    if(!file_exists($basepath.'file-backups')){
	     mkdir($basepath.'file-backups');
    }

    $basepath = $homepath.'miniorangebackup'.DIRECTORY_SEPARATOR.'file-backups'.DIRECTORY_SEPARATOR;
    if(!file_exists($basepath.$foldername)){
     	mkdir($basepath.$foldername);
    }
           
}

function barfw_create_index_file($folder_path){

	$html_path=$folder_path."index.html";
	$htaccess_path= $folder_path.".htaccess";

	if(!file_exists($html_path)){
        $f = fopen($html_path, "a");
        fwrite($f, '<html><body><a href="https://security.miniorange.com/" target="_blank">WordPress backups by miniorange</a></body></html>');
        fclose($f);
    }
    if(!file_exists($htaccess_path)){
    	$f = fopen($htaccess_path, "a");
    	fwrite($f, "deny from all");
    	fclose($f);
    }
}

function barfw_create_files_backup($real_path, $filename, $foldername){
	ini_set('max_execution_time', 0);
     $backup_store_path =  wp_upload_dir();
     $backup_store_path = $backup_store_path['basedir'].DIRECTORY_SEPARATOR.'miniorangebackup'.DIRECTORY_SEPARATOR.'file-backups'.DIRECTORY_SEPARATOR;
    $rootPath = realpath($real_path);
    $zip = new ZipArchive();
    $res = $zip->open($backup_store_path.$foldername.DIRECTORY_SEPARATOR.$filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    $files = new RecursiveIteratorIterator(
	    new RecursiveDirectoryIterator($rootPath),
	    RecursiveIteratorIterator::LEAVES_ONLY
	);
	foreach ($files as $name => $file)
	{
	   if (!$file->isDir())
	    {
	       $filePath = $file->getRealPath();
	       $relativePath = substr($filePath, strlen($rootPath) + 1);
           if(strpos($relativePath, 'miniorangebackup')!== false ){}
           else{
               $zip->addFile($filePath, $relativePath);
            }
        }
    }   
	$zip->close();
}


function barfw_create_db_backup(){
		
	if ( function_exists('memory_get_usage') && ( (int) ini_get('memory_limit') < 128 ) ){
		ini_set('memory_limit', '128M' );
		do_action('mo_eb_show_message',BARFW_Backup_Messages::barfw_show_essage('DB_MEMORY_LIMIT'),'SUCCESS');
	}

  	$backup_store_path = wp_upload_dir();
  	$backup_store_path = $backup_store_path['basedir'].DIRECTORY_SEPARATOR;
    
    if(!is_writable($backup_store_path)){
    	wp_send_json('not_writable');
    	return;
    }
	global $wpdb;
	$tables 		= $wpdb->get_results("SHOW TABLES", ARRAY_N);
	$nooftables 	= count($tables);
	$query			= "";
	$tableswithfk 	= array();
	$tableswithoutfk= array();

	foreach($tables as $table)
	{
		if(is_array($table))
			$table = $table[0];
		$createtable = $wpdb->get_results("SHOW CREATE TABLE  $table", ARRAY_A);
		if(!empty($createtable[0]))
		{
			$createquery = $createtable[0]['Create Table'];
			if (strpos($createquery, 'FOREIGN KEY') !== false) 
				array_push($tableswithfk,$table);
			else
				array_push($tableswithoutfk, $table);
		}
	}
	
	$query .= $this->barfw_get_table_query($query,$tableswithoutfk);

	$query .= $this->barfw_get_table_query($query,$tableswithfk);

	$fileName = $this->barfw_create_db_backup_file($query);
	wp_send_json('created backup');
}

function barfw_get_table_query($query,$tables)
{

global $wpdb;
foreach($tables as $table)
{
	$createtable = $wpdb->get_results("SHOW CREATE TABLE  $table", ARRAY_A);
	if(!empty($createtable[0]))
	{		
		$createquery = $createtable[0]['Create Table'];		
		$query 	    .= 'DROP TABLE IF EXISTS '.$table.";\n";
		$query 	    .= $createquery.";\n\n";
		$data    	 = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
		foreach($data as $record)
		{
			if(count($record)>0)
			{
				$query.= 'INSERT INTO '.$table.' VALUES(';
				$i=0;
				foreach($record as $key=>$value)
				{
					$value = addslashes($value);
					if (isset($value))
						$query.= '"'.$value.'"' ;
					else
						$query.= '""';
					if ($i < (count($record)-1)) { $query.= ','; }
					$i++;
				}
				$query.= ");\n";
			}
		}
		$query.="\n\n";
	}
}
return $query;
}

function barfw_create_db_backup_file($data)
{  
    global $BackupDbQueries;
    $time = time();
	$backup_store_path = wp_upload_dir();
    $backup_store_path = $backup_store_path['basedir'].DIRECTORY_SEPARATOR;
	
	if(!file_exists($backup_store_path."miniorangebackup")){
			mkdir($backup_store_path."miniorangebackup");
		}
        $basepath = $backup_store_path.'miniorangebackup'.DIRECTORY_SEPARATOR;
		$handler_obj = new BARFW_Backup_Site;
		$handler_obj->barfw_create_index_file($basepath);
		if(!file_exists($basepath.'db-backups')){
			mkdir($basepath.'db-backups');
		}

    $backup_path = $basepath.'db-backups';	 
	$filename = 'miniorange-db-backup-'.$time.'.sql';
	$basepath = $basepath.'db-backups';
	$handle = fopen($basepath.DIRECTORY_SEPARATOR.$filename,'w+');
	fwrite($handle,$data);
	fclose($handle);
	$BackupDbQueries->barfw_insert_backup_detail(BARFW_Backup_Constants::DATABASE,$filename,$time,$backup_path);
	return $filename;
}
}new BARFW_Backup_Site;