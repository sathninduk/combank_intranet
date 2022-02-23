<?php
require('mo-wpum-registration-pages.php');
require('mo-wpum-user-profile-pages.php');
require('mo-wpum-troubleshooting-pages.php');
require('mo-wpum-settings-pages.php');
require('mo-wpum-fields-pages.php');
require('mo-wpum-licensing-pages.php');
require('mo-wpum-restrict-access-pages.php');
require('mo-wpum-templates-pages.php');
function mo_wpum_show_plugin_settings() {
	global $mo_manager_utility, $db_queries,$wpdb;
	if( isset( $_GET[ 'tab' ]) && $_GET[ 'tab' ] !== 'register' ) {
		$active_tab = $_GET[ 'tab' ];
	} else if($mo_manager_utility->is_registered()) {
		$active_tab = 'settings';
	} else {
		$active_tab = 'register';
	}

	if( isset( $_GET['option'] ) && $_GET['option'] == "wpum_edit_role" )
		mo_wpum_show_edit_role_page($_GET['user_id']);
	elseif( isset( $_GET['option'] ) && $_GET['option'] == "mo_wpum_field" ){
		mo_wpum_show_field_pages();
	}elseif( isset( $_GET['option'] ) && $_GET['option'] == "mo_wpum_field_edit" ){
		$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $_GET['id'] ));
		update_option('field_type',$field->field_type);
		mo_wpum_edit_field_pages( $_GET['id'] );
	}elseif( isset( $_GET['option'] ) && $_GET['option'] == "mo_wpum_field_delete" ){ 
		$current_site = get_site_url();
		$url = $current_site.'/wp-admin/users.php?page=mo_wpum_settings&tab=fields';
		$db_queries->mo_wpum_delete_field($_GET['id']);
		$mo_manager_utility->redirect($url);
	}else
		mo_wpum_show_main_settings_page($active_tab);
} 

function mo_wpum_show_main_settings_page($active_tab){
	global $mo_manager_utility;
	$help_url = add_query_arg( array('tab' => 'troubleshooting'), $_SERVER['REQUEST_URI'] );
	?>
	<div class="wrap">
		<h1>WP User Management Settings</h1>
	</div>
	<?php mo_wpum_check_is_curl_installed() ?>
	<div id="tab" class="main-tabs" >
		<h2 class="nav-tab-wrapper"><?php
		if(!$mo_manager_utility->is_registered()){ ?>
		<a class="nav-tab <?php echo $active_tab == 'register' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'register'), $_SERVER['REQUEST_URI'] ); ?>">Account</a> <?php } ?>
			<a class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : 'settings'; ?>" href="<?php echo add_query_arg( array('tab' => 'settings'), $_SERVER['REQUEST_URI'] ); ?>">Settings</a>
			<a class="nav-tab <?php echo $active_tab == 'fields' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'fields'), $_SERVER['REQUEST_URI'] ); ?>">Registration Fields</a>
			<a class="nav-tab <?php echo $active_tab == 'templates' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'templates'), $_SERVER['REQUEST_URI'] ); ?>">Templates</a>
			<a class="nav-tab <?php echo $active_tab == 'restrict_access' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'restrict_access'), $_SERVER['REQUEST_URI'] ); ?>">Page Restrict</a>
			<a class="nav-tab <?php echo $active_tab == 'troubleshooting' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'troubleshooting'), $_SERVER['REQUEST_URI'] ); ?>">Troubleshooting</a>
			<a class="nav-tab <?php echo $active_tab == 'licensing' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'licensing'), $_SERVER['REQUEST_URI'] ); ?>">Licensing Plans</a>
		</h2>
	</div>

	<div id="mo_wpum_msgs"></div>
	<table style="width:100%;padding-top:12px;">
		<tr>
			<td style="vertical-align:top;width:65%;">

				<?php
					if ( $active_tab == 'register') {
						if (get_option ( 'mo_wpum_verify_customer' ) == 'true') {
							mo_wpum_show_verify_password_page();
						}elseif (trim ( get_option ( 'mo_wpum_admin_email' ) ) != '' && trim ( get_option ( 'mo_wpum_admin_api_key' ) ) == '' && get_option ( 'mo_wpum_new_registration' ) != 'true') {
							mo_wpum_show_verify_password_page();
						}elseif (get_option('mo_wpum_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_wpum_registration_status') == 'MO_OTP_VALIDATION_FAILURE' 
								|| get_option('mo_wpum_registration_status') == 'MO_OTP_DELIVERED_FAILURE' ){
							mo_wpum_show_otp_verification();
						}elseif (!$mo_manager_utility->is_registered()) {
							delete_option ( 'password_mismatch' );
							mo_wpum_show_new_registration_pages();
						}
					}elseif ( $active_tab == 'user_profile' ) {
						mo_wpum_show_user_profile();
					}elseif ( $active_tab == 'settings' ) {
						mo_wpum_show_settings_page();
					}elseif ( $active_tab == 'profile' ) {
						show_mo_profile_info();
					}elseif ( $active_tab == 'fields' ) {
						mo_wpum_show_field_settings();
					}elseif ( $active_tab == 'templates' ) {
						mo_wpum_show_templates_settings();
					}elseif ( $active_tab == 'restrict_access' ) {
						mo_wpum_restrict_access_settings();
					}elseif ( $active_tab == 'troubleshooting' ) {
						mo_wpum_show_troubleshooting();
					}elseif ( $active_tab == 'licensing' ) {
						mo_wpum_show_licensing_info();
					}
					
				?>
			</td>
			<td style="vertical-align:top;padding-left:1%;">
				<?php echo mo_wpum_show_plugin_support(); ?>
			</td>
		</tr>
	</table>
	<?php
}


function mo_wpum_check_is_curl_installed(){
	global $mo_manager_utility;
	if(!$mo_manager_utility->is_curl_installed()){ 
	?>
		<div id="help_curl_warning_title" class="mo_wpum_title_panel">
			<p><font color="#FF0000">Warning: PHP cURL extension is not installed or disabled. <span style="color:blue">Click here</span> for instructions to enable it.</font></p>
		</div>
		<div hidden="" id="help_curl_warning_desc" class="mo_wpum_help_desc">
			<ul>
				<li>Step 1:&nbsp;&nbsp;&nbsp;&nbsp;Open php.ini file located under php installation folder.</li>
				<li>Step 2:&nbsp;&nbsp;&nbsp;&nbsp;Search for <b>extension=php_curl.dll</b> </li>
				<li>Step 3:&nbsp;&nbsp;&nbsp;&nbsp;Uncomment it by removing the semi-colon(<b>;</b>) in front of it.</li>
				<li>Step 4:&nbsp;&nbsp;&nbsp;&nbsp;Restart the Apache Server.</li>
			</ul>
			For any further queries, please <a href="mailto:info@xecurify.com">contact us</a>.								
		</div>
	<?php
	}
}

function mo_wpum_show_plugin_support(){
	global $current_user;
	wp_get_current_user();
	?>
	<div class="mo_wpum_support_layout">
		<h3>Support</h3>
			<p>Need any help? Just send us a query so we can help you.</p>
			<form method="post" action="">
				<input type="hidden" name="option" value="mo_wpum_contact_us_query_option" />
				<table class="mo_wpum_settings_table">
					<tr>
						<td><input type="email" class="mo_wpum_table_contact" required placeholder="Enter your Email" name="mo_wpum_contact_us_email" value="<?php echo get_option("mo_wpum_admin_email"); ?>"></td>
					</tr>
					<tr>
						<td><input type="tel" id="contact_us_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" placeholder="Enter your phone number with country code (+1)" class="mo_wpum_table_contact" name="mo_wpum_contact_us_phone" value="<?php echo get_option('mo_wpum_admin_phone');?>"></td>
					</tr>
					<tr>
						<td><textarea class="mo_wpum_table_contact" onkeypress="mo_wpum_valid_query(this)" onkeyup="mo_wpum_valid_query(this)" placeholder="Write your query here" onblur="mo_wpum_valid_query(this)" required name="mo_wpum_contact_us_query" rows="4" style="resize: vertical;"></textarea></td>
					</tr>
				</table>
				<br>
			<input type="submit" name="submit" value="Submit Query" style="width:110px;" class="button button-primary button-large" />

			</form>
			<p>If you want custom features in the plugin, just drop an email to <a href="mailto:info@xecurify.com">info@xecurify.com</a>.</p>
	</div>
	</div>
	</div>
	</div>
	<script>
		jQuery("#contact_us_phone").intlTelInput();
		function mo_valid_query(f) {
			!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
					/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
		}

		function moSharingSizeValidate(e){
			var t=parseInt(e.value.trim());t>60?e.value=60:10>t&&(e.value=10)
		}
		function moSharingSpaceValidate(e){
			var t=parseInt(e.value.trim());t>50?e.value=50:0>t&&(e.value=0)
		}
		function moLoginSizeValidate(e){
			var t=parseInt(e.value.trim());t>60?e.value=60:20>t&&(e.value=20)
		}
		function moLoginSpaceValidate(e){
			var t=parseInt(e.value.trim());t>60?e.value=60:0>t&&(e.value=0)
		}
		function moLoginWidthValidate(e){
			var t=parseInt(e.value.trim());t>1000?e.value=1000:140>t&&(e.value=140)
		}
		function moLoginHeightValidate(e){
			var t=parseInt(e.value.trim());t>50?e.value=50:35>t&&(e.value=35)
		}

	</script>
	<?php
}