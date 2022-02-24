<?php
require_once dirname( __FILE__ ) . '/includes/lib/export.php';
require_once "pagination.php";

function mo_ldap_local_settings() {
	if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = sanitize_text_field($_GET[ 'tab' ]);
	} else {
		$active_tab = 'default';
	}

	?>
	 <div id="mo_ldap_settings" >
        <form name="f" method="post" id="show_ldap_pointers">
            <input type="hidden" name="option" value="clear_ldap_pointers"/>
            <input type="hidden" name="restart_tour" id="restart_tour"/>
            <input type="hidden" name="restart_plugin_tour" id="restart_plugin_tour"/>
        </form></div>
<?php
        if($active_tab != 'pricing' && $active_tab != 'add_on' && $active_tab!='troubleshooting' && $active_tab!='account' && $active_tab!='trial_request') {
            ?>
        <div style="font-size: large; font-weight: 600;"><br>miniOrange LDAP/Active Directory Login for Intranet Sites
            <a id="license_upgrade" class="button button-large" style="color:#fff;background-color:#f2881be0  ;border-color:#f2881be0  " href="<?php echo esc_url(add_query_arg( array( 'tab' => 'pricing' ), htmlentities( $_SERVER['REQUEST_URI'] ) )); ?>">Licensing Plans</a>
            <a id="ldap_troubleshooting_tab_pointer" class="button button-large button-primary"  href="<?php echo esc_url(add_query_arg( array('tab' => 'troubleshooting'), $_SERVER['REQUEST_URI'] )); ?>">FAQ's</a>
            <a id="ldap_account_setup_tab_pointer" class="button button-large button-primary" href="<?php echo esc_url(add_query_arg( array('tab' => 'account'), $_SERVER['REQUEST_URI'] )); ?>">Account Setup</a>
            <a id="ldap_trial_for_premium_plugin" style="color:#fff;background-color:#f2881be0;border-color:#f2881be0" class="button button-large" href="<?php echo esc_url(add_query_arg( array('tab' => 'trial_request'), $_SERVER['REQUEST_URI'] )); ?>">Request for Demo</a>
            <span id="configure-restart-plugin-tour" style="float:right; margin-right:15px;">
            <button id="restart_plugin_tour" type="button" value="restart_plugin_tour" style="position: relative" class="button button-primary button-large"  onclick="jQuery('#restart_plugin_tour').val('true');jQuery('#show_ldap_pointers').submit();"><em class="fas fa-sync"></em> Take Plugin Tour</button>
            </span></div>
        <?php

		if(!MoLdapLocalUtil::is_extension_installed('ldap')) {
			?>
            <div class="notice notice-error is-dismissible">
                <span style="color:#FF0000">Warning: PHP LDAP extension is not installed or disabled.</span>
				<div id="help_ldap_warning_title" class="mo_ldap_title_panel">
                    <p><a target="_blank" style="cursor: pointer;">Click here for instructions to enable it.</a></p>
				</div>
				<div hidden="" style="padding: 2px 2px 2px 12px" id="help_ldap_warning_desc" class="mo_ldap_help_desc">
                <ul>
                    <li style="font-size: large; font-weight: bold">Step 1 </li>
                    <li style="font-size: medium; font-weight: bold">Loaded configuration file : <?php echo php_ini_loaded_file() ?></li>
                    <li style="list-style-type:square;margin-left:20px">Open php.ini file from above file path</strong></li><br/>
                    <li style="font-size: large; font-weight: bold">Step 2</li>
                    <li style="font-weight: bold;color: #C31111">For Windows users using Apache Server</li>
                    <li style="list-style-type:square;margin-left:20px">Search for <strong>"extension=php_ldap.dll"</strong> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li>
                    <li style="font-weight: bold;color: #C31111">For Windows users using IIS server</li>
                    <li style="list-style-type:square;margin-left:20px">Search for <strong>"ExtensionList"</strong> in the php.ini file. Uncomment the <strong>"extension=php_ldap.dll"</strong> line, if not present then add this line in the file and save the file.</li>
                    <li style="font-weight: bold;color: #C31111">For Linux users</li>
                    <ul style="list-style-type:square;margin-left: 20px">
                    <li style="margin-top: 5px">Install php ldap extension (If not installed yet)
                        <ul style="list-style-type:disc;margin-left: 15px;margin-top: 5px">
                            <li>For Debian, the installation command would be <strong>apt-get install php-ldap</strong></li>
                            <li>For RHEL based systems, the command would be <strong>yum install php-ldap</strong></li></ul></li>
                    <li>Search for <strong>"extension=php_ldap.so"</strong> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li></ul><br/>
                    <li style="margin-top: 5px;font-size: large; font-weight: bold">Step 3</li>
                    <li style="list-style-type:square;margin-left:20px">Restart your server. After that refresh the "LDAP/AD" plugin configuration page.</li>
					</ul>
						For any further queries, please contact us</a>.
				</div>
            <p style="color:black">If your site is hosted on <strong>Shared Hosting</strong> platforms like Bluehost, DreamHost, SiteGround, Flywheel etc and you are not able to enable the extension then you can use our <a href="https://wordpress.org/plugins/miniorange-wp-ldap-login/" target="_blank" rel="noopener" style="cursor: pointer;">Active Directory Integration/LDAP Integration for Shared Hosting Environment</a> plugin.</p>
            </div>
			<?php
		}
		if(!MoLdapLocalUtil::is_extension_installed('openssl')) {
			?>
            <div class="notice notice-error is-dismissible">
			<p style="color:#FF0000">(Warning: <a target="_blank" rel="noopener" href="http://php.net/manual/en/openssl.installation.php">PHP OpenSSL extension</a> is not installed or disabled)</p>
            </div>
			<?php
		}
    } else { ?>
        <div style="background-color:#f9f9f9;  display: flex;justify-content: center;position: relative;padding:10px 0;" id="nav-container">
            <div>
                <a style="font-size: 16px; color: #000;text-align: center;text-decoration: none;display: inline-block;" href="<?php echo esc_url(add_query_arg( array( 'tab' => 'default' ), htmlentities( $_SERVER['REQUEST_URI'] ) )); ?>">
                    <button id="Back-To-Plugin-Configuration" type="button" value="Back-To-Plugin-Configuration" class="button button-primary button-large" style="position:absolute;left:10px;">
                        <span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span> 
                        Plugin Configuration
                    </button> 
                </a> 
            </div>
            <div style="display:block;text-align:center;padding:20px 0;">
                <h2 style="font-size:22px;text-align: center;">miniOrange LDAP/Active Directory Login for Intranet Sites</h2>
            </div>
        </div>
    <?php }?>
	<div class="mo2f_container">
        <?php if($active_tab != 'pricing' && $active_tab != 'add_on' && $active_tab!='troubleshooting' && $active_tab!='account' && $active_tab!='trial_request') {

        $check_multisite_message = get_option('mo_ldap_local_multisite_message');
        if( is_multisite()) {
            $multisite_msg = "It seems you have installed WordPress Multisite Environment. ";
        }
        else{
            $multisite_msg = "Using a Multisite Environment? ";
        }

        if($check_multisite_message != 'true'){
            ?>
            <div class="modals notice notice-info">
                <form method="post" class="modal-contents">
                    <?php wp_nonce_field("mo_ldap_hide_msg");?>
                    <div>
                             <form method="POST"><input type="hidden" name="option" value="mo_ldap_hide_msg">
                                 <h4><?php echo esc_attr($multisite_msg); ?><a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Click Here</a> to check our miniOrange LDAP/AD Login For Intranet Sites For Multisite Environment.</h4>
                                 <input type="submit" name="Close" value="X" style="position: relative; margin-top: -40px;" class="close_local_feedback_form"></form>
                    </div>
                </form>
            </div>
        <?php }
        ?>
		<h2 class="nav-tab-wrapper">
            <a id="ldap_default_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'default' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'default'), $_SERVER['REQUEST_URI'] )); ?>">LDAP Configuration</a>
            <a id="ldap_signin_settings_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'signin_settings' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'signin_settings'), $_SERVER['REQUEST_URI'] )); ?>">Sign-In Settings</a>
            <a id="ldap_multiple_directories_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'multiconfig' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'multiconfig'), $_SERVER['REQUEST_URI'] )); ?>">Multiple Directories</a>
			<a id="ldap_role_mapping_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'rolemapping' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'rolemapping'), $_SERVER['REQUEST_URI'] )); ?>">Role Mapping</a>
			<a id="ldap_attribute_mapping_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'attributemapping' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'attributemapping'), $_SERVER['REQUEST_URI'] )); ?>">Attribute Mapping</a>
            <a id="ldap_feature_request_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'feature_request' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'feature_request'), $_SERVER['REQUEST_URI'] )); ?>">Feature Request</a>
            <a id="ldap_config_settings_tab_pointer" style="position: relative" class="nav-tab <?php echo $active_tab == 'config_settings' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'config_settings'), $_SERVER['REQUEST_URI'] )); ?>">Configuration Settings</a>
			<a id="ldap_User_Report_tab_pointer" style="position: relative;" class="nav-tab <?php echo $active_tab == 'Users_Report' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg( array('tab' => 'Users_Report'), $_SERVER['REQUEST_URI'] )); ?>">Authentication Report</a>

		</h2>
		<table style="width:100%;" aria-hidden="true">
			<tr>
				<td style="width:65%;vertical-align:top;" id="configurationForm">
					<?php   
                            if($active_tab == 'signin_settings'){
                                mo_ldap_local_signin_settings();
                            } elseif($active_tab == 'multiconfig'){
                                mo_ldap_local_multiple_ldap();
                           } elseif($active_tab == 'rolemapping'){
								mo_ldap_local_rolemapping();
							}elseif($active_tab == 'attributemapping'){
									mo_ldap_show_attribute_mapping_page();
							}elseif($active_tab == 'config_settings'){
							        mo_show_export_page();
							}elseif($active_tab == 'Users_Report'){
                                mo_user_report_page();
							}elseif($active_tab == 'feature_request') {
                                feature_request();
                            }
							else {
									mo_ldap_local_configuration_page();
							}
					?>
				</td>
                <?php
                if($active_tab != 'pricing' && $active_tab!='feature_request'){
                    ?>
                    <td style="vertical-align:top;padding-left:1%;">
                        <?php mo_ldap_local_support();add_on_main_page(); ?>
                    </td>
                <?php } ?>
			</tr>
		</table>
        <?php }elseif ( $active_tab == 'pricing' || $active_tab == 'add_on' ){
            mo_ldap_show_licensing_page();
        }elseif($active_tab == 'trial_request'){
        mo_ldap_premium_plugin_trial();
        }
        elseif($active_tab == 'troubleshooting'){
        mo_ldap_local_troubleshooting();
        } elseif($active_tab == 'account'){
        if (get_option ( 'mo_ldap_local_verify_customer' ) == 'true') {
            mo_ldap_show_verify_password_page_ldap();
        } elseif (! MoLdapLocalUtil::is_customer_registered()) {
            mo_ldap_show_new_registration_page_ldap();
        } else{
            mo_ldap_show_customer_details();
        }
    }?>

</div>
	<div class='overlay_back' id="overlay" hidden></div>
	<?php
}

function mo_ldap_show_customer_details(){
    ?>
    <div class="mo_ldap_table_layout" >
        <h2>Thank you for registering with miniOrange.</h2>

        <table border="1" aria-hidden="true" style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:45%">
            <tr>
                <td style="width:45%; padding: 10px;">miniOrange Account Email</td>
                <td style="width:55%; padding: 10px;"><?php echo esc_attr(get_option( 'mo_ldap_local_admin_email' )); ?></td>
            </tr>
            <tr>
                <td style="width:45%; padding: 10px;">Customer ID</td>
                <td style="width:55%; padding: 10px;"><?php echo esc_attr(get_option( 'mo_ldap_local_admin_customer_key' )) ?></td>
            </tr>
        </table>
        <br /><br />

        <table aria-hidden="true">
            <tr>
                <td>
                    <form name="f1" method="post" action="" id="mo_ldap_change_account_form">
                        <?php wp_nonce_field("change_miniorange_account");?>
                        <input type="hidden" name="option" value="change_miniorange_account"/>
                        <input type="submit" value="Change Account" class="button button-primary button-large"/>
                    </form>
                </td><td>
                    <a href="<?php echo esc_url(add_query_arg( array( 'tab' => 'pricing' ), htmlentities( $_SERVER['REQUEST_URI'] ) )); ?>"><input type="button" class="button button-primary button-large" value="Check Licensing Plans"/></a>
                </td>
            </tr>
        </table>

        <br />
    </div>

    <?php
}



function mo_ldap_check_curl_extension()
{
    if (!MoLdapLocalUtil::is_curl_installed()) {
        $curl_warning = get_option('mo_ldap_curl_warning_message');
        ?>

        <div class="notice notice-error is-dismissible">
            <div id="help_curl_warning_title" class="mo_ldap_title_panel">
                <p style="color:#FF0000"><?php echo esc_attr($curl_warning); ?></p>
                <p><a target="_blank" style="cursor: pointer;">Click here for instructions to enable it.</a></p>
            </div>
            <div hidden="" id="help_curl_warning_desc" class="mo_ldap_help_desc">
                <ul>
                    <li style="font-size: large; font-weight: bold">Step 1</li>
                    <li style="font-size: large; font-weight: bold"><strong>Loaded configuration file
                            : <?php echo php_ini_loaded_file() ?></strong></li>
                    <li style="list-style-type:square;margin-left:20px">Open php.ini file from above file path</br></li>
                    <br/>
                    <li style="font-size: large; font-weight: bold">Step 2</li>
                    <li style="font-weight: bold;color: #C31111">For Windows users</li>
                    <li style="list-style-type:square;margin-left:20px">Search for <strong>"extension=php_curl.dll"</strong> in
                        php.ini file. Uncomment this line, if not present then add this line in the file and save the
                        file.
                    </li>
                    <li><span style="color: #C31111"><strong>For Linux users</strong></span>
                        <ul style="list-style-type:square;margin-left: 20px">
                            <li style="margin-top: 5px">Install php curl extension (If not installed yet)
                                <ul style="list-style-type:disc;margin-left: 15px;margin-top: 5px">
                                    <li>For Debian, the installation command would be <strong>apt-get install php-curl</strong>
                                    </li>
                                    <li>For RHEL based systems, the command would be <strong>yum install php-curl</strong></li>
                                </ul>
                            </li>
                        </ul>
                            </li>
                            <li>Search for <strong>"extension=php_curl.so"</strong> in php.ini file. Uncomment this line, if not
                                present then add this line in the file and save the file.
                            </li>
                        <br/>
                    <li><span style="margin-top: 5px;font-size: large; font-weight: bold">Step 3</span></li>
                    <li><span style="list-style-type:square;margin-left:20px">Restart your server. After that refresh the
                        "LDAP/AD" plugin configuration page.
                        </span></li>
                </ul>
                For any further queries, please contact us.
            </div>
        </div>
    <?php }
}

function mo_ldap_premium_plugin_trial() {
    $current_user = wp_get_current_user();
    if (get_option('mo_ldap_local_admin_email')) {
        $admin_email = get_option('mo_ldap_local_admin_email');
    }
    else {
        $admin_email = $current_user->user_email;
    }
    ?>

<?php
    $curl_warning_msg = 'Warning: PHP cURL extension is not installed or disabled. Please install/enable this extension to submit the demo request with miniOrange.';
    update_option('mo_ldap_curl_warning_message', $curl_warning_msg);
    mo_ldap_check_curl_extension();?>

    <div style="background-color: #FFFFFF; border: 1px solid #CCCCCC; padding: 10px 10px 10px 10px;">
        <h3 style="color:darkorange">Request for Demo</h3><hr class="mo_ldap_license_hr">
        Want to try out the paid features before purchasing the license? Just let us know which plan you're interested in and we will setup a demo for you.
        <br/><br/>
        <div class="mo_demo_layout" style="padding-bottom:20px; padding-right:5px;">

            <form method="post" action="">
                <?php wp_nonce_field("mo_ldap_trial_request");?>
                <input type="hidden" name="option" value="mo_ldap_trial_request"/>
                <table aria-hidden="true">
                    <tr>
                        <td><span style="color:#FF0000">*</span><strong>Email :</strong></td>
                        <td><input type="text" name="mo_ldap_demo_email" placeholder="We will use this email to setup the demo for you" required style="width:350px" value="<?php echo esc_attr($admin_email) ?>" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>></td>
                    </tr>

                    <?php
                    $license_plans = array(
                        'basic-plan'                   => 'Basic LDAP Authentication Plan',
                        'kerbores-ntlm'                => 'Basic LDAP Authentication Plan + Kerberos/NTLM SSO',
                        'enterprise-plan'              => 'Enterprise/All-Inclusive Plan',
                        'multisite-basic-plan'         => 'Multisite Basic LDAP Authentication Plan',
                        'multisite-kerbores-ntlm'      => 'Multisite Basic LDAP Authentication Plan + Kerberos/NTLM SSO ',
                        'enterprise-enterprise-plan'   => 'Multisite Enterprise/All-Inclusive Plan'
                    );
                    ?>
                    <tr>
                        <td><span style="color:#FF0000">*</span><strong>Request a demo for :</strong></td>
                        <td><select name="mo_ldap_demo_plan" id="mo_ldap_demo_plan" style="width:350px" required onchange="mo_ldap_show_description();" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>>
                                <option hidden disabled selected value="">--Select a license plan--</option>
                                <?php
                                foreach($license_plans as $key => $value){
                                ?>
                                <option value="<?php echo esc_attr($key);?>"><?php echo esc_attr($value);?>
                                    <?php
                                    }
                                    ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div id="premium-video" style="display:none; height: fit-content;">
                            <span><strong><em>You can also check out our premium features in the video below.</em></strong></span><br><br>
                          <table aria-hidden="true"><tr><td>
                            <div style="box-shadow: 9px 4px 6px #888888;">
                            <a class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="https://www.youtube.com/watch?v=r0pnB2d0QP8" title="Premium Plugin Features" id="videoLink" rel="noopener" target="_blank"><span class="link-text">Premium Plugin Features </span></a></div>
                            </td><td></td><td></td>
                              <td>
                                  <div id="ntlm-sso-video" style="box-shadow: 9px 4px 6px #888888;">
                                      <a class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="https://youtu.be/JCVWurFle9I" title="Auto-login (SSO) Features" id="videoLink" style="width:170px;" rel="noopener" target="_blank"><span class="link-text">Auto-login (SSO) Features </span></a></div>
                              </td>
                              </tr></table>
                            </div>
                    </td></tr>

                    <tr id="add-on-list" style="display:none">
                        <?php
                        $addonsArray = new MoAddonListContent();
                        $recommendedAddons = unserialize(MO_LDAP_RECOMMENDED_ADDONS);
                        $thirdPartyAddons = unserialize(MO_LDAP_THIRD_PARTY_INTEGRATION_ADDONS);
                        $addonArray = array_merge($recommendedAddons,$thirdPartyAddons);
                        $addons = array(
                            'directory-sync'          => 'Sync Users LDAP Directory<a onclick="showAddonTrialPopup_video(jQuery(this),\'Sync Users LDAP Directory\',title)" style=" box-shadow: 9px 4px 6px #888888; width: max-content;margin-left: 28%" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['DIRECTORY_SYNC']['addonVideo']).' id="videoLink" ><span class="link-text">Setup video</span></a><br>',

                            'buddypress-integration'  => 'Sync BuddyPress Extended Profiles<a onclick="showAddonTrialPopup_video(jQuery(this),\'Sync BuddyPress Extended Profiles\',title)" style=" box-shadow: 9px 4px 6px #888888;width: max-content;margin-left: 20%" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['BUDDYPRESS_PROFILE_SYNC']['addonVideo']).' id="videoLink" ><span class="link-text">Setup video</span></a><br>',

                            'password-sync'           => 'Password Sync with LDAP Server<a onclick="showAddonTrialPopup_video(jQuery(this),\'Password Sync with LDAP Server\',title)" style=" box-shadow: 9px 4px 6px #888888;width: max-content;margin-left: 22%" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['PASSWORD_SYNC']['addonVideo']).' id="videoLink" ><span class="link-text">Setup video</span></a><br>',

                            'profile-picture-map'     => 'Profile Picture Sync for WordPress and BuddyPress<a onclick="showAddonTrialPopup_video(jQuery(this),\'Profile Picture Sync for WordPress and BuddyPress\',title)" style=" box-shadow: 9px 4px 6px #888888;width: max-content;margin-left: 5%;" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['PROFILE_PICTURE_SYNC']['addonVideo']).' id="videoLink" ><span class="link-text">Setup video</span></a><br>',

                            'ultimate-member-login'   => 'Ultimate Member Login Integration<a onclick="showAddonTrialPopup_video(jQuery(this),\'Ultimate Member Login Integration\',title)" style=" box-shadow: 9px 4px 6px #888888;width: max-content;margin-left: 19%" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['ULTIMATE_MEMBER_LOGIN_INTEGRATION']['addonVideo']).' id="videoLink" ><span class="link-text">Setup video</span></a><br>',

                            'search-staff'            => 'Search Staff from LDAP Directory <a onclick="showAddonTrialPopup_video(jQuery(this),\'Search Staff from LDAP Directory\',title)" style=" box-shadow: 9px 4px 6px #888888;width: max-content;margin-left: 21%" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['LDAP_SEARCH_WIDGET']['addonVideo']).' id="videoLink" ><span class="link-text">Setup video</span></a><br>',

                            'profile-sync'            => 'Third Party Plugin User Profile Integration <a onclick="showAddonTrialPopup_video(jQuery(this),\'Third Party Plugin User Profile Integration\',title)" style=" box-shadow: 9px 4px 6px #888888;width: max-content;margin-left: 13%" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="#videoLink" title='.esc_url($addonArray['USER_META']['addonVideo']).' id="videoLink"><span class="link-text">Setup video</span></a><br>',
                            
                            'page-post-restriction'   => 'Page/Post Restriction<br>',
                            'gravity-forms'           => 'Gravity Forms Integration<br>',
                            'buddypress-group'        => 'Sync BuddyPress Groups<br>',
                            'memberpress-integration' => 'MemberPress Plugin Integration<br>',
                            'emember-integration'     => 'eMember Plugin Integration'
                            );
                        ?>
                        <td></td><td colspan="2">
                            <p><strong>Select the Add-ons you are interested in (Optional)</strong></p>
                            <div style="width: 600px;">
                                <?php
                                foreach($addons as $key => $value){?>
                                    <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="true"> <?php echo $value ?><br/>
                                    <?php
                                }
                                ?>
                            </div></td>
                    </tr>
                    <tr>
                        <td><strong>Description :</strong></td>
                        <td><textarea id="demo_details" name="mo_ldap_demo_description" style="resize: vertical; width:350px; height:100px;" rows="4" placeholder="Need assistance? Write us about your requirements and we will set up a demo for you." <?php if(!MoLdapLocalUtil::is_curl_installed()){echo "disabled";}?>></textarea></td>
                    </tr>
                    <tr><td><span style="color:#FF0000">*</span><strong>Is your LDAP server publicly accessible? :</strong></td><td><input type="radio" name="get_directory_access" value="Yes" required <?php if(!MoLdapLocalUtil::is_curl_installed()){echo "disabled";}?>>Yes &nbsp; <input type="radio" name="get_directory_access" value="No" <?php if(!MoLdapLocalUtil::is_curl_installed()) echo "disabled";?>>No</td>
                    </tr>
                    <tr><td><br/></td></tr>
                    <tr><td></td><td><input type="submit" value="Send Request" class="button button-primary button-large" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/></td></tr>
                </table>
            </form>
        </div>
    </div>

    <div  hidden id="AddOnVideo_PopUp_modal" name="AddOnVideo_PopUp_modal" class="mo_ldap_modal" style="margin-left: 26%">
        <div class="moldap-modal-contatiner-contact-us" style="color:black"></div>
        <div class="mo_ldap_modal-content" id="addonVideo_PopUp" style="width: 650px; padding:10px;"><br>
            <span id="PopUp_Title" style="font-size: 22px; font-weight: bold; display: flex; justify-content: center;"></span><br>
            <div style="display: flex; justify-content: center;"><iframe width="560" id="iframe_PopUp" height="315" src="" title="LDAP add-ons" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
            </div><input type="button" style="font-size: medium; margin-left: 275px;" name="close_video_modal_PopUp" id="close_video_modal_PopUp" class="button button-primary button-small" value="Close Video" />
        </div>
    </div>

    <script type="text/javascript">

        function showAddonTrialPopup_video(elem,addonTitle,addonSrc){
            setTimeout(function(){
                jQuery("#iframe_PopUp").attr("src", addonSrc);
                jQuery("span#PopUp_Title").text(addonTitle + " Add-on");
            },200);
            jQuery("#AddOnVideo_PopUp_modal").show();
        }
        jQuery("#close_video_modal_PopUp").click(function(){
            jQuery("#AddOnVideo_PopUp_modal").hide();
            jQuery("#iframe_PopUp").attr("src", "");
        });

        function mo_ldap_show_description() {
            var element = document.getElementById("mo_ldap_demo_plan").selectedIndex;
            var allOptions = document.getElementById("mo_ldap_demo_plan").options;
            if (allOptions[element].index == 0){
                document.getElementById("add-on-list").style.display = "none";
            }else if(allOptions[element].index == 2 || allOptions[element].index == 3 || allOptions[element].index == 5 || allOptions[element].index == 6){
                document.getElementById("add-on-list").style.display = "";
                document.getElementById("premium-video").style.display = "";
                document.getElementById("ntlm-sso-video").style.display = "";
            }
            else {
                document.getElementById("add-on-list").style.display = "";
                document.getElementById("premium-video").style.display = "";
                document.getElementById("ntlm-sso-video").style.display = "none";
            }
        }
    </script>
    <?php
}

function mo_ldap_show_new_registration_page_ldap() {
    update_option ( 'mo_ldap_local_new_registration', 'true' );
    $curl_warning_msg = 'Warning: PHP cURL extension is not installed or disabled. Please install/enable this extension to register with miniOrange.';
    update_option('mo_ldap_curl_warning_message', $curl_warning_msg);
    mo_ldap_check_curl_extension();
    ?>
    <form name="mo_ldap_registration_page" id="mo_ldap_registration_page" method="post" action="">
        <?php wp_nonce_field("mo_ldap_local_register_customer");?>
        <input type="hidden" name="option" value="mo_ldap_local_register_customer"/>
        <div class="mo_ldap_table_layout" style="padding:0 20% 5% 20%;">


            <h2 class="mo-ldap-h2">Register with miniOrange</h2>

            <div class="mo_ldap_panel">
                <p style="font-size:16px;"><strong>Why should I register? </strong></p>
                <div id="help_register_desc" style="background: aliceblue; padding: 10px 10px 10px 10px; border-radius: 10px;">
                    You should register so that in case you need help, we can help you with step by step
                    instructions. We support all known directory systems like Active Directory, OpenLDAP, JumpCloud etc.
                    <strong>You will also need a miniOrange account to upgrade to the premium version of the plugins.</strong> We do not store any information except the email that you will use to register with us.
                </div>
                </p>
                <table class="mo_ldap_settings_table" aria-hidden="true">
                    <tr>
                        <td style="font-size:16px;"><strong><span style="color:#FF0000;">*</span>Email:</strong></td>
                        <td>
                            <?php
                            $current_user = wp_get_current_user();
                            if(get_option('mo_ldap_local_admin_email')) {
                                $admin_email = get_option('mo_ldap_local_admin_email');
                            }
                            else {
                                $admin_email = $current_user->user_email;
                            }?>
                            <input class="mo_ldap_table_textbox" type="email" name="email"
                                   required placeholder="person@example.com"
                                   value="<?php echo esc_attr($admin_email);?>" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;"><strong><span style="color:#FF0000;">*</span>Password:</strong></td>
                        <td><input class="mo_ldap_table_textbox" required type="password"
                                   name="password" placeholder="Choose your password (Min. length 6)"
                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."
                                <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>
                            /></td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;"><strong><span style="color:#FF0000">*</span>Confirm Password:</strong></td>
                        <td><input class="mo_ldap_table_textbox" required type="password"
                                   name="confirmPassword" placeholder="Confirm your password"
                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."
                                <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>
                            /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><br><input type="submit" name="submit" value="Register"
                                       class="button button-primary button-large" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" name="mo_ldap_goto_login" id="mo_ldap_goto_login"
                                   value="Already have an account?" class="button button-primary button-large" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/>&nbsp;&nbsp;

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <form name="f1" method="post" action="" id="mo_ldap_goto_login_form">
        <?php wp_nonce_field("mo_ldap_goto_login");?>
        <input type="hidden" name="option" value="mo_ldap_goto_login"/>
    </form>
    <script>
        jQuery('#mo_ldap_goto_login').click(function () {
            jQuery('#mo_ldap_goto_login_form').submit();
        });
    </script>
    <?php
}


function mo_ldap_show_verify_password_page_ldap() {
    $curl_warning_msg = 'Warning: PHP cURL extension is not installed or disabled. Please install/enable this extension to login with miniOrange.';
    update_option('mo_ldap_curl_warning_message', $curl_warning_msg);
    mo_ldap_check_curl_extension();
   ?>
    <form name="mo_ldap_verify_password" id="mo_ldap_verify_password" method="post" action="">
        <?php wp_nonce_field("mo_ldap_local_verify_customer");?>
        <input type="hidden" name="option" value="mo_ldap_local_verify_customer"/>
        <div class="mo_ldap_table_layout" style="padding:0 20% 5% 20%;">
            <div id="toggle1" class="panel_toggle">
                <h3 class="mo-ldap-h2">Login with miniOrange</h3>
            </div>
            <div class="mo_ldap_panel">
                <p style="font-size:16px;">It seems you already have an account with miniOrange. Please enter your miniOrange email
                        and password. <a target="_blank"
                                              href="https://login.xecurify.com/moas/idp/resetpassword" rel="noopener">Click
                            here if you forgot your password?</a></p>
                <br/>
                <table class="mo_ldap_settings_table" aria-hidden="true">
                    <tr>
                        <td style="font-size:16px;"><strong><span style="color:#FF0000">*</span>Email:</strong></td>
                        <td><input class="mo_ldap_table_textbox" type="email" name="email"
                                   required placeholder="person@example.com"
                                   value="<?php echo esc_attr(get_option( 'mo_ldap_local_admin_email' )); ?>" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/></td>
                    
                    </tr>
                    <tr>
                        <td style="font-size:16px;"><strong><span style="color:#FF0000">*</span>Password:</strong></td>
                        <td><input class="mo_ldap_table_textbox" required type="password"
                                   name="password" placeholder="Enter your password"
                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."
                                <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>
                            /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" name="submit" value="Login"
                                   class="button button-primary button-large" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" name="mo_ldap_goback" id="mo_ldap_goback" value="Back"
                                   class="button button-primary button-large" <?php if(!MoLdapLocalUtil::is_curl_installed()){ echo "disabled";}?>/>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <form name="f" method="post" action="" id="mo_ldap_goback_form">
        <?php wp_nonce_field("mo_ldap_local_cancel");?>
        <input type="hidden" name="option" value="mo_ldap_local_cancel"/>
    </form>
    <script>
        jQuery('#mo_ldap_goback').click(function () {
            jQuery('#mo_ldap_goback_form').submit();
        });
    </script>
    <?php
}


function mo_ldap_local_account_page() {
	?>

			<div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; width:98%;height:344px">
				<div>
					<h4>Thank You for registering with miniOrange.</h4>
					<h3>Your Profile</h3>
					<table border="1" aria-hidden="true" style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:45%">
						<tr>
							<td style="width:45%; padding: 10px;">Username/Email</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_attr(get_option('mo_ldap_local_admin_email'))?></td>
						</tr>
						<tr>
							<td style="width:45%; padding: 10px;">Customer ID</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_attr(get_option('mo_ldap_local_admin_customer_key'))?></td>
						</tr>
						<tr>
							<td style="width:45%; padding: 10px;">API Key</td>
								<td style="width:55%; padding: 10px;"><?php echo esc_attr(get_option('mo_ldap_local_admin_api_key'))?></td>
						</tr>
						<tr>
							<td style="width:45%; padding: 10px;">Token Key</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_attr(get_option('mo_ldap_local_customer_token'))?></td>
						</tr>
					</table>
					<br/>
					<p><a href="#mo_ldap_local_forgot_password_link">Click here</a> if you forgot your password to your miniOrange account.</p>
				</div>
			</div>

			<form id="forgot_password_form" method="post" action="">
                <?php wp_nonce_field("reset_password");?>
				<input type="hidden" name="option" value="reset_password" />
			</form>

			<script>
				jQuery('a[href="#mo_ldap_local_forgot_password_link"]').click(function(){
					jQuery('#forgot_password_form').submit();
				});
			</script>
			<?php
			if( isset($_POST['option']) && (sanitize_text_field($_POST['option']) == "mo_ldap_local_verify_customer" || sanitize_text_field($_POST['option']) == "mo_ldap_local_register_customer") ){ ?>
				<script>
					window.location.href = "<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>";
				</script>
			<?php }
}

function mo_ldap_local_link() {

	?>
	<a href="http://miniorange.com/wordpress-ldap-login" style="display:none;">Login to WordPress using LDAP</a>
	<a href="http://miniorange.com/cloud-identity-broker-service" style="display:none;">Cloud Identity broker service</a>
	<a href="http://miniorange.com/strong_auth" style="display:none;"></a>
	<a href="http://miniorange.com/single-sign-on-sso" style="display:none;"></a>
	<a href="http://miniorange.com/fraud" style="display:none;"></a>
	<?php
}

function mo_ldap_local_configuration_page(){
    $directory_server_value = !empty(get_option('mo_ldap_directory_server_value'))?get_option('mo_ldap_directory_server_value'):'';
    $server_url = ( get_option('mo_ldap_local_server_url') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_server_url')) : '');
    $ldap_server_protocol = ( get_option('mo_ldap_local_ldap_protocol') ? get_option('mo_ldap_local_ldap_protocol') : 'ldap');
    $ldap_server_address =  get_option('mo_ldap_local_ldap_server_address') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_ldap_server_address')) : '';
    $ldap_server_port_number = ( get_option('mo_ldap_local_ldap_port_number') ? get_option('mo_ldap_local_ldap_port_number') : '389');
    $ldaps_server_port_number = ( get_option('mo_ldap_local_ldaps_port_number') ? get_option('mo_ldap_local_ldaps_port_number') : '636');

    $dn = (get_option('mo_ldap_local_server_dn') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_server_dn')) : '');
    $admin_password = (get_option('mo_ldap_local_server_password') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_server_password')) : '');
    $search_base = (get_option('mo_ldap_local_search_base') ? MoLdapLocalUtil::decrypt(get_option('mo_ldap_local_search_base')) : '');

	$mo_ldap_local_server_url_status= get_option( 'mo_ldap_local_server_url_status') ? get_option( 'mo_ldap_local_server_url_status') : "";
	if(!MoLdapLocalUtil::check_empty_or_null($server_url))
	{
		if($mo_ldap_local_server_url_status == 'VALID') {
            $mo_ldap_local_server_url_status = "mo_ldap_input_success";
        }
		elseif($mo_ldap_local_server_url_status == 'INVALID') {
            $mo_ldap_local_server_url_status = "mo_ldap_input_error";
        }
	}

	$mo_ldap_local_service_account_status = get_option( 'mo_ldap_local_service_account_status') ? get_option( 'mo_ldap_local_service_account_status') : "";
		if($mo_ldap_local_service_account_status == 'VALID'){
		    $mo_ldap_local_service_account_status="mo_ldap_input_success";
        }
		elseif($mo_ldap_local_service_account_status == 'INVALID') {
            $mo_ldap_local_service_account_status = "mo_ldap_input_error";
        }

	$mo_ldap_local_user_mapping_status = get_option( 'mo_ldap_local_user_mapping_status') ? get_option( 'mo_ldap_local_user_mapping_status') : "";
		if($mo_ldap_local_user_mapping_status == 'VALID') {
            $mo_ldap_local_user_mapping_status = "mo_ldap_input_success";
        }
		elseif($mo_ldap_local_user_mapping_status == 'INVALID') {
            $mo_ldap_local_user_mapping_status = "mo_ldap_input_error";
        }

	$mo_ldap_local_username_status = get_option( 'mo_ldap_local_username_status') ? get_option( 'mo_ldap_local_username_status') : "";
		if($mo_ldap_local_username_status == 'VALID') {
            $mo_ldap_local_username_status = "mo_ldap_input_success";
        }
		elseif($mo_ldap_local_username_status == 'INVALID') {
            $mo_ldap_local_username_status = "mo_ldap_input_error";
        }
		delete_option('mo_ldap_local_username_status');

    $mo_ldap_local_pass_status = get_option( 'mo_ldap_local_password_status') ? get_option( 'mo_ldap_local_password_status') : "";
        if($mo_ldap_local_pass_status == 'VALID') {
            $mo_ldap_local_pass_status = "mo_ldap_input_success";
        }
        elseif($mo_ldap_local_pass_status == 'INVALID') {
            $mo_ldap_local_pass_status = "mo_ldap_input_error";
        }
        delete_option('mo_ldap_local_password_status');

	$mo_ldap_local_ldap_username_attribute = get_option("mo_ldap_local_username_attribute");
	?>

		<div class="mo_ldap_small_layout" style="margin-top:0px;">
            <?php
            $ldap_skip_tour = get_option('mo_tour_skipped');
            if(empty($ldap_skip_tour)) { ?>
                <div class="mo_ldap_plugin_tour_modal" id="tour_modal">
                    <form method="post" class="mo_ldap_plugin_tour_modal_content">
                        <div class="mo_ldap_plugin_tour_modal_container">
                            <h1>Let's get started!</h1>
                            <p style="font-size: 15px;">Thank you for installing miniOrange LDAP plugin.</p>
                            <div class="clearfix">
                                <form method="POST">
                                    <?php wp_nonce_field("mo_ldap_plugin_tour_start");?>
                                    <input type="hidden" name="option" value="mo_ldap_plugin_tour_start">
                            <input type="submit"  name="plugintour" type="button"  value="Plugin Tour" style="position: relative"
                                   class="tourbutton plugintour"></form>
                                <form method="POST">
                                    <?php wp_nonce_field("mo_ldap_skip_ldap_tour");?>
                                    <input type="hidden" name="option" value="mo_ldap_skip_ldap_tour">
                                    <input type="submit"  name="skiptour" type="button"  value="Skip Tour" style="position: relative"
                                           class="tourbutton skiptour"></form>
                            </div>
                        </div>
                    </form>
                </div>

                <?php } ?>
			<form id="mo_ldap_connection_info_form" name="f" method="post" action="">
                <?php wp_nonce_field("mo_ldap_local_save_config");?>
				<input id="mo_ldap_local_connection_configuration_form_action" type="hidden" name="option" value="mo_ldap_local_save_config" />
				<input id="mo_ldap_local_ldap_server_port_no" type="hidden" name="mo_ldap_local_ldap_server_port_no" value="<?php echo esc_attr($ldap_server_port_number);?>" />
                <input id="mo_ldap_local_ldaps_server_port_no" type="hidden" name="mo_ldap_local_ldaps_server_port_no" value="<?php echo esc_attr($ldaps_server_port_number);?>" />
                       <span id="configure-service-restart-tour" style="position: relative; float:right; padding-bottom: 14px;padding-top:14px;background: white;border-radius: 10px;">
            <button id="restart_tour" type="button" value="restart_tour" class="button button-primary button-large"  onclick="jQuery('#show_ldap_pointers').submit(); "><em class="fas fa-sync"></em>  Take Tour</button>
            </span>
				
				<h3 class="mo_ldap_left">LDAP Connection Information</h3>
				<div class="mo_ldap_panel">
<strong style="font-size:13px;">Check our Premium features and find out how to get the configuration done through the videos and guides below. </strong><br><br>
                    <table style="margin-left: auto;  margin-right: auto;" aria-hidden="true"><tr>
                    <div style="display: inline-flex;"><td style="padding:10px;">
                        <div style="margin-right: 3%;box-shadow: 9px 4px 6px #888888;">
                            <a class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="https://www.youtube.com/watch?v=VE7KJrjfBaI" title="LDAP/AD Plugin Setup" id="videoLink" target="_blank" rel="noopener"><span class="link-text">LDAP/AD Plugin Setup</span></a>
                        </div>
                        </td><td style="padding:10px;">
                        <div style="margin-right: 3%;box-shadow: 9px 4px 6px #888888;">
                            <a class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" href="https://www.youtube.com/watch?v=r0pnB2d0QP8" title="Premium Plugin Features" id="videoLink" target="_blank" rel="noopener"><span class="link-text">Premium Plugin Features</span></a>
                        </div>
                        </td><td style="padding:10px;">
                            <div style="margin-right: 3%;box-shadow: 9px 4px 6px #888888;">
                            <a class="dashicons mo-form-links dashicons-book-alt mo_book_icon" href="https://plugins.miniorange.com/step-by-step-guide-for-wordpress-ldap-login-plugin" title="Setup LDAP/AD plugin" id="guideLink" rel="noopener" target="_blank"><span class="link-text">Setup LDAP/AD plugin</span></a>
                            </div></td><td style="padding:10px;">
                        <div style="margin-right: 3%; box-shadow: 9px 4px 6px #888888;">
                            <a class="dashicons mo-form-links dashicons-book-alt mo_book_icon" href="https://www.miniorange.com/guide-to-setup-ldaps-on-windows-server" title="Setup LDAPS connection" id="guideLink" target="_blank" rel="noopener"><span class="link-text">Setup LDAPS connection</span></a>
                        </div></td>
                    </div></tr></table><br><br>
                <p><strong style="font-size:14px;">NOTE: </strong> You need to find out the values for the below given fields from your LDAP Administrator.</strong></p>
					<table class="mo_ldap_settings_table" aria-hidden="true">
                        <tr>
                                                        <td><span style="color: red">*</span><strong>Select Your Directory Server:</strong></td><td><span id="mo_ldap_directory_servers" style="position: relative;">
                                                            <select name="mo_ldap_directory_server_value" id="mo_ldap_directory_server_value" onchange="mo_ldap_show_custom_directory()" required>
                                                                <option value="">Select</option>
                                                                <option value="msad" <?php if($directory_server_value == 'msad') {echo "selected";} ?>>Microsoft Active Directory</option>
                                                                <option value="openldap" <?php if($directory_server_value == 'openldap') {echo "selected";} ?>>OpenLDAP</option>
                                                                <option value="freeipa" <?php if($directory_server_value == 'freeipa') {echo "selected";} ?>>FreeIPA</option>
                                                                <option value="jumpcloud" <?php if($directory_server_value == 'jumpcloud') {echo "selected";} ?>>JumpCloud</option>
                                                                <option value="other" <?php if($directory_server_value == 'other') {echo "selected";} ?>>Other</option>
                                                            </select></span></td>
                                                    </tr>
                        <?php
                        if($directory_server_value == 'other'){
                            ?>
                            <tr><td></td><td><input class="mo_ldap_table_textbox" style="width: 65%;" type="text" id="mo_ldap_directory_server_custom_value" name="mo_ldap_directory_server_custom_value"  placeholder="Enter your directory name"  value="<?php echo esc_attr(get_option('mo_ldap_directory_server_custom_value'))?>"></td></tr>

                            <?php
                        }else{ ?>
                            <tr><td></td><td><input class="mo_ldap_table_textbox" style="width: 65%;display: none;" type="text" id="mo_ldap_directory_server_custom_value" name="mo_ldap_directory_server_custom_value"  placeholder="Enter your directory name"  value="<?php echo esc_attr(get_option('mo_ldap_directory_server_custom_value'))?>"></td></tr>
                            <?php
                        }
                        ?>

                        <tr>
                        <tr><td>&nbsp;</td></tr>
                        <script type="text/javascript">

                            function mo_ldap_show_custom_directory() {
                                var element = document.getElementById("mo_ldap_directory_server_value").selectedIndex;
                                var allOptions = document.getElementById("mo_ldap_directory_server_value").options;
                                if (allOptions[element].index == 5){
                                    document.getElementById("mo_ldap_directory_server_custom_value").style.display = "";
                                } else {
                                    document.getElementById("mo_ldap_directory_server_custom_value").style.display = "none";
                                }
                                selected_value = allOptions[element].value
                                document.getElementById("ldap_username_attribute").innerHTML = "";
                                var html_content = "";
                                if(selected_value == 'openldap' || selected_value == 'freeipa' ){
                                    html_content += "<option value='uid' selected>uid</option>";
                                    html_content += "<option value='samaccountname' >sAMAccountName</option>";
                                    html_content += "<option value='userprincipalname' >userPrincipalName</option>";
                                    html_content += "<option value='cn' >cn</option>";
                                    html_content += "<option value='custom_ldap_attribute' >Provide custom LDAP attribute name</option>";

                                }
                                else{
                                    html_content += "<option value='samaccountname' selected>sAMAccountName</option>";
                                    html_content += "<option value='userprincipalname' >userPrincipalName</option>";
                                    html_content += "<option value='cn' >cn</option>";
                                    html_content += "<option value='custom_ldap_attribute' >Provide custom LDAP attribute name</option>";
                                }
                                document.getElementById("ldap_username_attribute").innerHTML = html_content;
                            }
                        </script>

						<tr>
							<td style="width: 24%"><strong><span style="color:#FF0000">*</span>LDAP Server:</strong></td>
							<td style="float:left"><div id="ldap_server_url_pointer" style="position: relative;border-radius: 10px;"><table aria-hidden="true"><tr>
                                   <td> <select style="width: 110%;" name="mo_ldap_protocol" id="mo_ldap_protocol" >
                                        <?php if ($ldap_server_protocol == 'ldap') {?>
                                        <option value="ldap" selected>ldap</option>
                                            <option value="ldaps">ldaps</option>
                                        <?php } elseif ($ldap_server_protocol == 'ldaps') {?>
                                            <option value="ldap">ldap</option>
                                        <option value="ldaps" selected>ldaps</option>
                                        <?php }?>
                                    </select></td><td></td></tr></table></div></td>
                            <td style="float: left;width:78%;"><div id="mo_ldap_directory_server_url" style="position: relative;"><table style="width: 95%" aria-hidden="true"><tr><td ><input class="mo_ldap_table_textbox <?php echo esc_attr($mo_ldap_local_server_url_status); ?>" type="text" id="ldap_server" name="ldap_server" style="width: 100%;margin-left: 7%" required placeholder="LDAP Server hostname or IP address" value="<?php echo esc_attr($ldap_server_address)?>" /></td><td></td></td></tr></table></div></td>
                            <td style="width: 10%;"><div id="mo_ldap_server_port_number_div" style="position: relative;border-radius: 10px">
                                    <?php if ($ldap_server_protocol == 'ldap') {?>
                                    <input type="text" id="mo_ldap_server_port_no" style="width: 100%;" name="mo_ldap_server_port_no" required placeholder="port number" value="<?php echo esc_attr($ldap_server_port_number);?>" />
                                    <?php } elseif ($ldap_server_protocol == 'ldaps') {?>
                                    <input type="text" id="mo_ldap_server_port_no" style="width: 100%;" name="mo_ldap_server_port_no" required placeholder="port number" value="<?php echo esc_attr($ldaps_server_port_number);?>" />
                                    <?php }?>
                                </div></td>
						</tr>
                        <tr><td></td></tr>
						<tr>
							<td>&nbsp;</td>
							<td><em>Select ldap or ldaps from the above dropdwon list. Specify the host name for the LDAP server in the above text field. Edit the port number if you have custom port number.</em>
                            </td>
						</tr>
                    </table>
                          
                    <table style="width: 100%" aria-hidden="true">
                        <tr><td style="width: 24%"></td></tr>
						<tr>
							<td style="width: 24%"><strong><span style="color:#FF0000">*</span>Username:</strong></td>
							<td><div id="ldap_server_username" style="position: relative" ><input class="mo_ldap_table_textbox <?php echo esc_attr($mo_ldap_local_service_account_status); ?>" type="text" id="dn" name="dn" required placeholder="Enter username" value="<?php echo esc_attr($dn)?>" /></div></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><em>You can specify the Username of the LDAP server in the either way as follows<br/><strong> Username@domainname or Distinguished Name(DN) format</strong></em></td>
						</tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
						<tr>
                            <td style="width: 24%"><strong><span style="color:#FF0000">*</span>Password:</strong></td>
							<td><div id="ldap_server_password" style="position: relative;"><input class="mo_ldap_table_textbox <?php echo esc_attr($mo_ldap_local_service_account_status); ?>" required type="password" name="admin_password" placeholder="Enter password" value="<?php echo esc_attr($admin_password)?>"/></div></td>
						</tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
						<tr>
							<td>&nbsp;</td>
                            <td><strong>The above username and password will be used to establish the connection to your LDAP server.</strong></td>
						</tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" class="button button-primary button-large" value="Test Connection & Save"/>&nbsp;&nbsp; <input
								type="button" id="conn_help" class="help button button-large mo_ldap_trouble_button" value="Troubleshooting" /></td>
						</tr>
						<tr>
							<td colspan="2" id="conn_troubleshoot" hidden>
								<p>
									<strong>Are you having trouble connecting to your LDAP server from this plugin?</strong>
									<ol>
										<li>Please make sure that all the values entered are correct.</li>
										<li>If you are having firewall, open the firewall to allow incoming requests to your LDAP from your WordPress <strong>Server IP</strong> and <strong>port 389.</strong></li>
										<li>If you are still having problems, submit a query using the support panel on the right hand side.</li>
									</ol>
								</p>
							</td>
						</tr>
					</table>
				</div>
		<script>
            jQuery("#mo_ldap_protocol").change(function() {

                var current_selected_protocol_name = jQuery("#mo_ldap_protocol").val();
                var port_number_field = jQuery("#mo_ldap_server_port_no").val();
                var ldap_port_number_value = jQuery("#mo_ldap_local_ldap_server_port_no").val();
                var ldaps_port_number_value = jQuery("#mo_ldap_local_ldaps_server_port_no").val();
                if (current_selected_protocol_name == "ldaps") {
                    jQuery("#mo_ldap_server_port_no").val(ldaps_port_number_value);
                } else {
                    jQuery("#mo_ldap_server_port_no").val(ldap_port_number_value);
                }
            });

		</script>
			</form>
		</div>

		<div class="mo_ldap_small_layout">
		<h3>LDAP User Mapping Configuration</h3>
		<form id="mo_ldap_user_mapping_form" name="f" method="post" action="">
            <?php wp_nonce_field("mo_ldap_local_save_user_mapping");?>
				<input id="mo_ldap_local_user_mapping_configuration_form_action" type="hidden" name="option" value="mo_ldap_local_save_user_mapping" />
				<div class="mo_ldap_panel">
					<table class="mo_ldap_settings_table" aria-hidden="true">
						<tr>
							<td style="width: 24%"></td>
							<td></td>
						</tr>

						<tr>
							<td><strong><span style="color:#FF0000">*</span>Search Base:</strong></td><td><input type="button" id="searchbases" class="button button-primary button-large" name="Search Bases" value="Possible Search Bases / Base DNs">
                              </td></tr><tr><td></td>
							<td><div id="search_base_ldap" style="position: relative;line-height: 5;  "><input class="mo_ldap_table_textbox  <?php echo esc_attr($mo_ldap_local_user_mapping_status); ?>" type="text" id="search_base" name="search_base" required placeholder="dc=domain,dc=com" value="<?php echo esc_attr($search_base) ?>" /></div></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><em>This is the LDAP Tree under which we will search for the users for authentication.  If we are not able to find a user in LDAP it means they are not present in this search base or any of its sub trees. They may be present in some other
							.<br> Provide the distinguished name of the Search Base object. <strong>eg. cn=Users,dc=domain,dc=com</strong>.

							<?php if(get_option('mo_ldap_local_cust', '1') == '0'){ ?>
								<br><span style="color:#008000;"><strong>Multiple Search Bases are supported in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin.</strong></span></em><br><br></td>
							<?php }else{ ?>
								If you have users in different locations in the directory(OU's), separate the distinguished names of the search base objects by a semi-colon(;). <strong>eg. cn=Users,dc=domain,dc=com; ou=people,dc=domian,dc=com</strong></em></td>
							<?php } ?>
						</tr>
						<tr>
                            <td><strong><span style="color:#FF0000">*</span>Username Attribute:</strong></td>
                            <td><span id="search_filter_ldap" style="position: relative;border-radius: 10px;">
                                    <select name="ldap_username_attribute" style="width:100%" id="ldap_username_attribute" >
                                        <?php
                                        $directory_server_value = get_option('mo_ldap_directory_server_value');

                                        if($directory_server_value == 'openldap' || $directory_server_value == 'freeipa' ){
                                            $username_ldap_attributes = array("uid"=>"uid","sAMAccountName"=>"samaccountname","mail"=>"mail","userPrincipalName"=>"userprincipalname","cn"=>"cn","Provide custom LDAP attribute name"=>"custom_ldap_attribute");
                                        }
                                        else{
                                            $username_ldap_attributes = array("sAMAccountName"=>"samaccountname","mail"=>"mail","userPrincipalName"=>"userprincipalname","cn"=>"cn","Provide custom LDAP attribute name"=>"custom_ldap_attribute");
                                        }

                                        foreach($username_ldap_attributes as $ldap_attribute_name=>$ldap_attribute_value){
                                            $selected = ($mo_ldap_local_ldap_username_attribute == $ldap_attribute_value) ? 'selected':'';

                                            echo "<option value='".esc_attr($ldap_attribute_value)."' " . esc_attr($selected) . ">".esc_attr($ldap_attribute_name)."</option>";
                                            }
                                        ?>
                                    </select>
                                    </span></td>
						</tr>
                        <tr><td></td><td><?php if ($mo_ldap_local_ldap_username_attribute == "custom_ldap_attribute") {
                                    ?>
                                <input class="mo_ldap_table_textbox" style="width: 65%" type="text" id="custom_ldap_username_attribute" name="custom_ldap_username_attribute"  placeholder="eg. mail"  value="<?php echo esc_attr(get_option('Filter_search') ) ?>" /><?php
                        } else {?><input hidden class="mo_ldap_table_textbox" style="width: 65%" type="text" id="custom_ldap_username_attribute" name="custom_ldap_username_attribute"  placeholder="eg. mail"  value="<?php echo esc_attr(get_option('Filter_search') )?>"<?php }?></td></tr>

                        <tr>
							<td>&nbsp;</td>
							<td><em>This field is important for two reasons. <br>1. While searching for users, this is the attribute that is going to be matched to see if the user exists.  <br>2. If you want your users to login with their username or firstname.lastname or email - you need to specify those options in this field. e.g. <strong> LDAP_ATTRIBUTE</strong>. Replace <strong>&lt;LDAP_ATTRIBUTE&gt;</strong> with the attribute where your username is stored. Some common attributes are
							<ol>
							<table aria-hidden="true">
								<tr><td>logon name</td><td><strong>sAMAccountName</strong><br/><strong>userPrincipalName</strong></td></tr>
                                <tr><td>email</td><td><strong>mail</strong></td></tr>
                                <tr><td style="width:50%">common name</td><td><strong>cn</strong></td></tr>
								<tr><td>custom attribute where you store your WordPress usernames use</td> <td><strong>customAttribute</strong></td></tr>


							</table><br>
                                You can even allow logging in with multiple attributes, separated with <strong>' ; ' </strong>. e.g. you can allow logging in with username or email. e.g.<strong> cn;mail</strong>
                                <?php if(get_option('mo_ldap_local_cust', '1') == '0'){ ?>
                                <br><span style="color:#008000;"><strong>Logging in with multiple attributes are supported in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin.</strong></span></em><br><br></td>
                            <?php }?>
							</ol>
						</tr>
						<tr><td></td><td>Please make clear that the attributes that we are showing are examples and the actual ones could be different. These should be confirmed with the LDAP Admin.</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" class="button button-primary button-large" value="Save User Mapping"/>&nbsp;&nbsp; <input
								type="button" id="conn_help_user_mapping" class="help button button-large mo_ldap_trouble_button" value="Troubleshooting" /></td>
						</tr>
						<tr>
							<td colspan="2" id="conn_user_mapping_troubleshoot" hidden>
									<strong>Are you having trouble connecting to your LDAP server from this plugin?</strong>
									<ol>
										<li>The <strong>search base</strong> URL is typed incorrectly. Please verify if that search base is present.</li>
										<li>User is not present in that search base. The user may be present in the directory but in some other tree and you may have entered a tree where this users is not present.</li>
										<li><strong>Search filter</strong> is incorrect - User is present in the search base but the username is mapped to a different attribute in the search filter. E.g. you may be logging in with username and may have mapped it to the email attribute. So this wont work. Please make sure that the right attribute is mentioned in the search filter (with which you want the mapping to happen)</li>
										<li>Please make sure that the user is present and test with the right user.</li>
										<li>If you are still having problems, submit a query using the support panel on the right hand side.</li>
									</ol>

							</td>
						</tr>
					</table>
				</div>
			</form>

            <script>
                jQuery("#searchbases").click(function (){
                    showsearchbaselist();
                });
                function showsearchbaselist() {
                    var myWindow =   window.open('<?php echo site_url(); ?>' + '/?option=searchbaselist', "Search Base Lists", "width=600, height=600");

                }
            </script>

            <script>

                jQuery("#ldap_username_attribute").change(function() {
                   var current_selected_attribute_name = jQuery("#ldap_username_attribute").val();
                   var custom_username_attribute_field = document.getElementById("custom_ldap_username_attribute");
                    if (current_selected_attribute_name == "custom_ldap_attribute") {
                        custom_username_attribute_field.style.display = "block";
                    } else {
                        custom_username_attribute_field.style.display = "none";
                    }

                });
            </script>
		</div>

		<div class="mo_ldap_small_layout" id="Test_auth_ldap" style="position: relative;border-radius: 10px">
		<form name="f" method="post" action="">
            <?php wp_nonce_field("mo_ldap_local_test_auth");?>
			<input type="hidden" name="option" value="mo_ldap_local_test_auth" />
			<h3>Test Authentication</h3>

				<?php if(get_option('mo_ldap_local_cust', '1') == '0'){ ?>
					Wordpress username is mapped to the <strong>LDAP attribute defined in the Search Filter</strong> attribute in LDAP. Ensure that you have an administrator user in LDAP with the same attribute value. <br><br>
				<?php } ?>
			<div id="test_conn_msg"></div>
			<div class="mo_ldap_panel">
				<table class="mo_ldap_settings_table" aria-hidden="true">
					<tr>
						<td style="width: 24%"><strong><span style="color:#FF0000">*</span>Username:</strong></td>
						<td><input class="mo_ldap_table_textbox  <?php if(isset($_POST['test_username'])){echo esc_attr($mo_ldap_local_username_status);} ?>" type="text" name="test_username" required placeholder="Enter username" value="<?php if(isset($_POST['test_username']))echo esc_attr($_POST['test_username']); ?>" /></td>
					</tr>
					<tr>
						<td><strong><span style="color:#FF0000">*</span>Password:</strong></td>
						<td><input class="mo_ldap_table_textbox <?php if(isset($_POST['test_username'])){echo esc_attr($mo_ldap_local_pass_status);} ?>" type="password" name="test_password" required placeholder="Enter password" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" class="button button-primary button-large" value="Test Authentication"/>&nbsp;&nbsp; <input
								type="button" id="auth_help" class="help button button-large mo_ldap_trouble_button" value="Troubleshooting" /></td>
					</tr>
					<tr>
						<td colspan="2" id="auth_troubleshoot" hidden>
							<p>
								<strong>User is not getting authenticated? Check the following:</strong>
								<ol>
									<li>The username-password you are entering is correct.</li>
									<li>The user is not present in the search bases you have specified against <strong>SearchBase(s)</strong> above.</li>
									<li>Your Search Filter may be incorrect and the username mapping may be to an LDAP attribute other than the ones provided in the Search Filter</li>
								</ol>
							</p>
						</td>
					</tr>
				</table>
			</div>
		</form>
		</div>
	<?php
}

function mo_show_export_page(){
	?><div class="mo_ldap_support_layout">
		<div> <span id="export-config-service-restart-tour" style="position: relative; float:right; padding-bottom: 14px;padding-top:14px;background: white;border-radius: 10px;">
                        <button type="button"  class="button button-primary button-large"  onclick="jQuery('#show_ldap_pointers').submit();"><em class="fas fa-sync"></em>  Take Tour</button>
            </span><br>
            <br><br><div id="enable_save_config_ldap" style="position: relative; background: white; height: 30px;border-radius: 10px;">
            <form method="post" action="">
                <?php wp_nonce_field("enable_config");?>
                <input type="hidden" name="option" value="enable_config" />
                <table aria-hidden="true"><tr><td><input type="checkbox" id = "enable_save_config" name="enable_save_config" value="1" onchange="this.form.submit()" <?php checked(esc_attr(get_option('en_save_config')) == 1);?> />Persist configuration upon uninstall.
                        </td></tr></table>
            </form></div><div id="mo_export" style="background: white;position: relative;border-radius: 10px;">
			<form method="post" action="" name="mo_export_pass">
                <?php wp_nonce_field("mo_ldap_pass");?>
				<input type="hidden" name="option" value="mo_ldap_pass" />
				<table aria-hidden="true">
                    <tr><td><h3>Export Configuration</h3></td></tr>
                    <tr>
                        <td><p>This tab will help you to transfer your plugin configuration when you change your Wordpress instance.</p></td></tr>
					<tr><td><input type="checkbox" id="enable_ldap_login" name="enable_ldap_login" value="1" onchange="this.form.submit()" <?php checked(esc_attr(get_option('mo_ldap_export')) == 1);?> />Export Service Account password. (This will lead to your service account password to be exported in encrypted fashion in a file)</td>
                    </tr><tr><td>(Enable this only when server password is needed)</td>
                        <td></td>
                    </tr>
                </table>
			</form></div>
             <form method="post" action="" name="mo_export">
                 <?php wp_nonce_field("mo_ldap_export");?>
                <input type="hidden" name="option" value="mo_ldap_export"/>
                <br>
                <input type="button" class="button button-primary button-large" onclick="document.forms['mo_export'].submit();" value= "Export configuration" />
                <br><br>
            </form>
             

		</div>
	</div>
    <div class="mo_ldap_support_layout" style="margin-top:10px;">
            <div id="mo_import" style="background: white;position: relative;border-radius: 10px;">
        <form method="post" action="" name="mo_import" enctype="multipart/form-data">
            <input type="hidden" name="option" value="mo_ldap_import" />
            <table aria-hidden="true">
                <tr><td><h3>Import Configuration<sup style="font-size: 12px;color:#008000;">  [Available in <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium versions</a> of the plugin.]</sup></td></tr><br>
                <tr>
                    <td><p>This tab will help you to transfer your plugin configurations from one Wordpress instance to another Wordpress instance.</p></td>
                </tr>
                <tr>
                    <td><input type="file" name="mo_ldap_import_file" id="mo_ldap_import_file" required disabled/></td>
                </tr>
                <tr><td><br><td></tr>
                <tr>
                    <td><input type="submit" class="button button-primary button-large"  value="Import Configuration" name="import_file" disabled/></td>
                </tr>
                <tr><td><br><td></tr>
            </table>
        </form></div>
        </div>
    </div>
	<?php
}

function mo_ldap_local_troubleshooting(){
	?>
	<div class="mo_ldap_table_layout" style="padding:0 10% 3% 10%;">
        <h2 class="mo-ldap-h2">Frequently Asked Questions</h2>
		<table class="mo_ldap_help" aria-hidden="true">
					<tbody><tr>
						<td class="mo_ldap_help_cell">
							<div id="help_curl_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">How to enable PHP cURL extension? (Pre-requisite)</div>
							</div>
							<div hidden="" id="help_curl_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li style="font-size: large; font-weight: bold">Step 1 </li>
                                    <li style="font-size: medium; font-weight: bold">Loaded configuration file : <?php echo php_ini_loaded_file() ?></li>
                                    <li style="list-style-type:square;margin-left:20px">Open php.ini file from above file path</strong></li><br/>
                                    <li style="font-size: large; font-weight: bold">Step 2</li>
                                    <li style="font-weight: bold;color: #C31111">For Windows users</li>
                                    <li style="list-style-type:square;margin-left:20px">Search for <strong>"extension=php_curl.dll"</strong> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li>
                                    <li style="font-weight: bold; color:#C31111">For Linux users</li>
                                        <ul style="list-style-type:square;margin-left: 20px">
                                            <li style="margin-top: 5px">Install php curl extension (If not installed yet)
                                                <ul style="list-style-type:disc;margin-left: 15px;margin-top: 5px">
                                                    <li>For Debian, the installation command would be <strong>apt-get install php-curl</strong></li>
                                                    <li>For RHEL based systems, the command would be <strong>yum install php-curl</strong></li></ul></li></li>
                                            <li>Search for <strong>"extension=php_curl.so"</strong> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li></ul><br/>
                                    <li style="margin-top: 5px;font-size: large; font-weight: bold">Step 3</li>
                                    <li style="list-style-type:square;margin-left:20px">Restart your server. After that refresh the "LDAP/AD" plugin configuration page.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_ldap_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">How to enable PHP LDAP extension? (Pre-requisite)</div>
							</div>
							<div hidden="" style="padding: 2px 2px 2px 12px" id="help_ldap_desc" class="mo_ldap_help_desc">
                                <ul>
                                    <li style="font-size: large; font-weight: bold">Step 1 </li>
                                    <li style="font-size: medium; font-weight: bold">Loaded configuration file : <?php echo php_ini_loaded_file() ?></li>
                                    <li style="list-style-type:square;margin-left:20px">Open php.ini file from above file path</li><br/>
                                    <li style="font-size: large; font-weight: bold">Step 2</li>
                                    <li style="font-weight: bold;color: #C31111">For Windows users using Apache Server</li>
                                    <li style="list-style-type:square;margin-left:20px">Search for <strong>"extension=php_ldap.dll"</strong> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li>
                                    <li style="font-weight: bold;color: #C31111">For Windows users using IIS server</li>
                                    <li style="list-style-type:square;margin-left:20px">Search for <strong>"ExtensionList"</strong> in the php.ini file. Uncomment the <strong>"extension=php_ldap.dll"</strong> line, if not present then add this line in the file and save the file.</li>
                                    <li style="font-weight: bold;color: #C31111">For Linux users</li>
                                        <ul style="list-style-type:square;margin-left: 20px">
                                            <li style="margin-top: 5px">Install php ldap extension (If not installed yet)
                                                <ul style="list-style-type:disc;margin-left: 15px;margin-top: 5px">
                                                    <li>For Debian, the installation command would be <strong>apt-get install php-ldap</strong></li>
                                                    <li>For RHEL based systems, the command would be <strong>yum install php-ldap</strong></li></ul></li>
                                            <li>Search for <strong>"extension=php_ldap.so"</strong> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li></ul><br/>
                                    <li style="margin-top: 5px;font-size: large; font-weight: bold">Step 3</li>
                                    <li style="list-style-type:square;margin-left:20px">Restart your server. After that refresh the "LDAP/AD" plugin configuration page.</li>
                                </ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

                    <tr>
                        <td class="mo_ldap_help_cell">
                            <div id="connect_using_ldaps" class="mo_ldap_title_panel">
                                <div class="mo_ldap_help_title">How to setup/connect LDAP Server using LDAPS (LDAP over SSL)?</div>
                            </div>
                            <div hidden="" id="connect_ldaps_server" class="mo_ldap_help_desc" style="display: none;">
                                <ul>
                                    <li><a href="https://www.miniorange.com/guide-to-setup-ldaps-on-windows-server" rel="noopener" target="_blank">Click here</a> to go through the configuration steps to connect with LDAP server over LDAPS (LDAP over SSL:636).</li>
                                </ul>
                                For any further queries, please contact us.
                            </div>
                        </td>
                    </tr>

                    <tr>
						<td class="mo_ldap_help_cell">
						<div id="help_ping_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">Why is Contact LDAP Server not working?</div>
							</div>
							<div hidden="" id="help_ping_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;Check your LDAP Server URL to see if it is correct.<br>
									 eg. ldap://myldapserver.domain:389 , ldap://89.38.192.1:389. When using SSL, the host may have to take the form ldaps://host:636.</li>
									<li>2.&nbsp;&nbsp;&nbsp;&nbsp;Your LDAP Server may be behind a firewall. Check if the firewall is open to allow requests from your Wordpress installation.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

                    <tr>
                        <td class="mo_ldap_help_cell">
                            <div id="help_selinuxboolen_title" class="mo_ldap_title_panel">
                                <div class="mo_ldap_help_title">I can connect to LDAP server through the command line (using ping/telnet) but get an error when I test connection from the plugin.</div>
                            </div>
                            <div hidden="" id="help_selinuxboolen_desc" class="mo_ldap_help_desc" style="display: none;">
                                <ul>
                                    <li>This issue usually occurs for users whose wordpress is hosted on CentOS server. this error because SELinux Boolean httpd_can_network_connect is not set.<br></li>
                                    <li>Follow these steps to resolve the issue:</li>
                                    <li>1. Run command: setsebool -P httpd_can_network_connect on</li>
                                    <li>2. Restart apache server.</li>
                                    <li>3. Run command: getsebool –a | grep httpd and make sure that httpd_can_network_connect is on</li>
                                    <li>4. Try Ldap connect from the plugin again</li>
                                </ul>
                                For any further queries, please contact us.
                            </div>
                        </td>
                    </tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_invaliddn_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">Why is Test LDAP Configuration not working?</div>
							</div>
							<div hidden="" id="help_invaliddn_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;Check if you have entered valid Service Account DN(distinguished Name) of the LDAP server. <br>e.g. cn=username,cn=group,dc=domain,dc=com<br>
									uid=username,ou=organisational unit,dc=domain,dc=com</li>
									<li>2.&nbsp;&nbsp;&nbsp;&nbsp;Check if you have entered correct Password for the Service Account.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_invalidsf_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">Why is Test Authentication not working?</div>
							</div>
							<div hidden="" id="help_invalidsf_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;The username/password combination you provided may be incorrect.</li>
									<li>2.&nbsp;&nbsp;&nbsp;&nbsp;You may have provided a <strong>Search Base(s)</strong> in which the user does not exist.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_seracccre_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">What are the LDAP Service Account Credentials?</div>
							</div>
							<div hidden="" id="help_seracccre_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;Service account is an non privileged user which is used to bind to the LDAP Server. It is the preferred method of binding to the LDAP Server if you have to perform search operations on the directory.</li>
									<li>2.&nbsp;&nbsp;&nbsp;&nbsp;The distinguished name(DN) of the service account object and the password are provided as credentials.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_sbase_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">What is meant by Search Base in my LDAP environment?</div>
							</div>
							<div hidden="" id="help_sbase_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;Search Base denotes the location in the directory where the search for a particular directory object begins.</li>
									<li>2.&nbsp;&nbsp;&nbsp;&nbsp;It is denoted as the distinguished name of the search base directory object. eg: CN=Users,DC=domain,DC=com.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_sfilter_title" class="mo_ldap_title_panel">
                                <div class="mo_ldap_help_title">What is meant by Search Filter in my LDAP environment? <span style="color:#FF0000">*PREMIUM*</span></></div>
							</div>
							<div hidden="" id="help_sfilter_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;Search Filter is a basic LDAP Query for searching users based on mapping of username to a particular LDAP attribute.</li>
									<li>2.&nbsp;&nbsp;&nbsp;&nbsp;The following are some commonly used Search Filters. You will need to use a search filter which uses the attributes specific to your LDAP environment. Confirm from your LDAP administrator.</li>
										<ul>
											<table aria-hidden="true">
												<tr><td style="width:50%">common name</td><td>(&(objectClass=*)(<strong>cn</strong>=?))</td></tr>
												<tr><td>email</td><td>(&(objectClass=*)(<strong>mail</strong>=?))</td></tr>
												<tr><td>logon name</td><td>(&(objectClass=*)(<strong>sAMAccountName</strong>=?))<br/>(&(objectClass=*)(<strong>userPrincipalName</strong>=?))</td></tr>
												<tr><td>custom attribute where you store your WordPress usernames use</td> <td>(&(objectClass=*)(<strong>customAttribute</strong>=?))</td></tr>
												<tr><td>if you store Wordpress usernames in multiple attributes(eg: some users login using email and others using their username)</td><td>(&(objectClass=*)(<strong>|</strong>(<strong>cn=?</strong>)(<strong>mail=?</strong>)))</td></tr>
											</table>
										</ul>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_ou_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">How do users present in different Organizational Units (OU's) login into Wordpress? <span style="color:#FF0000">*PREMIUM*</span></div>
							</div>
							<div hidden="" id="help_ou_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>1.&nbsp;&nbsp;&nbsp;&nbsp;Support for multiple search bases is present in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_loginusing_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">Some of my users login using their email and the rest using their usernames. How will both of them be able to login?<span style="color:#FF0000"> *PREMIUM*</span></div>
							</div>
							<div hidden="" id="help_loginusing_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
									<li>Support for multiple username attributes is present in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium version</a> of the plugin.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>
					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_rolemap_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">How Role Mapping works?<span style="color:#FF0000"> *PREMIUM*</span></div>
							</div>
							<div hidden="" id="help_rolemap_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
                                    <li>Support for Advanced Role Mapping is present in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

					<tr>
						<td class="mo_ldap_help_cell">
							<div id="help_multiplegroup_title" class="mo_ldap_title_panel">
								<div class="mo_ldap_help_title">How Role Mapping works if user belongs to multiple groups?<span style="color:#FF0000"> *PREMIUM*</span></div>
							</div>
							<div hidden="" id="help_multiplegroup_desc" class="mo_ldap_help_desc" style="display: none;">
								<ul>
                                    <li>Support for Advanced Role Mapping is present in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium version</a> of the plugin.</li>
								</ul>
								For any further queries, please contact us.
							</div>
						</td>
					</tr>

				</tbody></table>
	</div>
	<?php

}

function mo_user_report_page()
{ ?>

    <div class="mo_ldap_small_layout" style="margin-top:0px; height: auto;">

        <h2>User Report</h2>
        <form name="f" id="user_report_form" method="post" action="">
            <?php wp_nonce_field("user_report_logs");?>
            <input type="hidden" name="option" value="user_report_logs" />
            <input type="checkbox" id="mo_ldap_local_user_report_log" name="mo_ldap_local_user_report_log" value="1" <?php checked(esc_attr(get_option('mo_ldap_local_user_report_log') == 1));?> />Log Authentication Requests
        </form><br>
       <?php

        
       
        $log_user_reporting = get_option('mo_ldap_local_user_report_log');
        
        if($log_user_reporting>0){
        
            
          $ldap_plugin_instance = MoLdapPluginPagination::get_instance();
          $ldap_plugin_instance->plugin_settings_page();
  }
      else{
        echo 'No audit logs are available currently. <br><br>';
    }
           ?>
    </div>
     <script>
        jQuery('#mo_ldap_local_user_report_log').change(function() {
            jQuery('#user_report_form').submit();
        });
        jQuery('#mo_ldap_local_keep_user_report_log').change(function() {
            jQuery('#keep_user_report_form_on_uinstall').submit();
        });

     </script>
     <?php
    

}
function mo_ldap_local_signin_settings(){
?>
 <div class="mo_ldap_small_layout" style="margin-top:0px;">
            <form name="f" id="enable_login_form" method="post" action="">
                <?php wp_nonce_field("mo_ldap_local_enable");?>
                <input type="hidden" name="option" value="mo_ldap_local_enable" />

                <h3>Enable login using LDAP</h3>
                <div id="enable_ldap_login_bckgrnd">
                <?php
                    $serverUrl = get_option('mo_ldap_local_server_url');
                    if(isset($serverUrl) && $serverUrl != ''){?>
                        <input type="checkbox" id="enable_ldap_login" name="enable_ldap_login" value="1" <?php checked(esc_attr(get_option('mo_ldap_local_enable_login') )== 1);?> />Enable LDAP login
                <?php } else{?>
                        <input type="checkbox" id="enable_ldap_login" name="enable_ldap_login" value="1" <?php checked(esc_attr(get_option('mo_ldap_local_enable_login')) == 1);?> disabled />Enable LDAP login
                <?php }?></div>
                <p>Enabling LDAP login will protect your login page by your configured LDAP. <strong>Please check this only after you have successfully tested your configuration</strong> as the default WordPress login will stop working.</p>
            </form>
            <script>
                jQuery('#enable_ldap_login').change(function() {
                    jQuery('#enable_login_form').submit();
                });
            </script>
            <form name="f" id="enable_admin_wp_login" method="post" action="">
                <?php wp_nonce_field("mo_ldap_local_enable_admin_wp_login");?>
                <input type="hidden" name="option" value="mo_ldap_local_enable_admin_wp_login" />
                <?php $enable_both_login = get_option('mo_ldap_local_enable_login');
                if($enable_both_login == 1) {?>
                <input type="checkbox" id="mo_ldap_local_enable_admin_wp_login" name="mo_ldap_local_enable_admin_wp_login" value="1" <?php checked(esc_attr(get_option('mo_ldap_local_enable_admin_wp_login')) == 1);?> /> Authenticate Administrators from both LDAP and WordPress<br><br>
                <?php } ?>
                <div id="miniorange-fallback-login" style="position:relative;background:white; line-height: 5;border-radius: 10px;">
                    <input type="checkbox" id="" name="" disabled /> Authenticate WP Users from both LDAP and WordPress <span style="color:#008000;"><strong> <em>( Supported in <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin. )</em></strong></span>
                </div>
            </form>
            <br>
            <form name="f" id="enable_register_user_form" method="post" action="">
                <?php wp_nonce_field("mo_ldap_local_register_user");?>
                <input type="hidden" name="option" value="mo_ldap_local_register_user" />
                <input type="checkbox" id="mo_ldap_local_register_user" name="mo_ldap_local_register_user" value="1" <?php checked(esc_attr(get_option('mo_ldap_local_register_user')) == 1);?> />Enable Auto Registering users if they do not exist in WordPress
            </form>
            <script>
                jQuery('#mo_ldap_local_register_user').change(function() {
                    jQuery('#enable_register_user_form').submit();
                });
                jQuery('#enable_fallback_login_form').change(function() {
                    jQuery('#enable_fallback_login_form').submit();
                });
                jQuery('#enable_admin_wp_login').change(function() {
                    jQuery('#enable_admin_wp_login').submit();
                });
            </script>
            <br/>
        </div>

        <?php
}

function mo_ldap_local_multiple_ldap()
{

    $current_user = wp_get_current_user();
    if (get_option('mo_ldap_local_admin_email')) {
        $admin_email = get_option('mo_ldap_local_admin_email');
    } else {
    $admin_email = $current_user->user_email;
}?>

    <div  hidden id="licensingContactUsModalMultidir" name="licensingContactUsModal" class="mo_ldap_modal" style="margin-left: 26%;z-index:999999;">
    <div class="moldap-modal-contatiner-contact-us" style="color:black"></div>
        <div class="mo_ldap_modal-content" id="contactUsPopUp" style="width: 700px; padding:30px;">
            <span id="contact_us_title_multidir" style="font-size: 22px; margin-left: 50px; font-weight: bold;">Contact Us for Choosing the Correct Premium Plan</span>
            <form name="f" method="post" action="" id="mo_ldap_licensing_contact_us_multidir" style="font-size: large;">
                <input type="hidden" name="option" value="mo_ldap_login_send_feature_request_query"/>
                <div>
                    <p style="font-size: large;">
                        <br>
                        <strong>Email: </strong>
                        <input style=" width: 77%; margin-left: 69px; " type="email" class="mo_ldap_table_textbox" id="query_email_multidir" name="query_email" value="<?php echo esc_attr($admin_email); ?>" placeholder="Enter email address through which we can reach out to you" required />
                        <br><br>
                        <span style="display:inline-block; vertical-align: top;">Description: </span>
                        <textarea style="width:77%; margin-left: 21px;" id="query_multidir" name="query" required rows="5" style="width: 100%"
                                  placeholder="Tell us which features you require"></textarea></p>
                        <br><br>
                    <div class="mo_ldap_modal-footer" style="text-align: center">
                        <input type="button" style="font-size: medium" name="miniorange_ldap_feedback_submit" id="miniorange_ldap_feedback_submit_multidir"
                               class="button button-primary button-small" onclick="validateRequirements()" value="Submit"/>
                        <input type="button" style="font-size: medium" name="miniorange_ldap_licensing_contact_us_close" id="miniorange_ldap_licensing_contact_us_close_multidir" class="button button-primary button-small" value="Close" />
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div style="position: relative;
	     background-color:#FFFFFF;
	     border:1px solid #CCCCCC;
	     padding:20px 24px 10px 20px;">
        <h3 class="mo_ldap_left">Add new LDAP Server &nbsp<sup style="font-size: 12px;color: green;">[To get more details on this plan please <a id="MultipleDirContactUsTab" href="#MultipleDirContactUs">Contact Us</a> ]</sup></h3>
                 <table class="mo_ldap_settings_table" aria-hidden="true">
                      <tr>
                            <td style="width: 24%"><strong><span style="color:#FF0000">*</span>LDAP Server:</strong></td>
                            <td><input class="mo_ldap_table_textbox" disabled type="url" id="ldap_server" name="ldap_server" required placeholder="ldap://<server_address or IP>:<port>"</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><em>eg: ldap://myldapserver.domain:389 , ldap://89.38.192.1:389. </em></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><strong><span style="color:#FF0000">*</span>Username:</strong></td>
                            <td><input class="mo_ldap_table_textbox" disabled type="text" id="multiple_ldap_dn" name="multiple_ldap_dn" required placeholder="CN=service,DC=domain,DC=com"</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><em>e.g. cn=username,cn=group,dc=domain,dc=com</em></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><strong><span style="color:#FF0000">*</span>Password:</strong></td>
                            <td><input class="mo_ldap_table_textbox" required disabled type="password" name="admin_password" placeholder="Enter password of Service Account"</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><strong><span style="color:#FF0000">*</span>Search Base(s):</strong></td>
                            <td><input class="mo_ldap_table_textbox" disabled type="text" id="multiple_ldap_search_base" name="multiple_ldap_search_base" required placeholder="dc=domain,dc=com" </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><em>e.g. cn=Users,dc=domain,dc=com</em></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td></td></tr><tr><td></td></tr>
                        <tr><td><strong><span style="color:#FF0000"></span>Search Conditions:</strong></td>
                            <td>
                                <label class="switch">
                             <input type="checkbox"disabled id="search_filter_check_add" name="ldap_search_filters_add">
                           <div class="slider round"</div>
                          </label>
                          </td>
                        </tr>

                         <tr><td></td><td><strong>Enable Custom Search Filter </strong>(Enable this to add more search-filter conditions.)</td></tr>
                         <tr>
                            <td></td>
                            <td><br>
                                <div id="user_div" style=" margin-top: -20px; ">

                                    <table aria-hidden="true">
                                        <tbody><tr>
                                            <td>
                                <strong><span style="color:#FF0000">*</span>Username Attribute:</strong></td>
                                <td>
                            <input class="mo_ldap_table_textbox" disabled type="text" size="58" name="username_attribute_text" id="username_attribute_id_add" placeholder="Enter username attribute" required="required"></td></tr>
                                <tr>
                            <td colspan="2"><em>e.g. sAMAccountName, userPrincipalName;mail</em></td>
                        </tr>

                            </tbody></table>

                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><br>
                                <div id="ldap_search_filter_div" style="margin-top: -30px;display: none;">
                                    <table aria-hidden="true"><tbody><tr>
                            <td width="140px"><strong><span style="color:#FF0000">*</span>Custom Search Filter:</strong></td>
                            <td><input class="mo_ldap_table_textbox" type="text" id="search_filter_add" size="58" name="search_filter" placeholder="(&amp;(objectClass=*)(cn=?))" value="(&amp;(objectClass=*)(sAMAccountName=?))" pattern=".*\?.*" title="Must contain Question Mark(?) for attributes you want to match e.g. (&amp;(objectClass=*)(uid=?))"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><em>e.g. (&amp;(objectClass=*)(cn=?)), (&amp;(objectClass=*)(sAMAccountName=?))</em></td>
                        </tr>

                    </tbody></table></div></td></tr>

                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" class="button button-primary button-large" disabled value="Test Connection &amp; Save">&nbsp;&nbsp;<input type="button" disabled class="button button-primary button-large" value="Add New configuration" onclick="add_new_config()"></td>
                        </tr>

                         </tbody>
                    </table>
                </div>
            </form>

     <script>


         jQuery('a[id=MultipleDirContactUsTab]').click(
            function(){

                jQuery('#licensingContactUsModalMultidir').show();
                jQuery("#contact_us_title_multidir").text("Contact Us for LDAP Multiple Directories Premium Plan");
                query = "Hi!! I am interested in LDAP Multiple Directories Premium Plan and want to know more about it.";
                jQuery("#mo_ldap_licensing_contact_us_multidir #query_multidir").val(query);
            });

        jQuery('#miniorange_ldap_licensing_contact_us_close_multidir').click(
            function(){
             jQuery("#mo_ldap_licensing_contact_us_multidir #query_multidir").val('');
             jQuery('#licensingContactUsModalMultidir').hide();
           });

       function validateRequirements() {

       if(validateEmails()){
        var requirement = document.getElementById("query_multidir").value;
        if (requirement.length <= 10) {
                    alert("Please enter more details about your requirement.");
        } else {
            document.getElementById("mo_ldap_licensing_contact_us_multidir").submit();
        }
    }
    }

    function validateEmails()
    {
        var email = document.getElementById('query_email_multidir');
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))
        {
            return (true)
        }
        else if(email.value.length == 0){
            alert("Please enter your email address!")
            return (false)
        }
        else
        {
            alert("You have entered an invalid email address!")
            return (false)
        }

    }


</script>


<?php
}
function mo_ldap_local_rolemapping() {
?>
<div class="mo_ldap_small_layout" style="margin-top:0px;">
    <div id="enable_role_mapping_pointer" style="position: relative;background: white;">
    <form name="f" id="enable_role_mapping_form" method="post" action="">
        <?php wp_nonce_field("mo_ldap_local_enable_role_mapping");?>
        <input type="hidden" name="option" value="mo_ldap_local_enable_role_mapping" />
        <h3>Default Role Mapping<sup style="font-size: 12px"></h3>
        <table aria-hidden="true"><tr><td><input type="checkbox" id="enable_ldap_role_mapping" name="enable_ldap_role_mapping"  value="1" <?php checked(esc_attr(get_option('mo_ldap_local_enable_role_mapping')) == 1); ?>/>Enable Role Mapping</td></tr></table>
        <p>Enabling Role Mapping will assign the below selected default WordPress Role to the LDAP users.</p>
    </form>
    </div>
	<form id="role_mapping_form" name="f" method="post" action="">
        <?php wp_nonce_field("mo_ldap_local_save_mapping");?>
				<input id="mo_ldap_local_user_mapping_form" type="hidden" name="option" value="mo_ldap_local_save_mapping" />

					<table class="mo_ldap_mapping_table" id="ldap_default_role_mapping_table" style="width:90%" aria-hidden="true">
							<tr>
								<td colspan=2><em> Following selected Default role will be assigned to all users.</em></td>
							</tr>
							<tr>
                                <td><span style="font-size:13px;font-weight:bold;">Default Role </span>
							</td>
							<td>
								<div id="default_role_value" style="position: relative;border-radius: 10px;">
								<select name="mapping_value_default" style="width:100%" id="default_group_mapping" >
								   <?php
								   	 if(get_option('mo_ldap_local_mapping_value_default')) {
                                         $default_role = get_option('mo_ldap_local_mapping_value_default');
                                     }
								   	 else {
                                         $default_role = get_option('default_role');
                                     }
								   	 wp_dropdown_roles($default_role); ?>
								</select>
								<select style="display:none" id="wp_roles_list">
								   <?php wp_dropdown_roles($default_role); ?>
                                </select></div>
							</td>
						</tr>
                        <tr>
                            <td><input id="save-default-mapping" type="submit" class="button button-primary button-large" value="Save Configuration" /></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
    </form>
</div>
    <div class="mo_ldap_small_layout" style="">
        <form name="mo_ldap_fetch_groups_form" method="post" action="" id="mo_ldap_fetch_groups_form">
		 <input type="hidden" name="mo_ldap_fetch_groups_form_nonce"
                   value="<?php echo wp_create_nonce( 'mo_ldap_fetch_groups_form_nonce' ); ?>"/>
            <h3>Fetch Groups Information<sup style="font-size: 12px;color:#008000;">  [Available in <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium versions</a> of the plugin.]</sup></h3>Enter container for groups
            <table id="groups_table" aria-hidden="true" class="mo_ldap_settings_table">
                <tbody><tr></tr>
                <tr></tr>
                <tr>
                    <td>Groups Container</td>
                    <td><div id="mo_ldap_groups_search_base_ldap" style="position: relative; "><input type="text" id="mo_ldap_groups_search_base" name="mo_ldap_groups_search_base" required placeholder="cn=groups,dc=domain,dc=com" style="width:80%;background: #DCDAD1;"></div>
                    </td></tr>
                <tr>
                    <td><input type="submit" value="Show Groups" class="button button-primary button-large" ></td>
                </tr>
                </tbody></table>
        </form><br/>
    </div>
    <div class="mo_ldap_small_layout" style="">
        <table class="mo_ldap_mapping_table" id="ldap_role_mapping_table" style="width:90%" aria-hidden="true">
        <h3>LDAP Groups to WP User Role Mapping <sup style="font-size: 12px;color:#008000;">[Available in <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin.]</sup></h3>
						<tr>
							<td style="width:50%"><strong>LDAP Group Name</strong></td>
							<td style="width:50%"><strong>WordPress Role</strong></td>
						</tr>

						<tr>
							<td><div id="selected_group" style="position: relative; background: white; "><input class="mo_ldap_table_textbox" type="text" name="mapping_key_1" placeholder="cn=group,dc=domain,dc=com" />
                                </div></td>
							<td><div id="selected_group_value" style="position: relative; background: white;">
								<select name="mapping_value_1" id="role" style="width:100%"  >
								   <?php wp_dropdown_roles(); ?>
								</select>
                            </div></td>
						</tr>
            <tr><td><a style="cursor:pointer" id="add_mapping">Add More Mapping</a><br><br></td><td>&nbsp;</td></tr>

						</table>
						<table aria-hidden="true" class="mo_ldap_mapping_table" style="width:90%;">
						<tr>
								<td colspan=2><em> Specify attribute which stores group names to which LDAP Users belong.</em></td>
							</tr>
							<tr>
							<td style="width:50%"><span style="font-size:13px;font-weight:bold;">LDAP Group Attributes Name </span>
							</td>
							<td><div id="role_mapping_form_ldap" style="position: relative;line-height: 5;  ">
								<input type="text" name="mapping_memberof_attribute" placeholder="Group Attributes Name" style="width:100%;background: #DCDAD1;" value="memberOf"  >
							</div></td>
						</tr>
                            <tr>
                                <td><input type="submit" id="save_role_mapping" class="button button-primary button-large" value="Save Mapping" /></td>
                                <td>&nbsp;</td>
                            </tr>
						<tr><td>&nbsp;</td></tr>
					</table>
				</div>

			<div id="mo_rolemap_ldap_username" style="position: relative;border-radius: 10px;" class="mo_ldap_small_layout">
			<form method="post" id="rolemappingtest">
			<input type="hidden" name="mo_rolemap_ldap_username_nonce"
                       value="<?php echo wp_create_nonce( 'mo_rolemap_ldap_username_nonce' ); ?>"/>
				<h3>Test Role Mapping Configuration <sup style="font-size: 12px;color:#008000;">[Available in <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium versions</a> of the plugin.]</sup></h3>Enter LDAP username to test role mapping configuration
				<table id="attributes_table" aria-hidden="true" class="mo_ldap_settings_table">
					<tbody><tr></tr>
					<tr></tr>
					<tr>
						<td>Username</td>
						<td><input type="text" id="mo_ldap_username" name="mo_ldap_username" required placeholder="Enter Username" style="width:61%;background: #DCDAD1;"  >
					</td></tr>
					<tr>
					<td><input type="button" value="Test Configuration" class="button button-primary button-large"></td>
					</tr>
				</tbody></table>
			</form>
</div>
<script>
	jQuery( document ).ready(function() {
		jQuery("#default_group_mapping option[value='administrator']").remove();
	});
</script>
<script>
		jQuery( document ).ready(function() {
                jQuery("#mo_ldap_fetch_groups_form :input").prop("disabled", true);
                jQuery("#enable_role_mapping_form :input").prop("enalbed", true);
				jQuery("#rolemappingtest :input").prop("disabled",true);
                jQuery("#rolemappingtest :input[type=text]").val("");
                jQuery("#ldap_role_mapping_table :input").prop("disabled",true);
                jQuery("#role_mapping_form_ldap :input").prop("disabled",true);
                jQuery('#default_group_mapping').prop("enabled",true);
                jQuery('#add_mapping').prop("disabled",true);
                jQuery('#save-default-mapping').prop("enabled",true);
                jQuery('#save_role_mapping').prop("disabled",true);
			});

        jQuery('#enable_ldap_role_mapping').change(function () {
            jQuery('#enable_role_mapping_form').submit();
        });

</script>
<?php
}

function mo_ldap_show_attribute_mapping_page(){
	?>
		<div class="mo_ldap_table_layout">
			<div id="ldap_intranet_attribute_mapping_div">
			<form name="f" method="post" id="attribute_config_form">
                <?php wp_nonce_field("mo_ldap_save_attribute_config");?>
				<table id="attributes_table" aria-hidden="true" class="mo_ldap_settings_table">
						<input type="hidden" name="option" value="mo_ldap_save_attribute_config" />
                        <br>
						<h3>Attribute Configuration</h3>
						<tr>
							<td style="width:70%;">Enter the LDAP attribute names for Email, Phone, First Name and Last Name attributes</td>
						</tr>
						<tr>
							<td style="width:40%;"><strong><span style="color:#FF0000">*</span>Email Attribute</strong></td>
							<td><div id="ldap_intranet_attribute_mail_name" style="position: relative;border-radius: 10px;"><input type="text"  name="mo_ldap_email_attribute" placeholder="Enter Email attribute" required style="width:80%;"
							value="<?php echo esc_attr(get_option('mo_ldap_local_email_attribute'));?>"/></div></td>
						</tr>
						<tr>
							<td style="width:40%;"><strong>Phone Attribute</strong></td>
							<td><div id="ldap_intranet_attribute_phone_name" style="position: relative"><input type="text" name="mo_ldap_phone_attribute"  placeholder="Enter Phone attribute" style="width:80%;background: #DCDAD1;"
							value="<?php echo esc_attr(get_option('mo_ldap_local_phone_attribute'));?>" <?php if(get_option('mo_ldap_local_cust', '1') == '0'){ echo "disabled"; }?>/></div></td>
						</tr>
						<tr>
							<td style="width:40%;"><strong>First Name Attribute</strong></td>
							<td><input type="text" name="mo_ldap_fname_attribute"  placeholder="Enter First Name attribute" style="width:80%;background: #DCDAD1;"
							value="<?php echo esc_attr(get_option('mo_ldap_local_fname_attribute'));?>" <?php if(get_option('mo_ldap_local_cust', '1') == '0'){ echo "disabled"; }?>/></td>
						</tr>
						<tr>
							<td style="width:40%;"><strong>Last Name Attribute</strong></td>
							<td><input type="text" name="mo_ldap_lname_attribute"  placeholder="Enter Last Name attribute" style="width:80%;background: #DCDAD1;"
							value="<?php echo esc_attr(get_option('mo_ldap_local_lname_attribute'));?>" <?php if(get_option('mo_ldap_local_cust', '1') == '0'){ echo "disabled"; }?>/></td>
						</tr>

                    <tr><td></td></tr><tr><td colspan="2"><span style="color:#008000;"><strong><em>Support for Phone, First Name, Last Name and Custom attributes from LDAP is present in the <a href="<?php echo esc_url(add_query_arg( array('tab' => 'pricing'), $_SERVER['REQUEST_URI'] )); ?>">Premium Version</a> of the plugin.</em></strong></span></em></td></tr>
                    <tr><td><br></td></tr>


                    <tr>
                        <td style="width:40%;"><strong>Email Domain</strong></td>
                        <?php $pattern_string = "[a-z0-9.-]+\.[a-z]{2,}$"; ?>
                        <td><div id="ldap_intranet_email_domain" style="position: relative;border-radius: 10px;"><input type="text" pattern="<?php echo esc_attr($pattern_string); ?>" title="Please Enter Valid Domain Name. Ex. miniorange.com" name="mo_ldap_email_domain" placeholder="example.com"  style="width:80%;" value="<?php echo esc_attr(get_option('mo_ldap_local_email_domain'));?>"/></div></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td colspan=2><em>  Set user email to<strong>username@email_domain</strong> in WordPress, if the "mail" attribute is not set in LDAP directory.</em></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>

						<tr id="save_config_element">
							<td>
								<input type="submit" value="Save Configuration" class="button button-primary button-large" />
							</td>
						</tr>

				</table>
				</form>
			</div><br>
			<?php if(get_option('mo_ldap_local_cust', '1') != '0'){ ?>
				<form id="delete_custom_attribute_form" method="post">
					<input type="hidden" name="option" value="mo_ldap_delete_custom_attribute" />
					<input type="hidden" id="custom_attribute_name" name="custom_attribute_name" value="" />
				</form>
			<?php } ?>
			<div id="attribiteconfigtest_ldap" style="background: white;position: relative;border-radius: 10px; ">
			<form method="post" id="attribiteconfigtest">
				<input type="hidden" name="option" value="mo_ldap_test_attribute_configuration" />
				<table id="attributes_table" class="mo_ldap_settings_table" aria-hidden="true">
					<tr><h3>Test Attribute Configuration</h3></tr>
					<tr>Enter LDAP username to test attribute configuration</tr>
					<tr>
						<td>Username</td>
						<td><input type="text" id="mo_ldap_username" name="mo_ldap_username" required placeholder="Enter Username" style="width:61%;" />
					</tr>
					<tr>
					<td><input type="submit" value="Test Configuration" class="button button-primary button-large" /></td>
					</tr>
				</table>
			</form></div>
			<script>
                jQuery("#attribiteconfigtest").submit(function(event ) {
                    event.preventDefault();
                    testConfiguration();
                });

                function testConfiguration(){
                    var username = jQuery("#mo_ldap_username").val();
                    var myWindow = window.open('<?php echo site_url(); ?>' + '/?option=testattrconfig&user='+username, "Test Attribute Configuration", "width=700, height=600");
                }
			</script>
		</div>
<?php
}
?>