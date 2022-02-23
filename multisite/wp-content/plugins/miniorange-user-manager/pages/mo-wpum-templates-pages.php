<?php
function mo_wpum_show_templates_settings()	{
	global $mo_manager_utility;
	$url = 'admin.php?page=mo_wpum_settings&option=mo_wpum_template';
	?>

	<div class="mo_wpum_table_layout">
		<?php if(!$mo_manager_utility->is_registered()) { ?>
					<div style="display:block;margin-top:10px;color:red;background-color:rgba(251, 232, 0, 0.15);padding:5px;border:solid 1px rgba(255, 0, 9, 0.36);">
							Please <a href="<?php echo add_query_arg( array('tab' => 'register'), $_SERVER['REQUEST_URI'] ); ?>">Register or Login with miniOrange</a> to enable WordPress User Manager.
					</div>
		<?php } ?>
		<h2>Customize Email Templates [Premium Feature]</h2><hr>
			<table id="email_template_table" class="display">
			<thead><tr><th width="30%">Sr. No.</th><th width="40%">Template</th><th width="30%">Actions</th></tr></thead>
			<tbody>
				<tr><td id="1" style="text-align:center;">1</td><td style="text-align:center;">User Registration Signup</td><td style="padding-left:70px;"><a disabled>Edit </a>&nbsp&nbsp
				<a disabled >Reset</a></td></tr>
				<tr><td id="2" style="text-align:center;">2</td><td style="text-align:center;">User Activation Link</td><td style="padding-left:70px;"><a disabled >Edit </a>&nbsp&nbsp
				<a disabled >Reset</a></td></tr>
				<tr><td id="3" style="text-align:center;">3</td><td style="text-align:center;">User Activation Confirmation(admin)</td><td style="padding-left:70px;"><a disabled>Edit </a>&nbsp&nbsp
				<a disabled >Reset</a></td></tr>
				<tr><td id="4" style="text-align:center;">4</td><td style="text-align:center;">User Forgot Password</td><td style="padding-left:70px;"><a disabled>Edit </a>&nbsp&nbsp
				<a disabled >Reset</a></td></tr>
				<tr><td id="5" style="text-align:center;">5</td><td style="text-align:center;">User Activation Confirmation(user)</td><td style="padding-left:70px;"><a disabled>Edit </a>&nbsp&nbsp
				<a disabled >Reset</a></td></tr>
				<tr><td id="6" style="text-align:center;">6</td><td style="text-align:center;">User Signup</td><td style="padding-left:70px;"><a disabled>Edit </a>&nbsp&nbsp
				<a disabled >Reset</a></td></tr>
			</tbody>
			</table>

		<script>
			jQuery(document).ready(function() {
				jQuery('#email_template_table').DataTable({
					"order": [[ 0, "asc" ]]
				});
			
			} );
		</script>
	</div>

	<?php
}

function mo_wpum_show_template($id)	{
	global $notification_actions,$wpdb,$sign_up_actions;
	$user_email = get_option('admin_email');
	$signup_id = $wpdb->get_var( $wpdb->prepare( "SELECT signup_id FROM {$wpdb->prefix}signups WHERE user_email = %s", $user_email ) );
		$default_template = new Mo_Wpum_Default_Template();
	$email_content = $wpdb->get_var($wpdb->prepare("SELECT content FROM {$wpdb->prefix}wpum_email_template WHERE id = %d",$id));
	if($email_content == FALSE){
		if($id == 1){
			$content = $default_template->admin_notification_body;
			$to_email = get_option('admin_email');
			$from_email = 'no-reply@xecurify.com';
			$subject = 'Miniorange User Manager';
		}elseif($id == 2){
			$content = $default_template->activation_email_body;
			$from_email = get_option('admin_email');
			$to_email = 'example@xyz.com';
			$subject = 'Miniorange User Manager';
		}elseif($id == 3){
			$content = $default_template->activation_confirmation;
			$to_email = get_option('admin_email');
			$from_email = 'no-reply@xecurify.com';
			$subject = 'Miniorange User Manager';
		}elseif($id == 4){
			$content = $default_template->lost_password;
			$subject = 'Password Reset';
		}elseif($id == 5){
			$content = $default_template->user_confirmation;
			$from_email = get_option('admin_email');
			$to_email = 'example@xyz.com';
			$subject = 'User activated on '.get_bloginfo();
		}elseif($id == 6){
			$content = $default_template->user_signup;
			$from_email = get_option('admin_email');
			$to_email = 'example@xyz.com';
			$subject = 'Account created on '.get_bloginfo();
		}
	}else { 
		$sql = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wpum_email_template WHERE id = %d",$id));
		$content = $sql->content;
		$from_email = $sql->from_email;
		$to_email = $sql->to_email;
		$subject = $sql->subject;
	}

	$editor_id = 'emailtemplate';
	?>
	<div class = "mo_wpum_table_layout"style = "margin-top:50px; margin-right:25px; width:75%">
	<form id="mo-wpum-email-template" name="mo-wpum-email-template" method="post" action="">
	<input type="button" name="Back Button" value="Back" style="float:right; margin-right:2%; margin-top: 10px;width:100px;" class="button button-primary button-large" onclick = "document.location.href='admin.php?page=mo_wpum_settings&tab=templates'"/>
	<input type="submit" name="Save Template" value="Save" style="float:right; margin-right:2%; margin-top: 10px;width:100px;" class="button button-primary button-large" />
		<input type="hidden" name="option" value="mo_wpum_template_save" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<div style="padding-top:20px;">
			<?php if(($id != 4) && ($id != 5) && ($id != 6)){ ?>
			<label for="email_template_from" style = "font-size:20px;padding-right:40px;"><?php _e('From:')?></label>	
			<input type="email" name="email_template_from" id="email_template_from" class="mo_wpum_table_textbox" style="width:30%;" placeholder = "person@xyz.com" value="<?php echo $from_email; ?>"/> <br><br>
			<label for="email_template_to" style = "font-size:20px;padding-right:65px;"><?php _e('To:')?></label>	
			<input type="email" name="email_template_to" id="email_template_to" class="mo_wpum_table_textbox" style="width:30%;" placeholder = "person@xyz.com" value="<?php echo $to_email;?>"/><br><br>
			<?php } ?>
			<label for="email_template_subject" style = "font-size:20px;padding-right:20px;"><?php _e('Subject:')?></label>
			<input type="text" name="email_template_subject" id="email_template_subject" class="mo_wpum_table_textbox" style="width:50%;" value="<?php echo $subject;?>"/>
		</div>
	<div style = "width:90%; padding-top:20px;">
		<label style = "font-size:20px"><?php _e('Email Template Content')?></label><br><br>
	<?php
	wp_editor( $content, 'mailTemplate', $settings = array('textarea_name'=>'mailTemplate','textarea_rows'=>15,'wpautop'=>false),
	$editor_id );
	?>
	</div>
	</form></div><?php
}

function mo_wpum_reset_template($id){ 
	$url = admin_url().'admin.php?page=mo_wpum_settings&tab=templates';
	?>
	<form name="template-deletion" method="post" action="<?php echo $url; ?>" id="template-deletion">
			<input type="hidden" name="option" value="template_deletion" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />

				<div>
					<h3>Reset Template</h3>
					Are you sure you want to Reset customized template to Default template?
					<p>
					Template : <?php if($id==1){ ?>
						<b>User Registration Signup </b>
				<?php	}elseif($id == 2){ ?>
						<b>User Activation Link </b>
				<?php	}elseif($id == 3){ ?>
						<b>User Activation Confirmation </b>
				<?php	}else{ ?>
						<b>User Forgot Password </b>
				<?php } ?>	
					<br><br><input type="submit" name="submit" id="submit" class="button button-primary" value="Reset to Default">
					</p>
				</div>
				</form>
				<?php exit;	
}
