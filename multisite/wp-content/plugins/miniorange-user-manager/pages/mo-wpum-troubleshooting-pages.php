<?php
function mo_wpum_show_troubleshooting(){
	?>
	
	<div class="mo_wpum_table_layout">
		<table class="mo_wpum_help">
					<tbody><tr>
						<td class="mo_wpum_help_cell">
							<div id="mo_wpum_help_curl_title" class="mo_wpns_title_panel">
								<div class="mo_wpum_help_title">How to enable PHP cURL extension? (Pre-requisite)</div>
							</div>
							<div hidden="" id="mo_wpum_help_curl_desc" class="mo_wpum_help_desc" style="display: none;">
								<ul>
									<li>Step 1:&nbsp;&nbsp;&nbsp;&nbsp;Open php.ini file located under php installation folder.</li>
									<li>Step 2:&nbsp;&nbsp;&nbsp;&nbsp;Search for <b>extension=php_curl.dll</b>. </li>
									<li>Step 3:&nbsp;&nbsp;&nbsp;&nbsp;Uncomment it by removing the semi-colon(<b>;</b>) in front of it.</li>
									<li>Step 4:&nbsp;&nbsp;&nbsp;&nbsp;Restart the Apache Server.</li>
								</ul>
								For any further queries, please contact us.								
							</div>
						</td>
					</tr><tr>
						<td class="mo_wpum_help_cell">
							<div id="mo_wpum_help_otp_title" class="mo_wpns_title_panel">
								<div class="mo_wpum_help_title">OTP and Forgot Password</div>
							</div>
							<div hidden="" id="mo_wpum_help_otp_desc" class="mo_wpum_help_desc" style="display: none;">
								<h4><a  id="mo_wpum_question1"  >I did not receive OTP. What should I do?</a></h4>
								<div  id="mo_wpum_question1_desc">
									The OTP is sent as an email to your email address with which you have registered with miniOrange. If you can't see the email from miniOrange in your mails, please make sure to check your SPAM folder. <br/><br/>If you don't see an email even in SPAM folder, please verify your account using your mobile number. You will get an OTP on your mobile number which you need to enter on the page. If none of the above works, please contact us using the Support form on the right.
								</div>
								<hr>
								<h4><a  id="mo_wpum_question2"  >After entering OTP, I get Invalid OTP. What should I do?</a></h4>
								<div  id="mo_wpum_question2_desc">
									Use the <b>Resend OTP</b> option to get an additional OTP. Please make sure you did not enter the first OTP you recieved if you selected <b>Resend OTP</b> option to get an additional OTP. Enter the latest OTP since the previous ones expire once you click on Resend OTP. <br/><br/>If OTP sent on your email address are not working, please verify your account using your mobile number. You will get an OTP on your mobile number which you need to enter on the page. If none of the above works, please contact us using the Support form on the right.
								</div>
								<hr>
								<h4><a  id="mo_wpum_question3" >I forgot the password of my miniOrange account. How can I reset it?</a></h4>
								<div  id="mo_wpum_question3_desc">
									There are two cases according to the page you see -<br><br/>
										1. <b>Login with miniOrange</b> screen: You should click on <b>forgot password</b> link. You will get your new password on your email address which you have registered with miniOrange . Now you can login with the new password.<br><br/>
										2. <b>Register with miniOrange</b> screen: Enter your email ID and any random password in <b>password</b> and <b>confirm password</b> input box. This will redirect you to <b>Login with miniOrange</b> screen. Now follow first step.
								</div>
							</div>
						</td>
					</tr><tr>
						<td class="mo_wpum_help_cell">
							<div id="mo_wpum_help_editor" class="mo_wpum_title_panel">
								<div class="mo_wpum_help_editor">Why is the "Send notification via PHP Mail()" option not working?</div>
							</div>
							<div hidden="" id="mo_wpum_help_editor_desc" class="mo_wpum_help_desc" style="display: none;">
								Please check your SMTP configurations <b>OR</b> make sure your server is hosting SMTP server.
							</div>
						</td>
					</tr>
				</tbody></table>
	</div>
	
	
	<?php

}