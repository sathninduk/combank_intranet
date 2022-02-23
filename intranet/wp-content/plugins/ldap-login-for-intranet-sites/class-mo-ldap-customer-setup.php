<?php

class MoLdapLocalCustomer{
	const TIMEOUT = '10000';
	const SUPPORTEMAIL ='ldapsupport@xecurify.com';
	private $defaultCustomerKey = "16555";
	private $defaultApiKey = "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";
	
	function create_customer(){
		if(!MoLdapLocalUtil::is_curl_installed()) {
			return json_encode(array("statusCode"=>'CURL_ERROR','statusMessage'=>'<a target="_blank" rel="noopener" href="http://php.net/manual/en/curl.installation.php">PHP cURL extension</a> is not installed or disabled.'));
		}
		$url = get_option('mo_ldap_local_host_name') . '/moas/rest/customer/add';
		
		$this->email = esc_attr(get_option('mo_ldap_local_admin_email'));
		$password = esc_attr(get_option('mo_ldap_local_password'));

		$fields = array(
			'areaOfInterest' => 'WP LDAP for Intranet',
			'email' => $this->email,
			'password' => $password,
		);
		$field_string = json_encode($fields);

        $headers = array(
            "Content-Type"=>"application/json",
            "charset"=>"UTF - 8",
            "Authorization"=>"Basic",
        );
        $args = array(
            'method' =>'POST',
            'body' => $field_string,
            'timeout' => MoLdapLocalCustomer::TIMEOUT,
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,
        );

        $response = wp_remote_post( $url, $args );
        if ( is_wp_error( $response ) ) {
            return json_encode(array("status"=>'ERROR'));
        }
        return $response['body'];
	}
	
	function get_customer_key() {
		if(!MoLdapLocalUtil::is_curl_installed()) {
			return json_encode(array("apiKey"=>'CURL_ERROR','token'=>'<a target="_blank" rel="noopener" href="http://php.net/manual/en/curl.installation.php">PHP cURL extension</a> is not installed or disabled.'));
		}
		
		$url = esc_url(get_option('mo_ldap_local_host_name') . "/moas/rest/customer/key");
		$email = esc_attr(get_option('mo_ldap_local_admin_email'));
		$password = esc_attr(get_option('mo_ldap_local_password'));
		
		$fields = array(
			'email' => $email,
			'password' => $password
		);
		$field_string = json_encode($fields);

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF - 8","Authorization"=>"Basic");
        $args = array(
            'method' =>'POST',
            'body' => $field_string,
            'timeout' => MoLdapLocalCustomer::TIMEOUT,
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,

        );

        $response = wp_remote_post( $url, $args );
        if ( is_wp_error( $response ) ) {
            return json_encode(array("status"=>'ERROR'));
        }
        return $response['body'];
	}
	
	function submit_contact_us( $q_email, $q_phone, $query ) {
		if(!MoLdapLocalUtil::is_curl_installed()) {
			return json_encode(array("status"=>'CURL_ERROR','statusMessage'=>'Warning: <a target="_blank" rel="noopener" href="http://php.net/manual/en/curl.installation.php">PHP cURL extension</a> is not installed or disabled. Please install/enable this extension to contact with miniOrange.<br/>Meanwhile, you can send us email on <a href=mailto:info@xecurify.com><strong>info@xecurify.com</strong></a>.'));
		}
		
		$url = esc_url(get_option('mo_ldap_local_host_name') . "/moas/rest/customer/contact-us");
		
		$fname = esc_attr(get_option('mo_ldap_local_admin_fname'));
		$lname = esc_attr(get_option('mo_ldap_local_admin_lname'));
		$companyName = esc_attr(get_option('mo_ldap_local_admin_company'));

		$fields = array(
			'firstName'			=> $fname,
			'lastName'	 		=> $lname,
			'company' 			=> $companyName,
			'email' 			=> $q_email,
			'ccEmail'           => MoLdapLocalCustomer::SUPPORTEMAIL,
			'phone'				=> $q_phone,
			'query'				=> $query
		);
		$field_string = json_encode( $fields );

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF - 8","Authorization"=>"Basic");
        $args = array(
            'method' =>'POST',
            'body' => $field_string,
            'timeout' => MoLdapLocalCustomer::TIMEOUT,
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,

        );

        $response = wp_remote_post( $url, $args );

        if ( is_wp_error( $response ) ) {
            return json_encode(array("status"=>'ERROR'));
        }
        return $response['body'];
	}

    function send_email_alert($email,$phone,$message,$call_setup_flag=false){
        $url = 'https://login.xecurify.com/moas/api/notify/send';
	    if (get_option( 'mo_ldap_local_host_name' )) {
           $url = esc_url(get_option('mo_ldap_local_host_name') . '/moas/api/notify/send');
        }

        $customerKey = $this->defaultCustomerKey;
        $apiKey =  $this->defaultApiKey;


        $currentTimeInMillis = self::get_timestamp();
        $stringToHash 		= $customerKey .  $currentTimeInMillis . $apiKey;
        $hashValue 			= hash("sha512", $stringToHash);
        $fromEmail 			= $email;
        global $user;
        $user         = wp_get_current_user();

        if($call_setup_flag == false){
            $subject = "WordPress LDAP/AD Plugin Feedback - ". $email;
            $query = '[WordPress LDAP/AD Plugin:] '. $message;   
        }
        else{
            $subject = "WordPress LDAP/AD Request For Setup Call - ". $email;
            $query = $message;
        }
        $esc_allowed = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'b' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
            'span' => array(),
        );

        $content='<div >First Name :'.esc_attr($user->user_firstname).'<br><br>Last  Name :'.esc_attr($user->user_lastname).'   <br><br>Company :<a href="'.esc_url($_SERVER['SERVER_NAME']).'" target="_blank" >'.esc_attr($_SERVER['SERVER_NAME']).'</a><br><br>Email :<a href="mailto:'.esc_attr($fromEmail).'" target="_blank">'.esc_attr($fromEmail).'</a><br><br>Query :'.wp_kses($query, $esc_allowed).'</div>';
        $fields = array(
            'customerKey'	=> $customerKey,
            'sendEmail' 	=> true,
            'email' 		=> array(
                'customerKey' 	=> $customerKey,
                'fromEmail' 	=> $email,
                'bccEmail' 		=> MoLdapLocalCustomer::SUPPORTEMAIL,
                'fromName' 		=> 'miniOrange',
                'toEmail' 		=> MoLdapLocalCustomer::SUPPORTEMAIL,
                'toName' 		=> MoLdapLocalCustomer::SUPPORTEMAIL,
                'subject' 		=> $subject,
                'content' 		=> $content
            ),
        );
        $field_string = json_encode($fields);
        $headers = array("Content-Type"=>"application/json","Customer-Key"=>$customerKey,"Timestamp"=>$currentTimeInMillis,"Authorization"=>$hashValue);
        $args = array(
            'method' =>'POST',
            'body' => $field_string,
            'timeout' => MoLdapLocalCustomer::TIMEOUT,
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,

        );

        $response = wp_remote_post( $url, $args );
        if ( is_wp_error( $response ) ) {
            return json_encode(array("status"=>'ERROR'));
        }
        return $response['body'];
    }

    function get_timestamp() {
	    $url = "https://login.xecurify.com/moas/rest/mobile/get-timestamp";
	    if (get_option( 'mo_ldap_local_host_name' )) {
            $url = esc_url(get_option('mo_ldap_local_host_name') . "/moas/rest/mobile/get-timestamp");
        }

        $response = wp_remote_post( $url);
        if ( is_wp_error( $response ) ) {
            $currentTimeInMillis = round( microtime( true ) * 1000 );
            $currentTimeInMillis = number_format( $currentTimeInMillis, 0, '', '' );
            return $currentTimeInMillis;
        } else {
            return $response['body'];
        }
    }

	function check_customer() {
		if(!MoLdapLocalUtil::is_curl_installed()) {
			return json_encode(array("status"=>'CURL_ERROR','statusMessage'=>'<a target="_blank" rel="noopener" href="http://php.net/manual/en/curl.installation.php">PHP cURL extension</a> is not installed or disabled.'));
		}
		
		$url 	= esc_url(get_option('mo_ldap_local_host_name') . "/moas/rest/customer/check-if-exists");
		$email 	= get_option("mo_ldap_local_admin_email");

		$fields = array(
			'email' 	=> $email,
		);
		$field_string = json_encode( $fields );
        $headers = array("Content-Type"=>"application/json","charset"=>"UTF - 8","Authorization"=>"Basic");
        $args = array(
            'method' =>'POST',
            'body' => $field_string,
            'timeout' => MoLdapLocalCustomer::TIMEOUT,
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,

        );

        $response = wp_remote_post( $url, $args );
        if ( is_wp_error( $response ) ) {
            return json_encode(array("status"=>'ERROR'));
        }
        return $response['body'];
	}

	function mo_ldap_local_forgot_password($email){
	
		$url = esc_url(get_option('mo_ldap_local_host_name') . '/moas/rest/customer/password-reset');
		$customerKey = get_option('mo_ldap_local_admin_customer_key');
		$apiKey = get_option('mo_ldap_local_admin_api_key');
		$currentTimeInMillis = round(microtime(true) * 1000);
		$stringToHash = $customerKey . number_format($currentTimeInMillis, 0, '', '') . $apiKey;
		$hashValue = hash("sha512", $stringToHash);

		$fields = array(
			'email' => $email
		);
	
		$field_string = json_encode($fields);
        $headers = array("Content-Type"=>"application/json","Customer-Key"=>$customerKey,"Timestamp"=>number_format($currentTimeInMillis, 0, '', ''),"Authorization"=>$hashValue);
        $args = array(
            'method' =>'POST',
            'body' => $field_string,
            'timeout' => MoLdapLocalCustomer::TIMEOUT,
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,

        );

        $response = wp_remote_post( $url, $args );
        if ( is_wp_error( $response ) ) {
            return json_encode(array("status"=>'ERROR'));
        }
        return $response['body'];
	}
}?>