<?php
	
	class BARFW_Backup_Messages
	{

		//support form 
		const SUPPORT_FORM_VALUES				= "Please submit your query along with email.";
		const SUPPORT_FORM_SENT					= "Thanks for getting in touch! We shall get back to you shortly.";
		const SUPPORT_FORM_ERROR				= "Your query could not be submitted. Please try again.";
        //feedback Form
		const DEACTIVATE_PLUGIN                 = "Plugin deactivated successfully";

        const CRON_DB_BACKUP_ENABLE			    = 'Scheduled Database Backup enabled';
		const CRON_DB_BACKUP_DISABLE			= 'Scheduled Database Backup disabled';
		const CRON_FILE_BACKUP_ENABLE			= 'Scheduled File Backup enabled';
		const CRON_FILE_BACKUP_DISABLE			= 'Scheduled File Backup disabled';	
		const BACKUP_CREATED					= 'Backup created successfully';
		const WARNING  							= 'Please select folder for backup';
        const INVALID_EMAIL  					= 'Please enter valid Email ID';
        const INVALID_PHONE                     = 'Please enter a valid phone number';
        const EMAIL_SAVED 						= 'Email ID saved successfully';
        const INVALID_HOURS 					= 'For scheduled backup, please enter number of hours greater than 1.';
        const DELETE_FILE 						= 'Someone has deleted the backup by going to directory please refreash the page';
        const NOT_ADMIN							= 'You are not a admin. Only admin can download';
        const NONCE_ERROR						= 'Nonce error';
        //registration
        const PASS_LENGTH						= 'Choose a password with minimum length 6.';
        const PASS_MISMATCH						= 'Password and Confirm Password do not match.';
		const REQUIRED_FIELDS					= 'Please enter all the required fields';
		const ACCOUNT_EXISTS					= 'You already have an account with miniOrange. Please SIGN IN.';
		const RESET_PASS						= 'You password has been reset successfully and sent to your registered email. Please check your mailbox.';
		const REG_SUCCESS						= 'Your account has been retrieved successfully.';
		const INVALID_CREDENTIALS               = 'Invalid Credentials.';
		const INVALID_REQ                       = 'Invalid request. Please try again';
		const DB_MEMORY_LIMIT					= 'Your database  backup memory limit is very low so please contact miniOrange';




     

		public static function barfw_show_essage($message , $data=array())
		{
			$message = constant( "self::".$message );
		    foreach($data as $key => $value)
		    {
		        $message = str_replace("{{" . $key . "}}", $value , $message);
		    }
		    return $message;
		}

	}

?>