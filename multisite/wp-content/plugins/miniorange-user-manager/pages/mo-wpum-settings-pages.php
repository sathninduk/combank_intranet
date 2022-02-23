<?php
function mo_wpum_show_settings_page() {
	global $mo_manager_utility,$registration;
	$current_site = get_site_url();
	$manage_signup = $current_site.'/wp-admin/users.php?page=mo_wpum_user_signups';
	$roles = $current_site.'/wp-admin/users.php?page=mo_wpum_role_caps_settings';
	$customer_email = get_option('mo_wpum_admin_email');
	?>
		<div class="mo_wpum_table_layout">
			<?php if(!$mo_manager_utility->is_registered()) { ?>
			<div style="display:block;margin-top:10px;color:red;background-color:rgba(251, 232, 0, 0.15);padding:5px;border:solid 1px rgba(255, 0, 9, 0.36);">
					Please <a href="<?php echo add_query_arg( array('tab' => 'register'), $_SERVER['REQUEST_URI'] ); ?>">Register or Login with miniOrange</a> to enable WordPress User Manager.
			</div>
			<?php } ?>
			<?php if(get_option('mo_wpum_notification_option_enable') == 'php'){
					if((ini_get('SMTP')== FALSE)||(ini_get('smtp_port') == FALSE)){
						?><div class = "error notice">
						<p><b>Warning:</b>&nbsp Your SMTP Port Or SMTP Host is not configured.</p>
						</div> <?php
				}
			} ?>
			<form id="mo-wpum-settings-enable" name="mo-wpum-settings-enable" method="post" action="">
				<input type="hidden" name="option" value="mo_wpum_save_enable" />
					<h2>Registration Settings
					<input type="submit" name="submit" value="Save" style="float:right; margin-right:2%; margin-top: 1px;width:100px;" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?>
					class="button button-primary button-large" />
					</h2><hr><br>
					 Click on Manage Signups to manage the user signups for your site. By default all users will added to pending list and admin can approve the users manually or send them an activation link to self enable.
					<br><br>
						<input type="button" name="button" onClick="parent.location='<?php echo $manage_signup?>'" value="Manage Sign-ups" style="float:left; margin-left:0.5%; margin-top: 1px; width:150px;" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> class="button button-primary button-large" /><br><br>

					<div>
						<br>
						<input type="checkbox" id="send_email_enable" name="mo_wpum_send_email_enable" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> value="1" <?php echo("checked");?>/>
						<strong>Enable Email Notifications</strong><br>
						<span style="font-style:italic;margin-left:25px;display:block">A notification email will be sent to 
							<b><?php echo isset($customer_email) ? $customer_email : 'admin'; ?></b>
							 when a user tries to register and when registration is complete.</span>
						<br> <strong>Enter another email id to receive notification for a user sign-up: [Premium Feature]</strong><br>
						<input class="mo_wpum_table_textbox" type="email" id="admin_email2" name="admin_email2"
						 required placeholder="person@example.com" value= "<?php  echo get_option("mo_wpum_admin_email_ids");?>" disabled/>
					</div>
					<div>
						<br><input type="checkbox" id="admin_dashboard_enable" name="mo_wpum_admin_dashboard_enable" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> value="1" <?php checked( get_option('mo_wpum_admin_dashboard_enable') == 1 );?> /><strong>Allow non-admin users to see admin panel?</strong><br><br>
					</div><br>
					<div>
						<input type="radio" id="send_mail_php_notification_option" name="mo_wpum_notification_option_enable" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> value="php" <?php checked( get_option('mo_wpum_notification_option_enable') == 'php' );?> /><strong>Send notifications via WP Mail?</strong><br><br>
						<input type="radio" id="send_mail_mo_notification_option" disabled name="mo_wpum_notification_option_enable" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> value="miniorange" <?php checked( get_option('mo_wpum_notification_option_enable') == 'miniorange' );?> /><strong>Send notifications via miniOrange Gateway? [Premium Feature]</strong><br><br>
					</div>
					<div>
						<h3>Roles and Capabilities</h3><hr>
						Click on Roles and Capabilities to manage user roles and capabilities. Add New Roles, Change Default Roles and Rename Roles. Add/Delete Capabilities. <br><br>
						<input type="button" name="button" onClick="parent.location='<?php echo $roles?>'" value="Roles and Capabilities" style="float:left; margin-left:0.5%; margin-top: 1px; width:150px;" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> class="button button-primary button-large" /><br><br>
					</div>
			</form>
		</div>
	<?php  if($mo_manager_utility->is_registered()) { mo_wpum_show_user_profile(); }
}