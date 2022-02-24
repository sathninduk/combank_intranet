<?php
add_action('admin_footer','barfw_scheduled_backup');
// mo_wpns_schedule_setting_layout
?>
<div id="wpns_backup_message2" ></div>
<div class="mo_wpns_divided_layout">
	<div class="mo_wpns_setting_layout">
	<br>
	<table class="mo_wpns_settings_table font_class">
		<tr>
			<th>Scheduled file backup </th>
			<th>Scheduled database backup </th>
		</tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			
             <td><b>Scheduled Status :</b><?php 
             if(get_site_option('scheduled_file_backup')){ 
				 ?><span class="mo_green" >Enabled</span><?php
				  }  else{
				  ?><span class="mo_green">Disabled</span><?php
				   } 
			?></td>
			<td><b>Scheduled Status :</b><?php 
			if(get_site_option('scheduled_db_backup')){ 
				?><span class="mo_green" >Enabled</span><?php
				 }  else{
				  ?><span class="mo_green">Disabled</span>
				<?php }
			 ?></td>

		</tr>
		
		<tr>
			<td><b>Last Backup :</b><?php 
			if($file_backup_time !== 0) echo $file_backup_time ; 
			?></td>	
			<td><b>Last Backup :</b><?php 
			if($db_eb_backup_time !== 0) echo $db_eb_backup_time ; 
			?></td>

		</tr>
		<tr>
			<td><b>Next Backup :</b><?php
			 if($file_schedule_status == 0){ echo 'N/A';
			    }  else{ echo $file_day.' '.$file_date.' '.$file_time ; 
			 }
		     ?></td>
			<td><b>Next Backup :</b>
				<?php if($db_backup_status == 0){ echo 'N/A';
			}  else{ echo $db_day.' '.$db_date.' '.$db_time ; 
				 } 
			?></td>

		</tr>
	</table>
	
</div>
<div class="mo_wpns_setting_layout text_size" >

	<form id="" method="post" action="">
		<br>
		    <p class="text_size"><b>To automatically create a backup select the following option and save the settings</b></p>
			<input type="checkbox" name="enable_backup_schedule" id="enable_backup_schedule" value="1"<?php checked(get_site_option('enable_backup_schedule') == 1);?>> Enable Backup Schedule<br><br>

	<br>
	     <p class="text_size"><b>Create a backup after every</b></p>
		    <table class="mo_wpns_settings_table " >
		    	<tr>
		    		<td>
		    			<input type="radio"  name="backup_time" value="12" id="hours"<?php checked(get_site_option('mo_wpns_backup_time') === '12')?>>12 Hours 
		    		</td>
		    		<td>	
						<input type="radio" name="backup_time" value="24" id="daily"<?php checked(get_site_option('mo_wpns_backup_time') === '24')?>> Day
					</td>
					<td>	
						<input type="radio" name="backup_time" value="168" id="weekly"<?php checked(get_site_option('mo_wpns_backup_time') === '168')?>>Week
					</td>
				 </tr>
				 <tr>
				  <td>	
						<input type="radio" name="backup_time" value="360" id="fortnight"<?php checked(get_site_option('mo_wpns_backup_time') === '360')?>> Fortnight
				</td>
				<td>		
						<input type="radio" name="backup_time" value="720" id="month"<?php checked(get_site_option('mo_wpns_backup_time') === '720')?>> Month 
		    	</td>
		    	</tr>
		    </table>	    
	   <br>
	   <p class="text_size"><b>Choose the following folder to backup</b></p>
		    <table class="mo_wpns_settings_table ">
		    	<tr>
		    		<td>
						<input type="checkbox" name="mo_schedule_file_backup_plugins" id="mo_schedule_plugins"  value="1"<?php checked(get_site_option('mo_file_backup_plugins') == 1);?>> WordPress Plugins folder
					</td>
					<td>	
						<input type="checkbox" name="mo_schedule_file_backup_themes" id="mo_schedule_themes" value="1"<?php checked(get_site_option('mo_file_backup_themes') == 1);?>> WordPress Themes folder
                    </td>
                </tr>
                <tr>
                    <td>    
						<input type="checkbox" name="mo_schedule_file_backup_wp_files" onclick="barfw_checkbox_disable()" value="1"<?php checked(get_site_option('mo_file_backup_wp_files') == 1);?>> WordPress Files
					</td>
					<td>	
						<input type="checkbox" name="mo_schedule_database_backup" id="mo_database_backup" value="1"<?php checked(get_site_option('mo_schedule_database_backup') == 1);?>> Database

			       </td>
		    	</tr>
		    </table>	    
     
	    	
	<br>
	<p class="text_size">After checking the <b>enable backup schedule</b> checkbox, a backup will be created once you click on save setting and another backup will be created automatically after the scheduled time you select.</p>
	<input type = "hidden" id = "wpns_schedule_backup_url" value="<?php echo wp_create_nonce('wpns-schedule-backup') ?>" >
<input type="button"  class="mo_wpns_scan_button"  name="save_schedule_settings" id="save_schedule_settings" value ="Save Settings" style="width:120px;" />

	
</div>	
</form>	
</div>
<?php
 function barfw_scheduled_backup(){
 ?><script type="text/javascript">
	
   	 jQuery(document).ready(function(){
	 jQuery('#save_schedule_settings').click(function(){
	 	var data={
			'action':'barfw_backup_ajax_redirect',
			'call_type':'submit_schedule_settings_form',
			'backup_plugin':jQuery('input[name= "mo_schedule_file_backup_plugins"]:checked').val(),
			'backup_themes':jQuery('input[name= "mo_schedule_file_backup_themes"]:checked').val(),
			'backup_wp_files':jQuery('input[name= "mo_schedule_file_backup_wp_files"]:checked').val(),
			'database':jQuery('input[name= "mo_schedule_database_backup"]:checked').val(),
			'backup_time':jQuery('input[name= "backup_time"]:checked').val(),
			'local_storage':jQuery('input[name= "local_storage"]:checked').val(),
			'enable_backup_schedule':jQuery('input[name= "enable_backup_schedule"]:checked').val(),
			'nonce' : jQuery('#wpns_schedule_backup_url').val(),
			
		};
		

		jQuery.post(ajaxurl, data, function(response){
		
			jQuery("#wpns_backup_message2").empty();
			jQuery("#wpns_backup_message2").hide();
			jQuery('#wpns_backup_message2').show();
			if (response == "folder_error"){
			jQuery('#wpns_backup_message2').empty();
            jQuery('#wpns_backup_message2').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; Please select at least one folder to backup</div></div>");
			}
			
			else if(response=="success"){
				jQuery('#wpns_backup_message2').empty();
                jQuery('#wpns_backup_message2').append("<div id='notice_div' class='overlay_success'><div class='popup_text'>&nbsp; &nbsp; Backup Configuration Saved Successfully</div></div>");           
			}
			else if(response=="disable"){
				jQuery('#wpns_backup_message2').empty();
                jQuery('#wpns_backup_message2').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; Automatic Backup Disable Successfully</div></div>");
                jQuery(".add_remove_disable").attr("disabled","disabled");
             
			}else if(response==="invalid_hours"){
				jQuery('#wpns_backup_message2').empty();
                jQuery('#wpns_backup_message2').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; Please select valid hours</div></div>");
			
			}else if(response==="ERROR"){
				jQuery('#wpns_backup_message2').empty();
                jQuery('#wpns_backup_message2').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; ERROR</div></div>");
			
			}
						window.onload = barfw_nav_popup();

		});
  
       });
	});

	function barfw_nav_popup() {
			  document.getElementById("notice_div").style.width = "40%";
			  setTimeout(function(){ jQuery('#notice_div').fadeOut('slow'); }, 3000);
	}

	function barfw_checkbox_disable() {
		 if(jQuery('input[name= "mo_schedule_file_backup_wp_files"]:checked').val()){
		 	jQuery('input[name="mo_schedule_file_backup_plugins"]').attr('disabled', true);
		 	jQuery('input[name="mo_schedule_file_backup_themes"]').attr('disabled', true);
		 	jQuery('#mo_schedule_plugins').prop('checked', false); // Unchecks it
		    jQuery('#mo_schedule_themes').prop('checked', false); // Unchecks it
		 }else{
		 	jQuery('input[name="mo_schedule_file_backup_plugins"]').removeAttr('disabled');
		 	jQuery('input[name="mo_schedule_file_backup_themes"]').removeAttr('disabled');
		 }
	}
		if(jQuery('input[name= "mo_schedule_file_backup_wp_files"]:checked').val()){
		 	jQuery('input[name="mo_schedule_file_backup_themes"]').attr('disabled', true);
		 	jQuery('input[name="mo_schedule_file_backup_plugins"]').attr('disabled', true);
		 	jQuery('#mo_schedule_plugins').prop('checked', false); // Unchecks it
		    jQuery('#mo_schedule_themes').prop('checked', false); // Unchecks it
		 }else{
		 	jQuery('input[name="mo_schedule_file_backup_plugins"]').removeAttr('disabled');
		 	jQuery('input[name="mo_schedule_file_backup_themes"]').removeAttr('disabled');
		 } 

   </script>
<?php } 
?>