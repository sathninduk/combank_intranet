<?php

class BARFW_Backup_Notification{


        function barfw_custom_dashboard_widgets() {
            global $wp_meta_boxes;

            wp_add_dashboard_widget('custom_help_widget', 'MiniOrange Security',array($this, 'barfw_custom_dashboard_help'));
     }

	    function barfw_custom_dashboard_help() {
         global $BackupDbQueries;
          $array = $BackupDbQueries->barfw_get_number_of_plugin_backup();
           $last_backup_create_time = get_site_option('backup_created_time');
           
           $last_backup = 'No Backup Util';
           $time = time();
           if($array['total_backup'] !=0){
             $timestamp = $time-$last_backup_create_time;
          
             $days = $timestamp/(60*60*24);
             $day = (int)$days;
           
             if($day === 0){
              $last_backup ='Last Backup Create Today';
             }else{
              $last_backup= 'Last backup'.' '.$day.' '.'days ago';
             }
           }else{
             $last_backup = 'No Backup Until Now';
           }
         
         echo "<div style='width:100%;background-color:#555f5f;padding-top:10px;'>
                    <div style='font-size:20px;color:white;text-align:center'>
                      <strong style='font-weight:300;'>Backup Created<span style='color:orange;'>[".$last_backup." ]</span></strong>
                    </div>
                    <hr>
                    <div>
                <table>
                <tbody>
                       
                  <tr>
                  <td style='border-collapse:collapse!important;color:#0a0a0a;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:normal'>
                    <table dir='ltr'   style='table-layout:fixed;margin:10px 0 20px 0;padding:0;vertical-align:top;width:100%'>
                      <tbody>
                        <tr>
                          <td style='text-align:center;font-size:36px;color:#ffffff;font-weight:400' ><strong>".$array['plugin_count']."</strong></td>
                          <td style='text-align:center;font-size:36px;color:#ffffff;font-weight:400'><strong>".$array['themes_count']."</strong></td>
                          <td style='text-align:center;font-size:36px;color:#ffffff;font-weight:400'><strong>".$array['wp_files_count']."</strong></td>
                          <td style='text-align:center;font-size:36px;color:#ffffff;font-weight:400'><strong>".$array['db_count']."</strong></td>
                       
                        </tr>
                       
                        <tr>
                        <td>&nbsp;
                        </td>
                        <td>
                        </td>
                        </tr>
                        <tr>
                        <td style='font-size:18px;color:#ffffff;text-align:center'><strong style='font-weight:300;'>Plugin Backup</strong></td>
                        <td style='font-size:18px;color:#ffffff;text-align:center'><strong style='font-weight:300;'>Themes Backup</strong></td>
                        <td style='font-size:18px;color:#ffffff;text-align:center'><strong style='font-weight:300;'>WP File Backup</strong></td>
                        <td style='font-size:18px;color:#ffffff;text-align:center'><strong style='font-weight:300;'>Database Backup</strong></td>
                        
                        </tr>
                     </tbody>
                    </table>
                    
                  </tr>  
              </tbody>
              </table>
              </div>
              <a class='button button-primary' style='background-color:#f0a702;width:100%;text-align:center' href='admin.php?page=backup'><h3 style='background-color:#f0a702'>Take Backup</h3></a>
              </div>";


			}  
 
}




?>