<?php
class MoAddonListContent
{

    function __construct()
    {

        define("MO_LDAP_RECOMMENDED_ADDONS",serialize( array(

            "DIRECTORY_SYNC" =>      [
                'addonName'  => 'Sync Users LDAP Directory',
                'addonDescription'  => 'Synchronize Wordpress users with LDAP directory and vice versa. Schedules can be configured for the synchronization to run at a specific time and after a specific interval.',
                'addonPrice' => '169',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-configure-miniorange-directory-sync-add-on-for-wordpress',
                'addonVideo' =>'https://www.youtube.com/embed/DqRtOauJjY8',

            ],
            "KERBEROS_NTLM" =>      [
                'addonName'  => 'Auto Login (SSO) using Kerberos/NTLM',
                'addonDescription'  => 'Provides the feature of auto-login (SSO) into your wordpress site on domain joined machines.',
                'addonPrice' => '169',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-setup-kerberos-single-sign-sso',
                'addonVideo' =>'https://www.youtube.com/embed/JCVWurFle9I',

            ],
            "PASSWORD_SYNC" =>      [
                'addonName'  => 'Password Sync with LDAP Server',
                'addonDescription'  => 'Synchronize your WordPress profile password with your LDAP user profile.',
                'addonPrice' => '119',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-setup-password-sync-with-ldap-add-on',
                'addonVideo' =>'https://www.youtube.com/embed/6XGUvlvjeUQ',
            ],
            "PROFILE_PICTURE_SYNC" =>      [
                'addonName'  => 'Profile Picture Sync for WordPress and BuddyPress',
                'addonDescription'  => 'Update your WordPress and BuddyPress profile picture with thumbnail photos stored in your LDAP directory.',
                'addonPrice' => '119',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/configure-miniorange-profile-picture-map-add-on-for-wordpress',
                'addonVideo' =>'https://www.youtube.com/embed/RL_TJ48kV5w',
            ],
            "LDAP_SEARCH_WIDGET" =>      [
                'addonName'  => 'Search Staff from LDAP Directory',
                'addonDescription'  => 'Search/display your directory users on your website using search widget and shortcode.',
                'addonPrice' => '129',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-setup-miniorange-ldap-search-widget-add-on',
                'addonVideo' =>'https://www.youtube.com/embed/GEw6dOx7hRo',
            ],
            "PAGE_POST_RESTRICTION" =>      [
                'addonName'  => 'Page/Post Restriction',
                'addonDescription'  => 'Allows you to control access to your site\'s content (pages/posts) based on LDAP groups/WordPress roles.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/wordpress-page-restriction',
                'addonVideo' =>'',
            ],
            "USER_META" =>      [
                'addonName'  => 'Third Party Plugin User Profile Integration',
                'addonDescription'  => 'Update profile information of any third-party plugin with information from LDAP Directory.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-setup-third-party-user-profile-integration-with-ldap-add-on',
                'addonVideo' =>'https://www.youtube.com/embed/KLKKe4tEiWI',
            ],
            "" =>      [
                'addonName'  => '',
                'addonDescription'  => '',
                'addonPrice' => '',
                'addonLicense' => '',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "CUSTOM_NOTIFICATION_WP_LOGIN" =>      [
                'addonName'  => 'Custom Notifications on WordPress Login page',
                'addonDescription'  => 'Add/Display customized messages on your WordPress login page.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
        )));

        define("MO_LDAP_THIRD_PARTY_INTEGRATION_ADDONS",serialize( array(

            "BUDDYPRESS_PROFILE_SYNC" =>      [
                'addonName'  => 'Sync BuddyPress Extended Profiles',
                'addonDescription'  => 'Integration with BuddyPress to sync extended profile of users with LDAP attributes upon login.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-setup-miniorange-ldap-buddypress-integration-add-on',
                'addonVideo' =>'https://www.youtube.com/embed/7itUoIINyTw',
            ],
            "BUDDYPRESS_GROUP_SYNC" =>      [
                'addonName'  => 'Sync BuddyPress Groups',
                'addonDescription'  => 'Assign BuddyPress groups to users based on group membership in LDAP.',
                'addonPrice' => '129',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "BUDDYBOSS_PROFILE_INTEGRATION" =>      [
                'addonName'  => 'BuddyBoss Profile Integration',
                'addonDescription'  => 'Integration with BuddyBoss to sync extended profile of users with LDAP attributes upon login.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "ULTIMATE_MEMBER_LOGIN_INTEGRATION" =>      [
                'addonName'  => 'Ultimate Member Login Integration',
                'addonDescription'  => 'Login to Ultimate Member with LDAP Credentials.',
                'addonPrice' => '119',
                'addonLicense' => 'ContactUs',
                'addonGuide' => 'https://plugins.miniorange.com/guide-to-setup-ultimate-member-login-integration-with-ldap-credentials',
                'addonVideo' =>'https://www.youtube.com/embed/-d2B_0rDFi0',
            ],
            "ULTIMATE_MEMBER_PROFILE_INTEGRATION" =>      [
                'addonName'  => 'Ultimate Member Profile Integration',
                'addonDescription'  => 'Integrate your Ultimate Member User Profile with LDAP attributes upon LDAP login.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "PAID_MEMBERSHIP_PRO_INTEGRATOR" =>      [
                'addonName'  => 'Paid Membership Pro Integrator',
                'addonDescription'  => 'WordPress Paid Memberships Pro Integrator will map the LDAP Security Groups to Paid Memberships Pro groups.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "LDAP_WP_GROUPS_INTEGRATION" =>      [
                'addonName'  => 'WP Groups Plugin Integration',
                'addonDescription'  => 'Assign WP groups to users based on group membership in LDAP.',
                'addonPrice' => '149',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "GRAVITY_FORMS_INTEGRATION" =>      [
                'addonName'  => 'Gravity Forms Integration',
                'addonDescription'  => 'Populate Gravity Form fields with information from LDAP. You can integrate with unlimited forms.',
                'addonPrice' => '129',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "MEMBERPRESS_INTEGRATION" =>      [
                'addonName'  => 'MemberPress Plugin Integration',
                'addonDescription'  => 'Login to MemberPress protected content with LDAP Credentials.',
                'addonPrice' => '119',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "" =>      [
                'addonName'  => '',
                'addonDescription'  => '',
                'addonPrice' => '',
                'addonLicense' => '',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
            "EMEMBER_INTEGRATION" =>      [
                'addonName'  => 'eMember Plugin Integration',
                'addonDescription'  => 'Login to eMember profiles with LDAP Credentials.',
                'addonPrice' => '119',
                'addonLicense' => 'ContactUs',
                'addonGuide' => '',
                'addonVideo' =>'',
            ],
        )));


    }
    public static function showAddonsContent($is_recommended_addons){
        $displayMessage = "";
        if($is_recommended_addons) {
            $messages = unserialize(MO_LDAP_RECOMMENDED_ADDONS);
        }
        else{
            $messages = unserialize(MO_LDAP_THIRD_PARTY_INTEGRATION_ADDONS);
        }
        echo '<div id="ldap_addon_container" class="mo_ldap_wrapper">';

        foreach ($messages as $messageKey)
        {
            if($messageKey['addonName'] == ''){
                echo '<div style="width: 250px;"></div>';
            }
            if($messageKey['addonName'] != 'Auto Login (SSO) using Kerberos/NTLM' && $messageKey['addonName'] != '') {
                echo'
                    <div class="cd-pricing-wrapper-addons">
                        <div data-type="singlesite" class="is-visible ldap-addon-box">
                        <div class="individual-container-addons" style="height:100%;" >
                            <header class="cd-pricing-header">
                               <div style="height:35px"> <h2 id="addonNameh2" title='.esc_url($messageKey['addonVideo']).'>'.esc_attr($messageKey['addonName']).'</h2>
                               </div><br>
                                <hr class="mo_ldap_license_hr">';

                echo '<div style="margin-right: 3%;">';
                if(!empty($messageKey['addonVideo']))
                {
                    echo'<a onclick="showAddonPopup(jQuery(this))" class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon" id="addonVideos" href="#addonVideos" style="width:max-content;"><span class="link-text" style="color: black;">Setup Video</span></a>';
                }
                if(!empty($messageKey['addonGuide']))
                {
                    echo'<a class="dashicons mo-form-links dashicons-book-alt mo_book_icon" href='.esc_url($messageKey['addonGuide']).' title="Setup Guide" id="guideLink"  target="_blank" style="width:max-content;"><span class="link-text" style="color: black;">Setup Guide</span></a>';
                }
                echo'</div>';

               if(empty($messageKey['addonVideo']) || empty($messageKey['addonGuide']))
               {
                echo '<div style="margin-right: 4%;height: 10px;"></div>';
            }
            echo'
                  <div style="height: 100px;display: grid;align-items: center;"><h3  class="subtitle" style="color:black;padding-left:unset;vertical-align: middle;text-align: center;letter-spacing: 1px">'.esc_attr($messageKey['addonDescription']).'</h3></div><br>
                       <div class="cd-priceAddon">
                             <span class="cd-currency">$</span>
                                 <div style="display:inline"><span class="cd-value" id="addon2Price" >'.esc_attr($messageKey['addonPrice']).' </span><p style="display:inline;font-size:20px" id="addon2Text"> / instance</p></span>
                                 </div>
                       </div>
                            </header>
                                 <footer>
                                <a style="text-align: center;display:inherit;cursor: pointer" class="cd-select" onclick="openSupportForm(\''.esc_attr($messageKey['addonName']).'\')"'. ' >Contact Us </a>
                             </footer>
                        </div>
                    </div> </div>';
        }
        }
        echo '</div><br>
 <div  hidden id="addonVideoModal" class="mo_ldap_modal" style="margin-left: 26%">
    <div class="moldap-modal-contatiner-contact-us" style="color:black"></div>
        <div class="mo_ldap_modal-content" id="addonVideoPopUp" style="width: 650px; padding:10px;"><br>
           <span id="add_title" style="font-size: 22px; margin-left: 50px; font-weight: bold; display: flex; justify-content: center;"></span><br>
                <div style="display: flex; justify-content: center;">
                  <iframe width="560" id="iframeVideo" title="LDAP add-ons" height="315" src="" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
                </div>
                <input type="button" style="font-size: medium; margin-left: 275px;" name="close_addon_video_modal" id="close_addon_video_modal" class="button button-primary button-small" value="Close Video" />
        </div>

    </div>
<script>
function showAddonPopup(elem){
    setTimeout(function(){
        addonTitle = elem.parents(".individual-container-addons.activeCurrent").find("#addonNameh2").text();
        addonSrc = elem.parents(".individual-container-addons.activeCurrent").find("#addonNameh2").attr("title");
        jQuery("#iframeVideo").attr("src", addonSrc);
        jQuery("span#add_title").text(addonTitle + " Add-on");
    },200);     
      jQuery("#addonVideoModal").show();
    }
   jQuery("#close_addon_video_modal").click(function(){
      jQuery("#addonVideoModal").hide();
      jQuery("#iframeVideo").attr("src", "");
   });

</script>';
        return $displayMessage;
    }
}

class MoLdapTimeZones {

    public static $zones = array(
        "Niue Time (GMT-11:00)" => "Pacific/Niue",
        "Samoa Standard Time (GMT-11:00) " => "Pacific/Pago_Pago",
        "Cook Islands Standard Time (GMT-10:00)" => "Pacific/Rarotonga",
        "Hawaii-Aleutian Standard Time (GMT-10:00) " => "Pacific/Honolulu",
        "Tahiti Time (GMT-10:00)" => "Pacific/Tahiti",
        "Marquesas Time (GMT-09:30)" => "Pacific/Marquesas",
        "Gambier Time (GMT-09:00)" => "Pacific/Gambier",
        "Hawaii-Aleutian Time (Adak) (GMT-09:00)" => "America/Adak",
        "Alaska Time - Anchorage(GMT-08:00)" => "America/Anchorage",
        "Alaska Time - Juneau (GMT-08:00)" => "America/Juneau",
        "Alaska Time - Metlakatla (GMT-08:00)" => "America/Metlakatla",
        "Alaska Time - Nome (GMT-08:00)" => "America/Nome",
        "Alaska Time - Sitka (GMT-08:00)" => "America/Sitka",
        "Alaska Time - Yakutat (GMT-08:00)" => "America/Yakutat",
        "Pitcairn Time (GMT-08:00)" => "Pacific/Pitcairn",
        "Mexican Pacific Standard Time (GMT-07:00)" => "America/Hermosillo",
        "Mountain Standard Time - Creston (GMT-07:00)" => "America/Creston",
        "Mountain Standard Time - Dawson (GMT-07:00)" => "America/Dawson",
        "Mountain Standard Time - Dawson Creek (GMT-07:00)" => "America/Dawson_Creek",
        "Mountain Standard Time - Fort Nelson (GMT-07:00)" => "America/Fort_Nelson",
        "Mountain Standard Time - Phoenix (GMT-07:00)" => "America/Phoenix",
        "Mountain Standard Time - Whitehorse (GMT-07:00)" => "America/Whitehorse",
        "Pacific Time - Los Angeles (GMT-07:00)" => "America/Los_Angeles",
        "Pacific Time - Tijuana (GMT-07:00)" => "America/Tijuana",
        "Pacific Time - Vancouver (GMT-07:00)" => "America/Vancouver",
        "Central Standard Time - Belize (GMT-06:00)" => "America/Belize",
        "Central Standard Time - Costa Rica (GMT-06:00)" => "America/Costa_Rica",
        "Central Standard Time - El Salvador (GMT-06:00)" => "America/El_Salvador",
        "entral Standard Time - Guatemala (GMT-06:00)" => "America/Guatemala",
        "Central Standard Time - Managua (GMT-06:00)" => "America/Managua",
        "Central Standard Time - Regina (GMT-06:00)" => "America/Regina",
        "Central Standard Time - Swift Current (GMT-06:00)" => "America/Swift_Current",
        "Central Standard Time - Tegucigalpa (GMT-06:00)" => "America/Tegucigalpa",
        "Easter Island Time (GMT-06:00)" => "Pacific/Easter",
        "Galapagos Time (GMT-06:00)" => "Pacific/Galapagos",
        "Mexican Pacific Time - Chihuahua (GMT-06:00)" => "America/Chihuahua",
        "Mexican Pacific Time - Mazatlan (GMT-06:00)" => "America/Mazatlan",
        "Mountain Time - Boise (GMT-06:00)" => "America/Boise",
        "Mountain Time - Cambridge Bay (GMT-06:00)" => "America/Cambridge_Bay",
        "Mountain Time - Denver (GMT-06:00)" => "America/Denver",
        "Mountain Time - Edmonton (GMT-06:00)" => "America/Edmonton",
        "Mountain Time - Inuvik (GMT-06:00)" => "America/Inuvik",
        "(Mountain Time - Ojinaga (GMT-06:00)" => "America/Ojinaga",
        "Mountain Time - Yellowknife (GMT-06:00)" => "America/Yellowknife",
        "Acre Standard Time - Eirunepe (GMT-05:00)" => "America/Eirunepe",
        "Acre Standard Time - Rio Branco (GMT-05:00)" => "America/Rio_Branco",
        "Central Time - Bahia Banderas (GMT-05:00)" => "America/Bahia_Banderas",
        "Central Time - Beulah, North Dakota (GMT-05:00)" => "America/North_Dakota/Beulah",
        "Central Time - Center, North Dakota (GMT-05:00)" => "America/North_Dakota/Center",
        "Central Time - Chicago (GMT-05:00)" => "America/Chicago",
        "Central Time - Knox, Indiana (GMT-05:00)" => "America/Indiana/Knox",
        "Central Time - Matamoros (GMT-05:00)" => "America/Matamoros",
        "Central Time - Menominee (GMT-05:00)" => "America/Menominee",
        "Central Time - Merida (GMT-05:00)" => "America/Merida",
        "Central Time - Mexico City (GMT-05:00)" => "America/Mexico_City",
        "Central Time - Monterrey (GMT-05:00)" => "America/Monterrey",
        "Central Time - New Salem, North Dakota (GMT-05:00)" => "America/North_Dakota/New_Salem",
        "Central Time - Rainy River (GMT-05:00)" => "America/Rainy_River",
        "Central Time - Rankin Inlet (GMT-05:00)" => "America/Rankin_Inlet",
        "Central Time - Resolute (GMT-05:00)" => "America/Resolute",
        "Central Time - Tell City, Indiana (GMT-05:00)" => "America/Indiana/Tell_City",
        "Central Time - Winnipeg (GMT-05:00)" => "America/Winnipeg",
        "Colombia Standard Time (GMT-05:00)" => "America/Bogota",
        "Eastern Standard Time - Atikokan (GMT-05:00)" => "America/Atikokan",
        "Eastern Standard Time - Cancun (GMT-05:00)" => "America/Cancun",
        "Eastern Standard Time - Jamaica (GMT-05:00)" => "America/Jamaica",
        "Eastern Standard Time - Panama (GMT-05:00)" => "America/Panama",
        "Ecuador Time (GMT-05:00)" => "America/Guayaquil",
        "Peru Standard Time (GMT-05:00)" => "America/Lima",
        "Amazon Standard Time - Boa Vista (GMT-04:00)" => "America/Boa_Vista",
        "Amazon Standard Time - Campo Grande (GMT-04:00)" => "America/Campo_Grande",
        "Amazon Standard Time - Cuiaba (GMT-04:00)" => "America/Cuiaba",
        "Amazon Standard Time - Manaus (GMT-04:00)" => "America/Manaus",
        "Amazon Standard Time - Porto Velho (GMT-04:00)" => "America/Porto_Velho",
        "Atlantic Standard Time - Barbados (GMT-04:00)" => "America/Barbados",
        "Atlantic Standard Time - Blanc-Sablon (GMT-04:00)" => "America/Blanc-Sablon",
        "Atlantic Standard Time - Curacao (GMT-04:00)" => "America/Curacao",
        "Atlantic Standard Time - Martinique (GMT-04:00)" => "America/Martinique",
        "Atlantic Standard Time - Port of Spain (GMT-04:00)" => "America/Port_of_Spain",
        "Atlantic Standard Time - Puerto Rico (GMT-04:00)" => "America/Puerto_Rico",
        "Atlantic Standard Time - Santo Domingo (GMT-04:00)" => "America/Santo_Domingo",
        "Bolivia Time (GMT-04:00)" => "America/La_Paz",
        "Chile Time (GMT-04:00)" => "America/Santiago",
        "Cuba Time (GMT-04:00)" => "America/Havana",
        "Eastern Time - Detroit (GMT-04:00)" => "America/Detroit",
        "Eastern Time - Grand Turk (GMT-04:00)" => "America/Grand_Turk",
        "Eastern Time - Indianapolis (GMT-04:00)" => "America/Indiana/Indianapolis",
        "Eastern Time - Iqaluit (GMT-04:00)" => "America/Iqaluit",
        "Eastern Time - Louisville (GMT-04:00)" => "America/Kentucky/Louisville",
        "Eastern Time - Marengo, Indiana (GMT-04:00)" => "America/Indiana/Marengo",
        "Eastern Time - Monticello, Kentucky (GMT-04:00)" => "America/Kentucky/Monticello",
        "Eastern Time - Nassau (GMT-04:00)" => "America/Nassau",
        "Eastern Time - New York (GMT-04:00)" => "America/New_York",
        "Eastern Time - Nipigon (GMT-04:00)" => "America/Nipigon",
        "Eastern Time - Pangnirtung (GMT-04:00)" => "America/Pangnirtung",
        "Eastern Time - Petersburg, Indiana (GMT-04:00)" => "America/Indiana/Petersburg",
        "Eastern Time - Port-au-Prince (GMT-04:00)" => "America/Port-au-Prince",
        "Eastern Time - Thunder Bay (GMT-04:00)" => "America/Thunder_Bay",
        "Eastern Time - Toronto (GMT-04:00)" => "America/Toronto",
        "Eastern Time - Vevay, Indiana (GMT-04:00)" => "America/Indiana/Vevay",
        "Eastern Time - Vincennes, Indiana (GMT-04:00)" => "America/Indiana/Vincennes",
        "Eastern Time - Winamac, Indiana (GMT-04:00)" => "America/Indiana/Winamac",
        "Guyana Time (GMT-04:00)" => "America/Guyana",
        "Paraguay Time (GMT-04:00)" => "America/Asuncion",
        "Venezuela Time (GMT-04:00)" => "America/Caracas",
        "Argentina Standard Time - Buenos Aires (GMT-03:00)" => "America/Argentina/Buenos_Aires",
        "Argentina Standard Time - Catamarca (GMT-03:00)" => "America/Argentina/Catamarca",
        "Argentina Standard Time - Cordoba (GMT-03:00)" => "America/Argentina/Cordoba",
        "Argentina Standard Time - Jujuy (GMT-03:00)" => "America/Argentina/Jujuy",
        "Argentina Standard Time - La Rioja (GMT-03:00)" => "America/Argentina/La_Rioja",
        "Argentina Standard Time - Mendoza (GMT-03:00)" => "America/Argentina/Mendoza",
        "Argentina Standard Time - Rio Gallegos (GMT-03:00)" => "America/Argentina/Rio_Gallegos",
        "Argentina Standard Time - Salta (GMT-03:00)" => "America/Argentina/Salta",
        "Argentina Standard Time - San Juan (GMT-03:00)" => "America/Argentina/San_Juan",
        "Argentina Standard Time - San Luis (GMT-03:00)" => "America/Argentina/San_Luis",
        "Argentina Standard Time - Tucuman (GMT-03:00)" => "America/Argentina/Tucuman",
        "Argentina Standard Time - Ushuaia (GMT-03:00)" => "America/Argentina/Ushuaia",
        "Atlantic Time - Bermuda (GMT-03:00)" => "Atlantic/Bermuda",
        "Atlantic Time - Glace Bay (GMT-03:00)" => "America/Glace_Bay",
        "Atlantic Time - Goose Bay (GMT-03:00)" => "America/Goose_Bay",
        "Atlantic Time - Halifax (GMT-03:00)" => "America/Halifax",
        "Atlantic Time - Moncton (GMT-03:00)" => "America/Moncton",
        "Atlantic Time - Thule (GMT-03:00)" => "America/Thule",
        "Brasilia Standard Time - Araguaina (GMT-03:00)" => "America/Araguaina",
        "Brasilia Standard Time - Bahia (GMT-03:00)" => "America/Bahia",
        "Brasilia Standard Time - Belem (GMT-03:00)" => "America/Belem",
        "Brasilia Standard Time - Fortaleza (GMT-03:00)" => "America/Fortaleza",
        "Brasilia Standard Time - Maceio (GMT-03:00)" => "America/Maceio",
        "Brasilia Standard Time - Recife (GMT-03:00)" => "America/Recife",
        "Brasilia Standard Time - Santarem (GMT-03:00)" => "America/Santarem",
        "Brasilia Standard Time - Sao Paulo (GMT-03:00)" => "America/Sao_Paulo",
        "Chile Time (GMT-03:00)" => "America/Santiago",
        "Falkland Islands Standard Time (GMT-03:00)" => "Atlantic/Stanley",
        "French Guiana Time (GMT-03:00)" => "America/Cayenne",
        "Palmer Time (GMT-03:00)" => "Antarctica/Palmer",
        "Punta Arenas Time (GMT-03:00)" => "America/Punta_Arenas",
        "Rothera Time (GMT-03:00)" => "Antarctica/Rothera",
        "Suriname Time (GMT-03:00)" => "America/Paramaribo",
        "Uruguay Standard Time (GMT-03:00)" => "America/Montevideo",
        "Newfoundland Time (GMT-02:30)" => "America/St_Johns",
        "Fernando de Noronha Standard Time (GMT-02:00)" => "America/Noronha",
        "South Georgia Time (GMT-02:00)" => "Atlantic/South_Georgia",
        "St. Pierre & Miquelon Time (GMT-02:00)" => "America/Miquelon",
        "West Greenland Time (GMT-02:00)" => "America/Nuuk",
        "Cape Verde Standard Time (GMT-01:00)" => "Atlantic/Cape_Verde",
        "Azores Time (GMT+00:00)" => "Atlantic/Azores",
        "Coordinated Universal Time (GMT+00:00)" => "UTC",
        "East Greenland Time (GMT+00:00)" => "America/Scoresbysund",
        "Greenwich Mean Time (GMT+00:00)" => "Etc/GMT",
        "Greenwich Mean Time - Abidjan (GMT+00:00)" => "Africa/Abidjan",
        "Greenwich Mean Time - Accra (GMT+00:00)" => "Africa/Accra",
        "Greenwich Mean Time - Bissau (GMT+00:00)" => "Africa/Bissau",
        "Greenwich Mean Time - Danmarkshavn (GMT+00:00)" => "America/Danmarkshavn",
        "Greenwich Mean Time - Monrovia (GMT+00:00)" => "Africa/Monrovia",
        "Greenwich Mean Time - Reykjavik (GMT+00:00)" => "Atlantic/Reykjavik",
        "Greenwich Mean Time - Sao Tome (GMT+00:00)" => "Africa/Sao_Tome",
        "Central European Standard Time - Algiers (GMT+01:00)" => "Africa/Algiers",
        "Central European Standard Time - Tunis (GMT+01:00)" => "Africa/Tunis",
        "Ireland Time (GMT+01:00)" => "Europe/Dublin",
        "Morocco Time (GMT+01:00)" => "Africa/Casablanca",
        "United Kingdom Time (GMT+01:00)" => "Europe/London",
        "West Africa Standard Time - Lagos (GMT+01:00)" => "Africa/Lagos",
        "West Africa Standard Time - Ndjamena (GMT+01:00)" => "Africa/Ndjamena",
        "Western European Time - Canary (GMT+01:00)" => "Atlantic/Canary",
        "Western European Time - Faroe (GMT+01:00)" => "Atlantic/Faroe",
        "Western European Time - Lisbon (GMT+01:00)" => "Europe/Lisbon",
        "Western European Time - Madeira (GMT+01:00)" => "Atlantic/Madeira",
        "Western Sahara Time (GMT+01:00)" => "Africa/El_Aaiun",
        "Central Africa Time - Khartoum (GMT+02:00)" => "Africa/Khartoum",
        "Central Africa Time - Maputo (GMT+02:00)" => "Africa/Maputo",
        "Central Africa Time - Windhoek (GMT+02:00)" => "Africa/Windhoek",
        "Central European Time - Amsterdam (GMT+02:00)" => "Europe/Amsterdam",
        "Central European Time - Andorra (GMT+02:00)" => "Europe/Andorra",
        "Central European Time - Belgrade (GMT+02:00)" => "Europe/Belgrade",
        "Central European Time - Berlin (GMT+02:00)" => "Europe/Berlin",
        "Central European Time - Brussels (GMT+02:00)" => "Europe/Brussels",
        "Central European Time - Budapest (GMT+02:00)" => "Europe/Budapest",
        "Central European Time - Ceuta (GMT+02:00)" => "Africa/Ceuta",
        "Central European Time - Copenhagen (GMT+02:00)" => "Europe/Copenhagen",
        "Central European Time - Gibraltar (GMT+02:00)" => "Europe/Gibraltar",
        "Central European Time - Luxembourg (GMT+02:00)" => "Europe/Luxembourg",
        "Central European Time - Madrid (GMT+02:00)" => "Europe/Madrid",
        "Central European Time - Malta (GMT+02:00)" => "Europe/Malta",
        "Central European Time - Monaco (GMT+02:00)" => "Europe/Monaco",
        "Central European Time - Oslo (GMT+02:00)" => "Europe/Oslo",
        "Central European Time - Paris (GMT+02:00)" => "Europe/Paris",
        "Central European Time - Prague (GMT+02:00)" => "Europe/Prague",
        "Central European Time - Rome (GMT+02:00)" => "Europe/Rome",
        "Central European Time - Stockholm (GMT+02:00)" => "Europe/Stockholm",
        "Central European Time - Tirane (GMT+02:00)" => "Europe/Tirane",
        "Central European Time - Vienna (GMT+02:00)" => "Europe/Vienna",
        "Central European Time - Warsaw (GMT+02:00)" => "Europe/Warsaw",
        "Central European Time - Zurich (GMT+02:00)" => "Europe/Zurich",
        "Eastern European Standard Time - Cairo (GMT+02:00)" => "Africa/Cairo",
        "Eastern European Standard Time - Kaliningrad (GMT+02:00)" => "Europe/Kaliningrad",
        "Eastern European Standard Time - Tripoli (GMT+02:00)" => "Africa/Tripoli",
        "South Africa Standard Time (GMT+02:00)" => "Africa/Johannesburg",
        "Troll Time (GMT+02:00)" => "Antarctica/Troll",
        "Arabian Standard Time - Baghdad (GMT+03:00)" => "Asia/Baghdad",
        "Arabian Standard Time - Qatar (GMT+03:00)" => "Asia/Qatar",
        "Arabian Standard Time - Riyadh (GMT+03:00)" => "Asia/Riyadh",
        "East Africa Time - Juba (GMT+03:00)" => "Africa/Juba",
        "East Africa Time - Nairobi (GMT+03:00)" => "Africa/Nairobi",
        "Eastern European Time - Amman (GMT+03:00)" => "Asia/Amman",
        "Eastern European Time - Athens (GMT+03:00)" => "Europe/Athens",
        "Eastern European Time - Beirut (GMT+03:00)" => "Asia/Beirut",
        "Eastern European Time - Bucharest (GMT+03:00)" => "Europe/Bucharest",
        "Eastern European Time - Chisinau (GMT+03:00)" => "Europe/Chisinau",
        "Eastern European Time - Damascus (GMT+03:00)" => "Asia/Damascus",
        "Eastern European Time - Gaza (GMT+03:00)" => "Asia/Gaza",
        "Eastern European Time - Hebron (GMT+03:00)" => "Asia/Hebron",
        "Eastern European Time - Helsinki (GMT+03:00)" => "Europe/Helsinki",
        "Eastern European Time - Kiev (GMT+03:00)" => "Europe/Kiev",
        "Eastern European Time - Nicosia (GMT+03:00)" => "Asia/Nicosia",
        "Eastern European Time - Riga (GMT+03:00)" => "Europe/Riga",
        "Eastern European Time - Sofia (GMT+03:00)" => "Europe/Sofia",
        "Eastern European Time - Tallinn (GMT+03:00)" => "Europe/Tallinn",
        "Eastern European Time - Uzhhorod (GMT+03:00)" => "Europe/Uzhgorod",
        "Eastern European Time - Vilnius (GMT+03:00)" => "Europe/Vilnius",
        "Eastern European Time - Zaporozhye (GMT+03:00)" => "Europe/Zaporozhye",
        "Famagusta Time (GMT+03:00)" => "Asia/Famagusta",
        "Israel Time" => "Asia/Jerusalem (GMT+03:00)",
        "Kirov Time" => "Europe/Kirov (GMT+03:00)",
        "Moscow Standard Time - Minsk (GMT+03:00)" => "Europe/Minsk",
        "Moscow Standard Time - Moscow (GMT+03:00)" => "Europe/Moscow",
        "Moscow Standard Time - Simferopol (GMT+03:00)" => "Europe/Simferopol",
        "Syowa Time (GMT+03:00)" => "Antarctica/Syowa",
        "Turkey Time (GMT+03:00)" => "Europe/Istanbul",
        "Armenia Standard Time (GMT+04:00)" => "Asia/Yerevan",
        "Astrakhan Time (GMT+04:00)" => "Europe/Astrakhan",
        "Azerbaijan Standard Time (GMT+04:00)" => "Asia/Baku",
        "Georgia Standard Time (GMT+04:00)" => "Asia/Tbilisi",
        "Gulf Standard Time (GMT+04:00)" => "Asia/Dubai",
        "Mauritius Standard Time (GMT+04:00)" => "Indian/Mauritius",
        "Reunion Time (GMT+04:00)" => "Indian/Reunion",
        "Samara Standard Time (GMT+04:00)" => "Europe/Samara",
        "Saratov Time (GMT+04:00)" => "Europe/Saratov",
        "Seychelles Time (GMT+04:00)" => "Indian/Mahe",
        "Ulyanovsk Time (GMT+04:00)" => "Europe/Ulyanovsk",
        "Volgograd Standard Time (GMT+04:00)" => "Europe/Volgograd",
        "Afghanistan Time (GMT+04:30)" => "Asia/Kabul",
        "Iran Time (GMT+04:30)" => "Asia/Tehran",
        "French Southern & Antarctic Time (GMT+05:00)" => "Indian/Kerguelen",
        "Maldives Time (GMT+05:00)" => "Indian/Maldives",
        "Mawson Time (GMT+05:00)" => "Antarctica/Mawson",
        "Pakistan Standard Time (GMT+05:00)" => "Asia/Karachi",
        "Tajikistan Time (GMT+05:00)" => "Asia/Dushanbe",
        "Turkmenistan Standard Time (GMT+05:00)" => "Asia/Ashgabat",
        "Uzbekistan Standard Time - Samarkand (GMT+05:00)" => "Asia/Samarkand",
        "Uzbekistan Standard Time - Tashkent (GMT+05:00)" => "Asia/Tashkent",
        "West Kazakhstan Time - Aqtau (GMT+05:00)" => "Asia/Aqtau",
        "West Kazakhstan Time - Aqtobe (GMT+05:00)" => "Asia/Aqtobe",
        "West Kazakhstan Time - Atyrau (GMT+05:00)" => "Asia/Atyrau",
        "West Kazakhstan Time - Oral (GMT+05:00)" => "Asia/Oral",
        "West Kazakhstan Time - Qyzylorda (GMT+05:00)" => "Asia/Qyzylorda",
        "Yekaterinburg Standard Time (GMT+05:00)" => "Asia/Yekaterinburg",
        "Indian Standard Time - Colombo (GMT+05:30)" => "Asia/Colombo",
        "Indian Standard Time - Kolkata (GMT+05:30)" => "Asia/Kolkata",
        "Nepal Time (GMT+05:45)" => "Asia/Kathmandu",
        "Bangladesh Standard Time (GMT+06:00)" => "Asia/Dhaka",
        "Bhutan Time (GMT+06:00)" => "Asia/Thimphu",
        "East Kazakhstan Time - Almaty (GMT+06:00)" => "Asia/Almaty",
        "East Kazakhstan Time - Kostanay (GMT+06:00)" => "Asia/Qostanay",
        "Indian Ocean Time (GMT+06:00)" => "Indian/Chagos",
        "Kyrgyzstan Time (GMT+06:00)" => "Asia/Bishkek",
        "Omsk Standard Time (GMT+06:00)" => "Asia/Omsk",
        "Urumqi Time (GMT+06:00)" => "Asia/Urumqi",
        "Vostok Time (GMT+06:00)" => "Antarctica/Vostok",
        "Cocos Islands Time (GMT+06:30)" => "Indian/Cocos",
        "Myanmar Time (GMT+06:30)" => "Asia/Yangon",
        "Barnaul Time (GMT+07:00)" => "Asia/Barnaul",
        "Christmas Island Time (GMT+07:00)" => "Indian/Christmas",
        "Davis Time (GMT+07:00)" => "Antarctica/Davis",
        "Hovd Standard Time (GMT+07:00)" => "Asia/Hovd",
        "Indochina Time - Bangkok (GMT+07:00)" => "Asia/Bangkok",
        "Indochina Time - Ho Chi Minh City (GMT+07:00)" => "Asia/Ho_Chi_Minh",
        "Krasnoyarsk Standard Time - Krasnoyarsk (GMT+07:00)" => "Asia/Krasnoyarsk",
        "Krasnoyarsk Standard Time - Novokuznetsk (GMT+07:00)" => "Asia/Novokuznetsk",
        "Novosibirsk Standard Time (GMT+07:00)" => "Asia/Novosibirsk",
        "Tomsk Time (GMT+07:00)" => "Asia/Tomsk",
        "Western Indonesia Time - Jakarta (GMT+07:00)" => "Asia/Jakarta",
        "Western Indonesia Time - Pontianak (GMT+07:00)" => "Asia/Pontianak",
        "Australian Western Standard Time - Casey (GMT+08:00)" => "Antarctica/Casey",
        "Australian Western Standard Time - Perth (GMT+08:00)" => "Australia/Perth",
        "Brunei Darussalam Time (GMT+08:00)" => "Asia/Brunei",
        "Central Indonesia Time (GMT+08:00)" => "Asia/Makassar",
        "China Standard Time - Macao (GMT+08:00)" => "Asia/Macau",
        "China Standard Time - Shanghai (GMT+08:00)" => "Asia/Shanghai",
        "Hong Kong Standard Time (GMT+08:00)" => "Asia/Hong_Kong",
        "Irkutsk Standard Time (GMT+08:00)" => "Asia/Irkutsk",
        "Malaysia Time - Kuala Lumpur (GMT+08:00)" => "Asia/Kuala_Lumpur",
        "Malaysia Time - Kuching (GMT+08:00)" => "Asia/Kuching",
        "Philippine Standard Time (GMT+08:00)" => "Asia/Manila",
        "Singapore Standard Time (GMT+08:00)" => "Asia/Singapore",
        "Taipei Standard Time (GMT+08:00)" => "Asia/Taipei",
        "Ulaanbaatar Standard Time - Choibalsan (GMT+08:00)" => "Asia/Choibalsan",
        "Ulaanbaatar Standard Time - Ulaanbaatar (GMT+08:00)" => "Asia/Ulaanbaatar",
        "Australian Central Western Standard Time (GMT+08:45)" => "Australia/Eucla",
        "East Timor Time (GMT+09:00)" => "Asia/Dili",
        "Eastern Indonesia Time (GMT+09:00)" => "Asia/Jayapura",
        "Japan Standard Time (GMT+09:00)" => "Asia/Tokyo",
        "Korean Standard Time - Pyongyang (GMT+09:00)" => "Asia/Pyongyang",
        "Korean Standard Time - Seoul (GMT+09:00)" => "Asia/Seoul",
        "Palau Time" => "Pacific/Palau (GMT+09:00)",
        "Yakutsk Standard Time - Chita (GMT+09:00)" => "Asia/Chita",
        "Yakutsk Standard Time - Khandyga (GMT+09:00)" => "Asia/Khandyga",
        "Yakutsk Standard Time - Yakutsk (GMT+09:00)" => "Asia/Yakutsk",
        "Australian Central Standard Time (GMT+09:30)" => "Australia/Darwin",
        "Central Australia Time - Adelaide (GMT+09:30)" => "Australia/Adelaide",
        "Central Australia Time - Broken Hill (GMT+09:30)" => "Australia/Broken_Hill",
        "Australian Eastern Standard Time - Brisbane (GMT+10:00)" => "Australia/Brisbane",
        "Australian Eastern Standard Time - Lindeman (GMT+10:00)" => "Australia/Lindeman",
        "Chamorro Standard Time (GMT+10:00)" => "Pacific/Guam",
        "Chuuk Time (GMT+10:00)" => "Pacific/Chuuk",
        "Dumont-dUrville Time (GMT+10:00)" => "Antarctica/DumontDUrville",
        "Eastern Australia Time - Currie (GMT+10:00)" => "Australia/Currie",
        "Eastern Australia Time - Hobart (GMT+10:00)" => "Australia/Hobart",
        "Eastern Australia Time - Melbourne (GMT+10:00)" => "Australia/Melbourne",
        "Eastern Australia Time - Sydney (GMT+10:00)" => "Australia/Sydney",
        "Papua New Guinea Time (GMT+10:00)" => "Pacific/Port_Moresby",
        "Vladivostok Standard Time - Ust-Nera (GMT+10:00)" => "Asia/Ust-Nera",
        "Vladivostok Standard Time - Vladivostok (GMT+10:00)" => "Asia/Vladivostok",
        "Lord Howe Time (GMT+10:30)" => "Australia/Lord_Howe",
        "Bougainville Time (GMT+11:00)" => "Pacific/Bougainville",
        "Kosrae Time (GMT+11:00)" => "Pacific/Kosrae",
        "Macquarie Island Time (GMT+11:00)" => "Antarctica/Macquarie",
        "Magadan Standard Time (GMT+11:00)" => "Asia/Magadan",
        "New Caledonia Standard Time (GMT+11:00)" => "Pacific/Noumea",
        "Norfolk Island Time (GMT+11:00)" => "Pacific/Norfolk",
        "Ponape Time (GMT+11:00)" => "Pacific/Pohnpei",
        "Sakhalin Standard Time (GMT+11:00)" => "Asia/Sakhalin",
        "Solomon Islands Time (GMT+11:00)" => "Pacific/Guadalcanal",
        "Srednekolymsk Time (GMT+11:00)" => "Asia/Srednekolymsk",
        "Vanuatu Standard Time (GMT+11:00)" => "Pacific/Efate",
        "Anadyr Standard Time (GMT+12:00)" => "Asia/Anadyr",
        "Fiji Time (GMT+12:00)" => "Pacific/Fiji",
        "Gilbert Islands Time (GMT+12:00)" => "Pacific/Tarawa",
        "Marshall Islands Time - Kwajalein (GMT+12:00)" => "Pacific/Kwajalein",
        "Marshall Islands Time - Majuro (GMT+12:00)" => "Pacific/Majuro",
        "Nauru Time (GMT+12:00)" => "Pacific/Nauru",
        "New Zealand Time (GMT+12:00)" => "Pacific/Auckland",
        "Petropavlovsk-Kamchatski Standard Time (GMT+12:00)" => "Asia/Kamchatka",
        "Tuvalu Time (GMT+12:00)" => "Pacific/Funafuti",
        "Wake Island Time (GMT+12:00)" => "Pacific/Wake",
        "Wallis & Futuna Time (GMT+12:00)" => "Pacific/Wallis",
        "Chatham Time (GMT+12:45)" => "Pacific/Chatham",
        "Apia Time (GMT+13:00)" => "Pacific/Apia",
        "Phoenix Islands Time (GMT+13:00)" => "Pacific/Enderbury",
        "Tokelau Time (GMT+13:00)" => "Pacific/Fakaofo",
        "Tonga Standard Time (GMT+13:00)" => "Pacific/Tongatapu",
        "Line Islands Time (GMT+14:00)" => "Pacific/Kiritimati",
    );
}