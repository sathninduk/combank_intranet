<?php

 $file_backup_time =get_site_option('file_backup_created_time');
 $db_eb_backup_time = get_site_option('db_backup_created_time');
 $file_schedule_status = get_site_option('scheduled_file_backup');
 $db_backup_status = get_site_option('scheduled_db_backup');
 $next_file_backup_hours = get_site_option('mo_wpns_backup_time');
 $next_db_backup_hours = get_site_option('mo_wpns_backup_time');
 $page_url			= "";
 $file_next_backup_timestamp = wp_next_scheduled( 'mo_eb_file_cron_hook' );
 $db_next_backup_timestamp   = wp_next_scheduled( 'mo_eb_bl_cron_hook' );

 $file_date = date('d-m-Y', $file_next_backup_timestamp);
 $file_time = date('H:i', $file_next_backup_timestamp);
 $file_day  = date('l',$file_next_backup_timestamp);

 $db_date = date('d-m-Y', $db_next_backup_timestamp);
 $db_time = date('H:i', $db_next_backup_timestamp);
 $db_day  = date('l',$db_next_backup_timestamp);



include_once $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'backup_schdule.php';