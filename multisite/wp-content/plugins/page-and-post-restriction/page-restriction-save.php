<?php
require( 'page-restriction-class-customer.php' );
require_once('page-and-post-restriction.php');

function papr_save_setting(){
	$pageRes = new page_and_post_restriction_add_on();

    if( $pageRes->papr_check_option_admin_referer("papr_restrict_pages") ){
					
        $allowed_roles = get_option('papr_allowed_roles_for_pages');
        if(!$allowed_roles)
            $allowed_roles=array();

        $restrictedpages = array();
        $pages=get_pages();
        $home_page_id='mo_page_0';
        if(array_key_exists($home_page_id, $_POST)) {
            if($_POST[$home_page_id] == 'true'){
                array_push($restrictedpages, $home_page_id);
            }
        }
        $roles = 'mo_role_values_0';
        if(array_key_exists($roles, $_POST)) {
            $allowed_roles[$home_page_id] = stripslashes($_POST[$roles]);
        }
        foreach($pages as $page){
            $pageid = $page->ID;
            if(array_key_exists($pageid, $_POST)) {
                if($_POST[$pageid] == 'true'){
                    array_push($restrictedpages, $page->ID);
                }
            }
            $roles = 'mo_role_values_' . $page->ID;
            if(array_key_exists($roles, $_POST)) {
                $allowed_roles[$page->ID] = stripslashes($_POST[$roles]);
            }
        }
        update_option('papr_allowed_roles_for_pages', $allowed_roles);
        update_option( 'papr_restricted_pages', $restrictedpages);
        update_option( 'papr_message', 'Selected pages have been restricted successfully.');

        return;
    }

    else if($pageRes->papr_check_option_admin_referer("papr_restrict_posts")){

        $restrictedposts=array();
        $allowed_roles=array();
        $posts= get_posts(array(
							'fields'  => 'ids', 
							'fields'  => 'post_title',
							'numberposts'  => -1  
                        ));

        foreach ($posts as $post) {
            $post_id="mo_post_".$post->ID;

            if(array_key_exists($post_id, $_POST) && $_POST[$post_id]=='true'){
                array_push($restrictedposts, $post->ID);

            }
            $roles= 'mo_role_values_'.$post->ID;
            if(array_key_exists($roles,$_POST)){
                $allowed_roles[$post->ID] = stripslashes(strtolower($_POST[$roles]));
            }
        }

        update_option('papr_allowed_roles_for_posts',$allowed_roles);
        update_option('papr_restricted_posts',$restrictedposts);
        update_option('papr_message','Selected posts have been restriced successfully');
        return;

    }

    else if($pageRes->papr_check_option_admin_referer('papr_redirect_allow_pages')) {
		
        $allowed_redirect_pages=array();
        $pages=get_pages();
        $home_page_id="mo_redirect_0";  
        $home_url=get_home_url().'/';
        if(array_key_exists($home_page_id, $_POST) && $_POST[$home_page_id]=='true')
                $allowed_redirect_pages[0]=true;

        foreach ($pages as $page) {
            $page_id=$page->ID;
            if(array_key_exists($page_id, $_POST) && $_POST[$page_id]=='true'){
                $allowed_redirect_pages[$page->ID]=true;

            }
        }

        if(array_key_exists('papr_select_all_pages', $_POST)){
            $select_all_pages = 'checked';
        } else {
            $select_all_pages = 'unchecked';
        }

        update_option('papr_select_all_pages', $select_all_pages);
        update_option('papr_allowed_redirect_for_pages',$allowed_redirect_pages);
        update_option('papr_message','Selected posts have been restriced successfully');
        return;
    }

    else if($pageRes->papr_check_option_admin_referer('papr_redirect_posts')) {
		
        $allowed_redirect_posts=array();
        $posts= get_posts(array(
							'fields'  => 'ids', // get post IDs
							'fields'  => 'post_title',
							'numberposts'  => -1  // to get all the posts
						));
        
        foreach ($posts as $post) {
            $post_id='mo_redirect_post_'.$post->ID;
            if(array_key_exists($post_id, $_POST) && $_POST[$post_id]=='true'){
                $allowed_redirect_posts[$post->ID]=true;
            }
        }

        if(array_key_exists('papr_select_all_posts', $_POST)){
            $select_all_posts = 'checked';
        } else {
            $select_all_posts = 'unchecked';
        }

        update_option('papr_select_all_posts', $select_all_posts);
        update_option('papr_allowed_redirect_for_posts',$allowed_redirect_posts);
        update_option('papr_message','Selected posts have been restriced successfully');
        return;
    }

    else if($pageRes->papr_check_option_admin_referer('papr_contact_us_query_option')){

        if ( ! papr_is_curl_installed() ) {
            update_option( 'papr_message', 'ERROR: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP cURL extension</a> is not installed or disabled. Query submit failed.' );
            $pageRes->papr_error_message();
            return;
        }

        // Contact Us query
        $email    = sanitize_email($_POST['papr_contact_us_email']);
        $phone    = htmlspecialchars($_POST['papr_contact_us_phone']);
        $query    = htmlspecialchars($_POST['papr_contact_us_query']);

        $customer = new Customer_page_restriction();
        if ( papr_check_empty_or_null( $email ) || papr_check_empty_or_null( $query ) ) {
            update_option( 'papr_message', 'Please fill up Email and Query fields to submit your query.' );
            $pageRes->papr_error_message();
        } 
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            update_option( 'papr_message', 'Please enter a valid email address.' );
            $pageRes->papr_error_message();
        } 
        else {
            $submited = $customer->papr_submit_contact_us( $email, $phone, $query );
            if(!is_null($submited)){
                if ( $submited == false ) {
                    update_option( 'papr_message', 'Your query could not be submitted. Please try again.' );
                    $pageRes->papr_error_message();
                } else {
                    update_option( 'papr_message', 'Thanks for getting in touch! We shall get back to you shortly.' );
                    $pageRes->papr_success_message();
                }
            }
        }
    }

    else if ($pageRes->papr_check_option_admin_referer('papr_change_miniorange')){
        papr_remove_account();
        update_option('papr_guest_enabled',true);
        return;
    }

    else if ( $pageRes->papr_check_option_admin_referer("papr_go_back") ) {
        update_option( 'papr_registration_status', '' );
        update_option( 'papr_verify_customer', '' );
        delete_option( 'papr_new_registration' );
        delete_option( 'papr_admin_email' );
        delete_option( 'papr_admin_phone' );
    }

    else if ( $pageRes->papr_check_option_admin_referer("papr_goto_login") ) {
        delete_option( 'papr_new_registration' );
        update_option( 'papr_verify_customer', 'true' );
    }


    else if ( $pageRes->papr_check_option_admin_referer("papr_forgot_password_form_option") ) {
        if ( ! papr_is_curl_installed() ) {
            update_option( 'papr_message', 'ERROR: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP cURL extension</a> is not installed or disabled. Resend OTP failed.' );
            $pageRes->papr_show_error_message();
            return;
        }

        $email = get_option( 'papr_admin_email' );
        $customer = new Customer_page_restriction();
        $content  = json_decode( $customer->papr_forgot_password( $email ), true );
        if(!is_null($content)){
            if ( strcasecmp( $content['status'], 'SUCCESS' ) == 0 ) {
                update_option( 'papr_message', 'Your password has been reset successfully. Please enter the new password sent to ' . $email . '.' );
                $pageRes->papr_success_message();
            } else {
                update_option( 'papr_message', 'An error occured while processing your request. Please Try again.' );
                $pageRes->papr_error_message();
            }
        }
    }


    else if( $pageRes->papr_check_option_admin_referer("papr_verify_customer") ) {    //register the admin to miniOrange
        if ( ! papr_is_curl_installed() ) {
            update_option( 'papr_message', 'ERROR: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP cURL extension</a> is not installed or disabled. Login failed.' );
            $pageRes->papr_error_message();
            return;
        }

        $email    = '';
        $password = '';
        if ( papr_check_empty_or_null( $_POST['email'] ) || papr_check_empty_or_null( $_POST['password'] ) ) {
            update_option( 'papr_message', 'All the fields are required. Please enter valid entries.' );
            $pageRes->papr_error_message();
            return;
        } else if(papr_check_password_pattern(htmlspecialchars($_POST['password']))){
            update_option( 'papr_message', 'Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*-_) should be present.' );
            $pageRes->papr_error_message();
            return;
        }else {
            $email    = sanitize_email( $_POST['email'] );
            $password = stripslashes( htmlspecialchars($_POST['password'] ));
        }

        update_option( 'papr_admin_email', $email );
        update_option( 'papr_admin_password', $password );
        $customer    = new Customer_page_restriction();
        $content     = $customer->papr_get_customer_key();

        if(!is_null($content)){
            $customerKey = json_decode( $content, true );
            if ( json_last_error() == JSON_ERROR_NONE ) {
                update_option( 'papr_admin_customer_key', $customerKey['id'] );
                update_option( 'papr_admin_api_key', $customerKey['apiKey'] );
                update_option( 'papr_customer_token', $customerKey['token'] );
                update_option( 'papr_admin_password', '' );
                update_option( 'papr_message', 'Customer retrieved successfully' );
                update_option( 'papr_registration_status', 'Existing User' );
                delete_option( 'papr_verify_customer' );
                $pageRes->papr_success_message();
                wp_redirect( admin_url( '/admin.php?page=page_restriction&tab=account_setup' ), 301 );
                exit;
            } 
            else {
                update_option( 'papr_message', 'Invalid username or password. Please try again.' );
                $pageRes->papr_error_message();
            }
            update_option( 'papr_admin_password', '' );
        }
    }


    else if ( $pageRes->papr_check_option_admin_referer("papr_register_customer")) {
        $user = wp_get_current_user();
        if ( ! papr_is_curl_installed() ) {
            update_option( 'papr_message', 'ERROR: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP cURL extension</a> is not installed or disabled. Registration failed.' );
            $pageRes->papr_error_message();
            return;
        }

        $email           = '';
        $password        = '';
        $confirmPassword = '';

        if ( papr_check_empty_or_null( $_POST['email'] ) || papr_check_empty_or_null( $_POST['password'] ) || papr_check_empty_or_null( $_POST['confirmPassword'] ) ) {
            update_option( 'papr_message', 'Please enter the required fields.' );
            $pageRes->papr_error_message();
            return;
        }  
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            update_option( 'papr_message', 'Please enter a valid email address.' );
            $pageRes->papr_error_message();
            return;
        }
        else if(papr_check_password_pattern(htmlspecialchars($_POST['password']))){
            update_option( 'papr_message', 'Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*-_) should be present.' );
            $pageRes->papr_error_message();
            return;
        }
        else {
            $email           = sanitize_email( $_POST['email'] );
            $password        = stripslashes( htmlspecialchars($_POST['password'] ));
            $confirmPassword = stripslashes( htmlspecialchars($_POST['confirmPassword'] ));
        }
        update_option( 'papr_admin_email', $email );
        
        if ( strcmp( $password, $confirmPassword ) == 0 ) {
            update_option( 'papr_admin_password', $password );
            $email    = get_option( 'papr_admin_email' );
            $customer = new Customer_page_restriction();
            $content  = json_decode( $customer->papr_check_customer(), true );
            if(!is_null($content)){
                if ( strcasecmp( $content['status'], 'CUSTOMER_NOT_FOUND' ) == 0 ) {
                    $response = papr_create_customer();
                    if(is_array($response) && array_key_exists('status', $response) && $response['status'] == 'success'){
                        update_option( 'papr_message', 'Customer created successfully.' );
                        wp_redirect( admin_url( '/admin.php?page=page_restriction&tab=account_setup' ), 301 );
                        $pageRes->papr_success_message();
                        exit;
                    }
                    else{
                        update_option( 'papr_message', 'This is not a valid email. Please enter a valid email.' );
                        wp_redirect( admin_url( '/admin.php?page=page_restriction&tab=account_setup' ), 301 );
                        $pageRes->papr_error_message();
                        exit;
                    }
                } 
                else if(strcasecmp($content['status'], 'INVALID_EMAIL') == 0){
                    update_option( 'papr_message', 'This is not a valid email. Please enter a valid email.' );
                    wp_redirect( admin_url( '/admin.php?page=page_restriction&tab=account_setup' ), 301 );
                    $pageRes->papr_error_message();
                    exit;
                }
                else {
                    $response = papr_get_current_customer();
                    if(is_array($response) && array_key_exists('status', $response) && $response['status'] == 'success'){
                        update_option( 'papr_message', 'Customer Retrieved Successfully.' );
                        wp_redirect( admin_url( '/admin.php?page=page_restriction&tab=account_setup' ), 301 );
                        $pageRes->papr_success_message();
                        exit;
                    }
                }
            }
        } 
        else {
            update_option( 'papr_message', 'Passwords do not match.' );
            delete_option( 'papr_verify_customer' );
            $pageRes->papr_error_message();
        }
        return;
    }

    else if ( $pageRes->papr_check_option_admin_referer("papr_skip_feedback") ) {
        update_option( 'papr_message', 'Plugin deactivated successfully' );
        $pageRes->papr_success_message();
        deactivate_plugins( 'page-and-post-restriction\page-and-post-restriction.php' );
        wp_redirect('plugins.php');
    }

    if ( $pageRes->papr_check_option_admin_referer("papr_feedback") ) {
        $user = wp_get_current_user();

        $message = 'Plugin Deactivated';

        $deactivate_reason_message = array_key_exists( 'papr_query_feedback', $_POST ) ? htmlspecialchars($_POST['papr_query_feedback']) : false;
        
        $message.= ', Feedback : '.$deactivate_reason_message.'';

        $reason='';
        if (isset($_POST['papr_reason']))
                $reason = htmlspecialchars($_POST['papr_reason']);
        
        $message.= ', [Reason :'.$reason.']';

        $email = $_POST['papr_query_mail'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = get_option('papr_admin_email');
            if(empty($email))
                $email = $user->user_email;
        }
        $phone = get_option( 'papr_admin_phone' );
        $feedback_reasons = new Customer_page_restriction();
        if(!is_null($feedback_reasons)){
            if(!papr_is_curl_installed()){
                deactivate_plugins( 'page-and-post-restriction\page-and-post-restriction.php' );
                wp_redirect('plugins.php');
            } else {
                $submited = json_decode( $feedback_reasons->papr_send_email_alert( $email, $phone, $message ), true );

                if ( json_last_error() == JSON_ERROR_NONE ) {
                    if ( is_array( $submited ) && array_key_exists( 'status', $submited ) && $submited['status'] == 'ERROR' ) {
                        update_option( 'papr_message', $submited['message'] );
                        $pageRes->papr_error_message();
                    }
                    else {
                        if ( $submited == false ) {
                            update_option( 'papr_message', 'Error while submitting the query.' );
                            $pageRes->papr_error_message();
                        }
                    }
                }
            deactivate_plugins( 'page-and-post-restriction\page-and-post-restriction.php');
            wp_redirect('plugins.php');
            update_option( 'papr_message', 'Thank you for the feedback.' );
            $pageRes->papr_success_message();
            }
        }
    }

}

function papr_check_empty_or_null( $value ) {
    if ( ! isset( $value ) || empty( $value ) ) {
        return true;
    }
    return false;
}

 function papr_is_curl_installed() {
    if ( in_array( 'curl', get_loaded_extensions() ) ) {
        return 1;
    } 
    else {
        return 0;
    }
}

function papr_remove_account() {
    //delete all customer related key-value pairs
    delete_option( 'papr_host_name' );
    delete_option( 'papr_new_registration' );
    delete_option( 'papr_admin_phone' );
    delete_option( 'papr_admin_password' );
    delete_option( 'papr_verify_customer' );
    delete_option( 'papr_admin_customer_key' );
    delete_option( 'papr_admin_api_key' );
    delete_option( 'papr_customer_token' );
    delete_option('papr_admin_email');
    delete_option( 'papr_message' );
    delete_option( 'papr_registration_status' );
    delete_option( 'papr_proxy_host' );
    delete_option( 'papr_proxy_username' );
    delete_option( 'papr_proxy_port' );
    delete_option( 'papr_proxy_password' );
}

function papr_check_password_pattern($password){
    $pattern = '/^[(\w)*(\!\@\#\$\%\^\&\*\.\-\_)*]+$/';
    return !preg_match($pattern,$password);
}

function papr_get_current_customer() {
    $pageRes = new page_and_post_restriction_add_on();
    $customer    = new Customer_page_restriction();
    $content     = $customer->papr_get_customer_key();
    if(!is_null($content)){
        $customerKey = json_decode( $content, true );
        $response = array();
        if ( json_last_error() == JSON_ERROR_NONE ) {
            update_option( 'papr_admin_customer_key', $customerKey['id'] );
            update_option( 'papr_admin_api_key', $customerKey['apiKey'] );
            update_option( 'papr_customer_token', $customerKey['token'] );
            update_option( 'papr_admin_password', '' );
            delete_option( 'papr_verify_customer' );
            delete_option( 'papr_new_registration' );
            $response['status'] = "success";
            return $response;
        } 
        else {
            update_option( 'papr_message', 'You already have an account with miniOrange. Please enter a valid password.' );
            $pageRes->papr_error_message();
            $response['status'] = "error";
            return $response;
        }
    }
}

function papr_create_customer() {
    $customer    = new Customer_page_restriction();
    $customerKey = json_decode( $customer->papr_create_customer(), true );
    if(!is_null($customerKey)){
        $response = array();
        if ( strcasecmp( $customerKey['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS' ) == 0 ) {
            $api_response = papr_get_current_customer();
            if($api_response){
                $response['status'] = "success";
            }
            else
                $response['status'] = "error";
        } 
        else if ( strcasecmp( $customerKey['status'], 'SUCCESS' ) == 0 ) {
            update_option( 'papr_admin_customer_key', $customerKey['id'] );
            update_option( 'papr_admin_api_key', $customerKey['apiKey'] );
            update_option( 'papr_customer_token', $customerKey['token'] );
            update_option( 'papr_admin_password', '' );
            update_option( 'papr_message', 'Thank you for registering with miniorange.' );
            update_option( 'papr_registration_status', '' );
            delete_option( 'papr_verify_customer' );
            delete_option( 'papr_new_registration' );
            $response['status']="success";
            return $response;
        }
        update_option( 'papr_admin_password', '' );
        return $response;
    }
}