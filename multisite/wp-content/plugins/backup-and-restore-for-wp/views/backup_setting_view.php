<?php 
	add_action('admin_footer','barfw_settings_page_submit');
?>
<div id="wpns_backup_message"></div>
<div class="mo_wpns_divided_layout">
 <div class="mo_wpns_setting_layout">		
	<div class="mo_wpns_subheading"></div>
	<br>
	<form id="abc" method="post" action="">
		<input type="hidden" name="option" value="mo_wpns_backup_configuration">
		
		<table class="mo_wpns_settings_table">
		<tr>
			<td style="width:30%"><b>Select Folders to Backup : </b></td>
			<td>
			<input type="checkbox" name="mo_file_backup_wp_files" onclick="barfw_check_wpfiles()" id="mo__manual_file_wp_files" 
			value="1"<?php checked(get_site_option('mo_file_manual_backup_wp_files') == 1);?>> WordPress Files<br>
		
			<input type="checkbox" name="mo_file_backup_plugins" id="mo_file_manual_backup_plugins" value="1"<?php checked(get_site_option('mo_file_manual_backup_plugins') == 1);?>> WordPress Plugins folder<br>
			<input type="checkbox" name="mo_file_backup_themes" id="mo_file_manual_backup_themes" value="1"<?php checked(get_site_option('mo_file_manual_backup_themes') == 1);?>> WordPress Themes folder<br>
			
			<input type="checkbox" name="mo_database_backup"  value="1"<?php checked(get_site_option('mo_database_backup') == 1);?>> Database
			</td>
		</tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			<td style="width: 30%"> <b>Choose the location where you want to store your backup :</b></td>
			<td>
		    
			<label class="mo_wpns_switch_small">
			<input type="radio" name="remote_storage_type" value="none" id="none" checked="checked" onclick="barfw_upgrade_prompt('1')">
			<span class="mo_wpns_slider_small mo_wpns_round_small"></span>
		    </label>
		    <b style="padding-right:10px;">Locally</b>
		    <br><br>
		    <label class="mo_wpns_switch_small">
			<input type="radio" name="remote_storage_type" value="google_drive" id="google_drive" onclick="barfw_upgrade_prompt('2')" >
			<span class="mo_wpns_slider_small mo_wpns_round_small"></span>
			</label>
			<b style="padding-right:10px;">On Cloud &nbsp;<strong style="color: red"><a href="admin.php?page=mo_eb_backup_upgrade">[Premium Feature] </a></strong></b>
			</td>
		</tr>	
		
		<tr>
			<td style="width: 30%"></td>
			<td>
				<div style="display: none; color: red" id="moeb_upgrade_message">This is our premium feature to upgrade <a href="admin.php?page=mo_eb_backup_upgrade">click here</a><br></div>

		      <div id="barfw_cloud_type_show" >
		      	<label>
					  <input type="radio" class="barfw_remote_type_select" name="cloud" value="google_drive" >
					  <img style="width: 10%" title="Premium Feature" src="<?php echo $google_imag_path; ?>">
					</label>

					<label>
					  <input type="radio" class="barfw_remote_type_select" name="cloud" value="drop_box">
					  <img style="width: 9%" title="Premium Feature" src="<?php echo $dropbox_img_path; ?>">
					</label>

					
		      </div>
			</td>

		</tr>	
		
		
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			<td style="width: 30%"><b>Protect your backup zip file with password<strong style="color: red"><a href="admin.php?page=mo_eb_backup_upgrade">[Premium Feature]: </a></strong></b></td>
			<td>
				<label class="mo_wpns_switch_small">
			    <input type="checkbox" name="password_protected" value="yes" disabled="disabled">
			    <span class="mo_wpns_slider_small mo_wpns_round_small"></span>
		        </label>
			</td>
		</tr>
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			<td style="width: 30%"><b>Delete old backup automatic<strong style="color: red"><a href="admin.php?page=mo_eb_backup_upgrade">[Premium Feature]: </a></strong></b></td>
			<td>
			    <label class="mo_wpns_switch_small">
				<input type="checkbox" name="automatic_delete" value="yes" disabled="disabled">
				<span class="mo_wpns_slider_small mo_wpns_round_small"></span>
		        </label>
			</td>
		</tr>
		
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			<td style="width: 30%"><b>Reporting<strong style="color: red"><a href="admin.php?page=mo_eb_backup_upgrade">[Premium Feature] </a></strong></b></td>
			<td>
			Generate sophisticated report with notification and alert over email
			</td>
		</tr>
		<tr><td>&nbsp;</td><td></td></tr>
        <tr>
        	<td style="width: 30%"></td>
        	<td>
        	<input type = "hidden" id = "wpns_backup_settings_url" value="<?php echo wp_create_nonce('wpns-backup-settings') ?>" >
        	<input type="button" name="save_backup_settings" id="save_backup_settings" value ="Take Backup" style="width:120px;" class="mo_wpns_scan_button"  />
 
        	</td>
        </tr>
		</table>

	</form>
	<div class="file_backup_desc" hidden></div>
</div>
   </div>
<?php
function barfw_settings_page_submit(){
	$plugins_url = plugins_url();
	$plugin_path = dirname(dirname(__FILE__));
    $basename = plugin_basename($plugin_path);
	$img_loader_url		= $plugins_url .'/'.$basename.'/includes/images/loader.gif';
	$filemessage			= '<div id=\'filebackupmessage\'><h2>DO NOT :</h2><ol><li>Close this browser</li><li>Reload this page</li><li>Click the Stop or Back button.</li></ol><h2>Untill your file backup is completed</h2></div><br/><div class=\'filebackupmessage\'><h2><div id=\'backupinprogress\'> BACKUP IN PROGRESS</div></h2></div><div id=\'fileloader\' ><img  src=\"'.$img_loader_url.'\"></div>';
   $filemessage2a			= 'Backup is Completed. Check ';
   $filemessage2b			= ' file in <b>uploads/miniorangebackup</b> folder.';
?>
<script>

jQuery(document).ready(function(){
	jQuery('#save_backup_settings').click(function(){
  
       var message = "<?php echo $filemessage; ?>";
                jQuery(".file_backup_desc").empty();
			    jQuery(".file_backup_desc").append(message);
			    jQuery(".file_backup_desc").slideDown(400);
			    setInterval(function(){  jQuery("#backupinprogress").fadeOut(700); }, 1000);
			    setInterval(function(){  jQuery("#backupinprogress").fadeIn(700); }, 1000);
			    document.getElementById("save_backup_settings").value = "Taking Backup...";
			    jQuery('input[name="save_backup_settings"]').attr('disabled', true);
			    document.getElementById('save_backup_settings').style.backgroundColor = '#20b2aa';

		var data={
			'action':'barfw_backup_ajax_redirect',
			'call_type':'submit_backup_settings_form',
			'backup_plugin':jQuery('input[name= "mo_file_backup_plugins"]:checked').val(),
			'backup_themes':jQuery('input[name= "mo_file_backup_themes"]:checked').val(),
			'backup_wp_files':jQuery('input[name= "mo_file_backup_wp_files"]:checked').val(),
			'database':jQuery('input[name= "mo_database_backup"]:checked').val(),
			'nonce'   :jQuery('#wpns_backup_settings_url').val(),
		};
		
		
  
		
			
			
			jQuery.post(ajaxurl, data, function(response){

			jQuery("#wpns_backup_message").empty();
			jQuery("#wpns_backup_message").hide();
			jQuery('#wpns_backup_message').show(); 

			if (response == "ERROR"){
			jQuery('#wpns_backup_message').empty();
            jQuery('#wpns_backup_message').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; ERROR</div></div>");
            window.onload = barfw_nav_popup();

			}else if(response == "not_writable"){
			jQuery('#wpns_backup_message').empty();
                jQuery('#wpns_backup_message').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; We don't have write permission. Please give the permission to create folder in uploads</div></div>");
            window.onload = barfw_nav_popup();

			}
            else if(response == "folder_error")
            {
            	jQuery('#wpns_backup_message').empty();
                jQuery('#wpns_backup_message').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp;Please select atleast one file folder from manual backup. </div></div>");
           		 window.onload = barfw_nav_popup();

        	jQuery(".filebackupmessage h2").empty();
        	jQuery(".filebackupmessage h2").append("NO FILES TO BACKUP.PLEASE CHANGE MANUAL SETTINGS");

        	jQuery("#fileloader").empty();
        	var result = JSON.stringify(response);
        	jQuery("#fileloader").append(result+' '+'please select at least one folder to backup');    
        	jQuery(".filebackupmessage").css("background-color","#1EC11E");

        	jQuery('input[name="save_backup_settings"]').removeAttr('disabled');
			document.getElementById('save_backup_settings').style.backgroundColor = '#20b2aa';
			document.getElementById("save_backup_settings").value = "Take Backup";
            
            }
            else
            {
        	jQuery(".filebackupmessage h2").empty();
        	jQuery(".filebackupmessage h2").append("BACKUP COMPLETED");

        	jQuery("#fileloader").empty();
        	
        	jQuery("#fileloader").append('<?php echo $filemessage2a; ?>'+response+'<?php echo $filemessage2b; ?>');    
        	jQuery(".filebackupmessage").css("background-color","#1EC11E");

        	jQuery('input[name="save_backup_settings"]').removeAttr('disabled');
			document.getElementById('save_backup_settings').style.backgroundColor = '#20b2aa';
			document.getElementById("save_backup_settings").value = "Take Backup";
            }

           
        
		});
			
	

	});

	});
function barfw_nav_popup() {
  document.getElementById("notice_div").style.width = "40%";
  setTimeout(function(){ jQuery('#notice_div').fadeOut('slow'); }, 3000);
}
function barfw_upgrade_prompt(val){
 if(val === '2')
 document.getElementById("moeb_upgrade_message").style.display='block';
 else
 document.getElementById("moeb_upgrade_message").style.display='none';
}

function barfw_check_wpfiles() {
 if(jQuery('input[name= "mo_file_backup_wp_files"]:checked').val()){
 	jQuery('input[name="mo_file_backup_plugins"]').attr('disabled', true);
 	jQuery('input[name="mo_file_backup_themes"]').attr('disabled', true);
 	jQuery('#mo_file_manual_backup_plugins').prop('checked', false); // Unchecks it
    jQuery('#mo_file_manual_backup_themes').prop('checked', false); // Unchecks it
 }else{
 	jQuery('input[name="mo_file_backup_plugins"]').removeAttr('disabled');
 	jQuery('input[name="mo_file_backup_themes"]').removeAttr('disabled');
 }
}
if(jQuery('input[name= "mo_file_backup_wp_files"]:checked').val()){
 	jQuery('input[name="mo_file_backup_plugins"]').attr('disabled', true);
 	jQuery('input[name="mo_file_backup_themes"]').attr('disabled', true);
 	jQuery('#mo_file_manual_backup_plugins').prop('checked', false); // Unchecks it
    jQuery('#mo_file_manual_backup_themes').prop('checked', false); // Unchecks it
 }else{
 	jQuery('input[name="mo_file_backup_plugins"]').removeAttr('disabled');
 	jQuery('input[name="mo_file_backup_themes"]').removeAttr('disabled');
 } 

</script>
<?php }?>