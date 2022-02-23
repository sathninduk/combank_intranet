<?php
function mo_wpum_restrict_access_settings()	{
	global $mo_manager_utility,$wpdb;
	
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
			
	    echo '	
		        <h2>Restrict Pages / Posts Access [Premium Feature]</h2><hr>
				<h3>Select pages you want to restrict</h3>
				<p>Note : By default all pages/posts are allowed to be accessed without login and by all roles. Select pages/posts you wish to restrict access to only logged in users. If you wish to restrict it for specific roles as well please enter the roles against the respective page/post.</p>
				<form name="f" style="margin-left:6px;" method="post" action="" id="blockedpagesform">
					<input type="hidden" name="option" value="mo_wpum_restrict_pages" />
					<table>';
					
				$page_ids=get_all_page_ids();
				$page =0;
				echo '<tr><td><input type="checkbox" name="mo_wpum_page_'.$page.'" disabled value="true"';
						echo '> <b>Home Page</b><br><i><a style="margin-left:30px;" disabled href="'.site_url().'">'.site_url().'</a></i></td>	
				<td><input type="text" name="mo_wpum_role_values_0" disabled placeholder="Enter (;) separated Roles" style="width: 400px;"/><br><br></td></tr>';
				
				foreach($page_ids as $page)
				{ 
	echo '			<tr><td><input type="checkbox" name="mo_wpum_page_'.$page.'" disabled value="true"';
						echo '> <b>'.get_the_title($page).'</b><br><i><a style="margin-left:30px;" href="'.get_page_link($page).'">'.get_page_link($page).'</a></i></td>';	
	echo '			<td><input type="text" name="mo_wpum_role_values_' . $page . '" disabled
	              placeholder="Enter (;) separated Roles" style="width: 400px;" /><br><br></td>
					</tr>';
				}
	
	echo'			</table><br>
					
				</form>
				<br>
	
				<h3>Select posts you want to restrict</h3>
				<form name="f" style="margin-left:6px;" method="post" action="" id="blockedpostsform">
					<input type="hidden" name="option" value="mo_wpum_restrict_posts" /><table>';
				$post_ids=get_posts();
			
				foreach($post_ids as $post)
				{   
	echo'			<tr style="margin-bottom:3%;"><td><input type="checkbox" disabled name="mo_wpum_post_'.$post->ID.'" value="true"';
	               
    echo'> <b>'.$post->post_title.'</b><br><i><a style="margin-left:30px;" href="'.get_permalink($post).'">'.get_permalink($post).'</a></i></td>';
	echo '			<td><input type="text" disabled name="mo_wpum_role_values_' . $post->ID . '"  value="'; 
	           
				 echo '" placeholder="Enter (;) separated Roles" style="width: 400px;" /><br><br></td></tr>';
				} 
	
	echo'		</table><br>
					
				</form>';
}



