<?php
            

          //if uninstall not called from WordPress exit
	       if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
		       exit();

   
            
		    delete_site_option('mo_file_backup_plugins');
			delete_site_option('mo_file_backup_themes');
		    delete_site_option('mo_file_backup_wp_files');
		    delete_site_option('mo2f_cron_file_backup_hours');
		    delete_site_option('mo2f_cron_hours');
		    delete_site_option('file_backup_created');
			delete_site_option('db_backup_created');
			delete_site_option('scheduled_file_backup');
			delete_site_option('scheduled_db_backup');
			delete_site_option('file_backup_created_time');
			delete_site_option('db_backup_created_time');
			delete_site_option('storage_type','local_storage');
			delete_site_option('mo_database_backup');
			delete_site_option('mo_wpns_backup_time');
			delete_site_option('enable_backup_schedule');
			delete_site_option('barfw_dbversion');
			delete_site_option('backup_created_time');
			delete_site_option('not_admin');
			delete_site_option('mo_file_manual_backup_plugins');
			delete_site_option('mo_file_manual_backup_themes');
			delete_site_option('mo_file_manual_backup_wp_files');
			delete_site_option('mo_schedule_database_backup');
			

			global $wpdb;
	        $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}wpns_backup_created_report" );

?>