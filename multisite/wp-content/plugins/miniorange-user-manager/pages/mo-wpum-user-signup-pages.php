<?php
	function mo_wpum_show_user_signups_page(){
		global $user_list;
		global $mo_manager_utility;
		$curr_url = $mo_manager_utility->getCurPageUrl();
		if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "activate" ){
			 if(is_string($_REQUEST['signup_id']))
		     {  $data=array($_REQUEST['signup_id']);
		       
	            mo_wpum_show_activate_confirmation_page($data);
		      }
			  else{
			mo_wpum_show_activate_confirmation_page($_REQUEST['signup_id']);
	    	}
		}
		elseif( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "delete" ){
			
		        if(is_string($_REQUEST['signup_id']))
		     {  $data=array($_REQUEST['signup_id']);
		       
	            mo_wpum_show_delete_confirmation_page($data);
		      }
	             else{  mo_wpum_show_delete_confirmation_page($_REQUEST['signup_id']);
	         	}
		}
		
		elseif( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "resend" ){
			
			 if(is_string($_REQUEST['signup_id']))
		     {  $data=array($_REQUEST['signup_id']);
		 
	            mo_wpum_show_email_activation_confirm_page($data);
		      }
			  else{	mo_wpum_show_email_activation_confirm_page($_REQUEST['signup_id']);
			  }
		}
		?>
		<div class="wrap">
			<h1>
				Users 
				<?php if ( current_user_can( 'create_users' ) ) : ?>
					<a href="user-new.php" class="add-new-h2">Add New</a>
				<?php endif; ?>
				<?php if (!empty($_REQUEST['s'])) : ?>
					<span class="subtitle"><?php printf('Search results for "%s"', stripslashes($_REQUEST['s']) ); ?></span>
				<?php endif; ?>
			</h1>

			<?php $user_list->prepare_items(); ?>
			
			<?php $user_list->views(); ?>
			<form name="f" method="post" action="<?php echo $curr_url; ?>">
				<input type="hidden" name="page" value="wpum-signup" />
				<?php $user_list->search_box('Search Pending Users', 'wpum_search'); ?>
				<?php $user_list->display();  ?>
			</form>
			
			<div id="mo_wpum_msgs" class="mo_wpum_msgs"></div>
		</div>
		
	<?php
	}

	function mo_wpum_signup_screen_options(){
		global $user_list;		
		add_screen_option( 'per_page', array( 'label' => 'Pending Accounts', 'default' => 10, 'option' => 'wpum_signups_per_page' ) );
		get_current_screen()->add_help_tab( array(
			'id'      => 'mo_wpum_user_signups',
			'title'   => 'Overview',
			'content' =>
			'<p>This screen lists all the pending accounts on your site.' .
			' You can reorder the list of your pending accounts by clicking on the Username, Email or Registered column headers.' .
			' Using the search form, you can find pending accounts more easily. The Username and Email fields will be included in the search.</p>'
		) );

		get_current_screen()->add_help_tab( array(
			'id'      => 'wpum_signups_actions',
			'title'   => 'Actions',
			'content' =>
			'<p>Hovering over a row in the pending accounts list will display action links that allow you to manage pending accounts. You can perform the following actions:</p>' .
			'<ul><li>"Email" sends the activation link to the desired pending account.</li>' .
			'<li>"Delete" allows you to delete a pending account from your site.</li>' .
			'<li>"Activate" allows you to activate a pending account'. '</li></ul>' .
			'<p>Bulk actions allow you to perform the above 3 actions for the selected rows.</p>'
		) );
		get_current_screen()->set_help_sidebar(
			'<p><strong> For more information: </strong></p>' .
			'<p><a href="#">Troubleshoot</a></p>'
		);
		$user_list = new Mo_User_List();
	}
	
	function mo_wpum_show_activate_confirmation_page($signup_ids){ 
		global $wpdb, $db_queries; 
		$url = admin_url().'users.php';
		?>
		
		<form name="confirm-activation" method="post" action="<?php echo $url; ?>" id="confirm-activation">
		<input type="hidden" name="option" value="confirm_activation" />
			<div>
				<h3>Activate Users</h3>
				Are you sure you want to activate user?
				<p><?php
			 foreach($signup_ids as $signup_id)
			{
		$signup_user_detail = $db_queries->get_customer_signup_detail( $signup_id );
		$user_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->users} WHERE user_login LIKE %s", $wpdb->esc_like($signup_user_detail->user_login) ) );
		$user_login = $signup_user_detail->user_login;
		?>
				
				ID #<?php echo $user_id; ?>: <?php echo $user_login; ?><br>
				<input type="hidden" name="signup_id[]" value="<?php echo $signup_id; ?>">
				<input type="hidden" name="user_id[]" value="<?php echo $user_id; ?>">
				<?php }?>
				<br><br><input type="submit" name="submit" id="submit" class="button button-primary" value="Confirm Activation">
				</p>
			</div>
			</form>
			<?php exit;
	}
	
	function mo_wpum_show_delete_confirmation_page($signup_ids){
		global $wpdb, $db_queries;
		$url = admin_url().'users.php?page=mo_wpum_user_signups';
		?>
		
		 <form name="confirm-deletion" method="post" action="<?php echo $url; ?>" id="confirm-deletion">
		 <input type="hidden" name="option" value="confirm_delete" />
			<div>
				<h3>Delete User</h3>
				Are you sure you want to delete user? 
			<?php
			 foreach($signup_ids as $signup_id)
			{
				
				
			 
				$signup_user_detail = $db_queries->get_customer_signup_detail( $signup_id );

				$user_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->users} WHERE user_login LIKE %s", $wpdb->esc_like($signup_user_detail->user_login) ) );
				$user_login = $signup_user_detail->user_login; 
				
			?>	
				<p>
					ID #<?php echo $user_id; ?>: <?php echo $user_login; ?>  
					<input type="hidden" name="signup_id[]" value="<?php echo $signup_id; ?>">
					<input type="hidden" name="user_id[]" value="<?php echo $user_id; ?>"> 
			<?php }?>
				<br><br><input type="submit" name="submit" id="submit" class="button button-primary" value="Confirm Deletion">
				</p>
			</div>
			</form>
	<?php exit;
	
	}
	
	function mo_wpum_show_email_activation_confirm_page($signup_ids){
		global $wpdb, $db_queries;
		$url = admin_url().'users.php?page=mo_wpum_user_signups';
		?>
		
		<form name="confirm-mail-activate" method="post" action="<?php echo $url; ?>" id="send-activation-mail">
			<input type="hidden" name="option" value="send_activation_mail" />
			<div>
				<h3>Mail To User</h3>
				Are you sure you want to send activation link to user?
				<p>
				<?php
			 foreach($signup_ids as $signup_id)
			{ 
		$signup_user_detail = $db_queries->get_customer_signup_detail( $signup_id );
		$user_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->users} WHERE user_login LIKE %s", $wpdb->esc_like($signup_user_detail->user_login) ) );
		$user_login = $signup_user_detail->user_login;
		?>
				ID #<?php echo $user_id; ?>: <?php echo $user_login; ?> <br>
				<input type="hidden" name="signup_id[]" value="<?php echo $signup_id; ?>">
				<input type="hidden" name="user_id[]" value="<?php echo $user_id; ?>">
				<?php }?>
				<br><br><input type="submit" name="submit" id="submit" class="button button-primary" value="Send Email">
				</p>
			</div>
		</form>
		<?php exit;
	}
	
?>