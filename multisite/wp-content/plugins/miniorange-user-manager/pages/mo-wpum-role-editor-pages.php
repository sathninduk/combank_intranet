<?php
	function mo_wpum_show_edit_role_page($user_id){
		global $role_cap_actions,$mo_manager_utility;
		$editable_roles = get_editable_roles();
		$capabilities_list = $role_cap_actions->mo_wpum_get_capabilities_list();
		$user_data = get_userdata( $user_id );
		if(!empty($user_data)){
			$user_roles = $user_data->roles;
			$primary_role = !empty($user_roles) ? $user_roles[0] : NULL;
		}
		$help_url = admin_url('admin.php?page=mo_wpum_settings&tab=troubleshooting');
		$add_new_url = admin_url('users.php?page=mo_wpum_role_caps_settings');
		$userlist_url = admin_url('users.php');
		$disabled = !$mo_manager_utility->is_registered() ? 'disabled' : '';

		?>
		<div class="wrap">
			<h1>
				User Role Editor 
				<?php if ( current_user_can( 'wpum_add_role' ) ) : ?>
					<a class="add-new-h2" href="<?php echo $add_new_url ?>">Add New Role</a>
				<?php endif; ?> 
				<a class="add-new-h2" href="<?php echo $help_url ?>">Troubleshooting</a>
			</h1>
			<div id="mo_wpum_msgs" class="mo_wpum_msgs"></div>
			<div class="mo_wpum_table_layout1 mo_wpum_layout">
				<div class="mo_wpum_table_layout_container baner_text">
					USER : <a href="user-edit.php?user_id=<?php echo $user_data->ID; ?>"><?php echo $user_data->user_login; ?></a> ( <?php echo $user_data->user_email ?> ) 
					<a class="right" href="<?php echo $userlist_url ?>" >&#8592; Go Back</a>
				</div>
			</div>
			<div class="mo_wpum_table_layout1 left mo_wpum_layout left_div">
				<div class="mo_wpum_table_layout_header role_header header_background">Roles</div>
				<div class="mo_wpum_table_layout_container">

					<form name="f" method="post" action="">
						<input type="hidden" name="option" value="wpum_role_edit_settings" />
						<input type="hidden" name="user_id" value="<?php echo  $user_data->ID ?>">
						<?php wp_nonce_field( 'wpum_set_roles', '_wpum_roles_nonce' ); ?>
						<span class="subheading" style="">Primary Role:</span>
						<select name='wpum_role[]' required <?php echo $disabled ?>>
		  					<option disabled value="">-- Select Role --</option>
		  					<?php wp_dropdown_roles($primary_role); ?>
		  				</select>
		  				<span style="display:block;" class="subheading">Secondary Roles:</span>
		  					<div style="padding-left:3%;">
				  				<?php foreach ($editable_roles as $role_id => $role_info) : ?>
									<?php if(strcasecmp($primary_role,$role_id)!=0){ ?>
				  							<input type='checkbox' <?php echo $disabled; ?>	name ='wpum_role[]' value='<?php echo $role_id; ?>' <?php echo in_array($role_id, $user_roles) ? 'checked' : ''; ?>/>
				  								<?php echo $role_info['name']." ( ".$role_id." )"; ?><br/>
				  					<?php } ?>
								<?php endforeach; ?>
							</div>
						<br/>
						<div class="center">
							<input type="submit" name="submit" value="Update Roles" class="button button-primary button-large" <?php echo $disabled ?>/>
						</div>
					</form>
				</div>
			</div>
			<div class="mo_wpum_table_layout1 left right_div">
				<div class="mo_wpum_table_layout_header header_background">
					<div style="margin:10px;" class="left" >Capabilities</div>
					<div style="text-align:right"><input type="submit" name="submit" onclick='document.getElementById("cap_settings").submit()'
						 value="Save Capabilties" style="margin:5px;" class="button button-primary" <?php echo $disabled ?>/></div>
				</div>
				<div class="mo_wpum_table_layout_container">

					<form name="f" method="post" id="cap_settings" action="">
						<input type="hidden" name="option" value="wpum_cap_edit_settings" />
						<input type="hidden" name="user_id" value="<?php echo  $user_data->ID ?>">
						<?php wp_nonce_field( 'wpum_set_user_caps', '_wpum_caps_nonce' ); ?>
						<?php foreach ($capabilities_list as $key => $capability) : ?>
							<div class="capability">
								<input type='checkbox' <?php echo $disabled; ?>	name ='wpum_capability[]' <?php echo $role_cap_actions->mo_wpum_check_capability($capability,$user_data)?> 
								value='<?php echo $capability; ?>'/><?php echo $capability; ?>
				  			</div>
						<?php endforeach; ?>
					</form>
				</div>
			</div>
		</div>
	<?php
	}

	function mo_wpum_show_role_cap_edit_page(){
		global $role_cap_actions,$mo_manager_utility;
		$help_url = admin_url('admin.php?page=mo_wpum_settings&tab=troubleshooting');
		$capabilities_list = $role_cap_actions->mo_wpum_get_capabilities_list();
		$roles = get_editable_roles();
		$user_id = get_current_user_id();
		$default_role = get_option('default_role');
		$curr_role_id= array_key_exists('role_id',$_GET) && array_key_exists($_GET['role_id'],$roles) ? $_GET['role_id'] : 'administrator';
		$curr_role = $roles[$curr_role_id];
		$disabled = !$mo_manager_utility->is_registered() ? 'disabled' : '';
		$unused_roles = $role_cap_actions->mo_wpum_get_unused_roles();
		$custom_caps = $role_cap_actions->mo_wpum_get_user_defined_capabilities();
		$hidden = in_array($curr_role_id,array_keys($unused_roles)) ? '' : 'style="display: none;" ';
	?>
		<div class="wrap">
			<h1>User Role Editor <a class="add-new-h2" href="<?php echo $help_url ?>">Troubleshooting</a></h1>
			<div id="mo_wpum_msgs" class="mo_wpum_msgs"></div>
				<div class="mo_wpum_table_layout1 mo_wpum_layout">
					<div class="baner_text">
						<div style="margin:5px 0 0 10px;" class="left" >ROLE : <?php echo $curr_role['name']." ( ".$curr_role_id." )"; ?></div>
							<div style="text-align:right;">
								SELECT ROLE:&nbsp;
								<select name='wpum_role' id="wpum_role_edit_dropdown" required <?php echo $disabled ?>>
									<option selected disabled value="">-- Select Role --</option> 
									<?php wp_dropdown_roles($curr_role_id); ?>
								</select>	
							</div>
					</div>
				</div>
			<div class="mo_wpum_table_layout1 left left_div">
				<div class="mo_wpum_table_layout_header role_header header_background">Actions</div>
				<div class="mo_wpum_table_layout_container center">

					<input type="button" value="Add Role" data-action="add_role" class="overlay button button-primary wpum_action_btn" <?php echo $disabled ?>/>
					<input type="button" value="Delete Role" data-action="delete_role" class="overlay button button-primary wpum_action_btn" <?php echo $hidden.$disabled ?>/>
					<input type="button" value="Add Capability" data-action="add_cap" class="overlay button button-primary wpum_action_btn" <?php echo $disabled ?>/>
					<input type="button" value="Delete Capability" data-action="delete_cap" class="overlay button button-primary wpum_action_btn" <?php echo $disabled ?>/>
					<input type="button" value="Change Default Role" data-action="change_default" class="overlay button button-primary wpum_action_btn" <?php echo $disabled ?>/>
					<input type="button" value="Rename Role" data-action="rename_role" class="overlay button button-primary wpum_action_btn" <?php echo $disabled ?>/>
				</div>
			</div>
			<div class="mo_wpum_table_layout1 left mo_wpum_layout right_div">
				<div class="mo_wpum_table_layout_header header_background">
					<div style="margin:10px;" class="left" >Role Capabilities</div>
					<div style="text-align:right"><input type="submit" name="submit" onclick='document.getElementById("role_cap_settings").submit()'
						 value="Save Capabilties" style="margin:5px;" class="button button-primary" <?php echo $disabled ?>/></div>
				</div>
				<div class="mo_wpum_table_layout_container">

					<form name="f" method="post" id="role_cap_settings" action="">
						<input type="hidden" name="option" value="wpum_role_cap_edit_settings" />
						<input type="hidden" name="role_id" value="<?php echo  $curr_role_id ?>">
						<input type="hidden" name="user_id" value="<?php echo  $user_id ?>">
						<?php wp_nonce_field( 'wpum_set_roles_caps', '_wpum_roles_caps_nonce' ); ?>
						<?php foreach ($capabilities_list as $key => $capability) : ?>
							<div class="capability">
								<input type='checkbox' <?php echo $disabled; ?>	name ='wpum_capability[]' <?php echo $role_cap_actions->mo_wpum_check_capability_roles($capability,(array)$curr_role_id)?> 
								value='<?php echo $capability; ?>'/><?php echo $capability; ?>
				  			</div>
						<?php endforeach; ?>
					</form>
				</div>
			</div>
		</div>
		<div hidden class="wpum_modal_background"></div>

		<div hidden id="add_role" class="wpum_modal">
			<div class="wpum_modal_dialog">
	            <div class="wpum_modal_header">
	                <span class="close">Close</span>
	                <span class="baner_text">ADD NEW ROLE</span>
	            </div>
	            <form name="f" method="post" action="">
	                <input type="hidden" name="option" value="wpum_add_role">
	                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
	                <?php wp_nonce_field( 'wpum_add_roles_caps', '_wpum_add_role_nonce' ); ?>
	                <div class="wpum_modal_body">
	                	<table class="mo_wpum_display_table">
	                		<tr>
	                			<td> <label class="wpum_control_label">Role ID:</label> </td>
	                			<td> <input type="text" class="mo-form-control" id="wpum_role_id" name="wpum_role_id" autocomplete="off"> </td>
	                		</tr>
	                		<tr>
	                			<td> <label class="wpum_control_label">Role name (Display Name):</label> </td>
	                			<td> <input type="text" class="mo-form-control" name="wpum_role_name" autocomplete="off"> </td>
	                		</tr>
	                		<tr>
	                			<td> <label class="wpum_control_label">Copy Capabilities From:</label> </td>
	                			<td>
	                				 <select class="mo-form-control" name='wpum_role' id="wpum_role_edit_dropdown" required <?php echo $disabled ?>>
							  			<option selected value="none">None</option> 
										<?php wp_dropdown_roles(); ?>
									</select>
	                			</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary">Add Role</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
	            </form>
	   		</div>
	   	</div>

	   	<div hidden id="delete_role" class="wpum_modal">
			<div class="wpum_modal_dialog">
	            <div class="wpum_modal_header">
	                <span class="close">Close</span>
	                <span class="baner_text">DELETE ROLE</span>
	            </div>
	            <form name="f" method="post" action="">
	                <input type="hidden" name="option" value="wpum_delete_role">
	                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
	                <?php wp_nonce_field( 'wpum_delete_roles_caps', '_wpum_delete_role_nonce' ); ?>
	                <div class="wpum_modal_body">
	                	( You can only delete roles that are not in use )
	                	<table class="mo_wpum_display_table">
	                		<tr>
	                			<td> <label class="wpum_control_label">Select Role to delete:</label> </td>
	                			<td>  
	                				<select class="mo-form-control" name='wpum_role' id="wpum_delete_role_dropdown" required <?php echo $disabled ?>>
		                				<?php foreach ($unused_roles as $key => $value) : ?>
											<option value="<?php echo $key; ?>"><?php echo $value." ( ".$key." )"; ?></option> 
										<?php endforeach; ?>
									</select>
	                			</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary">Delete Role</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
	            </form>
	   		</div>
	   	</div>


	   	<div hidden id="default_role" class="wpum_modal">
			<div class="wpum_modal_dialog">
	            <div class="wpum_modal_header">
	                <span class="close">Close</span>
	                <span class="baner_text">CHANGE DEFAULT ROLE</span>
	            </div>
	            <form name="f" method="post" action="">
	                <input type="hidden" name="option" value="wpum_change_default_role">
	                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
	                <?php wp_nonce_field( 'wpum_default_roles_caps', '_wpum_default_role_nonce' ); ?>
	                <div class="wpum_modal_body">
	                	<table class="mo_wpum_display_table">
	                		<tr>
	                			<td> <label class="wpum_control_label">Select Default Role:</label> </td>
	                			<td>  
	                				<select class="mo-form-control" name='wpum_role' id="wpum_default_role_dropdown" required <?php echo $disabled ?>>
										<?php wp_dropdown_roles($default_role); ?>
									</select>
	                			</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary">change Default</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
	            </form>
	   		</div>
	   	</div>


	   	<div hidden id="add_cap" class="wpum_modal">
			<div class="wpum_modal_dialog">
	            <div class="wpum_modal_header">
	                <span class="close">Close</span>
	                <span class="baner_text">ADD CAPABILITY</span>
	            </div>
	            <form name="f" method="post" action="">
	                <input type="hidden" name="option" value="wpum_add_cap">
	                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
	                <?php wp_nonce_field( 'wpum_add_caps', '_wpum_add_cap_nonce' ); ?>
	                <div class="wpum_modal_body">
	                	<table class="mo_wpum_display_table">
	                		<tr>
	                			<td> <label class="wpum_control_label">Capability Name:</label> </td>
	                			<td> <input type="text" class="mo-form-control" id="wpum_cap_name" name="wpum_cap_name" autocomplete="off"> </td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary">Add Capability</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
	            </form>
	   		</div>
	   	</div>


	   	<div hidden id="delete_cap" class="wpum_modal">
			<div class="wpum_modal_dialog">
	            <div class="wpum_modal_header">
	                <span class="close">Close</span>
	                <span class="baner_text">DELETE CAPABILITY</span>
	            </div>
	            <form name="f" method="post" action="">
	                <input type="hidden" name="option" value="wpum_delete_cap">
	                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
	                <?php wp_nonce_field( 'wpum_delete_caps', '_wpum_delete_cap_nonce' ); ?>
	                <div class="wpum_modal_body">
	                	<table class="mo_wpum_display_table">
	                		<tr>
	                			<td> <label class="wpum_control_label">Select capability to delete:</label> </td>
	                			<td>
	                				<?php if(!empty($custom_caps)){?>
	                				<select class="mo-form-control" name='wpum_cap' id="wpum_cap_dropdown" required <?php echo $disabled ?>>
		                				<?php foreach ($custom_caps as $cap) : ?>
											<option value="<?php echo $cap; ?>"><?php echo $cap; ?></option> 
										<?php endforeach; ?>
									</select>
									<?php }else{?>
										<label class="wpum_control_label">No custom Capability has been set.</label>
									<?php }?>
	                			</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary">Delete Capability</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
	            </form>
	   		</div>
	   	</div>


	   	<div hidden id="rename_role" class="wpum_modal">
			<div class="wpum_modal_dialog">
	            <div class="wpum_modal_header">
	                <span class="close">Close</span>
	                <span class="baner_text">Rename Role</span>
	            </div>
	            <form name="f" method="post" action="">
	                <input type="hidden" name="option" value="wpum_rename_role">
	                <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
	                <input type="hidden" name="role_id" value="<?php echo $curr_role_id ?>">
	                <?php wp_nonce_field( 'wpum_rename_role_caps', '_wpum_rename_role_nonce' ); ?>
	                <div class="wpum_modal_body">
	                	<table class="mo_wpum_display_table">
	                		<tr>
	                			<td> <label class="wpum_control_label">Role ID:</label> </td>
	                			<td> <label class="wpum_control_label"> <?php echo $curr_role_id; ?></label> </td>
	                		</tr>
	                		<tr>
	                			<td> <label class="wpum_control_label">Role Name:</label> </td>
	                			<td><input type="text" class="mo-form-control" value="<?php echo $curr_role['name']; ?>" name="wpum_role_name" autocomplete="off"> </td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary">Rename Role</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
	            </form>
	   		</div>
	   	</div>
	<?php
	}

	function mo_wpum_signup_filter_view( $views = array() ) {
		global $role, $user_list,$db_queries;
		if ( 'registered' === $role ) {
			$views['all'] = str_replace( 'class="current"', '', $views['all'] );
			$class        = 'current';
		} else {
			$class        = '';
		}
		
		$signups = $db_queries->signup_count();
		$base_url = admin_url( 'users.php' );
		$url     = add_query_arg( 'page', 'mo_wpum_user_signups', $base_url );
		$text    = 'Pending <span class="count">(' . number_format_i18n( $signups ) . ')</span>';
		$views['registered'] = '<a href="'.esc_url( $url ).'" class="'.$class.'">'.$text.'</a>';
		return $views;
	}