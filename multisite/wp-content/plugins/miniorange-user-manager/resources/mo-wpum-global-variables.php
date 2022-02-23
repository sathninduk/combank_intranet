<?php
	class Mo_Wpum_Global_Variables{
		function __construct() {
			global $mo_manager_utility,$role_cap_actions,$sign_up_actions,$db_queries,$notification_actions,$login_actions,$registration,$template,$default_template,$custom_fields_actions;
			$mo_manager_utility = new Mo_Manager_Utility();
			$role_cap_actions = new Mo_Wpum_Role_Cap_Actions();
			$sign_up_actions = new Mo_Wpum_Sign_Up_Actions();
			$db_queries = new Mo_Db_Queries();
			$notification_actions = new Mo_Wpum_Notification_Actions();
			$login_actions = new Mo_Wpum_Login_Actions();
			$registration = new Mo_Wpum_Registration_Actions();
			$template = new Mo_Database_Setup();
			$default_template = new Mo_Wpum_Default_Template();
			$custom_fields_actions = new Mo_Wpum_Custom_Fields_Actions();
		}
	}
?>