<?php
function mo_wpum_show_field_settings()	{
	global $mo_manager_utility,$wpdb;
	$current_site = get_site_url();
	$url = $current_site.'/wp-admin/users.php?page=mo_wpum_settings&option=mo_wpum_field';
	$current_site = get_site_url();
	$current_user = wp_get_current_user();
	$wpum_meta = get_user_meta($current_user->ID);
	
	?>
		<div class="mo_wpum_table_layout">
			<?php
				if(!$mo_manager_utility->is_registered()) {
					?>
						<div style="display:block;margin-top:10px;color:red;background-color:rgba(251, 232, 0, 0.15);padding:5px;border:solid 1px rgba(255, 0, 9, 0.36);">
							Please <a href="<?php echo add_query_arg( array('tab' => 'register'), $_SERVER['REQUEST_URI'] ); ?>">Register or Login with miniOrange</a> to enable WordPress User Manager.
						</div>
					<?php
				}
			?>
			<form id="mo-wpum-fields-enable" name="mo-wpum-fields-enable" method="post" action="">
					<input type="hidden" name="option" value="mo_wpum_fields_save_enable" /> 
					<div style="display:block;margin-top:10px;padding:5px;">
					<h3>Registration Fields</h3>
					<h4>Select the fields you would like to add in your default WordPress registration form.</h4>

						<input type="submit" name="submit" value="Save" style="float:right; margin-right:2%; margin-top: -5%; width:100px;" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> class="button button-primary button-large" />
						<input type="button" name="add_field" data-action="add_field"  value="Add Field" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> class="overlay button button-primary button-large" style="margin-top:-5%; margin-left:72%;"/>
						<table id="field_customization_table" class="display" style="margin-top: 10px;">
							<thead><tr><th width="15%">Enable</th><th width="25%">Fields</th><th width="30%">Field Type</th><th width="60%">Actions</th></tr></thead>
								<tbody>
									<?php
										$count = "SELECT COUNT(id) FROM {$wpdb->prefix}wpum_fields";
										$sql = $wpdb->get_var($count);
										for($i = 1 ; $i <= $sql ; $i++) { 
											$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $i ));
											if($field->title != NULL) {
												?>
													<tr><td id="<?php echo $i ?>" style="text-align:center;"><input type="checkbox" id="field<?php echo $i?>" name="field<?php echo $i ?>" <?php if(!$mo_manager_utility->is_registered()) echo 'disabled'?> value="1" <?php checked( get_option('field'.$i) == 1 );?>></td><td style="text-align:center;"><?php echo $field->title ?></td><td style="text-align:center;"><?php echo $field->field_type ?></td><td style="padding-left:initial; text-align:center;"><a href=" <?php if($mo_manager_utility->is_registered())echo 'admin.php?page=mo_wpum_settings&option=mo_wpum_field_edit&id='.$i ; ?> ">Edit </a>&nbsp&nbsp
													<a onClick="<?php if($mo_manager_utility->is_registered()) ?> return confirm('Delete <?php echo $field->title; ?> field?')" <?php ?> href="<?php if($mo_manager_utility->is_registered())echo 'admin.php?page=mo_wpum_settings&option=mo_wpum_field_delete&id='.$i; ?>" >Delete</a></td></tr>
												<?php
											}	
										}
									?>
								</tbody>	
						</table>
					</div>				
			</form>	
			<script>
				jQuery(document).ready(function() {
					jQuery('#field_customization_table').DataTable({
						"order": [[ 0, "desc" ]]
					});
				
				} );
			</script>
		</div>
		
		<div hidden class="wpum_modal_background"></div>
			<div hidden id="add_field" class="wpum_modal">
				<div class="wpum_modal_dialog">
					<div class="wpum_modal_header">
						<span class="close">Close</span>
						<span class="baner_text">Add Field</span>
					</div>
					<script>
		
					function EForm() {
						var x = document.forms["f"]["field_key"].value;
						var y = document.forms["f"]["field_custom_meta"].value;
	
						if (x == "*" && y == "") {
							alert("One of the meta data field must be filled out");
							return false;
						}
	
						if(document.f.field_type[1].checked || document.f.field_type[3].checked)
						{ var z = document.forms["f"]["field_option"].value;
							if(z.length < 1)
							{ alert("Please enter options.");
							  return false;
							}
						}
					}
					</script>
					<form name="f" method="post" action=""  >
						<input type="hidden" name="option" value="mo_wpum_field_save" />
						<div class="wpum_modal_body">
	                	<table class="mo_wpum_display_table">
	                		<tr>
								<td>
									<b>Field Label: </b>
									<input type="textbox" id="field_label" name="field_label" required style="margin-top:20px; margin-left:10px;" placeholder="" /><br><br><br>
								</td>
							</tr>
							<tr>
								<td>
									<b>Choose Meta Field: </b>
									<select name="field_key" id="field_key">
										<option value="*">
											<?php _e('Choose a meta key'); ?> 
										</option>
										
										<optgroup>
											<?php
												if($wpum_meta){
													ksort($wpum_meta); 
														
													foreach($wpum_meta as $user_meta => $array){
														?>
															<option value="<?php echo $user_meta; ?>">
																<?php echo $user_meta; ?>
															</option>
														<?php
														}	

												}
												
											?>
										</optgroup>
									</select> 
									
									<br>
									<b>Create a Custom Meta Field: </b>
									<input type="textbox" id="field_custom_meta" name="field_custom_meta"  style="margin-top:20px; margin-left:10px;" placeholder=""  />
								</td>
							</tr>
							<tr>
								<td><br><br>
									<b>Select the type of field: </b>
									<input type="radio" id="field_type" name="field_type"  value="textbox" style="margin-left:31px;"<?php checked( get_option('field_type') == 'textbox' );?>/>Textbox <br><br>	
									<input type="radio" id="field_type" name="field_type" value="radio" style="margin-left:173px;"<?php checked( get_option('field_type') == 'radio' );?> />Radio <br><br>	
									<input type="radio" id="field_type" name="field_type" value="textarea" style="margin-left:173px;"<?php checked( get_option('field_type') == 'textarea' );?> />Text Area <br><br>	
									<input type="radio" id="field_type" name="field_type" value="checkbox" style="margin-left:173px;"<?php checked( get_option('field_type') == 'checkbox' );?> />Checkbox <br><br>	<br>
									
									
								</td>
							</tr>
							<tr>
								<td>
									<b>Field Option: </b>
									<input type="textbox" style="width:70%" name="field_option" id="field_option" style="margin-left:10px;" placeholder="comma(,) separated Radio/checkbox options" /><br>
							</td>
							</tr>
							<tr>
								<td>
									<font size="2.0" face='Sans'>(Above field is only required if you have selected field type as radio button/checkbox, to mention names of different options)
								</td>
							</tr>
	                	</table>
	                </div>
	                <div class="wpum_modal_footer">
	                	<button type="submit" class="button button-primary" onclick="return EForm()" >Add Field</button>
	                    <button type="button" class="cancel button button-primary">Cancel</button>
	                </div>
					</form>
				</div>
			</div>
	<?php
}


function mo_wpum_edit_field_pages($id){
	global $wpdb;
	$current_site = get_site_url();
	$url = $current_site.'/wp-admin/users.php?page=mo_wpum_settings&tab=fields';
	$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $id ));
	$options=$field->options; 
	$current_user = wp_get_current_user();
	$wpum_meta = get_user_meta($current_user->ID);
	?>
		<div class = "mo_wpum_table_layout"style = "margin-top:50px; margin-right:25px; width:75%">
		    <script>
		
					function VForm() {
						var x = document.forms["mo-wpum-field"]["field_key"].value;
						
						if (x == "*") {
							alert("Please choose the meta data value.");
							return false;
						}
						
						if(document.forms["mo-wpum-field"]["field_type"][1].checked || document.forms["mo-wpum-field"]["field_type"][3].checked)
						{ 	var z = document.forms["mo-wpum-field"]["field_option"].value;
							
							if(z.length < 1)
							{ alert("Please enter options.");
							  return false;
							}
						}
					}
					</script>
			<form id="mo-wpum-field" name="mo-wpum-field" method="post" action="<?php echo $url?>" onsubmit="return VForm()">
				<input type="button" name="Back Button" value="Back" style="float:right; margin-right:2%; margin-top: 10px;width:100px;" class="button button-primary button-large" onclick = "document.location.href='admin.php?page=mo_wpum_settings&tab=fields'"/>
				<input type="submit" name="Save Field" value="Save" style="float:right; margin-right:2%; margin-top: 10px;width:100px;" class="button button-primary button-large" />				
				<input type="hidden" name="option" value="mo_wpum_field_edit"/>
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<label for="field_label"><b>Field Label</b><span class="required">*</span><b>&nbsp: </b></label>
				<input type="textbox" id="field_label" name="field_label" style="margin-top:20px; margin-left:10px;" value="<?php echo $field->title ?>" /><br><br><br>
				<label for="field_key"><b>Choose Meta Field :</b></label>
				
				<select name="field_key" id="field_key" value="<?php echo $field->field_meta ?>"  style="margin-top:3px; margin-left:10px;">
					<option value="*">
						<?php _e('Choose a meta key'); ?> 
					</option>
					<optgroup>
						<?php
							if($wpum_meta){
								ksort($wpum_meta);
								foreach($wpum_meta as $user_meta => $array){
									 if($field->field_meta == $user_meta){
										 ?>
										<option value="<?php  echo $user_meta; ?>"selected>
											<?php echo $user_meta; ?>
										</option>
									<?php
									 }
									 else {?><option value="<?php  echo $user_meta; ?>">
											<?php echo $user_meta; ?>
										</option>
										<?php
										}
									}
							}
						?>
					</optgroup>
				</select>
				<br><br><br>
				<label for="field_type"><b>Select the type of field :</b></label>
				<input type="radio" id="field_type" name="field_type" value="textbox" style="margin-left:28px;"<?php checked( get_option('field_type') == 'textbox' );?>/>Textbox <br><br>	
				<input type="radio" id="field_type" name="field_type" value="radio" style="margin-left:173px;"<?php checked( get_option('field_type') == 'radio' );?> />Radio <br><br>	
				<input type="radio" id="field_type" name="field_type" value="textarea" style="margin-left:173px;"<?php checked( get_option('field_type') == 'textarea' );?> />Text Area <br><br>	
				<input type="radio" id="field_type" name="field_type" value="checkbox" style="margin-left:173px;"<?php checked( get_option('field_type') == 'checkbox' );?> />Checkbox <br><br>	<br>
				<label for="field_option"><b>Field option :</b></label>
				<input type="textbox" name="field_option" id="field_option" value="<?php echo $options;?>" style="margin-left:10px;" /><br>
				<font size="2.0" face='Sans'>(Above field is only required if you have selected field type as radio button for to mention names of different option.)<br>
			
			<font size="2.5" face='Sans'><b>NOTE:</b> &nbsp Separate the names of Radio button/Checkbox mentioned in field options with a comma( , ).
			</form>	
		</div>
<?php	
}