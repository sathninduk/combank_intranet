<?php

class MoLdapLocalRoleMapping{

	function mo_ldap_local_update_role_mapping($user_id) {
		if($user_id==1) {
			return;
		}

		$roles = 0;
        $wpuser = new WP_User($user_id);

		if ($roles == 0) {
			if(get_option('mo_ldap_local_mapping_value_default')) {
				$wpuser->set_role( get_option('mo_ldap_local_mapping_value_default') );
			}
		}
	}
}
?>