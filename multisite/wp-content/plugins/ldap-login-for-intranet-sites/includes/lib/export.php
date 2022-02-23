<?php

include "BasicEnum_Ldap.php";

class mo_options_ldap_acc_details extends MoLdapBasicEnum{
    const admin_customer_id = "mo_ldap_local_admin_customer_key";
    const admin_api_key = "mo_ldap_local_admin_api_key";
}
 class mo_options_ldap_config_details extends MoLdapBasicEnum{
     const Ldap_login_enable = "mo_ldap_local_enable_login";
     const auth_admin_both_ldap_wp = "mo_ldap_local_enable_admin_wp_login";
     const auto_registering = "mo_ldap_local_register_user";
     const directory_server_value = "mo_ldap_directory_server_value";
     const server_url ="mo_ldap_local_server_url";
     const server_dn = "mo_ldap_local_server_dn";
     const server_password = "mo_ldap_local_server_password";
     const search_base = "mo_ldap_local_search_base";
     const search_filter ="mo_ldap_local_search_filter";
     const Username_Attribute = "Filter_search";
	 const plugin_version = "mo_ldap_local_current_plugin_version";
 }

class MoLdapFeedbackOptions extends MoLdapBasicEnum{
    const Features_not_available = "Does not have the features I'm looking for";
    const Not_upgrading_to_premium = "Do not want to upgrade to Premium version";
    const Confusing_interface = "Confusing Interface";
    const Bugs_in_plugin = "Bugs in the plugin";
    const Other_reasons = "Other Reasons:";
}



class MoLdapEnumPointers extends MoLdapBasicEnum{
    public static $SERVICE_PROVIDER_LDAP = array(
		'custom_admin_pointers4_8_52_miniorange-fallback-login',
        'custom_admin_pointers4_8_52_miniorange-select-your-ldap-directory',
        'custom_admin_pointers4_8_52_miniorange-select-your-ldap-server',
        'custom_admin_pointers4_8_52_miniorange-ldap-server-url',
        'custom_admin_pointers4_8_52_miniorange-select-your-ldap-server-port',
        'custom_admin_pointers4_8_52_miniorange-ldap-anony',
        'custom_admin_pointers4_8_52_miniorange-ldap-server-username',
        'custom_admin_pointers4_8_52_miniorange-ldap-server-password',
        'custom_admin_pointers4_8_52_miniorange-ldap-search-base',
        'custom_admin_pointers4_8_52_miniorange-ldap-search-filter',
        'custom_admin_pointers4_8_52_miniorange-test-auth',
        'custom_admin_pointers4_8_52_configure-ldap-service-restart-tour',
    );
    public static $ROLE_MAPPING_LDAP = array(
        'custom_admin_pointers4_8_52_miniorange-default-role-mapping',
        'custom_admin_pointers4_8_52_miniorange-enable-role-mapping',
        'custom_admin_pointers4_8_52_role-mapping-ldap-tour',
   );
    public static $ATTRIBUTE_MAPPING_LDAP = array(
        'custom_admin_pointers4_8_52_minorange-ldap-attr-mail-map',
        'custom_admin_pointers4_8_52_miniorange-test-attr-config',
        'custom_admin_pointers4_8_52_miniorange-redirection-ldap-restart-tour');
    public static $EXPORT_IMPORT_CONFIG_LDAP = array(
        'custom_admin_pointers4_8_52_minorange-ldap-save-config',
        'custom_admin_pointers4_8_52_miniorange-ldap-export-feature',
        'custom_admin_pointers4_8_52_miniorange-redirection-ldap-config-restart-tour',
    );

    public static $LDAP_PLUGIN_TOUR = array(
        'custom_admin_pointers4_8_52_miniorange-default-tab',
        'custom_admin_pointers4_8_52_miniorange-signin-settings-tab',
        'custom_admin_pointers4_8_52_miniorange-multiple-directories-tab',
        'custom_admin_pointers4_8_52_miniorange-role-mapping-tab',
        'custom_admin_pointers4_8_52_miniorange-attribute-mapping-tab',
        'custom_admin_pointers4_8_52_miniorange-configuration-settings-tab',
		'custom_admin_pointers4_8_52_miniorange-users-report-tab',
        'custom_admin_pointers4_8_52_miniorange-licensing-plans-tab',
        'custom_admin_pointers4_8_52_miniorange-troubleshooting-tab',
        'custom_admin_pointers4_8_52_miniorange-account-setup-tab',
        'custom_admin_pointers4_8_52_miniorange-premium-plugin-trial-tab',
        'custom_admin_pointers4_8_52_miniorange-add-on-tab',
        'custom_admin_pointers4_8_52_miniorange-feature-request-tab',
        'custom_admin_pointers4_8_52_miniorange-features-tab',
        'custom_admin_pointers4_8_52_miniorange-licensing-tab',
        'custom_admin_pointers4_8_52_miniorange-restart-plugin-tour',
    );
}