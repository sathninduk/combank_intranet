<?php
?>
<div id="wpns_backup_message1"></div>
<div class="mo_wpns_divided_layout">
<div class="mo_wpns_setting_layout" id="backup_report_table">
<?php if(! isset($_GET['view']))?>	
		<h2>Backup Created Report</h2>
	
		<hr>
		<div id="backupdata">
			<table id="reports_table" class="display" cellspacing="0" width="100%">
            <thead><tr><th style="text-align:center">Created Time</th><th style="text-align:center">Backup Folders</th><th style="text-align:center">Storage</th><th style="text-align:center">Download</th><th style="text-align:center">Delete</th></tr></thead>
            <tbody>
 	        <br>
<?php 
				include_once $MoBackupDirName. 'controllers'.DIRECTORY_SEPARATOR.'backup_created_result.php';
				echo barfw_show_backup_results();
			
		?></tbody>
	</table>
</div>
</div>
</div>
<?php                       
  function barfw_show_backup_report($file_path,$file_name,$timestamp,$id)	{
  	$time = date('m/d/Y H:i:s', $timestamp);
    $nonce = wp_create_nonce('mo-wpns-download-nonce');
        echo "<tr><td style=text-align:center>".esc_html($time)."</td>";
    	echo "<td style=text-align:center>".esc_html($file_name)."</td>";
    	echo "<td style=text-align:center>Local</td>";
        echo "<td><form action='' method='POST' enctype='multipart/form-data'>
        	  <input type='hidden' value='mo_wpns_backup_download' name='option' />
              <input type='hidden' value=".esc_html($file_name."/".$id)." name='file_name' />
              <input type='hidden' value=".esc_html($file_path)." name='file_path' />
              <input type='hidden' value=".$nonce." name='download_nonce'/>
              <input type='submit' value='Download' name='download' class='upload btn btn-info btn-xs'>
              </form>
              </td>";
        echo "<td><button type='button' onclick=\"barfw_delete(this, '".addslashes(esc_html($file_path))."','".esc_html($file_name)."',".esc_html($id).")\" name='delete' id='delete'  class='btn btn-info btn-xs delete'>Delete</button></td>";
        echo "</tr>";
} ?>
<script>
function barfw_delete(elmt, file_path,file_name,id){
	
	jQuery(document).ready(function(){
	
	 if(confirm("Are you sure you want to delete it?"))
    {	
 		var data={
			'action':'barfw_backup_ajax_redirect',
			'call_type':'delete_backup',
			'file_name':file_name,
			'folder_name':file_path,
            'id'         :id,
            'nonce'      : '<?php echo wp_create_nonce("delete_entry");?>',
			
		};
		
		jQuery.post(ajaxurl, data, function(response){
			
			jQuery("#wpns_backup_message1").empty();
			if(response=="success"){
				jQuery('#wpns_backup_message1').append("<div id='notice_div' class='overlay_success'><div class='popup_text'>&nbsp; &nbsp; Backup delete successfully.</div></div>");
					window.onload = barfw_nav_popup();
             
				var row = elmt.parentNode.parentNode;
				row.parentNode.removeChild(row);
			}else if(response ==="notexist"){
				jQuery('#wpns_backup_message1').append("<div class= 'notice notice-error is-dismissible' style='height : 25px;padding-top: 10px;  ' >	Please refreash the page. </div>");
				jQuery('#wpns_backup_message1').append("<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp;  Please refreash the page.</div></div>");
					window.onload = barfw_nav_popup();
			}
		});
   }
	
});
	
}
jQuery("#reports_table").DataTable({
				"order": [[ 1, "desc" ]]
			});

function barfw_nav_popup() {
  document.getElementById("notice_div").style.width = "40%";
  setTimeout(function(){ jQuery('#notice_div').fadeOut('slow'); }, 3000);
}
</script>