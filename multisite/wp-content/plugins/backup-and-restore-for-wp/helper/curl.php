<?php
include dirname(__FILE__).DIRECTORY_SEPARATOR .'mobackup_api.php';
class BARFW_Backup_Curl
{
       
       function barfw_submit_contact_us( $q_email, $q_phone, $query )
		{
		$current_user = wp_get_current_user();
		$url    = BARFW_Backup_Constants::HOST_NAME . "/moas/rest/customer/contact-us";
		$query  = '[WordPress Backup Plugin: - V '.BARFW_PLUGIN_VERSION.']: ' . $query;
        
		$fields = array(
					'firstName'	=> $current_user->user_firstname,
					'lastName'	=> $current_user->user_lastname,
					'company' 	=> $_SERVER['SERVER_NAME'],
					'email' 	=> $q_email,
					'ccEmail'   => '2fasupport@xecurify.com',
					'phone'		=> $q_phone,
					'query'		=> $query
				);
		 $field_string = json_encode( $fields );
         $response = self::callAPI($url, $field_string);
        return $response;

	  }

        function barfw_check_customer() {
        $url = BARFW_Backup_Constants::HOST_NAME . "/moas/rest/customer/check-if-exists";
        $email = get_option( "mo2f_email" );
        $fields = array (
            'email' => $email
        );
        $field_string = json_encode ( $fields );

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $barfw_api =  new BARFW_Backup_Api();
        $response = $barfw_api->barfw_make_curl_call( $url, $field_string );
        return $response;

    }

    function barfw_forgot_password()
    {
    
        $url         = BARFW_Backup_Constants::HOST_NAME . '/moas/rest/customer/password-reset';
        $email       = get_option('mo2f_email');
        $customerKey = get_option('mo2f_customerKey');
        $apiKey      = get_option('mo2f_api_key');
    
        $fields      = array(
                        'email' => $email
                     );
    
        $field_string        = json_encode($fields);

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $mobackupApi= new BARFW_Backup_Api();
        $response = $mobackupApi->barfw_make_curl_call( $url, $field_string );
        return $response;
    }


    function barfw_create_customer($email, $company, $password, $phone = '', $first_name = '', $last_name = '') {

        $url = BARFW_Backup_Constants::HOST_NAME . '/moas/rest/customer/add';
       
        $fields       = array(
            'companyName'     => $company,
            'areaOfInterest'  => 'WordPress Backup Plugin',
            'productInterest' => 'Backup Security',
            'firstname'       => $first_name,
            'lastname'        => $last_name,
            'email'           => $email,
            'phone'           => $phone,
            'password'        => $password
        );
        $field_string = json_encode( $fields );
        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $mobackupApi= new BARFW_Backup_Api();
        $content = $mobackupApi->barfw_make_curl_call( $url, $field_string );
        return $content;
    }

     function barfw_get_customer_key($email,$password) {
        $url      = BARFW_Backup_Constants::HOST_NAME . "/moas/rest/customer/key";
        $barfw_api =  new BARFW_Backup_Api();
        $fields       = array(
            'email'    => $email,
            'password' => $password
        );
        $field_string = json_encode( $fields );
        
        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $barfw_api =  new BARFW_Backup_Api();
        $content = $barfw_api->barfw_make_curl_call( $url, $field_string );
        return $content;
    }


	function barfw_send_email_alert($email,$phone,$message,$feedback_option){
    
	    global $moWpnsUtility;
	    global $user;
	    
        $url = BARFW_Backup_Constants::HOST_NAME . '/moas/api/notify/send';
        $customerKey = BARFW_Backup_Constants::DEFAULT_CUSTOMER_KEY;
        $apiKey      = BARFW_Backup_Constants::DEFAULT_API_KEY;
        $fromEmail			= 'no-reply@xecurify.com';
        if ($feedback_option == 'mo_eb_skip_feedback') 
        {
        	$subject            = "Deactivate [Skipped Feedback]: WordPress Backup Plugin -". $email;
        }
        elseif ($feedback_option == 'mo_eb_feedback') 
        {
        	$subject            = "Feedback: WordPress Backup Plugin -". $email;
        }

        $user         = wp_get_current_user();

		$query = '[WordPress Backup Plugin: - V '.BARFW_PLUGIN_VERSION.']: ' . $message;


        $content='<div >Hello, <br><br>First Name :'.$user->user_firstname.'<br><br>Last  Name :'.$user->user_lastname.'   <br><br>Company :<a href="'.$_SERVER['SERVER_NAME'].'" target="_blank" >'.$_SERVER['SERVER_NAME'].'</a><br><br>Phone Number :'.$phone.'<br><br>Email :<a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br><br>Query :'.$query.'</div>';


        $fields = array(
            'customerKey'	=> $customerKey,
            'sendEmail' 	=> true,
            'email' 		=> array
            (
                'customerKey' 	=> $customerKey,
                'fromEmail' 	=> $fromEmail,
                'fromName' 		=> 'Xecurify',
                'toEmail' 		=> '2fasupport@xecurify.com',
                'toName' 		=> '2fasupport@xecurify.com',
                'subject' 		=> $subject,
                'content' 		=> $content
            ),
        );
        $field_string = json_encode($fields);
        $authHeader  = $this->createAuthHeader($customerKey,$apiKey);
        $response = self::callAPI($url, $field_string,$authHeader);
        return $response;

    }

    private static function createAuthHeader($customerKey, $apiKey) {
        $currentTimestampInMillis = round(microtime(true) * 1000);
        $currentTimestampInMillis = number_format($currentTimestampInMillis, 0, '', '');

        $stringToHash = $customerKey . $currentTimestampInMillis . $apiKey;
        $authHeader = hash("sha512", $stringToHash);

        $header = array (
            "Content-Type: application/json",
            "Customer-Key: $customerKey",
            "Timestamp: $currentTimestampInMillis",
            "Authorization: $authHeader"
        );
        return $header;
    }

    private static function callAPI($url, $json_string, $headers = array("Content-Type: application/json")) {
      
        $sslhost=0;
        $sslpeer=false;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, $sslhost );

        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $sslpeer );  
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        if(!is_null($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
        $content = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Request Error:' . curl_error($ch);
            exit();
        }

        curl_close($ch);
        return $content;
    }

   
}