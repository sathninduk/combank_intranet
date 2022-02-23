<?php

class Mo_Wpum_Custom_Fields_Actions{

	public function wpum_user_registration_errors($errors, $sanitized_user_login, $user_email){
		global $mo_manager_utility,$wpdb;
		if($mo_manager_utility->mo_check_empty_or_null( $_POST['pass_word'] ) || $mo_manager_utility->mo_check_empty_or_null( $_POST['cpass_word'] )){
			$errors->add( 'passerror', __( "All the fields are required. Please enter valid entries.") );
		}else{
			$password = sanitize_text_field( $_POST['pass_word'] );
			$confirm_password = sanitize_text_field( $_POST['cpass_word'] );
			$first_name ='';
			
			if(array_key_exists('first_name', $_POST))
			$first_name = sanitize_text_field( $_POST['first_name'] );
		
			if(strcmp( $password, $confirm_password) != 0){
				$errors->add( 'password_mismatch', __( "Passwords do not match" ) );	
			} elseif( strlen( $password ) < 6 || strlen( $confirm_password ) < 6){	
				$errors->add( 'password_mismatch', __( "Password must be atleast 6 characters" ) );
			}
		}
		
		if($mo_manager_utility->mo_check_empty_or_null(array_filter($errors->errors))){
			$userdata = array(
						'user_login' => $sanitized_user_login,
						'user_email' => $user_email,
						'user_pass'  => $password,
						);
			$user_id = wp_insert_user($userdata);
			$count = "SELECT id FROM {$wpdb->prefix}wpum_fields ORDER BY id DESC LIMIT 1";
			$sql = $wpdb->get_var($count);
			for($i = 1 ; $i <= $sql ; $i++){
				if(get_option('field'.$i) == 1){
					$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $i ));
					if( $field != NULL ){
						if( (($field->field_meta != NULL) || ($field->title != NULL)) && isset($_POST['field'.$i])) {
							update_user_meta($user_id, $field->field_meta, $_POST['field'.$i]);
						}
					}
				}
			}
			//$mo_manager_utility->send_registration_otp('EMAIL',$user_email,NULL);
			if (!isset($_SESSION))
				session_start();
			$_SESSION['login_message'] = "<p class='message register'>Your Account has been created successfully.</p>";
			auth_redirect();
		}else{
			return $errors;
		}
	}
	
	public function wpum_custom_profile_fields($user) {
		
		if(get_class($user)=="WP_User")
		  { $user_id= $user->ID; }
	    else $user_id= $user;
		global $wpdb;
		
		$user_meta = get_user_meta($user_id); 
		?>
			<table class="form-table">
				<tbody>
					<h2>Additional Information</h2>
					<?php
						$count = "SELECT id FROM {$wpdb->prefix}wpum_fields ORDER BY id DESC LIMIT 1";
						$sql = $wpdb->get_var($count);
						for($i = 1 ; $i <= $sql ; $i++)
						{
							$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $i ));
							if( $field != NULL)
							{
								if( $field->title != NULL)
								{ 
									if( ($field->field_meta != 'first_name') && ($field->field_meta != 'last_name') && ($field->field_meta != 'nickname') && ($field->field_meta != 'description') && ($field->field_meta != 'user_url'))
									{
										if(get_option('field'.$i) == 1)
										{
											$field_meta = $field->field_meta;
											if(($field->field_type == 'radio') || ($field->field_type == 'checkbox'))
											{
												$meta = get_user_meta($user_id,$field_meta);
											    $options = $field->options;
												$list = array();
												$list = array_map( 'trim', explode( ",", $options ) );
											    $count1 = count($list);
												
												?>
													<br><label for="field<?php echo $i ?>" ><font size="3.5"><b><?php echo $field->title ?></b> </label><br>
												<?php 
												for($l=0; $l<$count1; $l++)
												{  //var_dump($meta); exit;
											        if(empty($meta) || $meta[0]==null)
														{ 
															if($field->field_type == 'checkbox') 
															{ ?>
																<input type="<?php echo $field->field_type ?>" name="field<?php echo $i; ?>[]" id="field<?php echo $i; ?>" class="input" value="<?php echo $list[$l];?>"<?php echo "unchecked"; ?> style="width:15px;height:16px;margin-left:15%;" /><?php echo $list[$l];  	 
															     echo"<br>";
															}
															else
															{ ?>
															   <input type="<?php echo $field->field_type ?>" name="field<?php echo $i; ?>" id="field<?php echo $i; ?>" class="input" value="<?php echo $list[$l];?>"<?php checked("Default",$list[$l]); ?> style="width:15px;height:16px;margin-left:15%;" /><?php	echo $list[$l];  	 
																echo "<br>";
															}
														}
													else	
													{ 
														foreach($meta as $value)
													   { 
														$meta_value = maybe_unserialize($value);
													   
														if($field->field_type == 'checkbox')
															{ ?>  <?php if(!is_array($meta_value)){$val=$meta_value; $meta_value=array($val);}?>
															<input type="<?php echo $field->field_type ?>" name="field<?php echo $i ?>[]" id="field<?php echo $i ?>" class="input" value="<?php echo $list[$l];?>"<?php checked(in_array($list[$l],maybe_unserialize($meta_value))); ?> style="width:15px;height:16px;margin-left:15%;" /><?php	echo $list[$l]; 
															echo "<br>";
															} 
															else 
															{ ?>  <?php if(is_array($meta_value)) {$val=$meta_value[0]; $meta_value=$val;}?>
																
																<input type="<?php echo $field->field_type ?>" name="field<?php echo $i ?>" id="field<?php echo $i ?>" class="input" value="<?php echo $list[$l];?>"<?php checked($meta_value,$list[$l]); ?> style="width:15px;height:16px;margin-left:15%;" /><?php	echo $list[$l]; 
																echo "<br>";
															}
															
													   }
													}
												}	
											} 
											else
											{		
												$meta = get_user_meta($user_id,$field_meta);
												if(empty($meta) || $meta[0]==null)
												{?>		
													<br><label for="field<?php echo $i ?>"><font size="3.5"><b><?php echo $field->title ?></b></label>
													<input type="<?php echo $field->field_type ?>"name="field<?php echo $i ?>" id="field<?php echo $i ?>" class="input" value="" style="margin-left:11%;"  /><br><br>
												   <?php
														
												}
													
												else{	
												   foreach($meta as $value)
												   { 
													$meta_value = $value;
												 ?>		
													<br><label for="field<?php echo $i ?>"><font size="3.5"><b><?php echo $field->title ?></b></label>
													<input type="<?php echo $field->field_type ?>"name="field<?php echo $i ?>" id="field<?php echo $i ?>" class="input" value="<?php echo $meta_value ;  ?> " style="margin-left:11%;"  /><br><br>
												   <?php } 
												}
											} ?>	
										<?php 		
										
										}
									}
								}
							}
						}
					?>
				</tbody>
			</table>
		<?php
	}
 
	public function wpum_custom_profile_fields_update($user_id)
	{
		global $wpdb;
		$count = "SELECT id FROM {$wpdb->prefix}wpum_fields ORDER BY id DESC LIMIT 1";
		$sql = $wpdb->get_var($count);
		for($i = 1 ; $i <= $sql ; $i++){
			$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $i ));
			if( $field != NULL){
				if( $field->title != NULL ){
					if(( ($field->field_meta != 'first_name') && ($field->field_meta != 'last_name') && ($field->field_meta != 'nickname') && ($field->field_meta != 'description') && ($field->field_meta != 'user_url')) && isset($_POST['field'.$i])){
						if($field->field_type == 'radio' )
						{ 
							update_user_meta($user_id, $field->field_meta, $_POST['field'.$i]); 
						}
						else if($field->field_type == 'checkbox' )
						{  
							update_user_meta($user_id, $field->field_meta,maybe_serialize($_POST['field'.$i]) );
						}
						
						else
						{
							update_user_meta($user_id, $field->field_meta, $_POST['field'.$i]);
						}
					}
				}
			}
		} 
	} 
 } 

?>