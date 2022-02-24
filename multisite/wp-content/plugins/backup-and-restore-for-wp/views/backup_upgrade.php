<?php
	$register_url	= add_query_arg( array('page' => 'mo_eb_backup_account','option'=>'upgrade'	), $_SERVER['REQUEST_URI'] );
	if(get_option('mo_2factor_admin_registration_status')!==false)
		$is_customer_registered=get_option('mo_2factor_admin_registration_status');
?><div class="mo_wpns_divided_layout">
<div class="mo_wpns_setting_layout">
	<div style="text-align: center;">

	<table class="mo_wpns_settings_table">
		
		<tr>
			<h1 style="text-align: center;">Website Backup</h1>
			<p style="text-align: center;">Price starting form</p>
		</tr>
		<tr >

	        <span class="mo_wpns_products-dollar-amount" >$30 </span>
			<span class="mo_wpns_products-dollar-detail">/ site / year</span>
			<br><br>
			<span class="mo_wpns_products-dollar-amount">$50 </span>
			<span class="mo_wpns_products-dollar-detail">/ 5 sites / year</span>
			<br><br>
			<span class="mo_wpns_products-dollar-amount">$70 </span>
			<span class="mo_wpns_products-dollar-detail">/ 10 sites / year</span><br><br>

		</tr><?php 
          if( isset($is_customer_registered)) {
          	?><tr>
			<a target="_blank" class="mo_wpns_button mo_wpns_button1" onclick="barfw_upgradeform('wp_security_backup_plan')">Upgrade Now</a>
		</tr><?php }else{ ?><tr>
			<a class="mo_wpns_button mo_wpns_button1" onclick="barfw_register_and_upgradeform('wp_security_backup_plan')">Upgrade Now</a>
		</tr><?php }
		 ?></table>
   </div>
	<table class="mo_wpns_settings_table">
					  <tr class="mo_wpns_table_row_layout">
					    <td  class="mo_wpns_table_free_text_layout">
					    	<a id="backup_id" class=" mo_wpns_button1 mo_wpns_collapsible mo_wpns_free_feature_button">All Free Features ⮞</a>
					   		
						   <div class="mo_wpns_backup_free">
							   <table class="mo_wpns_settings_table">
								   <tr class="mo_wpns_table_row_layout mo_wpns_backup_free">
								    <td class="mo_wpns_table_free_col1_layout">Database Backup</td>
								    <td class="mo_wpns_table_free_col2_layout">Take backup of your latest database so that you have copy of the latest database if you need to restore.</td>
								    <td class="mo_wpns_table_free_col3_layout"><b>FREE</b></td>
								  </tr>
								  <tr class="mo_wpns_table_row_layout mo_wpns_backup_free">
								    <td class="mo_wpns_table_free_col1_layout">File Backup</td>
								    <td class="mo_wpns_table_free_col2_layout">Due to some unavoidable events you might need to restore complete or partial website. You can do this with our file backup.</td>
								    <td class="mo_wpns_table_free_col3_layout"><b>FREE</b></td>
								  </tr>
								  <tr class="mo_wpns_table_row_layout">
					                <td class="mo_wpns_table_col1_layout">Scheduled Backup</td>
					                <td class="mo_wpns_table_col2_layout">
									<ul>
									    <li>Support both manual and automated (scheduled) backups</li>
									    <li>Backups Files and Database on separate schedule</li>
									    
									   </ul>
									</td>
					                <td class="mo_wpns_table_free_col3_layout"><b>FREE</b></td>
					            </tr>
					   </tr>
							   </table>
						   </div>
					    </td>
					  </tr>
	</table>
		<hr class=mo_wpns_line>
					<table class="mo_wpns_settings_table">
						<tr class="mo_wpns_table_row_layout">
										<td class="" colspan=3>
										<a class="mo_wpns_premium_feature" style="text-align:left;">All Premium Features ⮟</a>
										</td>
									</tr>
					   <tr class="mo_wpns_table_row_layout">
					                <td class="mo_wpns_table_col1_layout">Cloud Backup</td>
					                <td class="mo_wpns_table_col2_layout">Storing the files on remote location is more secure. We provide backups on cloud storage like
										<ul>
									    <li>Google Drive</li>
									    <li>Dropbox and Many more</li>
									    
									   </ul></td>
					                <td class="mo_wpns_table_col3_layout"><b>PREMIUM</b></td>
					    </tr>
					          
					    <tr class="mo_wpns_table_row_layout">
					                <td class="mo_wpns_table_col1_layout">Security</td>
					                <td class="mo_wpns_table_col2_layout">
									<ul>
									    <li>The files are password protected so that only person authorized can check the backup</li>
									   
									    
									   </ul></td>
					                <td class="mo_wpns_table_col3_layout"><b>PREMIUM</b></td>
					            </tr>
					

					  
						    <tr class="mo_wpns_table_row_layout mo_wpns_backup_free">
								    <td class="mo_wpns_table_free_col1_layout">Password Protected Zip files</td>
								    <td class="mo_wpns_table_free_col2_layout">The files are password protected so that only person authorized can check the backup</td>
								    <td class="mo_wpns_table_col3_layout"><b>PREMIUM</b></td>
								  </tr>
					 <tr class="mo_wpns_table_row_layout">
					                <td class="mo_wpns_table_col1_layout">Reporting</td>
					                <td class="mo_wpns_table_col2_layout">Generate sophisticated report with notification and alert over email</td>
					                <td class="mo_wpns_table_col3_layout"><b>PREMIUM</b></td>
					            </tr>
					   </tr>
					 
					<tr class="mo_wpns_table_row_layout">
					                <td class="mo_wpns_table_col1_layout">Automatic Delete</td>
					                <td class="mo_wpns_table_col2_layout">Support automatic delete backup </td>
					                <td class="mo_wpns_table_col3_layout"><b>PREMIUM</b></td>
					            </tr>
					</table>		
	
</div>
</div>
             <form class="mo2f_display_none_forms" id="mo_eb_loginform"
                  action="<?php echo BARFW_Backup_Constants::HOST_NAME . '/moas/login'; ?>"
                  target="_blank" method="post">
                <input type="email" name="username" value="<?php echo esc_html(get_option( 'mo2f_email' )); ?>"/>
                <input type="text" name="redirectUrl"
                       value="<?php echo BARFW_Backup_Constants::HOST_NAME . '/moas/initializepayment'; ?>"/>
                <input type="text" name="requestOrigin" id="requestOrigin"/>
            </form>
            <form class="mo2f_display_none_forms" id="mo_eb_register_to_upgrade_form" action="admin.php?page=mo_eb_backup_account" 
                   method="post">
                <input type="hidden" name="requestOrigin" />
                <input type="hidden" name="mo_eb_register_to_upgrade_nonce"
                       value="<?php echo wp_create_nonce( 'miniorange-eb-user-reg-to-upgrade-nonce' ); ?>"/>
            </form>

 <script type="text/javascript">
 	function barfw_upgradeform(planType) {
                    jQuery('#requestOrigin').val(planType);
                    jQuery('#mo_eb_loginform').submit();
                }
  function barfw_register_and_upgradeform(planType) {
                    jQuery('#requestOrigin').val(planType);
                    jQuery('input[name="requestOrigin"]').val(planType);
                    jQuery('#mo_eb_register_to_upgrade_form').submit();
                }
 </script>