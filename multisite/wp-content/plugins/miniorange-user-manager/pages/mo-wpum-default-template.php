<?php
class Mo_Wpum_Default_Template{
	public $from_email = 'admin@example.com';
	public $to_email = 'user@example.com';
	public $subject = 'user manager';
	public $activation_email_body = "Hello,<br>Following is the link to activate your account on <b>##Blog Name##</b><br>Activation link :<a href=##Activation Link##>##Activation Link## </a><br><br> Thanks,<br> miniOrange";
	public $admin_notification_body = "Hello,<br>Following user is trying to create account on <b>##Blog Name##</b><br><br>User Name : ##User Name##<br><br>User Email : ##User Email##<br><br> You can click on following link to activate user <br><a href=##Activation Link##>##Activation Link##</a> <br><br>Thanks,<br>miniOrange";
	public $activation_confirmation = "Hello,<br><b>##User Name##</b> has been activated to your site<b> ##Blog Name##</b> successfully.<br><br>Thanks,<br>miniOrange";
}
?>