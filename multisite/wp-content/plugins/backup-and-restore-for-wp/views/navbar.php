<?php

echo'<div class="wrap">
				<div><img  style="float:left;margin-top:5px;" src="'.$logo_url.'"></div>
				<h1>
					miniOrange Website Backup &nbsp;
					<a class="add-new-h2 " href="'.$profile_url.'">Account</a>	
				</h1>

		</div>';
		$active_tab = sanitize_text_field(wp_unslash($_GET['page']));
		if($active_tab == 'mo_eb_backup')
			$active_tab = 'mo_eb_backup_settings';
		?><div class="mo_flex-container">
	<a class="nav-tab <?php echo ($active_tab == 'mo_eb_backup_settings' ? 'nav-tab-active' : '')?>" 
		href="<?php echo $setting_url;?>" id="backup_set">Manual Backup</a>
   <a class="nav-tab <?php echo ($active_tab == 'mo_eb_backup_schdule' 	  ? 'nav-tab-active' : '')?>" href="<?php echo $schdule_url;?>" id="schdule">Scheduled Backup</a>
   
    <a class="nav-tab <?php echo ($active_tab == 'mo_eb_backup_report' 	  ? 'nav-tab-active' : '')?>" href="<?php echo $report_url;?>" id="report">Report</a>
   
    <a class="nav-tab <?php echo ($active_tab == 'mo_eb_backup_upgrade' 	  ? 'nav-tab-active' : '')?>" href="<?php echo $upgrade_url;?>"id="upgrade">Upgrade</a>
</div>
<br>