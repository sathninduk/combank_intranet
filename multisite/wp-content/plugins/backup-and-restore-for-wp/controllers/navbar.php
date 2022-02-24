<?php
	
	global $moWpnsUtility,$MoBackupDirName;
    $backup			= add_query_arg( array('page' => 'mo_eb_backup'			), $_SERVER['REQUEST_URI'] );
	$logo_url       = plugin_dir_url(dirname(__FILE__)) . 'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'miniorange_logo.png';
	$profile_url	= add_query_arg( array('page' => 'mo_eb_backup_account'		), $_SERVER['REQUEST_URI'] );
	$setting_url	= add_query_arg( array('page' => 'mo_eb_backup_settings'		), $_SERVER['REQUEST_URI'] );
	$schdule_url	= add_query_arg( array('page' => 'mo_eb_backup_schdule'		), $_SERVER['REQUEST_URI'] );
	$upgrade_url	= add_query_arg( array('page' => 'mo_eb_backup_upgrade'		), $_SERVER['REQUEST_URI'] );
	$backup_and_restore_url	= add_query_arg( array('page' => 'mo_eb_backup_and_restore'		), $_SERVER['REQUEST_URI'] );
	$report_url	= add_query_arg( array('page' => 'mo_eb_backup_report'		), $_SERVER['REQUEST_URI'] );

	include $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR.'navbar.php';