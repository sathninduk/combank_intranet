<?php
	
	class BARFW_Backup_Constants
	{
		
		const DB_VERSION				= '146';
		const HOST_NAME					= "https://login.xecurify.com";
		const DEFAULT_CUSTOMER_KEY		= "16555";
		const DEFAULT_API_KEY 			= "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";
		const PLUGIN 					= 'plugin';
        const THEMES					= 'themes';
        const WPFILES					= 'wpfiles';
        const DATABASE 					= 'db';
        
	
		function __construct()
		{
			$this->barfw_define_global();
		}

		function barfw_define_global()
		{
			global $BackupDbQueries,$MoBackupDirName;
			$BackupDbQueries	 	= new BARFW_Backup_Query();
			$MoBackupDirName 		= dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR;
			
		}
		
	}
	new BARFW_Backup_Constants;

?>