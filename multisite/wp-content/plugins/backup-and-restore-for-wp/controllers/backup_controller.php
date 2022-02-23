<?php
$remote_storage_type = get_site_option('mo_remote_storage_type');
$google_imag_path =dirname(plugin_dir_url(__FILE__)).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'gdrive.jpg';
$dropbox_img_path =dirname(plugin_dir_url(__FILE__)).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'dropbox.png';
$onedrive_img_path =dirname(plugin_dir_url(__FILE__)).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'onedrive.png';
$box_img_path =dirname(plugin_dir_url(__FILE__)).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'box.png';
$amazon_img_path =dirname(plugin_dir_url(__FILE__)).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'amazons3.png'; 
 include_once $MoBackupDirName . 'views'.DIRECTORY_SEPARATOR .'backup_setting_view.php';