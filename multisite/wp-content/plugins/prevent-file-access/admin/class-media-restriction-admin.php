<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://miniorange.com/
 * @since      1.1.1
 *
 * @package    Media_Restriction
 * @subpackage Media_Restriction/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Media_Restriction
 * @subpackage Media_Restriction/admin
 * @author     test <test@test.com>
 */
require_once 'partials/media-restriction-admin-display.php';
require_once 'class-media-restriction-customer.php';
require_once 'partials/media-restriction-feedback.php';

class Media_Restriction_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.1
	 * @param string $plugin_name  The name of this plugin.
	 * @param string $version  The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		update_option( 'host_name', 'https://login.xecurify.com' );
		add_action( 'init', array( $this, 'mo_media_restriction_validate' ) );
		if ( get_option( 'mo_enable_media_restriction' ) === false)
			update_option( 'mo_enable_media_restriction', 1 );
	}


	// To show files and folders 
	function mo_media_show_file_or_folder($redirect_url){
		$file_path = ABSPATH.DIRECTORY_SEPARATOR.$redirect_url;
		$file_url = site_url().'/'.$redirect_url;
		if(file_exists($file_path)){
			if (is_dir($file_path)){
				if ($dh = opendir($file_path)){
					while (($file = readdir($dh)) !== false){
						if($file !== '..' && $file !== '.')
							echo "<a href='".$file_url.'/'.$file."'>" . $file . "</a><br>";
					}
					closedir($dh);
				}
				exit;
			} else {
				header("content-type: ".mime_content_type($file_path));
				echo file_get_contents($file_path);
				exit;
			}
		} else {
			wp_die("No such file exist");
		}
	}

	// Media restriction validate
	function mo_media_restriction_validate(){
		if(isset($_GET['mo_media_restrict_request']) && sanitize_text_field( wp_unslash( $_GET['mo_media_restrict_request'] ) ) === '1' ){
			if( is_user_logged_in() === false ) {
				$restrict_option = get_option('mo_mr_redirect_to');
				if( '403-forbidden-page' === $restrict_option ) {
					header('HTTP/1.0 403 Forbidden');
					echo 'Access forbidden!';
				} else {
					$redirect_to = get_permalink( get_page_by_path( $restrict_option ) );
					wp_redirect( $redirect_to );
				}
				exit;
			} else {
				$redirect_url = isset($_GET['redirect_to']) ? sanitize_text_field( wp_unslash( $_GET['redirect_to'] ) ) : site_url();
				$this->mo_media_show_file_or_folder($redirect_url);
			}
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.1.1
	 */
	public function enqueue_styles( $page ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Media_Restriction_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Media_Restriction_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( 'toplevel_page_mo_media_restrict' !== $page ) {
			return;
		}
		
		wp_enqueue_style( 'mo_media_admin_bootstrap_style', plugins_url( 'css/bootstrap.min.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( 'mo_media_admin_font_awesome_style', plugins_url( 'css/font-awesome.min.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( 'mo_media_admin_media_phone_style', plugins_url( 'css/phone.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( 'mo_media_admin_media_settings_style', plugins_url( 'css/media-restriction-admin.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( 'mo_media_admin_settings_style', plugins_url( 'css/style.css', __FILE__ ), array(), $this->version );		
		wp_enqueue_style( 'mo_media_admin_table_style', plugins_url( 'css/jquery.dataTables.min.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.1.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Media_Restriction_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Media_Restriction_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'mo_media_admin_media_settings_script', plugins_url( 'js/media-restriction-admin.js', __FILE__ ), array() , $this->version, false );
		wp_enqueue_script( 'mo_media_admin_media_phone_script', plugins_url( 'js/phone.js', __FILE__ ), array() , $this->version, false );
		wp_enqueue_script( 'mo_media_admin_custom_settings_script', plugins_url( 'js/custom.js', __FILE__ ), array() , $this->version, false );		
		wp_enqueue_script( 'mo_media_admin_table_script', plugins_url( 'js/jquery.dataTables.min.js', __FILE__ ), array() , $this->version, false );
	}

	/**
	 * On Post field check values are empty or not
	 *
	 * @since    1.1.1
	 * @param string $value  The version of this plugin.
	 */
	private function mo_media_restriction_check_empty_or_null( $value ) {
		if( ! isset( $value ) || empty( $value ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Remove rules in htaccess file
	 *
	 * @since    1.1.1
	 */
	private function mo_media_restrict_remove_rules() {
		$home_path = get_home_path();
		$htaccess_file = $home_path.'.htaccess';

		if(file_exists($htaccess_file) && is_writable($home_path) && is_writeable($htaccess_file)){
			insert_with_markers( $htaccess_file, 'MINIORANGE MEDIA RESTRICTION', array() );
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Write rules in htaccess file 
	 *
	 * @since    1.1.1
	 */
	private function mo_media_restrict_write_rules(){

		$home_path = get_home_path();
		$htaccess_file = $home_path.'.htaccess';

		if(file_exists($htaccess_file) && is_writable($home_path) && is_writeable($htaccess_file)){
			$htaccess_file_backup = $home_path.'.htaccess-backup';
			if(!file_exists($htaccess_file_backup))
			copy($htaccess_file, $home_path.'.htaccess-backup');
		} else{
			if(is_writable($home_path)){
				global $wp_rewrite;
				$wp_rewrite->set_permalink_structure( '/%category%/%postname%/' );
				flush_rewrite_rules();
				copy($htaccess_file, $home_path.'.htaccess-backup');
			} else{
				return false;
			}
		}
		
		$mo_media_restriction_file_types = get_option('mo_media_restriction_file_types');
		if(empty($mo_media_restriction_file_types))
			$mo_media_restriction_file_types = 'png|jpg|gif|pdf|doc';
		$restrict_option = get_option('mo_mr_restrict_option');
		if(empty($restrict_option))
			$restrict_option = 'display-custom-page';
		$redirect_to = get_option('mo_mr_redirect_to');
		if(empty($redirect_to))
			$redirect_to = '403-forbidden-page';
				
		
		$rules  = "RewriteCond %{REQUEST_FILENAME} ^.*(".$mo_media_restriction_file_types.")$ [OR]\n";
		$rules .= "RewriteCond %{REQUEST_URI} protectedfiles ";
		$rules .= "\n";
		$rules .= "RewriteCond %{HTTP_COOKIE} !^.*wordpress_logged_in.*$ [NC]\n";
				
		$choose_server = get_option('mo_media_restriction_choose_server', 'apache');

		if('godaddy' === $choose_server ) {
			$rules .= "RewriteRule ^(.*)$ ./?mo_media_restrict_request=1&redirect_to=$1 [R=302,NC]";
		} else {
			if($restrict_option === 'display-custom-page'){
				if($redirect_to === '403-forbidden-page')
					$rules .= 'RewriteRule . - [R=403,L]';
				else
					$rules .= 'RewriteRule . ./'.$redirect_to.' [R=302,NC]';
			}
		}

		if(!$this->mo_media_restrict_remove_rules()){
			return false;
		}

		return insert_with_markers( $htaccess_file, 'MINIORANGE MEDIA RESTRICTION', $rules );
	}

	/**
	 * Success Message
	 *
	 * @return void
	 */
	public function mo_media_restriction_success_message() {
		$class = "error";
		$message = get_option('mo_media_restriction_message');
		echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
	}

	/**
	 * Error Message
	 *
	 * @return void
	 */
	public function mo_media_restriction_error_message() {
		$class = "updated";
		$message = get_option('mo_media_restriction_message');
		echo "<div class='" . $class . "'><p>" . $message . "</p></div>";
	}

	/**
	 * Success message print
	 *
	 * @return void
	 */
	private function mo_media_restriction_show_success_message() {
		remove_action( 'admin_notices', array( $this, 'mo_media_restriction_success_message' ) );
		add_action( 'admin_notices', array( $this, 'mo_media_restriction_error_message' ) );
	}

	/**
	 * Error message print
	 *
	 * @return void
	 */
	private function mo_media_restriction_show_error_message() {
		remove_action( 'admin_notices', array( $this, 'mo_media_restriction_error_message' ) );
		add_action( 'admin_notices', array( $this, 'mo_media_restriction_success_message' ) );
	}

	public function mo_media_restrict_support(){
		if(isset($_POST['option'])){
			if(current_user_can('administrator')) {
				if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_feedback'  && isset($_REQUEST['mo_media_restriction_feedback_fields']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_feedback_fields'])), 'mo_media_restriction_feedback_form') ){
					$user = wp_get_current_user();
					$message = 'Plugin Deactivated:';
					$deactivate_reason         = array_key_exists( 'mo_media_restriction_deactivate_reason_radio', $_POST ) ? sanitize_textarea_field($_POST['mo_media_restriction_deactivate_reason_radio']) : false;
					$deactivate_reason_message = array_key_exists( 'mo_media_restriction_query_feedback', $_POST ) ? sanitize_textarea_field($_POST['mo_media_restriction_query_feedback']) : false;
					if ( $deactivate_reason ) {
						$message .= $deactivate_reason;
						if ( isset( $deactivate_reason_message ) ) {
							$message .= ':' . $deactivate_reason_message;
						}
						$email = get_option( "mo_media_restriction_admin_email" );
						if ( $email == '' ) {
							$email = $user->user_email;
						}
						$phone = get_option( 'mo_media_restriction_admin_phone' );
						//only reason
						$feedback_reasons = new Miniorange_Media_Restriction_Customer();
						$submited = $feedback_reasons->mo_media_restriction_send_email_alert( $email, $phone, $message, "Feedback: WordPress Prevent Files / Folders Access");
						
						$path = plugin_dir_path( dirname( __FILE__ ) ) .'media-restriction.php';
						deactivate_plugins( $path );
						if ( $submited == false ) {
							update_option('mo_media_restriction_message', 'Your query could not be submitted. Please try again.');
							$this->mo_media_restriction_show_error_message();
						} else {
							update_option('mo_media_restriction_message', 'Thanks for getting in touch! We shall get back to you shortly.');
							$this->mo_media_restriction_show_success_message();
						}
					} else {
						update_option( 'mo_media_restriction_message', 'Please Select one of the reasons ,if your reason is not mentioned please select Other Reasons' );
						$this->mo_media_restriction_show_error_message();
					}
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_skip_feedback'  && isset($_REQUEST['mo_media_restriction_skip_feedback_form_fields']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_skip_feedback_form_fields'])), 'mo_media_restriction_skip_feedback_form') ){
					$path = plugin_dir_path( dirname( __FILE__ ) ) .'media-restriction.php';
					deactivate_plugins( $path );
					update_option('mo_media_restriction_message', 'Plugin deactivated successfully');
					$this->mo_media_restriction_show_success_message();
				}
			}
		}
	}

	/**
	 * Post data request handle for media restriction on admin side
	 *
	 * @since    1.1.1
	 */
	public function mo_media_restrict_page() {
		if(isset($_POST['option'])){
			if(current_user_can('administrator')) {
				if(sanitize_textarea_field(wp_unslash($_POST['option'])) === 'mo_enable_media_restriction' && isset($_REQUEST['mo_media_restriction_enable_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_enable_field'])), 'mo_media_restriction_enable_form') ){
					update_option( 'mo_enable_media_restriction', isset( $_POST['mo_enable_media_restriction']) ? intval($_POST['mo_enable_media_restriction']) : 0);
					if(get_option( 'mo_enable_media_restriction')) {
						$upload_dir = wp_upload_dir();
						if($upload_dir && isset($upload_dir['basedir'])){
							$base_upload_dir = $upload_dir['basedir'];
							$protectedfiles = $base_upload_dir.DIRECTORY_SEPARATOR."protectedfiles";
							
							if (!file_exists($protectedfiles) && !is_dir($protectedfiles)) {
								wp_mkdir_p($protectedfiles);
							} 
						}
					}else{
						if(!$this->mo_media_restrict_remove_rules()){
							echo "<br><div class='mo_media_restriciton_error_box'><b style=color:red>Directory doesn\'t have write permissions.</b></div>";
						}
					}
				} else if(sanitize_textarea_field(wp_unslash($_POST['option'])) === 'mo_media_restriction_file_types'  && isset($_REQUEST['mo_media_restriction_file_configuration_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_file_configuration_field'])), 'mo_media_restriction_file_configuration_form') ){

					$mo_media_restriction_file_types = isset( $_POST['mo_media_restriction_file_types']) ? sanitize_textarea_field($_POST['mo_media_restriction_file_types']) : 0;
					$mo_media_restriction_show_rules = isset( $_POST['mo_media_restriction_show_rules']) ? intval($_POST['mo_media_restriction_show_rules']) : 0;
					if(empty($mo_media_restriction_file_types)){
						echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>File extension is requried.</b></div>';
					}else{
						if(is_string($mo_media_restriction_file_types)){
							$mo_media_restriction_file_types = str_replace('{\"value\":\"','',$mo_media_restriction_file_types);	
							$mo_media_restriction_file_types = str_replace('\"}','',$mo_media_restriction_file_types);	
							$mo_media_restriction_file_types = str_replace('[','',$mo_media_restriction_file_types);
							$mo_media_restriction_file_types = str_replace(']','',$mo_media_restriction_file_types);					
							$mo_media_restriction_file_types = explode(',',$mo_media_restriction_file_types);
							$string = $mo_media_restriction_file_types[0];
							for($i=1;$i<sizeof($mo_media_restriction_file_types);$i++){
								$string = $string."|".$mo_media_restriction_file_types[$i];
							}
							$mo_media_restriction_file_types = $string;
						}
						update_option( 'mo_media_restriction_file_types', $mo_media_restriction_file_types );
						update_option( 'mo_media_restriction_show_rules', $mo_media_restriction_show_rules );

						if(isset($_POST['mo_mr_restrict_option'])){
							$restrict_option = sanitize_textarea_field(wp_unslash($_POST['mo_mr_restrict_option']));
							update_option('mo_mr_restrict_option', $restrict_option);

							if($restrict_option === "display-custom-page"){
								if(isset($_POST['mo_media_redirect_to_display_page'])){
									$redirect_to = sanitize_textarea_field(wp_unslash($_POST['mo_media_redirect_to_display_page']));
									update_option('mo_mr_redirect_to', $redirect_to);
								}
							}
						}

						$choose_server = isset( $_POST['choose_server']) ? sanitize_textarea_field($_POST['choose_server']) : 'apache';
						update_option( 'mo_media_restriction_choose_server', $choose_server );

						if($mo_media_restriction_show_rules === 0){
							if(get_option('mo_enable_media_restriction')) {
								if($this->mo_media_restrict_write_rules()){
									echo "<br><div class='mo_media_restriciton_success_box'><b style=color:green>Settings saved successfully.</b></div>";
								}else{
									echo "<br><div class='mo_media_restriciton_error_box'><b style=color:red>Please give write permissions.</b></div>";
								}
							}else{
								echo "<br><div class='mo_media_restriciton_error_box'><b style=color:red>Enable media restriction for logged in user first.</b></div>";
							}
						}else{
							update_option('mo_media_restriction_show_rules',2);
						}
					}
				} else if(sanitize_textarea_field(wp_unslash($_POST['option'])) === 'mo_media_restriction_file_upload'   && isset($_REQUEST['mo_media_restriction_file_upload_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_file_upload_field'])), 'mo_media_restriction_file_upload_form') ){
					$filename = isset($_FILES["fileToUpload"]["name"]) ? sanitize_file_name($_FILES["fileToUpload"]["name"]) : '';
					if(!$this->mo_media_restriction_check_empty_or_null($filename) && ! validate_file($filename)){
						$upload_dir = wp_upload_dir();
						if($upload_dir && isset($upload_dir['basedir'])){
							$base_upload_dir = $upload_dir['basedir'];
							$protectedfiles = $base_upload_dir.DIRECTORY_SEPARATOR."protectedfiles";
							if( $upload_dir['error'] !== false ){
								echo "<br><div class='mo_media_restriciton_error_box'><b style='color:red'>".$upload_dir['error']."</b></div>";
							} else {
								if (!file_exists($protectedfiles) && !is_dir($protectedfiles)) {
									wp_mkdir_p($protectedfiles, 0775, true);
								}
								$target_file = $protectedfiles .DIRECTORY_SEPARATOR. basename($filename);
								if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
									echo "<br><div class='mo_media_restriciton_success_box'><b style=color:green>File uploaded successfully.</b></div>";
								} else{
									echo "<br><div class='mo_media_restriciton_error_box'><b style=color:red>Error uploading the file.</b></div>";
								}
							}						
						}else{
							echo "<br><div class='mo_media_restriciton_error_box'><b style=color:red>Directory doesn\'t exist.</b></div>";
						}
					}else{
						echo "<br><div class='mo_media_restriciton_error_box'><b style=color:red>Invalid file name.</b></div>";
					}
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_contact_us'  && isset($_REQUEST['mo_media_restriction_contact_us_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_contact_us_field'])), 'mo_media_restriction_contact_us_form') ){
					// contact us 
					$email = sanitize_email($_POST['mo_media_restriction_contact_us_email']);
					$phone = "+ ".preg_replace('/[^0-9]/', '',sanitize_textarea_field ( $_POST['mo_media_restriction_contact_us_phone']));
					$query = sanitize_textarea_field($_POST['mo_media_restriction_contact_us_query']);
					if ( $this->mo_media_restriction_check_empty_or_null( $email ) || $this->mo_media_restriction_check_empty_or_null( $query ) ) {
						echo '<br><b style=color:red>Please fill up Email and Query fields to submit your query.</b>';
					}else{
						$customer = new Miniorange_Media_Restriction_Customer();
						$submited = $customer->submit_contact_us( $email, $phone, $query );
						if ( $submited === false ) {
							echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Your query could not be submitted. Please try again.</b></div>';
						} else {
							echo '<br><div class="mo_media_restriciton_success_box"><b style=color:green>Thanks for getting in touch! We shall get back to you shortly.</b></div>';
						}
					}	
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_delete_file'  && isset($_REQUEST['mo_media_restriction_delete_file_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_delete_file_field'])), 'mo_media_restriction_delete_file_form') ){
					$filename = isset($_POST['mo_media_restrict_filename']) ? sanitize_file_name($_POST['mo_media_restrict_filename']) : '';
					if ( $this->mo_media_restriction_check_empty_or_null( $filename ) || $filename == "none" ) {
						echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Please select a file to submit your query.</b></div>';
					}else{
						if(!validate_file($filename)){
							$upload_dir = wp_upload_dir();
							if($upload_dir && isset($upload_dir['basedir'])){
								$base_upload_dir = $upload_dir['basedir'];
								$protectedfiles = $base_upload_dir.DIRECTORY_SEPARATOR."protectedfiles";
								if(file_exists($protectedfiles)){
									if (file_exists($protectedfiles.DIRECTORY_SEPARATOR.$filename)){
										wp_delete_file($protectedfiles.DIRECTORY_SEPARATOR.$filename);
										echo '<br><div class="mo_media_restriciton_success_box"><b style=color:green>File deleted successfully.</b></div>';
									}else{
										echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>File doesn\'t exist.</b></div>';
									}
								}else{
									echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Protected directory doesn\'t exist.</b></div>';
								}
							}else{
								echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Upload directory doesn\'t exist.</b></div>';
							}
						}else{
							echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Invalid file.</b></div>';
						}
					}
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_register_customer'  && isset($_REQUEST['mo_media_restriction_register_customer_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_register_customer_field'])), 'mo_media_restriction_register_customer_form') ){
					//validation and sanitization
					$email = '';
					$phone = '';
					$password = '';
					$confirmPassword = '';
					$fname = '';
					$lname = '';
					$company = '';
					if( $this->mo_media_restriction_check_empty_or_null( $_POST['mo_media_restriction_admin_email'] ) || $this->mo_media_restriction_check_empty_or_null( $_POST['mo_media_restriction_password'] ) || $this->mo_media_restriction_check_empty_or_null( $_POST['mo_media_restriction_confirm_password'] ) ) {
						echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>All the fields are required. Please enter valid entries.</b></div>';
					} else if( strlen( $_POST['mo_media_restriction_password'] ) < 8 || strlen( $_POST['mo_media_restriction_confirm_password'] ) < 8){
						echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Choose a password with minimum length 8.</b></div>';
					} else {
						$email = sanitize_email( $_POST['mo_media_restriction_admin_email'] );
						$phone = "";
						$password = sanitize_textarea_field( $_POST['mo_media_restriction_password'] );
						$confirmPassword = sanitize_textarea_field( $_POST['mo_media_restriction_confirm_password'] );
						$fname = "";
						$lname = "";
						$company = "";
						update_option( 'mo_media_restriction_admin_email', $email );
						update_option( 'mo_media_restriction_admin_phone', $phone );
						update_option( 'mo_media_restriction_admin_fname', $fname );
						update_option( 'mo_media_restriction_admin_lname', $lname );
						update_option( 'mo_media_restriction_admin_company', $company );
						
						if( strcmp( $password, $confirmPassword) == 0 ) {
							update_option( 'password', $password );
							$customer = new Miniorange_Media_Restriction_Customer();
							$email = get_option('mo_media_restriction_admin_email');
							$content = json_decode( $customer->check_customer(), true );
							
							if( strcasecmp( $content['status'], 'CUSTOMER_NOT_FOUND') == 0 ) {
								$response = json_decode( $customer->create_customer(), true );
	
								if(strcasecmp($response['status'], 'SUCCESS') != 0) {
									echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Failed to create customer. Try again.</b></div>';
								} else {
									echo '<br><div class="mo_media_restriciton_success_box"><b style=color:green>'.$response['message'].'.</b></div>';
									update_option( 'mo_media_restriction_new_user', 'login' );
								}
							} elseif(strcasecmp( $content['status'], 'SUCCESS') == 0 ) {
								update_option( 'mo_media_restriction_new_user', 'login' );
								echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Account already exist. Please Login.</b></div>';
							} else if(is_null($content)) {
								echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Failed to create customer. Try again.</b></div>';
							} else {
								echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>'.$content['message'].'.</b></div>';
							}							
						} else {
							echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Passwords do not match.</b></div>';
						}
					}
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_login_customer'  && isset($_REQUEST['mo_media_restriction_login_customer_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_login_customer_field'])), 'mo_media_restriction_login_customer_form') ){
					//validation and sanitization
					$email = '';
					$password = '';
					if( $this->mo_media_restriction_check_empty_or_null( $_POST['mo_media_restriction_admin_email'] ) || $this->mo_media_restriction_check_empty_or_null( $_POST['mo_media_restriction_password'] ) ) {
						echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>All the fields are required. Please enter valid entries.</b></div>';
					} else{
						$email = sanitize_email( $_POST['mo_media_restriction_admin_email'] );
						$password = sanitize_textarea_field( $_POST['mo_media_restriction_password'] );
						
						update_option( 'mo_media_restriction_admin_email', $email );
						update_option( 'password', $password );
						$customer = new Miniorange_Media_Restriction_Customer();
						$content = $customer->get_customer_key();
						$customerKey = json_decode( $content, true );
						if( json_last_error() == JSON_ERROR_NONE && isset($customerKey['status']) && $customerKey['status'] === "SUCCESS" ) {
							update_option( 'mo_media_restriction_admin_customer_key', $customerKey['id'] );
							update_option( 'mo_media_restriction_admin_api_key', $customerKey['apiKey'] );
							update_option( 'customer_token', $customerKey['token'] );
							update_option( 'mo_media_restriction_admin_phone', $customerKey['phone'] );
							delete_option( 'password' );
							update_option( 'mo_media_restriction_new_user', 'account-setup');
							echo '<br><div class="mo_media_restriciton_success_box"><b style=color:green>Customer retrieved successfully.</b></div>';
						} else {
							echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Invalid username or password. Please try again.</b></div>';
						}
					}
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_change_to_login'  && isset($_REQUEST['mo_media_restriction_change_to_login_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_change_to_login_field'])), 'mo_media_restriction_change_to_login') ){
					//validation and sanitization
					delete_option( 'mo_media_restriction_admin_customer_key' );
					delete_option( 'mo_media_restriction_admin_api_key' );
					delete_option( 'customer_token' );
					delete_option( 'mo_media_restriction_admin_phone' );
					delete_option( 'mo_media_restriction_admin_email' );
					update_option( 'mo_media_restriction_new_user', 'login');
				} else if (sanitize_textarea_field($_POST['option']) === 'mo_media_restriction_change_to_register'  && isset($_REQUEST['mo_media_restriction_change_to_register_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['mo_media_restriction_change_to_register_field'])), 'mo_media_restriction_change_to_register') ){
					//validation and sanitization
					delete_option( 'mo_media_restriction_admin_customer_key' );
					delete_option( 'mo_media_restriction_admin_api_key' );
					delete_option( 'customer_token' );
					delete_option( 'mo_media_restriction_admin_phone' );
					delete_option( 'mo_media_restriction_admin_email' );
					update_option( 'mo_media_restriction_new_user', 'register');
				}  else {
					echo '<br><div class="mo_media_restriciton_error_box"><b style=color:red>Something went wrong please try again later.</b></div>';
				}
			}
		}
		
		mo_media_restrict_page_ui();
	}

}
