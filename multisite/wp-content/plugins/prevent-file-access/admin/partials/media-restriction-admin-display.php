<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://miniorange.com/
 * @since      1.1.1
 *
 * @package    Media_Restriction
 * @subpackage Media_Restriction/admin/partials
 */


function mo_prevent_show_bfs_note()
{
	?>
		<form name="f" method="post" action="" id="mo_oauth_client_bfs_note_form">
			<?php wp_nonce_field('mo_oauth_client_bfs_note_form','mo_oauth_client_bfs_note_form_field'); ?>
			<input type="hidden" name="option" value="mo_oauth_client_bfs_note_message"/>	
			<div class="notice notice-info"style="padding-right: 38px;position: relative;border-color:red; background-color:black"><h4><center><i class="fa fa-gift" style="font-size:50px;color:red;"></i>&nbsp;&nbsp;
			<big><font style="color:white; font-size:30px;"><b>BLACK FRIDAY AND CYBER MONDAY SALE: </b><b style="color:yellow;">UPTO 50% OFF!</b></font> <br><br></big><font style="color:white; font-size:20px;">Contact us @ oauthsupport@xecurify.com for more details.</font></center></h4>
			<p style="text-align: center; font-size: 60px; margin-top: 0px; color:white;" id="demo"></p>
			</div>
		</form>
	<script>
	var countDownDate = <?php echo strtotime('Nov 30, 2021 00:00:00') ?> * 1000;
	var now = <?php echo time() ?> * 1000;
	var x = setInterval(function() {
		now = now + 1000;
		var distance = countDownDate - now;
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
			minutes + "m " + seconds + "s ";
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("demo").innerHTML = "EXPIRED";
		}
	}, 1000);
	</script>
	<?php
}

function mo_media_restrict_page_ui()
{
?>
	<div style="margin-left:20px;overflow:hidden">
		<div class="row" style="margin:15px">
			<img width="30px" src="<?php echo esc_url(dirname(plugin_dir_url(__FILE__))); ?>/images/logo.png">
			<h5>miniOrange Prevent Files / Folders Access</h5>
		</div>
		
		<?php
		$today = date("Y-m-d H:i:s");
		$date = "2021-11-30 23:59:59";
		if ( $today <= $date )
			mo_prevent_show_bfs_note();
		?>

		<div class="row">
			<div class="col-md-8">

				<?php
				$currenttab = '';
				if (isset($_GET['tab'])) {
					$currenttab = sanitize_text_field(wp_unslash($_GET['tab']));
				}

				?>
				<ul class="row mo_media_restriction_nav">
					<a href="admin.php?page=mo_media_restrict&tab=configure_file_restriction">
						<li class="mo_media_restriciton_nav_item <?php if ($currenttab === '' || $currenttab === 'configure_file_restriction') echo 'active'; ?>">File Restriction</li>
					</a>
					<a href="admin.php?page=mo_media_restrict&tab=protected_folder">
						<li class="mo_media_restriciton_nav_item <?php if ($currenttab === 'protected_folder') echo 'active'; ?>">Protected Folder</li>
					</a>
					<a href="admin.php?page=mo_media_restrict&tab=configure_folder_restriction">
						<li class="mo_media_restriciton_nav_item <?php if ($currenttab === 'configure_folder_restriction') echo 'active'; ?>">Folder Restriction</li>
					</a>
					<a href="admin.php?page=mo_media_restrict&tab=page_restriction">
						<li class="mo_media_restriciton_nav_item <?php if ($currenttab === 'page_restriction') echo 'active'; ?>">Page/Post Restriction</li>
					</a>
					<a href="admin.php?page=mo_media_restrict&tab=account_setup">
						<li class="mo_media_restriciton_nav_item <?php if ($currenttab === 'account_setup') echo 'active'; ?>">Account Setup</li>
					</a>
					<a href="admin.php?page=mo_media_restrict&tab=licensingtab">
						<li class="mo_media_restriciton_nav_item <?php if ($currenttab === 'licensingtab') echo 'active'; ?>">Licensing plans</li>
					</a>
				</ul>

				<?php
				if ($currenttab === '' || $currenttab === 'configure_file_restriction') {
					mo_media_restrict_file_restriction();
				} elseif ($currenttab === 'configure_folder_restriction') {
					mo_media_restrict_folder_restriction();
				} elseif ($currenttab === 'account_setup') {
					mo_media_restrict_account_setup();
				} elseif ($currenttab === 'licensingtab') {
					mo_media_restrict_licensing_tab();
				} elseif ($currenttab === 'page_restriction') {
					mo_media_restrict_page_restriction();
				} elseif ($currenttab === 'protected_folder') {
					mo_media_restrict_protected_folder();
				}
				?>
			</div>
			<div class="col-md-4">
				<div class="mo_media_restriction_card" style="width:90%">
					<h4 style="margin-bottom:30px">Contact us</h4>
					<p class="mo_media_restriction_contact_us_p"><b>Need any help?<br>Just send us a query so we can help you.</b></p><br>
					<form action="" method="POST">
						<?php wp_nonce_field('mo_media_restriction_contact_us_form', 'mo_media_restriction_contact_us_field'); ?>
						<input type="hidden" name="option" value="mo_media_restriction_contact_us">
						<div class="form-group">
							<input type="email" placeholder="Enter email here" class="form-control" name="mo_media_restriction_contact_us_email" id="mo_media_restriction_contact_us_email" required>
						</div>
						<div class="form-group">
							<input type="tel" id="mo_media_restriction_contact_us_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" placeholder="Enter phone here" class="form-control" name="mo_media_restriction_contact_us_phone">
						</div>
						<div class="form-group">
							<textarea class="form-control" onkeypress="mo_media_restriction_contact_us_valid_query(this)" onkeyup="mo_media_restriction_contact_us_valid_query(this)" onblur="mo_media_restriction_contact_us_valid_query(this)" name="mo_media_restriction_contact_us_query" placeholder="Enter query here" rows="5" id="mo_media_restriction_contact_us_query" required></textarea>
						</div>
						<input type="submit" class="btn btn-primary" style="width:130px;height:40px" value="Submit">
					</form>
					<br>
					<p class="mo_media_restriction_contact_us_p"><b>If you want custom features in the plugin, just drop an email at<br><a href="mailto:info@xecurify.com">info@xecurify.com</a></b></p>
				</div>
				<br>
				<?php 
				if ($currenttab === 'page_restriction') {
?>
	<div class="mo_oauth_premium_option_text" style="margin: 12% 9%;"><span style="color:red;">*</span>This is a add-on feature.
		<a href="https://wordpress.org/plugins/page-and-post-restriction/" target="_blank" rel="noopener">Click Here</a> to see our full list of add-on feature.</div>

					<div class="mo_media_restriction_card" style="width:90%;font-size: small;background-color: rgba(168, 168, 168, 0.7);opacity: 0.5;">
        <h3 style="font-size: 17px;">Page Restrict Options 
        </h3>
		<hr><br>
		<div style="padding-left:10px" style="font-size: small;">
            <input style="cursor: not-allowed;" type="radio" name="mo_display" disabled=""><b>Redirect to Login Page</b><br><b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to WP Login Page. <p></p><input style="cursor: not-allowed;" type="radio" name="mo_display" disabled=""><b>Single Sign On </b><br><b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to IDP login page.<p></p><table>
                <tbody><tr style="margin-bottom:7%;">
                	
					
					
     			</tr>
                <tr>
                	<td width="60%" style="padding-bottom:6px;">
                    	<input style="cursor: not-allowed;" type="radio" name="mo_display" value="mo_display_page" disabled="">
						<b>Redirect to Page Link</b>
					</td>
				</tr>
				<tr>
					<td colsapn="2">
                    	<input type="url" style="width:90%;cursor: not-allowed;" name="mo_display_page_url" id="mo_page_url" disabled="" placeholder="Enter URL of the page">
                     	</td><td>
                        	<button style="cursor: not-allowed;" class="button button-primary button-larges disabled value = " "="" placeholder="Enter URL of the page">
                        		<b>SAVE &amp; TEST URL
                        	</b></button><b> 
                        </b></td>
					
				</tr>
				<tr>
					<td colspan="3">
						<b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to the given page URL.<br><font color="#8b008b">Please provide a valid URL and make sure that the given page is not Restricted</font>
 						<br><br>
 					</td>
 				</tr>

				<tr>
                    <td style="padding-bottom:6px;" width="70%">
                    	<input style="cursor: not-allowed;" type="radio" name="mo_display" value="mo_display_message" disabled="">
                    	<b>Message on display</b><br>
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input type="text" style="width:90%;cursor:not-allowed;" name="mo_display_message_text" disabled="" value="" placeholder="Enter message to display">
						</td><td>
							<button style="cursor: not-allowed;" class="button button-primary button-larges" disabled=""> SAVE &amp; Preview</button>    
                    	</td>
                    
                </tr>
                <tr>
					<td colspan="2">
						<b>Note </b>: Enabling this option will display the configured message to the restricted users.
					</td>
				</tr>
 				<tr style="margin-bottom:7%;">
                    
                    
					
					

     			</tr>
  			</tbody></table>
            <br><br>
        </div>
    
				</div>
<?php
				}
			?>
			</div>


		</div>
	</div>
<?php
}

function mo_media_restrict_licensing_tab()
{
?>
	<!-- HTML Code start -->
	<section class='content'>
		<div class="container">
			<div class="clearfix">
				<div class="row pricing-wrapper comparison-table clearfix style-3">
					<div class="col-md-1"></div>
					<div class="col-md-4 pricing-col list-feature">
						<div class="pricing-card">
							<div class="pricing-header">
								<h5>Choose Your Plan</h5>
								<p>Compare Package Feature</p>
							</div>
							<div class="pricing-feature">
								<li>
									<p><b>File Restriction</b></p>
								</li>
								<li>
									<p>Number of Extensions</p>
								</li>
								<li>
									<p><b>Redirect Option</b></p>
								</li>
								<li>
									<p>Display Custom Page</p>
								</li>
								<li>
									<p>WordPress login</p>
								</li>
								<li>
									<p>SSO (SAML or OAuth) login</p>
								</li>
								<li>
									<p><b>Folder Restriction</b></p>
								</li>
								<li>
									<p>WordPress Upload Folder</p>
								</li>
								<li>
									<p>WordPress Custom Folder</p>
								</li>
								<li>
									<p>User Based Folder Restriction</p>
								</li>
								<li>
									<p>Roles Based Folder Restriction</p>
								</li>
								<li>
									<p><b>Protected Folder</b></p>
								</li>
								<li>
									<p>Number of file uploads</p>
								</li>
								<li>
									<p><b>Supported server</b></p>
								</li>
								<li>
									<p>Apache</p>
								</li>
								<li>
									<p>NGINX</p>
								</li>
								<li>
									<p><b>Security level Base</b></p>
								</li>
								<li>
									<p>Cookie</p>
								</li>
								<li>
									<p>Session</p>
								</li>
							</div>
						</div>
					</div>
					<div class="col-md-3 pricing-col person">
						<div class="pricing-card">
							<div class="pricing-header">
								<h5>Premium</h5>
								<div class="price-box">
									<div class="price">149
										<div class="currency">$</div>
										<!-- <div class="plan">/ Year</div> -->
									</div>
								</div>
							</div>
							<div class="pricing-feature">
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<span>UNLIMITED</span>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-times unavailable"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-times unavailable"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-times unavailable"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-times unavailable"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<span>UNLIMITED</span>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-times unavailable"></i>
									</p>
								</li>
							</div>
							<div class="pricing-footer">
								<a onclick="upgradeform('wp_media_restriction_plan')" class="btn btn-act rounded btn-line">
									<span>Upgrade now</span>
									<i class="fa fa-arrow-right"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 pricing-col current unlim">
						<div class="pricing-card">
							<div class="pricing-header">
								<h5>Enterprise</h5>
								<a class="ribbon">
									<i class="fa fa-star"></i>
									<span>Feature</span>
								</a>
								<div class="price-box">
									<div class="price">249
										<div class="currency">$</div>
										<!-- <div class="plan">/ Year</div> -->
									</div>
								</div>
							</div>
							<div class="pricing-feature">
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<span>UNLIMITED</span>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<span>UNLIMITED</span>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
								<li>
									<p>
										<i class="fa fa-check available"></i>
									</p>
								</li>
							</div>
							<div class="pricing-footer">
								<a onclick="upgradeform('wp_media_restriction_enterprise_plan')" class="btn btn-act rounded btn-line">
									<span>Upgrade now</span>
									<i class="fa fa-arrow-right"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="moc-licensing-notice">
							<span style="color: red;">*</span>Cost applicable for one instance only. Licenses are perpetual and the Support Plan includes 12 months of maintenance (support and version updates). You can renew maintenance after 12 months at 50% of the current license cost.
							<p><span style="color: red;">*</span><strong>MultiSite Network Support</strong>
								There is an additional cost for the number of subsites in Multisite Network.</p>
							<h4>10 Days Return Policy</h4>
							<p>At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is not working as advertised and you've attempted to resolve any issues with our support team, which couldn't get resolved. We will refund the whole amount within 10 days of the purchase. Please email us at <a href="mailto:info@xecurify.com" target="_blank">info@xecurify.com</a> for any queries regarding the return policy.</p>
							<p><b>This functionality operates at the server level, thus if the Apache server rules doesn't work. Please contact info@xecurify.com with your concerns.</b></p>
							<p><b>The WPengine, Siteground and other servers like this runs on a nginx server, which requires the use of nginx configuration rules. Please email us at info@xecurify.com or oauthsupport@xecurify.com if you face any issues.</b></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



	<a id="mobacktoaccountsetup" style="display:none;" href="<?php echo add_query_arg(array('tab' => 'account_setup'), htmlentities($_SERVER['REQUEST_URI'])); ?>">Back</a>
	<input type="hidden" value="<?php echo 'account-setup' === get_option('mo_media_restriction_new_user') ? 1 : 0; ?>" id="mo_customer_registered">
	<form style="display:none;" id="loginform" action="<?php echo esc_url( get_option('host_name') . '/moas/login' ); ?>" target="_blank" method="post">
		<input type="email" name="username" value="<?php echo esc_attr( get_option('mo_media_restriction_admin_email') ); ?>" />
		<input type="text" name="redirectUrl" value="<?php echo esc_attr( get_option('host_name') . '/moas/initializepayment'); ?>" />
		<input type="text" name="requestOrigin" id="requestOrigin" />
	</form>
	<script>
		function upgradeform(planType) {
			if (planType === "") {
				location.href = "https://wordpress.org/plugins/miniorange-login-with-eve-online-google-facebook/";
				return;
			} else {
				jQuery('#requestOrigin').val(planType);
				if (jQuery('#mo_customer_registered').val() == 1)
					jQuery('#loginform').submit();
				else {
					location.href = jQuery('#mobacktoaccountsetup').attr('href');
				}
			}

		}
	</script>
	<?php
}

function mo_media_restrict_account_setup()
{

	if (false === get_option('mo_media_restriction_new_user') || 'register' === get_option('mo_media_restriction_new_user')) {
	?>
		<div class="mo_media_restriction_card">
			<h4 style="margin-bottom:30px">Register with miniOrange <small style="font-size: x-small;">[OPTIONAL]</small></h4>
			<h6>Why should I register? </h6>
			<p class="mo_media_restriction_contact_us_p">You should register so that in case you need help, we can help you with step by step instructions.<b> You will also need a miniOrange account to upgrade to the premium version of the plugins.</b> We do not store any information except the email that you will use to register with us.</p>
			<br>
			<form action="" method="POST">
				<?php wp_nonce_field('mo_media_restriction_register_customer_form', 'mo_media_restriction_register_customer_field'); ?>
				<input type="hidden" name="option" value="mo_media_restriction_register_customer">

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Email:</b></h6>
					</div>
					<div class="col-md-4">
						<input type="email" placeholder="person@example.com" value="<?php echo esc_attr( get_option('mo_media_restriction_admin_email') ); ?>" name="mo_media_restriction_admin_email" class="form-control" required>
					</div>
				</div>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Password:</b></h6>
					</div>
					<div class="col-md-4">
						<input type="password" name="mo_media_restriction_password" minlength="8" placeholder="Choose your password (Min. length 8)" class="form-control" required>
					</div>
				</div>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Confirm Password:</b></h6>
					</div>
					<div class="col-md-4">
						<input type="password" name="mo_media_restriction_confirm_password" minlength="8" placeholder="Confirm your password" class="form-control" required>
					</div>
				</div>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3"></div>
					<div class="col-md-2">
						<input type="submit" class="btn btn-primary btn-large" style="width:150px;height:35px" value="Register">
					</div>
					<div class="col-md-3">
						<input type="button" class="btn btn-primary btn-large" style="height:35px" id="mo_media_restriction_goto_login" value="Already have an account?">
					</div>
				</div>
			</form>
		</div>
		<form action="" id="mo_media_restriction_goto_login_form" method="POST">
			<?php wp_nonce_field('mo_media_restriction_change_to_login', 'mo_media_restriction_change_to_login_field'); ?>
			<input type="hidden" name="option" value="mo_media_restriction_change_to_login">
		</form>
		<script>
			jQuery('#mo_media_restriction_goto_login').click(function() {
				jQuery('#mo_media_restriction_goto_login_form').submit();
			});
		</script>
	<?php
	} elseif ('login' === get_option('mo_media_restriction_new_user')) {
	?>
		<div class="mo_media_restriction_card">
			<h4 style="margin-bottom:30px">Login with miniOrange <small style="font-size: x-small;">[OPTIONAL]</small></h4>
			<p class="mo_media_restriction_contact_us_p">It seems you already have an account with miniOrange. Please enter your miniOrange email and password.</p>
			<p><a target="_blank" href="https://login.xecurify.com/moas/idp/resetpassword" rel="noopener">Click here if you forgot your password?</a></p>
			<form action="" method="POST">
				<?php wp_nonce_field('mo_media_restriction_login_customer_form', 'mo_media_restriction_login_customer_field'); ?>
				<input type="hidden" name="option" value="mo_media_restriction_login_customer">

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Email:</b></h6>
					</div>
					<div class="col-md-4">
						<input type="email" placeholder="person@example.com" value="<?php echo esc_attr( get_option('mo_media_restriction_admin_email') ); ?>" name="mo_media_restriction_admin_email" class="form-control" required>
					</div>
				</div>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Password:</b></h6>
					</div>
					<div class="col-md-4">
						<input type="password" name="mo_media_restriction_password" minlength="8" placeholder="Choose your password (Min. length 8)" class="form-control" required>
					</div>
				</div>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3"></div>
					<div class="col-md-2">
						<input type="submit" class="btn btn-primary btn-large" style="width:150px;height:35px" value="Login">
					</div>
					<div class="col-md-2">
						<input type="button" class="btn btn-primary btn-large" id="mo_media_restriction_goto_register" style="width:150px;height:35px" value="Back">
					</div>
				</div>
			</form>
		</div>
		<form action="" id="mo_media_restriction_goto_register_form" method="POST">
			<?php wp_nonce_field('mo_media_restriction_change_to_register', 'mo_media_restriction_change_to_register_field'); ?>
			<input type="hidden" name="option" value="mo_media_restriction_change_to_register">
		</form>
		<script>
			jQuery('#mo_media_restriction_goto_register').click(function() {
				jQuery('#mo_media_restriction_goto_register_form').submit();
			});
		</script>
	<?php
	} elseif ('account-setup' === get_option('mo_media_restriction_new_user')) {
	?>
		<div class="mo_media_restriction_card">
			<h4 style="margin-bottom:30px">Thank you for registering with miniOrange.</h4>
			<div class="row">
				<table class="table table-striped table-bordered">
					<tbody>
						<tr>
							<td><b>miniOrange Account Email</b></td>
							<td><?php echo esc_html( get_option('mo_media_restriction_admin_email') ); ?></td>
						</tr>
						<tr>
							<td><b>Customer ID</b></td>
							<td><?php echo esc_html( get_option('mo_media_restriction_admin_customer_key') ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="row" style="margin-top:20px">
				<div class="col-md-2">
					<form action="" method="POST">
						<?php wp_nonce_field('mo_media_restriction_change_to_register', 'mo_media_restriction_change_to_register_field'); ?>
						<input type="hidden" name="option" value="mo_media_restriction_change_to_register">
						<input type="submit" class="btn btn-primary btn-large" style="height:35px" value="Change email address">
					</form>
				</div>
			</div>
		</div>
	<?php
	}
}

function mo_media_restrict_file_restriction()
{
	?>

	<div class="mo_media_restriction_card">
		<h4>Configuration</h4>
		<br>
		<div class="row">
			<div class="col-md-12">
				<p style="color: red;">This functionality operates at the server level, thus if the Apache server rules doesn't work, or also The WPengine, Siteground and other servers like this runs on a nginx server, which requires the use of nginx configuration rules. If you face any issues Please email us at info@xecurify.com or oauthsupport@xecurify.com. We would recommend you to please ensure your PHP server and rules which will work on your server before purchasing it or else <i><b>contact us we will help you to set up the plugin according to your requirements on your site.</b></i></p>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-3">
				<h6 class="mo_media_restriction_label_heading"><b>Enable Media Restriction:</b></h6>
			</div>
			<div class="col-md-4">
				<label class="mo_media_restriction_switch">
					<form action="" method="POST" id="mo_enable_media_restriction_form">
						<?php wp_nonce_field('mo_media_restriction_enable_form', 'mo_media_restriction_enable_field'); ?>
						<input value="1" name="mo_enable_media_restriction" type="checkbox" id="mo_enable_media_restriction" <?php checked(get_option('mo_enable_media_restriction') == 1); ?>>
						<span class="mo_media_restriction_slider round"></span>
						<input type="hidden" name="option" value="mo_enable_media_restriction">
					</form>
				</label>
			</div>
		</div>
		<?php
		if (get_option('mo_enable_media_restriction')) {
			$mo_media_restriction_file_types = 'png,jpg,gif,pdf,doc';
			$restrict_option = 'display-custom-page';
		?>
			<form action="" id="mo_media_restriction_file_configuration_form" method="POST">
				<?php wp_nonce_field('mo_media_restriction_file_configuration_form', 'mo_media_restriction_file_configuration_field'); ?>
				<input type="hidden" name="option" value="mo_media_restriction_file_types">
				<input type="hidden" id="mo_media_restriction_show_rules" name="mo_media_restriction_show_rules" value="0">
				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>File types to restrict:</b></h6>
						<br>
						<p style="font-size:12px">We do support only five extenstions in our free version which are: <b>png, jpg, gif, pdf, doc</b></p>
					</div>

					<div class="col-md-4">
						<input type="text" name="mo_media_restriction_file_types" value="<?php echo esc_attr($mo_media_restriction_file_types); ?>" placeholder="Write file extension hit enter">
						<script>
							var input1 = document.querySelector('input[name=mo_media_restriction_file_types]'),
								// init Tagify script on the above inputs
								tagify1 = new Tagify(input1, {
									maxTags: 5,
									enforceWhitelist: true,
									whitelist: ["pdf", "png", "jpg", "doc", "gif"],
									blacklist: [] // In string format "hello","temp"
								});
						</script>
					</div>
				</div>

				<h4 style="margin-top:30px">Redirect Option</h4>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Choose Redirect Option:</b></h6>
					</div>

					<div class="col-md-9">
						<input type="radio" class="mo_media_restriction_redirect_radio" name="mo_mr_restrict_option" value="display-custom-page" <?php checked($restrict_option == 'display-custom-page'); ?>> <span class="mo_media_restriction_redirect_radio_text">Display Custom Page</span> &nbsp;&nbsp;
						<input type="radio" readonly class="mo_media_restriction_redirect_radio" name="mo_mr_restrict_option" value="redirect-to-wordpress-login"> <span class="mo_media_restriction_redirect_radio_text">Redirect to Wordpress login <small style="color:red;"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[PREMIUM]</a></b></small></span>&nbsp;&nbsp;
						<input type="radio" readonly class="mo_media_restriction_redirect_radio" name="mo_mr_restrict_option" value="redirect-to-idp-login"> <span class="mo_media_restriction_redirect_radio_text">Redirect to SSO Login <small style="color:red;"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[ENTERPRISE]</a></b></small> </span>
					</div>
				</div>

				<?php
				$page_list = get_pages();
				$redirect_to = get_option('mo_mr_redirect_to');
				if (empty($redirect_to))
					$redirect_to = '403-forbidden-page';
				?>

				<div class="row" style="margin-top:20px">
					<div class="col-md-3">
						<h6 class="mo_media_restriction_label_heading"><b>Redirect to:</b></h6>
					</div>

					<div class="col-md-4">
						<select id="display-custom-page-select" class="form-control mo_media_restriction_select" name="mo_media_redirect_to_display_page">
							<option value="403-forbidden-page" <?php if ($redirect_to === '403-forbidden-page') echo 'selected'; ?>>403 Forbidden Page</option>
							<?php
							if (sizeof($page_list) > 0) {
								foreach ($page_list as $page) {
									echo '<option value="' . esc_attr($page->post_name) . '"';
									if ($page->post_name == $redirect_to)
										echo 'selected';
									echo ' >' . esc_html($page->post_title) . '</option>';
								}
							}
							?>
						</select>
						<select readonly style="display:none" id="redirect-to-idp-login-select" class="form-control mo_media_restriction_select">
							<option>SAML SSO login</option>
							<option>OAuth SSO login</option>
						</select>
						<select readonly style="display:none" id="redirect-to-wordpress-login-select" class="form-control mo_media_restriction_select">
							<option>WordPress login</option>
						</select>
					</div>
				</div>

			<h4 style="margin-top:30px">Advanced Option</h4>

			<div class="row" style="margin-top:20px">
				<div class="col-md-3">
					<h6 class="mo_media_restriction_label_heading"><b>Choose server:</b></h6>
				</div>
				<div class="col-md-6">
					<?php 
						$choose_server = get_option('mo_media_restriction_choose_server', 'apache');
					?>
					<input type="radio" <?php if('apache' === $choose_server ){ ?>checked <?php } ?> name="choose_server" value="apache"> <span class="mo_media_restriction_redirect_radio_text">Apache</span> &nbsp;&nbsp;
					<input type="radio" <?php if('godaddy' === $choose_server ){ ?>checked <?php } ?> name="choose_server" value="godaddy"> <span class="mo_media_restriction_redirect_radio_text">GoDaddy Managed Hosting Server</span> &nbsp;&nbsp;
					<input type="radio" name="choose_server"> <span class="mo_media_restriction_redirect_radio_text">NGINX <small style="color:red;"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[PREMIUM]</a></b></small></span>&nbsp;&nbsp;
				</div>
				<div class="col-md-3">
				</div>
			</div>
			</form>

			<div class="row" style="margin-top:20px">
				<div class="col-md-3">
					<h6 class="mo_media_restriction_label_heading"><b>Security Level Base:</b></h6>
					<p></p>
				</div>
				<div class="col-md-6">
					<input type="radio" name="security_level" checked><span class="mo_media_restriction_redirect_radio_text">Cookie </span>&nbsp;&nbsp;
					<input type="radio" name="security_level" > <span class="mo_media_restriction_redirect_radio_text">Session  <small style="color:red;"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[ENTERPRISE]</a></b></small></span>&nbsp;&nbsp;
				</div>
				<div class="col-md-3">
				</div>
			</div>


			<div class="row" style="margin-top:50px">
				<div class="col-md-12">
					<input type="submit" onclick="mo_media_restriction_rules_confirmation()" class="btn btn-primary btn-large" style="width:180px;height:50px" value="Save Settings">
				</div>
			</div>

			<div id="confirmation-popup" class="mo_media_restriction_overlay" style="display:none">
				<div class="mo_media_restriction_popup" style="width:30%;">
					<a class="close" href="">&times;</a>
					<br>
					<br>
					<div class="content text-center">
						<h4 class="text-center"><b>The plugin will update your .htaccess file to make it work. In case if you find any difficulty drop a query on <a href="mailto:info@xecurify.com">info@xecurify.com</a></b></h4>
						<br>
						<button class="btn btn-primary btn-large" onclick="mo_media_restriction_rules_alert_box(true,'mo_media_restriction_file_configuration_form')" style="width:250px;height:50px">Okay, I understand</button>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php
}

function mo_media_restrict_directory_has_subdirectory($path)
{
	$subdir_list = scandir($path);
	foreach ($subdir_list as $list) {
		if ($list !== '.' || $list !== '..') {
			$check_dir = $path . '/' . $list;
			if (is_dir($check_dir)) {
				return true;
			}
		}
	}
	return false;
}

function mo_media_restrict_directory_print($path, $parentfolder)
{
	$subdir_list = scandir($path);
	foreach ($subdir_list as $list) {
		if ($list !== '.' && $list !== '..' && $list !== 'protectedfiles') {
			$check_dir = $path . '/' . $list;
			if (is_dir($check_dir)) {
				echo '<li>';
				if (mo_media_restrict_directory_has_subdirectory($check_dir)) {
					echo '<i id="mo-media-restriction-' . esc_attr($parentfolder . '-' . $list) . '-i" onclick="mo_media_restrict_display_folder(\'mo-media-restriction-' . esc_attr($parentfolder . '-' . $list) . '\')" class="mo_media_restriction_plus_icon">+</i>';
				}
				echo '<input disabled type="checkbox" id="mo-media-restriction-' . esc_attr($parentfolder . '-' . $list) . '"';
				if (get_option('mo_media_restriction_folder_list') !== false) {
					$selected_dir = str_replace("/", "-", get_option('mo_media_restriction_folder_list'));
					if (in_array($parentfolder . '-' . $list, $selected_dir))
						echo 'checked';
				}
				echo '>
				<label for="mo-media-restriction-' . esc_attr($parentfolder . '-' . $list) . '">' . esc_html($list) . '</label>';
				if (mo_media_restrict_directory_has_subdirectory($check_dir)) {
					echo '<ul class="mo_media_restriction_pure_tree">';
					$parentfolder = $parentfolder . '-' . $list;
					mo_media_restrict_directory_print($check_dir, $parentfolder);
					echo '</ul>';
					$all_folders = explode('-', $parentfolder);
					unset($all_folders[sizeof($all_folders) - 1]);
					$parentfolder = implode('-', $all_folders);
				}
				echo '</li>';
			}
		}
	}
}

function mo_media_restrict_folder_restriction()
{
?>
	<div class="mo_media_restriction_card">
		<h4 style="margin-bottom:30px">Folder Restriction</h4>
		<p>
			<?php
			$upload_dir = wp_upload_dir();
			?>
		</p>


		<form method="post" id="mo_media_restriction_folder_configuration_form" action="">
			<div class="row">
				<div class="col-md-4">
					<h6 class="mo_media_restriction_label_heading"><b>WP Upload Folder to restrict:</b> <small style="color:red;font-size:12px"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[PREMIUM]</a></b></small> </h6>
				</div>
				<div class="col-md-4">
					<?php
					if ($upload_dir && isset($upload_dir['basedir']) && $upload_dir['error'] === false) {
					?>
						<ul class="mo_media_restriction_pure_tree main-tree">
							<li>
								<i id="mo-media-restriction-uploads-i" onclick="mo_media_restrict_display_folder('mo-media-restriction-uploads')" class="mo_media_restriction_plus_icon active">+</i>
								<input class="active" disabled type="checkbox" id="mo-media-restriction-uploads">
								<label for="mo-media-restriction-uploads">uploads</label>
								<?php
								if (mo_media_restrict_directory_has_subdirectory($upload_dir['basedir'])) {
									echo '<ul class="mo_media_restriction_pure_tree">';
									mo_media_restrict_directory_print($upload_dir['basedir'], 'uploads');
									echo '</ul>';
								}
								?>
							</li>
						</ul>
					<?php
					} else {
						echo '<b style="color:red">' . esc_html( $upload_dir['error'] ) . '</b>';
					}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<h6 class="mo_media_restriction_label_heading"><b>WP Custom Folder to restrict:</b> <small style="color:red;font-size:12px"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[ENTERPRISE]</a></b></small> </h6>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" placeholder="Enter folder name here">
				</div>
			</div>
		</form>
		<div class="row" style="margin-top:50px">
			<div class="col-md-12">
				<input type="submit" disabled class="btn btn-primary btn-large" style="width:180px;height:50px;background-color:#007bff !important" value="Save Settings">
			</div>
		</div>
	</div>

	<div class="mo_media_restriction_card">
		<h4 style="margin-bottom:30px">User base Folder Restriction <small style="color:red;font-size:12px"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[ENTERPRISE]</a></b></small></h4>
		<div class="row">
			<div class="col-md-4">
				<h6 class="mo_media_restriction_label_heading"><b>Enable user base restriction:</b></h6>
			</div>
			<div class="col-md-4">
				<label class="mo_media_restriction_switch">
					<input value="1" name="mo_enable_user_base_restriction" disabled type="checkbox" id="mo_enable_user_base_restriction">
					<span class="mo_media_restriction_slider round"></span>
				</label>
			</div>
		</div>
	</div>

	<div class="mo_media_restriction_card">
		<h4 style="margin-bottom:30px">Role base Folder Restriction <small style="color:red;font-size:12px"><b><a href="admin.php?page=mo_media_restrict&tab=licensingtab">[ENTERPRISE]</a></b></small></h4>
		<div class="row">
			<div class="col-md-4">
				<h6 class="mo_media_restriction_label_heading"><b>Enable role base restriction:</b></h6>
			</div>
			<div class="col-md-4">
				<label class="mo_media_restriction_switch">
					<input value="1" name="mo_enable_user_base_restriction" disabled type="checkbox" id="mo_enable_user_base_restriction">
					<span class="mo_media_restriction_slider round"></span>
				</label>
			</div>
		</div>
	</div>
<?php
}

function mo_media_restrict_page_restriction()
{
?>
	<div class="mo_oauth_premium_option_text"><span style="color:red;">*</span>This is a add-on feature.
		<a href="https://wordpress.org/plugins/page-and-post-restriction/" target="_blank" rel="noopener">Click Here</a> to see our full list of add-on feature.</div>
	<div class="mo_media_restriction_card" style="background-color: rgba(168, 168, 168, 0.7);opacity: 0.5;">
		<h4 style="margin-bottom:30px">Page/Post Restriction</h4>
		<p>
			<?php
			$upload_dir = wp_upload_dir();
			?>
		</p>

		<div style="padding-right:10px; font-size: small;">
			<h3 style="font-size: 20px;">Give Access to Pages based on Roles</h3>
			<p>
				<b>Note </b>: Enter role(s) of a user that you want to give access to for a page. Other roles will be restricted (By default all pages/posts are accessible to all users irrespective of their roles).
			</p>
			<p>
				<b>Note </b>: Before clicking on "Save Configuration", please check all the boxes of the pages/posts for which you want to save the changes.
			</p>

			<input type="hidden" id="_wpnonce" name="_wpnonce" value="ccc4b3f2bc"><input type="hidden" name="_wp_http_referer" value="/hookswp/wp-admin/admin.php?page=page_restriction">
			<input type="hidden" name="option" value="papr_restrict_pages">
			<span style="color: blue;">Select All</span> &nbsp;
			<span style="color: blue;">Deselect All</span>



			<br><br>&nbsp;&nbsp;&nbsp;<input disabled type="checkbox" class="checkBoxClass1" name="mo_page_0" value="true"><b>Home Page</b><i>&nbsp;&nbsp;<span style="color: blue;">[Visit Page]</span></i>
			<input class="mo_roles_suggest ui-autocomplete-input" disabled type="text" name="mo_role_values_0" id="0" value="" placeholder="Enter (;) separated Roles" style="width: 300px;" autocomplete="off"><br><br>&nbsp;&nbsp;&nbsp;<input disabled type="checkbox" class="checkBoxClass1" name="2" value="true" > <b>Sample Page</b>&nbsp;<i><span style="color: blue;">[Visit Page]</span></i>&nbsp; <input class="mo_roles_suggest ui-autocomplete-input" disabled type="text" name="mo_role_values_2" id="2" value="" placeholder="Enter (;) separated Roles" style="width: 300px;" autocomplete="off"><br><br><br><input type="submit" disabled class="button button-primary button-larges" value="Save Configuration" 11="">
			<br>
			<h3 style="font-size: 20px;">Give Access to Posts based on Roles</h3>
			<p>
				<b>Note </b>: Enter a role(s) of a user that you want to give access to for a post (By default all posts are accessible to all users irrespective of their roles).
			</p>

			<span style="color: blue;">Select All</span> &nbsp;
			<span style="color: blue;">Deselect All</span>
			<table>

				<tbody>
					<tr style="margin-bottom:3%;">
						<td><input type="checkbox" disabled class="checkBoxClass2" name="mo_post_1" value="true"> <b>Hello world!</b><i>&nbsp;&nbsp;<span style="color: blue;">[Visit Post]</span> </i> </td>
						<td>
							<input class="mo_roles_suggest ui-autocomplete-input" disabled type="text" name="mo_role_values_1" value="" placeholder="Enter (;) separated Roles" style="width: 300px;" autocomplete="off"><br><br>
						</td>
					</tr>
				</tbody>
			</table><br>
			<input type="submit" disabled class="button button-primary button-larges" value="Save Configuration">
			<br>

			<h3 style="font-size: 20px;">Give Access to Category of Posts based on Roles
			</h3>
			<p><b>Note </b>: Enter a role(s) of a user that you want to give access to for a Category post (By default all posts are accessible to all users irrespective of their roles). </p>
			<span style="color: blue;">Select All</span> &nbsp;
			<span style="color: blue;">Deselect All</span>
			<table>


				<tbody>
					<tr style="margin-bottom:3%;">
						<td><input type="checkbox"  class="checkBoxClass2" name="mo_category_1" value="true" disabled>
							<b>Uncategorized</b><i>&nbsp;&nbsp;<span style="color: blue;">[Visit Category]</span></i></td>
						<td><input class="mo_roles_suggest ui-autocomplete-input" style="width:175%" type="text" name="mo_role_values_1" disabled value="" placeholder="Enter (;) separated Roles" autocomplete="off"><br><br></td>
					</tr>
				</tbody>
			</table>
			<br>
			<input type="submit" disabled class="button button-primary button-larges" value="Save Configuration">
			<br><br>
		</div>

		<div style="padding-right:10px; font-size: small;">
			<h3 style="font-size: 20px;">Select pages you want to give access to Logged in Users only</h3>
			<p>
				<b>Note </b>: Selet the page(s) that you want to restrict access, for a user not Logged In (By default all pages/posts are accessible to all users).
			</p>
				<span class="selectAll"><input type="checkbox" disabled name="papr_select_all_pages"  id="selectall4"> Select All Pages
				</span><br>
				<span class="mo_pr_help_desc"><b>NOTE: </b> If this option is enabled, all the newly added pages will be checked by default.</span>

				<br><br>&nbsp;&nbsp;&nbsp;<input disabled type="checkbox" class="checkBoxClass3" name="mo_redirect_0" value="true"> <b>Home Page&nbsp;</b><i><span style="color: blue;">[visit page]</span> </i> <br><br> &nbsp;&nbsp;&nbsp;<input type="checkbox" disabled class="checkBoxClass3" id="2" name="2" value="true"><b>Sample Page</b><i>&nbsp;<span style="color: blue;">[visit page]</span></i><br><br><br><input type="submit" disabled class="button button-primary button-larges" value="Save Configuration">
			<br>

			<h3 style="font-size: 20px;">Select posts you want only Logged in Users to access</h3>
			<p><b>Note </b>: Select the post(s) that you want to restrict access, for a User not Logged In (By default all pages/posts are accessible to all users). </p>


				<span class="selectAll"><input disabled type="checkbox"   id="selectall4" name="papr_select_all_posts"> Select All Posts</span><br><span class="mo_pr_help_desc"><b>NOTE: </b> If this option is enabled, all the newly added posts will be checked by default.</span><br><br>
				<table>

					<tbody>
						<tr style="margin-bottom:3%;">
							<td><input type="checkbox" disabled class="checkBoxClass4" name="mo_redirect_post_1" value="true"> <b>Hello world!</b>&nbsp;<i><span style="color: blue;">[visit post]</span></i><br><br></td>
						</tr>
					</tbody>
				</table><br>
				<input type="submit" disabled class="button button-primary button-larges" value="Save Configuration">

		</div>

	</div>
<?php
}
function mo_media_restrict_protected_folder(){
	?><div class="mo_media_restriction_card">
		<h4 style="margin-bottom:30px;">Upload files in protected folder </h4>
		<p style="color:red;margin-bottom:30px;font-size:12px"><b>NOTE: we do provide only five files upload in the free version.</b></p>
		<div class="row">
			<div style="widht:100%;text-align:center;padding:20px;border: 4px dashed #b4b9be;margin-left:auto;margin-right:auto;margin-bottom:10px">
				<form method="post" enctype="multipart/form-data">
					<?php wp_nonce_field('mo_media_restriction_file_upload_form', 'mo_media_restriction_file_upload_field'); ?>
					<input type="file" name="fileToUpload" style="display: inline-block; position: relative; z-index: 1;" required>
					<input type="submit" value="Upload">
					<input type="hidden" name="option" value="mo_media_restriction_file_upload">
				</form>
			</div>
		</div>

		<div class="row" style="margin:20px">
			<form method="post" id="mo_media_restriction_delete_file" action="">
				<?php wp_nonce_field('mo_media_restriction_delete_file_form', 'mo_media_restriction_delete_file_field'); ?>
				<input type="hidden" name="option" value="mo_media_restriction_delete_file">
				<input type="hidden" id="mo_media_restrict_filename" name="mo_media_restrict_filename" value="none">
			</form>
		</div>
			<?php
			$upload_dir = wp_upload_dir();
			if ($upload_dir && isset($upload_dir['basedir'])) {
				$base_upload_dir = $upload_dir['basedir'];
				$protectedfiles = $base_upload_dir . DIRECTORY_SEPARATOR . "protectedfiles";
				$protectedfilesurl = $upload_dir['baseurl'] . "/protectedfiles";
				if ($upload_dir['error'] !== false) {
					echo "<p style='color:red'>" . esc_html( $upload_dir['error'] ) . "</p>";
				} else {
					if (!file_exists($protectedfiles) && !is_dir($protectedfiles)) {
						wp_mkdir_p($protectedfiles, 0775, true);
					}
					$diriterator = new DirectoryIterator($protectedfiles);
					echo "<table class='mo_media_restriction_table' id='mo_media_restriction_table'><thead><tr class='mo_media_restriction_tr'><th class='mo_media_restriction_th'>File Name</th><th class='mo_media_restriction_th'>URL</th><th class='mo_media_restriction_th'>Action</th></tr></thead><tbody>";
					$count = 0;
					foreach ($diriterator as $fileinfo) {
						if (!$fileinfo->isDot()) {
							echo "<tr class='mo_media_restriction_tr'><td class='mo_media_restriction_td'>" . esc_html($fileinfo->getFilename()) . "</td><td class='mo_media_restriction_td'>" . esc_html($protectedfilesurl . "/" . $fileinfo->getFilename()) . "</td><td class='mo_media_restriction_td'><button class='btn btn-danger' onclick=\"mo_media_restrict_delete_file('" . esc_attr($fileinfo->getFilename()) . "')\">Delete</button></td></tr>";
							if (++$count > 100)
								break;
						}
					}
					echo "</tbody></table>
					<script>
					 jQuery(document).ready(function() {
					        jQuery('#mo_media_restriction_table').DataTable({
					            'order': [[ 1, 'desc' ]]
					        });
					    } );
					</script>";
				}
			}
			?>
		</div>
	<?php
}
?>