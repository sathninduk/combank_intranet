<?php
/**
 * Plugin Name: Backup and Restore For Wp
 * Plugin URI: https://miniorange.com
 * Description: Creating regular backups for your website is essential. By Creating backup you can restore your website back to normal within a few minutes. miniOrange creates database and file Backup which is stored locally in your system.
 * Version: 1.0.3
 * Author: miniOrange
 * Author URI: https://miniorange.com
 * License: GPL2
 */
define( 'BARFW_PLUGIN_VERSION', '1.0.3' );
define( 'BARFW_TEST_MODE', false );
	class BARFW_Mo{
            
		function __construct()
		{
			register_deactivation_hook(__FILE__		 , array( $this, 'barfw_deactivate'		       )		);
			register_activation_hook  (__FILE__		 , array( $this, 'barfw_activate'			       )		);
			if(is_multisite())
			add_action( 'network_admin_menu'		 , array( $this, 'barfw_widget_menu'		  	   )		);
		    else
		    add_action( 'admin_menu'		         , array( $this, 'barfw_widget_menu'		  	   )		);
		    	
			add_action( 'admin_enqueue_scripts'		 , array( $this, 'barfw_settings_style'	       )		);
			add_action( 'admin_enqueue_scripts'		 , array( $this, 'barfw_settings_script'	       )	    );
			add_action( 'mo_eb_show_message'		 	 , array( $this, 'barfw_show_messages' 				   ), 1 , 2 );
			$this->barfw_includes();
            add_action( 'admin_footer', array( $this, 'barfw_feedback_request' ) );
			$notify = new BARFW_Backup_Notification;
			if(is_multisite())
		    add_action('wp_network_dashboard_setup', array($notify,'barfw_custom_dashboard_widgets'));
		    else
		    add_action('wp_dashboard_setup', array($notify,'barfw_custom_dashboard_widgets'));

		}
	
	
	function barfw_feedback_request() {
            if ( 'plugins.php' != basename( $_SERVER['PHP_SELF'] ) ) {
                return;
            }
            global $MoBackupDirName;
           
            $email = get_site_option("mo2f_email");
            $email = esc_html($email);
             
            if(empty($email)){
                $user = wp_get_current_user();
                $email = $user->user_email;
            }
            $imagepath=plugins_url( DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR, __FILE__ );

            wp_enqueue_style( 'wp-pointer' );
            wp_enqueue_script( 'wp-pointer' );
            wp_enqueue_script( 'utils' );
            wp_enqueue_style( 'mo_wpns_admin_plugins_page_style', plugins_url( DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'css'.DIRECTORY_SEPARATOR .'style_settings.css?ver=1.0.0', __FILE__ ) );
			include $MoBackupDirName .'views'.DIRECTORY_SEPARATOR.'feedback_form.php';
		}


	function barfw_activate(){

		    global $BackupDbQueries;
			$BackupDbQueries->barfw_plugin_activate();
            
		    add_site_option('mo_file_backup_plugins',1);
			add_site_option('mo_file_backup_themes',1);
			add_site_option('mo_file_manual_backup_plugins',1);
			add_site_option('mo_file_manual_backup_themes',1);
		    add_site_option('mo_wpns_backup_time',12);
		    add_site_option('file_backup_created',0);
			add_site_option('db_backup_created',0);
			add_site_option('scheduled_file_backup',0);
			add_site_option('scheduled_db_backup',0);
			add_site_option('file_backup_created_time',0);
			add_site_option('db_backup_created_time',0);
			add_site_option('mo_database_backup',1);
			add_site_option('mo_schedule_database_backup',1);
	}	

	function barfw_deactivate(){
         
			delete_site_option('mo_file_backup_plugins');
			delete_site_option('mo_file_backup_themes');
			delete_site_option('mo_file_backup_type');
			delete_site_option('mo_database_backup_type');
			delete_site_option('mo2f_cron_file_backup_hours');
			delete_site_option('mo2f_cron_hours');
			delete_site_option('mo2f_cron_hours');
			delete_site_option('file_backup_created');
			delete_site_option('db_backup_created');
			delete_site_option('scheduled_file_backup');
			delete_site_option('scheduled_db_backup');
			delete_site_option('file_backup_created_time');
			delete_site_option('db_backup_created_time');
			delete_site_option('mo_file_backup_wp_files');
			delete_site_option('mo_schedule_database_backup');
	}


	function barfw_widget_menu(){
		$menu_slug = 'mo_eb_backup_settings';
            
            
			add_menu_page (	'Backup and Restore For Wp' , 'Backup and Restore For Wp' , 'activate_plugins', $menu_slug , array( $this, 'barfw_main'), plugin_dir_url(__FILE__).'includes'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'miniorange_icon.png' );
		     

			add_submenu_page( $menu_slug	,'Backup and Restore For Wp'	,'Manual Backup','administrator','mo_eb_backup_settings'			, array( $this, 'barfw_main'),2);
			
			add_submenu_page( $menu_slug	,'Backup and Restore For Wp'	,'Scheduled Backup','administrator','mo_eb_backup_schdule'			, array( $this, 'barfw_main'),4);
			
			add_submenu_page( $menu_slug	,'Backup and Restore For Wp'	,'Report','administrator','mo_eb_backup_report'			, array( $this, 'barfw_main'),5);
			add_submenu_page( $menu_slug	,'Backup and Restore For Wp'	,'Upgrade','administrator','mo_eb_backup_upgrade'			, array( $this, 'barfw_main'),6);

			add_submenu_page( $menu_slug	,'Backup and Restore For Wp'	,'Account','administrator','mo_eb_backup_account'			, array( $this, 'barfw_main'),7);

	}

	function barfw_main()
	{
	include 'controllers'.DIRECTORY_SEPARATOR .'main_controller.php';
	}

	function barfw_settings_style($hook){
		if(strpos($hook, 'page_mo_eb')){
		wp_enqueue_style( 'mo_wpns_admin_settings_style'			, plugins_url('includes'.DIRECTORY_SEPARATOR .'css'.DIRECTORY_SEPARATOR .'style_settings.css', __FILE__));
		
		wp_enqueue_style( 'mo_wpns_admin_settings_datatable_style'	, plugins_url('includes'.DIRECTORY_SEPARATOR .'css'.DIRECTORY_SEPARATOR.'jquery.dataTables.min.css', __FILE__));
	}
			
	}
	function barfw_settings_script($hook)
		{
				if(strpos($hook, 'page_mo_eb')){
				wp_enqueue_script( 'mo_wpns_admin_datatable_script'			, plugins_url('includes'.DIRECTORY_SEPARATOR .'js'.DIRECTORY_SEPARATOR .'jquery.dataTables.min.js', __FILE__ ), array('jquery'));
			}
		}
  
    
    function barfw_show_messages($content,$type) 
		{
			if($type=="CUSTOM_MESSAGE")
				echo $content;
			if($type=="NOTICE")
				echo '	<div class="is-dismissible notice notice-warning"> <p>'.esc_html($content).'</p> </div>';
			if($type=="ERROR")
				echo '	<div class="notice notice-error is-dismissible"> <p>'.esc_html($content).'</p> </div>';
			if($type=="SUCCESS")
				echo '	<div class="notice notice-success"> <p>'.esc_html($content).'</p> </div>';
		}

    function barfw_includes(){
    	require('helper'.DIRECTORY_SEPARATOR .'curl.php');
    	require('controllers'.DIRECTORY_SEPARATOR .'backup_ajax.php');
    	require('handler'.DIRECTORY_SEPARATOR .'backup.php');
    	require('handler'.DIRECTORY_SEPARATOR .'feedback_form.php');
    	require('database'.DIRECTORY_SEPARATOR .'database_functions.php');
    	require('helper'.DIRECTORY_SEPARATOR .'constants.php');
    	require('helper'.DIRECTORY_SEPARATOR .'dashboard_security_notification.php');
    	require('helper'.DIRECTORY_SEPARATOR .'messages.php');
    }

} new BARFW_Mo;
?>