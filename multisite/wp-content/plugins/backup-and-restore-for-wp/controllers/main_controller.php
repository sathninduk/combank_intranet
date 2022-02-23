<?php
global $MoBackupDirName;
$controller = $MoBackupDirName . 'controllers'.DIRECTORY_SEPARATOR;
global $active_tab;
include $controller . 'navbar.php';

if( isset( $_GET[ 'page' ])) {
	$page = sanitize_text_field(wp_unslash($_GET['page']));
	switch($page)
	{
		
		case 'mo_eb_backup_account':
		    include $controller . 'account.php';                  break;				
		
		case 'mo_eb_backup_settings':
			include $controller . 'backup_controller.php';		  break;			
		
		case 'mo_eb_backup_schdule':
		    include $controller . 'backup_schdule.php';			  break;
		case 'mo_eb_backup_upgrade':
		    include $controller . 'backup_upgrade.php';			  break;
		case 'mo_eb_backup_report':
			include $controller . 'backup_created_report.php';	  break;	
	}
}

include $controller . 'support.php';