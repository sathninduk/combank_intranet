<?php

include_once 'page-restriction-premium-plan.php';

/* Main Page Restriction Function which is called on addition of Menu and Submenu pages.
	Function to display the correct page content based on the active tab. */
function papr_page_restriction(){
	$currenttab = "";
	if ( array_key_exists( 'tab', $_GET ) ) {
		$currenttab = $_GET['tab'];
	} ?>

    <div id="papr_settings">
        <div>
            <table style="width:100%;">
                <tr>
                    <h2 class="nav-tab-wrapper">
                        <a class="nav-tab 
                        	<?php if ( $currenttab == '' ) {
								echo 'nav-tab-active';
							} 
							?>
							" href="admin.php?page=page_restriction">Page/Post Access
						</a>

                        <a class="nav-tab 
                        	<?php if ( $currenttab == 'login_page_restriction' ) {
								echo 'nav-tab-active';
							} 
							?>
							" href="admin.php?page=page_restriction&tab=login_page_restriction">Restrict to Logged in Users
						</a>

						<a class="nav-tab 
							<?php if ( $currenttab == 'post_type_restriction' ) {
                        	echo 'nav-tab-active';
                    		} 
							?>
							" href="admin.php?page=page_restriction&tab=post_type_restriction">Restrict Custom Post Type
						</a>

						<a class="nav-tab 
							<?php if ( $currenttab == 'account_setup' ) {
								echo 'nav-tab-active'; 
							} 
							?>
							" href="admin.php?page=page_restriction&tab=account_setup">Account Setup
						</a>

						<a class="nav-tab 
							<?php if ( $currenttab == 'premium_plan' ) {
								echo 'nav-tab-active'; 
							} 
							?>
							" href="admin.php?page=page_restriction&tab=premium_plan">Licensing Plans
						</a>
                    </h2>
                    
                    <td style="vertical-align:top;width:65%;">
						<?php
						if ( $currenttab == 'login_page_restriction' ) {
							papr_login_restriction_page();
						}
						else if ( $currenttab == 'post_type_restriction'){
						    papr_restrict_complete_post_type();
						}
						else if ( $currenttab == '' ) {
							papr_user_restriction_page();
						} 
						else if ( $currenttab == 'account_setup' ) {
							if(papr_is_customer_registered()){
                            	papr_show_customer_details();
                            }else{
                                if ( get_option( 'papr_verify_customer' ) == 'true' ) {
                                    papr_show_verify_password_page();
                                }else{
                                    papr_show_new_registration_page();
                                }
                            }
						}
						else if ( $currenttab == 'premium_plan' ){
							papr_show_premium_plans();
						}
						?>
                    </td>
                    <td style="vertical-align:top;padding-left:1%;">
						<?php
						if ( $currenttab == 'login_page_restriction' ) {
							echo papr_display_options_page();
						}
						if ( $currenttab == '' ) {
							echo papr_display_options_log();
						}
						echo papr_support_page_restriction();
						?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
		
	<?php
	/* To hide the child pages on page load */
	$pages=get_pages();
    $round=count($pages);
    for ($i=0; $i <$round ; $i++) { 
		echo '
			<script> 
				jQuery("#view'.$pages[$i]->ID.'").hide();
			</script>
		';
	}
}
		
/* Function to restrict Before login - Defines selecting and deselecting all the check boxes at once for page restriction for users not logged in */
function papr_login_restriction_page() {
	echo '   
		<div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding-left:10px;padding-right:10px;border:solid 1px rgba(255, 255, 255, 255);border: 1px solid #CCCCCC";>
			<h3>Restrict to Logged in Users</h3>
			<hr>
			<div style="padding-left:16px">		
				<h3>Select pages you want to give access to Logged in Users only</h3>
        		<p>
        		<b>Note </b>: Selet the page(s) that you want to restrict access, for a user not Logged In (By default all pages/posts are accessible to all users). 
        		</p>
        		<form name="f" style="margin-left:6px;" method="post" action="" id="IDPredirect_allow">
    ';
        			wp_nonce_field("papr_redirect_allow_pages");
    echo '
    				<input type="hidden" name="option" value="papr_redirect_allow_pages" />
    ';

            		$pages    = get_pages();
					$round = count($pages); 
	?>
					<span class="selectAll"><input type="checkbox" name="papr_select_all_pages" onclick="papr_checkUncheckAll('checkBoxClass3', this)" onchange="document.getElementById('IDPredirect_allow').submit();" id="selectall4"
						<?php checked(get_option('papr_select_all_pages') == 'checked'); ?>
						> Select All Pages
					</span><br>
					<span class="mo_pr_help_desc"><b>NOTE: </b> If this option is enabled, all the newly added pages will be checked by default.</span>
					<script>
						function papr_checkUncheckAll(className, elem){
							var elements = document.getElementsByClassName(className);
							var l = elements.length;
							if(elem.checked == true){
								for (var i = 0; i < l; i++) {
				   					elements[i].checked = true;
								}
							} else if(elem.checked == false){
								for (var i = 0; i < l; i++) {
					                elements[i].checked = false;
								}
							}
						}
						function papr_CheckAll(className, elem) {
							var elements = document.getElementsByClassName(className);
							var l = elements.length;        
							for (var i = 0; i < l; i++) {
				   		 		elements[i].checked = true;
							}
						}
						function papr_Check(name,elem) {
						   	var elements = document.getElementsByName(name);
							var l = elements.length;    
							var r='<?php echo $round ?>';
							var ele;
							var users = <?php echo json_encode($pages); ?>;
							for(i=0;i<r;i++) {        
								x=i;
								if(name==users[i].post_parent) {
									if(elements[0].checked==true){
										ele=document.getElementsByName(users[i].ID);
										ele[0].checked=true;
										for(j=i+1;j<r;j++){
											if(users[i].ID==users[j].post_parent){
												ele=document.getElementsByName(users[j].ID);
												ele[0].checked=true;
												if(users[j].ID==users[j+1].post_parent){
													i=j;
												}
											}
											else if(i!=x){
												i--;
												j--;
											}				
										}
									}
									else {
										ele=document.getElementsByName(users[i].ID);
										ele[0].checked=false;
										for(j=i+1;j<r;j++) {
											if(users[i].ID==users[j].post_parent) {
												ele=document.getElementsByName(users[j].ID);
												ele[0].checked=false;
												if(users[j].ID==users[j+1].post_parent) {
													i=j;
												}
											}
											else if(i!=x){
												i--;
												j--;
											}
										}
									}

								}	
							}
						}

						function papr_UncheckAll(className, elem) {
							var elements = document.getElementsByClassName(className);
					        var l = elements.length;
							for (var i = 0; i < l; i++) {
					                elements[i].checked = false;
					            }
			  			}
			  		</script>

	<?php
						$display_choice = 'papr_display_message';
						$pages = get_pages();
						if ( get_option( "papr_allowed_redirect_for_pages" ) ) {
							$allowed_page = get_option( "papr_allowed_redirect_for_pages" );
						} else {
							$allowed_page = array();
						}
						$page = 0;
						echo'<br><br>';
						echo '&nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass3" name="mo_redirect_' . $page . '" value="true"';
						if ( array_key_exists(get_option('page_on_front'), $allowed_page) ) {
							echo "checked";
						}
						
						echo '> <b>Home Page&nbsp</b><i><a " href="' . get_home_url() . '">[visit page]</a></i><br><br>';

					    $count=0;
						for ( $i=0;$i<$round;$i++) {
							if($i+1<$round && $pages[$i]->ID==$pages[$i+1]->post_parent) {
								echo '<a href="#" onclick="jQuery(\'#view' . $pages[$i]->ID . '\').toggle();"><img src="'. plugin_dir_url(__FILE__) . 'includes/images/collapse1.png"></a>';
								echo '<input type="checkbox" class="checkBoxClass3" id='.$pages[$i]->ID.' name="' . $pages[$i]->ID . '" onclick="papr_Check('.$pages[$i]->ID.',this)" value="true"';
										if ( array_key_exists($pages[$i]->ID , $allowed_page ) ) {
											echo "checked";
										}
								echo '>';

								echo '<b>' . get_the_title( $pages[$i]->ID ) . '</b>';
								echo '<i>&nbsp <a href="' . get_page_link( $pages[$i]->ID ) . '">[visit page]</a></i>';
								echo '<br><br>';
					            
					            $x=$i;
					            echo '
					            	<div id="view' . $pages[$i]->ID .'">';
						        		for($j=$i+1;$j<$round;$j++) {
						        	  		if($pages[$i]->ID!=$pages[$j]->post_parent){
								            	$i=--$j;
								            	break;
						        			}
						        	
						        			for($z=0;$z<$count;$z++) {
						                   		echo '&nbsp&nbsp&nbsp&nbsp';
						        			}

						        			if($j+1<$round&&$pages[$j]->ID==$pages[$j+1]->post_parent) {
						        				echo '&nbsp&nbsp&nbsp<a href="#" onclick="jQuery(\'#view' . $pages[$j]->ID . '\').toggle();";"FUNCTION1()"><img id="ig1" src="'. plugin_dir_url(__FILE__) . 'includes/images/collapse1.png"></a>';
						        				echo '<input type="checkbox" class="checkBoxClass3" name="'. $pages[$j]->ID . '" onclick="papr_Check('.$pages[$j]->ID.',this )"  value="true"';
						                        	if ( array_key_exists($pages[$j]->ID , $allowed_page )) {
														echo "checked";
													}
												echo'>';
												echo '<b>' . get_the_title( $pages[$j]->ID ) . '</b>&nbsp';
									
												echo'<i><a  href="' . get_page_link( $pages[$j]->ID ) . '">[visit page]</a></i>';
												echo '<br><br>';
							                	$i=$j;
							            		$count++;
					            echo '
					            		<div id="view' . $pages[$j]->ID .'">
					            ';
					            			}
					            			else{
					            				echo'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass3" name="' . $pages[$j]->ID . '" value="true"';
					            				if ( array_key_exists($pages[$j]->ID , $allowed_page ) ) {
													echo "checked";
												}
												echo '>';
												echo '<b>' . get_the_title( $pages[$j]->ID ) . '</b>&nbsp';
								
												echo'<i><a href="' . get_page_link( $pages[$j]->ID ) . '">[visit page]</a></i>';
												echo '<br><br>';

						                        if($j+1<$round&&$pages[$i]->ID!=$pages[$j+1]->post_parent){
						                        	if($count>=1){
						                    			$count--;
						                    		}
						                    		if($x!=$i){
						                    			for($k=0;$k<$round;$k++){
						                    				if($pages[$k]->ID==$pages[$i]->post_parent){  	
						                    					$i=$k;
						                    					$k=-1;
						        echo '
						        		</div>
						        ';
						                    					if($pages[$i]->ID==$pages[$j+1]->post_parent){
						                    						break;                    					
						                    					}
						                    			    }
						                    		    }
						                            }
						                    	}
						                		else if($j+1>=$round && $x!=$i){
						                			for($k=0;$k<$round;$k++){
						                				if($pages[$k]->ID==$pages[$i]->post_parent){
						                					$i=$k;
						                			        $k=-1;
						        echo'
						        	</div>
						        ';
						                					if($pages[$i]->ID==$pages[$j+1]->post_parent){
						                						break;
						                					}
						                				}
						                			}
						                			$i=$j;
						                			break;
						                		}
				                				else if($j+1>=$round ){
				                					$i=$j;
				                					break;
				                				}
				                    		}	
				                    	}
				                echo'
						        	</div>
						        ';
							}
							else {
								echo ' &nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass3" id='.$pages[$i]->ID.' name="' . $pages[$i]->ID . '"  value="true"';
									if ( array_key_exists($pages[$i]->ID , $allowed_page ) ) {
										echo "checked";
									}
								echo '>';
								echo '<b>' . get_the_title( $pages[$i]->ID ) . '</b><i>&nbsp<a  href="' . get_page_link( $pages[$i]->ID ) . '">[visit page]</a></i>';
								echo '<br><br>';
							}
						}

						echo '<br><input type="submit" class="button button-primary button-larges" value="Save Configuration"/>';
	echo '
            	</form><br>

				<h3>Select posts you want only Logged in Users to access</h3>
                <p><b>Note </b>: Select the post(s) that you want to restrict access, for a User not Logged In (By default all pages/posts are accessible to all users). </p>
                
                <form name="f" style="margin-left:6px;" method="post" action="" id="blockedpostsloggedform">';
                    wp_nonce_field("papr_redirect_posts");
                    echo '<input type="hidden" name="option" value="papr_redirect_posts" />

                    <table>';
	?>
						<span class="selectAll"><input type="checkbox" onclick="papr_checkUncheckAll('checkBoxClass4', this);" onchange="document.getElementById('blockedpostsloggedform').submit();" id="selectall4" name="papr_select_all_posts"
						<?php checked(get_option('papr_select_all_posts') == 'checked'); ?>
						> Select All Posts</span><br/>
						<span class="mo_pr_help_desc"><b>NOTE: </b> If this option is enabled, all the newly added posts will be checked by default.</span>
	<?php
				
						$post_ids= get_posts(array(
	                        'fields'  => 'ids', 
	                        'fields'  => 'post_title',
	                        'numberposts'  => -1  
						));
				

						echo '<br><br>';

						if ( get_option( "papr_allowed_redirect_for_posts" ) ) {
							$allowed_roles_for_posts = get_option( "papr_allowed_redirect_for_posts" );
						} else {
							$allowed_roles_for_posts = array();
						}
						foreach ( $post_ids as $post ) {
							echo '           <tr style="margin-bottom:3%;"><td><input type="checkbox" class="checkBoxClass4" name="mo_redirect_post_' . $post->ID . '" value="true"';
							if ( array_key_exists( $post->ID, $allowed_roles_for_posts ) ) {
								echo "checked";
							}

							echo '> <b>' . $post->post_title . '</b>&nbsp<i><a  href="' . get_permalink( $post ) . '">[visit post]</a></i><br/><br></td>';
							echo '          </tr>';
						}

			echo '
					</table><br>
                    <input type="submit" class="button button-primary button-larges" value="Save Configuration">
               	</form>
               	';


		    echo '
				<br>
				<h3>Select Category of Posts you want only Logged in Users to Access
				<sup style="font-size: 12px; color: red;">[Available in <a href="'. admin_url( "admin.php?page=page_restriction&tab=premium_plan" ).'">Paid version</a> of the plugin]</sup>
				</h3>
				<p><b>Note </b>: Select the category(s) that you want to restrict access, for a User not Logged In (By default all pages/posts/categories are accessible to all users). </p>
				<table>
			';
		?>
					<span class="selectAll">
						<input type="checkbox" id="selectall5" style="cursor:not-allowed;" name="mo_pr_select_all_categories" disabled>
						Select All Categories
					</span>
					<br>
					<span class="mo_pr_help_desc"><b>NOTE: </b> If this option is enabled, all the newly added Category Pages will be checked by default.</span>
					<?php
					
					$categories_ids = get_categories(array("hide_empty" => 0,
			            "type"      => "post",
						"orderby"   => "name",
						"order"     => "ASC" ));

						echo '<br><br>';
						foreach ( $categories_ids as $category ) {
							echo '<tr style="margin-bottom:3%; "><td><input style="cursor:not-allowed;" type="checkbox" class="checkBoxClass5" name="mo_redirect_category_' . $category->term_id . '" value="true" disabled> 
								<b>' . $category->name . '</b>&nbsp<i><a  href="' . get_category_link( $category ) . '">[visit category]</a></i><br/><br></td></tr>';
						}
			echo'
				</table>
				<br>
		        <input type="submit" style="cursor:not-allowed;" class="button button-primary button-larges" value="Save Configuration" disabled>
			</div>
			<br><br>
		</div>';
}

//Function to Restrict for pages
function papr_user_restriction_page() {
	global $wpdb;
	?>
    <div class="mo_table_layoaut">
	<?php
	echo '
        <div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding-left:10px;border:solid 1px rgba(255, 255, 255, 255);border:solid 1px  #CCCCCC";>
		<h2>Page/Post Access</h2>
		<hr>
		<div style="padding-left:16px; padding-right:10px;">
        <h3>Give Access to Pages based on Roles</h3>
        <p>
        	<b>Note </b>: Enter role(s) of a user that you want to give access to for a page. Other roles will be restricted (By default all pages/posts are accessible to all users irrespective of their roles). 
        </p>
        <p>
        	<b>Note </b>: Before clicking on "Save Configuration", please check all the boxes of the pages/posts for which you want to save the changes. 
        </p>
        
        <form name="f" method="post" action="" id="blockedpagesform"  onSubmit="papr_call()">
    ';
            wp_nonce_field("papr_restrict_pages");
    echo '
        		<input type="hidden" name="option" value="papr_restrict_pages" />
    ';
               	$page_ids = get_all_page_ids();
				$pages    = get_pages();
				$round = count($pages); 

?>
				<a href="#" id="selectall" onclick="papr_CheckAll('checkBoxClass1', this)">Select All</a> &nbsp;
				<a href="#" id="unselectall" onclick="papr_UncheckAll('checkBoxClass1', this)">Deselect All</a>
			
				<script>
				
				/*function call is used for checking and assigning roles to child text boxes as that of parent text box that is it will check the value of child text box with parent text box and compare it,if child text box contains value which is a subset of parent text box than it is fine, if not than the value of parent text box will be transfered to child text box*/
				function papr_call() {
					var r='<?php echo $round ?>';
					var flag=0;
					var user = <?php echo json_encode($pages); ?>;
					for(i=0;i<r;i++){
						document.getElementById(user[i].ID).value=document.getElementById(user[i].ID).value.toLowerCase();
					}
					
					for(i=0;i<r;i++){
					   	for(j=i+1;j<r;j++){
					   	 	if(user[j].post_parent==user[i].ID){
					   	   		var elements = document.getElementsByName(user[i].ID);
                           		if(elements[0].checked==true){
                                 	if(document.getElementById(user[i].ID).value.length>1){
                                   		var a= document.getElementById(user[i].ID).value.split(";");
                                   		if(document.getElementById(user[j].ID).value.length>1){
                            	       		flag=0;
                            	       		var b= document.getElementById(user[j].ID).value.split(";");
                            	       		for(x=0;x<b.length;x++){
                            		      		for(y=0;y<a.length;y++){
                                               		if(b[x]==a[y]){
                                                    	flag++;
                                                 	}    
                            		         	}
                            	         	}
                            		    	if(flag<b.length){
                                            	document.getElementById(user[j].ID).value= document.getElementById(user[i].ID).value;
                            		     	}	
                                     	}
                             		 	else {
                                  			document.getElementById(user[j].ID).value= document.getElementById(user[i].ID).value;	
                                 		}                       	 
                             		}
                           		}
					   	 	}
					   	}
					}    
				}

				/* function check is used for checking and unchecking of all child check boxes of a particular check box */
			    function papr_Check(name,elem) {
     				var elements = document.getElementsByName(name);
    				var l = elements.length;    
    				var r='<?php echo $round ?>';
    				var ele;
    				var users = <?php echo json_encode($pages); ?>;
    				for(i=0;i<r;i++){        x=i;
						if(name==users[i].post_parent){
							if(elements[0].checked==true){
								ele=document.getElementsByName(users[i].ID);
								ele[0].checked=true;
								for(j=i+1;j<r;j++){
									if(users[i].ID==users[j].post_parent){
										ele=document.getElementsByName(users[j].ID);
										ele[0].checked=true;
										if(users[j].ID==users[j+1].post_parent){
											i=j;
										}
									}
									else if(i!=x){
										i--;
										j--;
									}
								}	
							}
							else{
								ele=document.getElementsByName(users[i].ID);
								ele[0].checked=false;
								for(j=i+1;j<r;j++){
									if(users[i].ID==users[j].post_parent){
										ele=document.getElementsByName(users[j].ID);
										ele[0].checked=false;
										if(users[j].ID==users[j+1].post_parent){
											i=j;
										}
									}
									else if(i!=x){
										i--;
										j--;
									}
								}
							}

						}	
					}
				}

				/* function CheckAll is used to check all check boxes on the basis of classname which is same */
				function papr_CheckAll( className,elem) {
 				   var elements = document.getElementsByClassName(className);
  				   var l = elements.length;
      				for (var i = 0; i < l; i++) {
          					elements[i].checked = true;
       					}
					} 

 				/* function UncheckAll is used to uncheck all the checkboxes present */
				function papr_UncheckAll(className, elem) {
					var elements = document.getElementsByClassName(className);
    				var l = elements.length;
					for (var i = 0; i < l; i++) {
            			elements[i].checked = false;
        				}
    				}

				function papr_requireInput(element, id){
					if(element.checked){
						document.getElementById(id).setAttribute("required", "required");
					} else {
						document.getElementById(id).removeAttribute("required");
					}
				}
				</script>

				<?php
				$mo_roles = array();
				global $wp_roles;
				$roles = $wp_roles->roles;
				foreach($roles as $key => $val)
					$mo_roles[] = $val["name"];
				?>

				<script>
				jQuery(function() {
				    function split( val ) {
				      return val.split( /;\s*/ );
				    }
				    function extractLast( term ) {
				      return split( term ).pop();
				    } 

				  	var mo_roles = <?php echo json_encode($mo_roles); ?>;
				   
				  	jQuery( ".mo_roles_suggest" )
				  	.on("keydown", function( event ) {
				    	if ( event.keyCode === jQuery.ui.keyCode.TAB && jQuery( this ).autocomplete( "instance" ).menu.active ) {
				      		event.preventDefault();
				    	}
				  	})
				  	.autocomplete({
				    	minLength: 0,
				    	source: function( request, response ) {
				      		response( jQuery.ui.autocomplete.filter(mo_roles, extractLast( request.term ) ) );
				    	},   
				    	focus: function() {
				      		return false;
				    	},
				    	select: function( event, ui ) {
					    	var terms = split( this.value );
					      	terms.pop();
					      	terms.push( ui.item.value );
					      	terms.push( "" );
					      	this.value = terms.join( "; " );
					     	return false;
				    	}
				  	});
				});
				</script>

<?php
				$page_ids = get_all_page_ids();
				$pages    = get_pages();
				$round = count($pages); 
				$restrictedpages = get_option( "papr_restricted_pages" );
				if ( get_option( "papr_allowed_roles_for_pages" ) ) {
					$allowed_roles = get_option( "papr_allowed_roles_for_pages" );
				} else {
					$allowed_roles = array();
				}
				$page = 0;
		
				echo '<br><br>&nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass1" name="mo_page_' . $page . '" value="true"';
					if(is_array($restrictedpages))
						if ( in_array('mo_page_0', $restrictedpages) ) {
							echo "checked";
						}
				echo '>';
				echo '<b>Home Page</b><i>&nbsp&nbsp<a  href="' . get_home_url() . '">[Visit Page]</a></i>
		               <input class="mo_roles_suggest" type="text" name="mo_role_values_0" id="'.$page.'"';
				echo 'value="';

				if ( array_key_exists( 'mo_page_0', $allowed_roles ) ) {
					echo $allowed_roles['mo_page_0'];
				} 
				else {
					"";
				}
				echo '" placeholder="Enter (;) separated Roles" style="width: 300px;"/><br><br>';
				$count=0;
		
				for( $i=0; $i<$round; $i++){
					$x=$i;
					if($i+1<$round&&$pages[$i]->ID==$pages[$i+1]->post_parent){
						echo '<a href="#" onclick="jQuery(\'#view' . $pages[$i]->ID . '\').toggle();"><img src="'. plugin_dir_url(__FILE__) . 'includes/images/collapse1.png"></a>';
						echo '<input type="checkbox" class="checkBoxClass1" name="'. $pages[$i]->ID . '" onclick="papr_Check('.$pages[$i]->ID.',this )"  value="true" onchange="papr_requireInput(this,\''. $pages[$i]->ID .'\');"';
							if(is_array($restrictedpages))
								if ( in_array($pages[$i]->ID, $restrictedpages) ) {
									echo "checked";
								}
						echo '>';
						echo '<b>' . get_the_title( $pages[$i]->ID ) . '</b>&nbsp<i><a href="' . get_page_link( $pages[$i]->ID ) . '">[Visit Page]</a></i>&nbsp';
						echo '          <input class="mo_roles_suggest" type="text" name="mo_role_values_' . $pages[$i]->ID . '" id="'.$pages[$i]->ID.'"';

						echo 'value="';
						if ( array_key_exists( $pages[$i]->ID, $allowed_roles ) ) {
							echo $allowed_roles[ $pages[$i]->ID ];
						}
						else {
							echo '';
						}
						echo '" placeholder="Enter (;) separated Roles" style="width: 300px;" /><br><br>';
	   
	                    echo '<div id="view' . $pages[$i]->ID .'">';
	                    	for($j=$i+1;$j<$round;$j++) {
	                    		if($pages[$i]->ID!=$pages[$j]->post_parent){
	                    			$i=--$j;
	                    			break;
	                    		}
	                   			for($z=0;$z<$count;$z++){
	                            	echo '&nbsp&nbsp&nbsp&nbsp';
	                    		}

			                    if( $j+1 < $round && $pages[$j]->ID==$pages[$j+1]->post_parent){
	                    			echo '&nbsp&nbsp&nbsp&nbsp<a href="#" onclick="jQuery(\'#view' . $pages[$j]->ID . '\').toggle();";"FUNCTION1()"><img id="ig1" src="'. plugin_dir_url(__FILE__) . 'includes/images/collapse1.png"></a>';
	                    			echo '<input type="checkbox" class="checkBoxClass1" name="'. $pages[$j]->ID . '" onclick="papr_Check('.$pages[$j]->ID.',this )"  value="true" onchange="papr_requireInput(this,\''. $pages[$j]->ID .'\');"';
										if(is_array($restrictedpages))
											if ( in_array($pages[$j]->ID, $restrictedpages) ) {
												echo "checked";
											}
									
									echo '> <b>' . get_the_title( $pages[$j]->ID ) . '</b>&nbsp<i><a href="' . get_page_link( $pages[$j]->ID ) . '">[Visit Page]</a></i>&nbsp';
									echo '<input class="mo_roles_suggest" type="text" name="mo_role_values_' . $pages[$j]->ID . '" id="'.$pages[$j]->ID.'" ';
										echo 'value="';
											if ( array_key_exists( $pages[$j]->ID, $allowed_roles ) ) {
												echo $allowed_roles[ $pages[$j]->ID ];
											} else {
												echo "";
											}
										echo '" placeholder="Enter (;) separated Roles" style="width: 300px;" /><br><br>';
		                			
		                			$i=$j;
		                			$count++;
		               					echo '<div id="view' . $pages[$j]->ID .'">';			  
			                	}
			                	else {		
			        				echo'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass1" name="' . $pages[$j]->ID . '" value="true" onchange="papr_requireInput(this,\''. $pages[$j]->ID .'\');"';
			        			        if(is_array($restrictedpages))
											if ( in_array($pages[$j]->ID, $restrictedpages) ) {
												echo "checked";
											}
									echo '>';
									echo '<b>' . get_the_title( $pages[$j]->ID ) . '</b>&nbsp<i><a href="' . get_page_link( $pages[$j]->ID ) . '">[Visit Page]</a></i>&nbsp';
									echo '  <input class="mo_roles_suggest" type="text" name="mo_role_values_' . $pages[$j]->ID . '" id="'.$pages[$j]->ID.'" ';
										echo 'value="';
											if ( array_key_exists( $pages[$j]->ID, $allowed_roles ) ) {
												echo $allowed_roles[ $pages[$j]->ID ];
											} 
											else {
												echo "";
											}
									echo '" placeholder="Enter (;) separated Roles" style="width: 300px;" /><br><br>';
			                    	
			                    	if($j+1<$round&&$pages[$i]->ID!=$pages[$j+1]->post_parent){              	
					                    if($count>=1){
					                    	$count--;
					                    }
					                    if($x!=$i){
			                    			for($k=0;$k<$round;$k++){
			                    				if($pages[$k]->ID==$pages[$i]->post_parent){
			                    					$i=$k;
			                    			        $k=-1;
			                    			        
			                    		echo'</div>';
			                    					if($pages[$i]->ID==$pages[$j+1]->post_parent){
			                    						break;
			                    					}
			                    					if($i==$x){
			                    						break;
			                    					}
			                    				}
			                    			}
			                    		}
			                       	}
			                       	else if($j+1==$round && $i!=$x) {
			                     		for($k=0;$k<$round;$k++){
			                    			if($pages[$k]->ID==$pages[$i]->post_parent){
			                					$i=$k;
			                			        $k=-1;
			            echo'</div>';
			                					if($pages[$i]->ID==$pages[$j+1]->post_parent){
			                						break;
			                					}
			                    			}
			                    		}
			                       		$i=$j;
			                       		break;
			                       	}
			                       	else if($j+1>=$round){
			                       		$i=$j;
			                       		break;
			                       	}
		                    	}
		                	}

						echo'</div>';         
					}
					else{
						echo'&nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass1" name="' . $pages[$i]->ID . '" value="true" onchange="papr_requireInput(this,\''. $pages[$i]->ID .'\');"';

						if(is_array($restrictedpages))
							if (in_array($pages[$i]->ID, $restrictedpages) ) {
								echo "checked";
							}
						echo '> <b>' . get_the_title( $pages[$i]->ID ) . '</b>&nbsp<i><a href="' . get_page_link( $pages[$i]->ID ) . '">[Visit Page]</a></i>&nbsp';
						echo '          <input class="mo_roles_suggest" type="text" name="mo_role_values_' . $pages[$i]->ID . '" id="'.$pages[$i]->ID.'" ';

						echo 'value="';
						if ( array_key_exists( $pages[$i]->ID, $allowed_roles ) ) {
							echo $allowed_roles[ $pages[$i]->ID ];
						} else {
							echo "";
						}
						echo '" placeholder="Enter (;) separated Roles" style="width: 300px;" /><br><br>';          
					}
				}

				echo '<br><input type="submit" class="button button-primary button-larges"  value="Save Configuration"';
				echo $wpdb->query("Select * from $wpdb->posts");

				echo ' />';
				echo '
		    </form>
            <br>
            <h3>Give Access to Posts based on Roles</h3>
            <p>
            	<b>Note </b>: Enter a role(s) of a user that you want to give access to for a post (By default all posts are accessible to all users irrespective of their roles).
            </p>

            <form name="f" style="margin-left:6px;" method="post" action="" id="blockedpostsform">';
            	wp_nonce_field("papr_restrict_posts");
            	echo  '<input type="hidden" name="option" value="papr_restrict_posts" />';
        echo '
        		<table>'; 
?>
					<a href="#" id="selectall" onclick="papr_CheckAll('checkBoxClass2', this)">Select All</a> &nbsp;
					<a href="#" id="unselectall" onclick="papr_UncheckAll('checkBoxClass2', this)">Deselect All</a>
	<?php
					$post_ids= get_posts(array(
						'fields'  => 'ids', 
						'fields'  => 'post_title',
						'numberposts'  => -1  
					));
					
					$restrictedposts = get_option( "papr_restricted_posts" );
					if ( get_option( "papr_allowed_roles_for_posts" ) ) {
						$allowed_roles_for_posts = get_option( "papr_allowed_roles_for_posts" );
					} else {
						$allowed_roles_for_posts = array();
					}
					foreach ( $post_ids as $post ) {
					echo '
						<tr style="margin-bottom:3%;"><td><input type="checkbox" class="checkBoxClass2" name="mo_post_' . $post->ID . '" value="true"';
							if(is_array($restrictedposts))
								if ( in_array($post->ID, $restrictedposts) ) {
									echo "checked";
								}
						echo '>';
						echo ' <b>' . $post->post_title . '</b><i>&nbsp&nbsp<a " href="' . get_permalink( $post ) . '">[Visit Post]</a></i></td>';
						echo '
							<td>
								<input class="mo_roles_suggest" type="text" name="mo_role_values_' . $post->ID . '"';
								echo 'value="';
									if ( array_key_exists( $post->ID, $allowed_roles_for_posts ) ) {
										echo $allowed_roles_for_posts[ $post->ID ];
									} else {
										"";
									}
								echo '" placeholder="Enter (;) separated Roles" style="width: 300px;" />';
						echo'<br><br>';
					echo'	
							</td>
						</tr>';
					}

			echo '      
				</table><br>
                <input type="submit" class="button button-primary button-larges" value="Save Configuration"/>
            </form>';

	echo '
                <br>
               
                <h3>Give Access to Category of Posts based on Roles
                <sup style="font-size: 12px; color: red;">[Available in <a href="'. admin_url( "admin.php?page=page_restriction&tab=premium_plan" ).'">Paid version</a> of the plugin]</sup>
                </h3>
                <p><b>Note </b>: Enter a role(s) of a user that you want to give access to for a Category post (By default all posts are accessible to all users irrespective of their roles). </p>
                <table>
        '; 
        ?>
					<a href="" style="color:currentColor;cursor: not-allowed;opacity: 0.5;">Select All</a> &nbsp;
					<a href="" style="color:currentColor;cursor: not-allowed;opacity: 0.5;">Deselect All</a>
		<?php
					$categories_ids= get_categories(array("hide_empty" => 0,
			            "type"      => "post",
			            "orderby"   => "name",
			            "order"     => "ASC" ));

					foreach ( $categories_ids as $category ) {
						echo '
							<tr style="margin-bottom:3%;"><td><input type="checkbox" style="cursor:not-allowed;" class="checkBoxClass2" name="mo_category_' . $category->term_id . '" value="true" disabled>
							<b>' . $category->name . '</b><i>&nbsp&nbsp<a href="' . get_category_link( $category ) . '">[Visit Category]</a></i></td>';
						echo '
							<td><input class="mo_roles_suggest" style="cursor:not-allowed;width:175%" type="text" name="mo_role_values_' . $category->term_id . '" disabled value="" placeholder="Enter (;) separated Roles" style="width: 300px;" /><br><br></td></tr>';
					}
		echo '       
				</table>
				<br>
                <input type="submit" style="cursor:not-allowed;" class="button button-primary button-larges" value="Save Configuration" disabled> 
                <br><br>
		</div>
		<br>
	</div>';
}

function papr_restrict_complete_post_type(){

	echo '
	<div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding-left:10px;border:solid 1px rgba(255, 255, 255, 255);border: 1px solid #CCCCCC";>
		<h3>Restrict Entire Custom Post Type<sup style = "font-size: 12px;color:red;">
		[Available in <a href="'. admin_url( "admin.php?page=page_restriction&tab=premium_plan" ).'">Paid version</a> of the plugin]</sup></h3>
		<hr>
		<div style="padding-left:16px">		
			<h3>Select post types you want to give access to Logged in Users only</h3>
			<p><b>Note </b>: Select the custom post type that you want to restrict access for a user not Logged In (By default all custom post types are accessible to all users). </p>';

			$custom_post_types = papr_get_custom_post_types();

			foreach ( $custom_post_types as $post_key=>$post_title ) {

				$post_ids= get_posts(array(
					'fields'  => 'ids', // get post IDs
					'post_type' => $post_key,
					'fields'  => 'post_title',
					'numberposts'  => -1  // to get all the posts
				));

				if(count($post_ids)!=0) {
					echo '<a href="#" onclick="jQuery(\'#view' . $post_key . '\').toggle();"><img src="'. plugin_dir_url(__FILE__) . 'includes/images/collapse1.png"></a>';
				}

				echo '&nbsp<input type="checkbox" class="checkBoxClass4" name="mo_redirect_post_' . $post_key . '" value="true" ';
				echo ' disabled ';
				echo '> <b>' . $post_title . '</b><br><br>';

				if(count($post_ids)!=0) {
					echo '<div id="view' . $post_key .'">';
					foreach($post_ids as $post) {
						echo ' &nbsp&nbsp&nbsp&nbsp&nbsp<input type="checkbox" class="checkBoxClass3" value="true"';
						echo ' disabled ';
						echo '> <b>' . $post->post_title . '</b>&nbsp<i><a  href="' . get_permalink( $post ) . '">[visit post]</a></i><br><br>';
					}
					echo '</div>';
				}
			}
			echo '<br> <input type="submit" class="button button-primary button-larges" value="Save Configuration" disabled';
			echo ' />
			</form></br></br>
		  </div></div>
		';
}

function papr_get_custom_post_types(){
	$args = array(
		'public'   => true,
		'_builtin' => false
	 );
	 
	 $output = 'names'; // names or objects, note names is the default
	 $operator = 'and'; // 'and' or 'or'
	 
	 $post_types = get_post_types( $args, $output, $operator ); 
	return $post_types;
	
}



function papr_support_page_restriction() {
	?>
    <div style="background-color: #FFF;margin-top:1px;width: 90%;border: 1px solid #CCC;padding: 0px 15px;">
        <div>
            <h3>Support/Contact Us</h3>
            <hr>
            <p>Need any help? We can help you with configuring your Page Restriction Plugin. Just send us a query and we will get back to you soon.</p>
            <form method="post" action="">
            	<?php wp_nonce_field("papr_contact_us_query_option");?>
                <input type="hidden" name="option" value="papr_contact_us_query_option">
                <table style="width:100%">
                    <tr>
                        <td>
                        	<input style="width:95%" type="email" class="mo_pr_table_textbox" required
                                   name="papr_contact_us_email"
                                   value="<?php echo ( get_option( 'papr_admin_email' ) == '' ) ? get_option( 'admin_email' ) : get_option( 'papr_admin_email' ); ?>"
                                   placeholder="Enter your email">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        	<input type="tel" style="width:95%" id="contact_us_phone"
                                   pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}"
                                   class="mo_pr_table_textbox"
                                   name="papr_contact_us_phone"
                                   value="<?php echo get_option( 'mo_pr_admin_phone' ); ?>"
                                   placeholder="Enter your phone">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        	<textarea style="width:95%; resize: vertical;" onkeypress="papr_valid_query(this)"
                                      onkeyup="papr_valid_query(this)" onblur="papr_valid_query(this)" required
                                      name="papr_contact_us_query" rows="4"
                                      placeholder="Write your query here">
                            </textarea>
                        </td>
                    </tr>
                </table>
                <div style="text-align:center;">
                    <input type="submit" name="submit" style="margin:15px; width:120px;"
                           class="button button-primary button-large"/>
                </div>
            </form>
            <br>
        </div>
    </div>
    <script>
        jQuery("#contact_us_phone").intlTelInput();
        jQuery("#phone_contact").intlTelInput();

        function papr_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
                /[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
        }
    </script>
<?php }	

		
//Display options for the customer to choose from when user is restricted
function papr_display_options_page() {
	echo '
	<div style="background-color: #FFF;width: 93%;border: 1px solid #CCC;padding: 10px; cursor: not-allowed;">       
        <h3 style="margin-top:">Page Restrict Options 
        <sup style="font-size: 12px; color: red;">[Available in <a href="'. admin_url( "admin.php?page=page_restriction&tab=premium_plan" ).'">Paid version</a> of plugin]</sup>
        </h3>
		<hr><br>
		<div style="padding-left:10px">
            <table>
                <tr style="margin-bottom:7%;">
                	<input style="cursor: not-allowed;" type="radio" name="mo_display" disabled >
					<b>Redirect to Login Page</b>
					<br><b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to WP Login Page. </p>
     			</tr>
                <tr>
                	<td width="60%" style="padding-bottom:6px;">
                    	<input style="cursor: not-allowed;" type="radio" name="mo_display" value="mo_display_page" disabled>
						<b>Redirect to Page Link</b>
					</td>
				</tr>
				<tr>
					<td colsapn="2">
                    	<input type="url" style="width:90%;cursor: not-allowed;" name="mo_display_page_url" id="mo_page_url" disabled placeholder="Enter URL of the page">
                     	<td>
                        	<button style="cursor: not-allowed;" class="button button-primary button-larges disabled value = "" placeholder = "Enter URL of the page">
                        		<b>SAVE & TEST URL
                        	</button> 
                        </td>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to the given page URL.<br><font color="#8b008b">Please provide a valid URL and make sure that the given page is not Restricted</font>
 						<br><br>
 					</td>
 				</tr>

				<tr>
                    <td  style="padding-bottom:6px;" width="70%">
                    	<input style="cursor: not-allowed;" type="radio" name="mo_display" value="mo_display_message" disabled>
                    	<b>Message on display</b><br>
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input type="text" style="width:90%;cursor:not-allowed;" name="mo_display_message_text" disabled="" value="" placeholder = "Enter message to display"/>
						<td>
							<button style="cursor: not-allowed;" class="button button-primary button-larges" disabled> SAVE & Preview</button>    
                    	</td>
                    </td>
                </tr>
                <tr>
					<td colspan="2">
						<b>Note </b>: Enabling this option will display the configured message to the restricted users.
					</td>
				</tr>
 				<tr style="margin-bottom:7%;">
                    <input style="cursor: not-allowed;" type="radio" name="mo_display" disabled>
                    <b>Single Sign On </b>
					<br>
					<b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to IDP login page.</p>

     			</tr>
  			</table>
            <br><br>
        </div>
    </div>';
}

function papr_display_options_log() {
	echo '
	<div style="display:block;background-color: #FFF;width: 93%;border: 1px solid #CCC;padding: 10px;">
        <h3>Page Restrict Options
        <sup style="font-size: 12px; color: red;">[Available in <a href="'. admin_url( "admin.php?page=page_restriction&tab=premium_plan" ).'">Paid version</a> of the plugin]</sup>
        </h3>
		<hr>
		<div style="padding:15px">
        	<input type="hidden" style="cursor: not-allowed;" name="option" value="mo_display_option_login_log">
        	<table>
        		<tr>
        			<td colspan="2" style="padding-bottom:6px">
        				<input style="cursor: not-allowed;" type="radio" name="mo_display" value="mo_display_page_log" disabled>
        				<b>Redirect to Page Link</b>
					</td>
				</tr>
				<tr>
					<td width="80%" colspan="2">
                    	<input type="url" name="mo_display_page_url_log" style="width:90%;cursor:not-allowed;" id="mo_page_url" disabled placeholder = "Enter URL of the page"/>
                        <td><b>
                        	<button style="cursor: not-allowed;" class="button button-primary button-larges" disabled>SAVE & TEST URL</button>
                        </td>
                    </td>
                </tr>
				<tr>
					<td colspan="3">
						<br><b>Note </b>: Enabling this option will <i><b>Redirect</b></i> the restricted users to the given page URL.
						<br>
						<font color="#8b008b">Please provide a valid URL and make sure that the given page is not Restricted</font>
 					</td>
 				</tr>
				<tr>
					<td>
						<br>
					</td>
				</tr>
				<tr>
                	<td style="padding-bottom:6px">
                    	<input style="cursor: not-allowed;" type="radio" name="mo_display" value="mo_display_message_log" disabled>
                    	<b>Message on display</b>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">
                    	<input type="text" name="mo_display_message_text_log" style="width:90%; cursor:not-allowed;" disabled value="" placeholder = "Enter your message here">
						<td>
							<button style="cursor: not-allowed;" class="button button-primary button-larges" disabled>SAVE & Preview</button> 
						</td>
                    </td>
                </tr>
                <tr>            
					<td colspan="3">
						<br>
						<b>Note </b>: Enabling this option will display the configured message to the restricted users.
					</td>
				</tr>
			</table>   
            <br><br>
        </div>
    </div>';
}


function papr_is_customer_registered() {

    $email       = get_option( 'papr_admin_email' );
    $customerKey = get_option( 'papr_admin_customer_key' );
    if ( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) ) {
        return 0;
    } else {
        return 1;
    }
}

function papr_show_customer_details(){
?>
    <div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding-left:10px;border:solid 1px rgba(255, 255, 255, 255);border:solid 1px  #CCCCCC"; >
        <h2>Thank you for registering with miniOrange.</h2>
        <div style="padding: 10px;">
	        <table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; margin-bottom:15px; width:85%">
		        <tr>
		            <td style="width:45%; padding: 10px;">miniOrange Account Email</td>
		            <td style="width:55%; padding: 10px;"><?php echo get_option( 'papr_admin_email' ); ?></td>
		        </tr>
		        <tr>
		            <td style="width:45%; padding: 10px;">Customer ID</td>
		            <td style="width:55%; padding: 10px;"><?php echo get_option( 'papr_admin_customer_key' ) ?></td>
		        </tr>
	        </table>
	        
		    <table>
			    <tr>
				    <td>
					    <form name="f1" method="post" action="" id="papr_goto_login_form">
					    	<?php wp_nonce_field("papr_change_miniorange");?>
					        <input type="hidden" value="papr_change_miniorange" name="option"/>
					        <input type="submit" value="Change Email Address" class="button button-primary button-large"/>
					    </form>
				    </td>
				    <td>
		    			<a href="<?php echo admin_url("admin.php?page=page_restriction&tab=premium_plan");?>"><input type="button" class="button button-primary button-large" value="Check Premium Plans"/></a>
		    		</td>
		    	</tr>
		    </table>
		</div>
		<br>
    </div>

    <?php
}

function papr_show_new_registration_page() {
    update_option( 'papr_new_registration', 'true' );
    ?>
    <div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding:10px 20px 20px 20px;border:solid 1px rgba(255, 255, 255, 255);border:solid 1px  #CCCCCC";>
	    <form name="f" method="post" action="">
	        <?php wp_nonce_field("papr_register_customer");?>
	        <input type="hidden" name="option" value="papr_register_customer">
	        <div>
	            <h2>Register with miniOrange</h2>
	            <hr>
	            <div id="panel1">
	                <p style="font-size:14px;"><b>Why should I register? </b></p>
	                <div id="help_register_desc" style="background: aliceblue; padding: 10px 10px 10px 10px; border-radius: 10px;">
	                    You should register so that in case you need help, we can help you with step by step instructions. <b>You will also need a miniOrange account to upgrade to the premium version of the plugin.</b> We do not store any information except the email that you will use to register with us.
	                </div>
	                </p>
	                <table>
	                    <tr>
	                        <td><b><font color="#FF0000">*</font>Email:</b></td>
	                        <td><input class="mo_papr_table_textbox" style="width:100%" type="email" name="email"
	                                   required placeholder="person@example.com"
	                                   value="<?php echo ( get_option( 'papr_admin_email' ) == '' ) ? get_option( 'admin_email' ) : get_option( 'papr_admin_email' ); ?>"/>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td><b><font color="#FF0000">*</font>Password:</b></td>
	                        <td><input class="mo_papr_table_textbox" style="width:100%" required type="password"
	                                   name="password" placeholder="Choose your password (Min. length 6)"
	                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
	                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."
	                                   /></td>
	                    </tr>
	                    <tr>
	                        <td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
	                        <td><input class="mo_papr_table_textbox" style="width:100%" required type="password"
	                                   name="confirmPassword" placeholder="Confirm your password"
	                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
	                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present.">
	                        </td>
	                    </tr>
	                    <tr>
	                        <td>&nbsp;</td>
	                        <td>
	                        	<br>
	                        	<input type="submit" name="submit" value="Register" class="button button-primary button-large"/>
	                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                            <input type="button" name="papr_goto_login" id="papr_goto_login" value="Already have an account?" class="button button-primary button-large"/>
	                            &nbsp;&nbsp;
	                        </td>
	                    </tr>
	                </table>
	            </div>
	        </div>
	    </form>
	</div>
    <form name="f1" method="post" action="" id="papr_goto_login_form">
    <?php wp_nonce_field("papr_goto_login");?>
        <input type="hidden" name="option" value="papr_goto_login"/>
    </form>

    <script>
        jQuery('#papr_goto_login').click(function () {
            jQuery('#papr_goto_login_form').submit();
        });
    </script>
    <?php
}


function papr_show_verify_password_page() {
    ?>
    <form name="f" method="post" action="">
    <?php wp_nonce_field("papr_verify_customer");?>
        <input type="hidden" name="option" value="papr_verify_customer">
        <div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding:10px 20px 20px 20px;border:solid 1px rgba(255, 255, 255, 255);">
                <h3>Login with miniOrange</h3>
            <hr>
            <div id="panel1">
                <p>
                	<b>It seems you already have an account with miniOrange. Please enter your miniOrange email and password.
                		<br><a target="_blank" href="https://login.xecurify.com/moas/idp/resetpassword">Click here if you forgot your password?</a>
            		</b>
            	</p>
                <br>
                <table>
                    <tr>
                        <td><b><font color="#FF0000">*</font>Email:</b></td>
                        <td><input class="mo_papr_table_textbox" style="width:120%" type="email" name="email"
                                   required placeholder="person@example.com"
                                   value="<?php echo get_option( 'papr_admin_email' ); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b><font color="#FF0000">*</font>Password:</b></td>
                        <td><input class="mo_papr_table_textbox" style="width:120%" required type="password"
                                   name="password" placeholder="Enter your password"
                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present.">
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="width:75%;">
                        	<br>
                            <input type="submit" name="submit" value="Login" class="button button-primary button-large" style="width:40%;"/>
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" name="papr_goback" id="papr_goback" value="Back" class="button button-primary button-large" style="width:40%;"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>

    <form name="f" method="post" action="" id="papr_goback_form">
        <?php wp_nonce_field("papr_go_back")?>
        <input type="hidden" name="option" value="papr_go_back"/>
    </form>
    <form name="f" method="post" action="" id="papr_forgotpassword_form">
    <?php wp_nonce_field("papr_forgot_password_form_option");?>
        <input type="hidden" name="option" value="papr_forgot_password_form_option"/>
    </form>
    <script>
        jQuery('#papr_goback').click(function () {
            jQuery('#papr_goback_form').submit();
        });
        jQuery("a[href=\"#papr_forgot_password_link\"]").click(function () {
            jQuery('#papr_forgotpassword_form').submit();
        });
    </script>
    <?php
}