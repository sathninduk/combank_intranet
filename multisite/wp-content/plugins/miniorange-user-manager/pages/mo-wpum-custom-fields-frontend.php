<?php
function mo_register_form()
{ 
	global $wpdb;
	?>
	<p>
        <label for="pass_word">Password<br />
            <input type="password" name="pass_word" placeholder="Min. 6 characters"id="pass_word" class="input" value="" size="25" /></label><br />
		<label for="cpass_word">Confirm Password<br />
            <input type="password" name="cpass_word" id="cpass_word" class="input" value="" size="25" /></label>
		<?php			
			$count = "SELECT COUNT(id) FROM {$wpdb->prefix}wpum_fields";
			$sql = $wpdb->get_var($count);
			for($i = 1 ; $i <= $sql ; $i++)
			{
				$field = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpum_fields WHERE id LIKE %d", $i ));
				if( $field->title != NULL)
				{
					if(get_option('field'.$i) == 1)
					{
						if(($field->field_type == 'radio') || ($field->field_type == 'checkbox'))
						{
							$options = $field->options;
							$list = array();
							$list = array_map( 'trim', explode( ",", $options ) );
							$count1 = count($list);
							
							?>
								<label for="field<?php echo $i ?>"><?php echo $field->title ?><br /> </label>
							<?php
							
								if($field->field_type=='radio')
								{
									for($l=0; $l<$count1; $l++)
									{ ?>
										<input type="<?php echo $field->field_type ?>" name="field<?php echo $i ?>"  id="field<?php echo $i ?>" class="input" value="<?php echo $list[$l]; ?>"<?php echo checked("Default",$list[$l]);?> style=<?php if($field->field_type == 'radio'){ ?> width:15px;height:16px;<?php } ?>"  /><?php	echo $list[$l]; ?> <br>
										
										<?php
									}
									
								 }	
								 
								if($field->field_type=='checkbox')
								{
									for($l=0; $l<$count1; $l++)
									{  ?>
									   <input type="<?php echo $field->field_type ?>" name="field<?php echo $i ?>[]" id="field<?php echo $i ?>" class="input" value="<?php echo $list[$l]; ?>" style=<?php if($field->field_type == 'checkbox'){ ?> width:15px;height:16px;<?php } ?>"   /><?php	echo $list[$l]; ?> <br>	
									<?php
									}
								}
								
							
						}
						else
						{
							?>
								<label for="field<?php echo $i ?>"><?php echo $field->title; ?> <br/> </label>
								 
								<input type="<?php echo $field->field_type ?>" name="field<?php echo $i ?>" id="field<?php echo $i ?>" class="input" value="" style=""  /></label>
							<?php
							
						} 
					}
				}
			}
		
	echo "</p>";
		
	return ;
}
?>
