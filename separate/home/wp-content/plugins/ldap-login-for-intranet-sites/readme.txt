=== Active Directory Integration / LDAP Integration ===
Contributors: miniOrange
Donate link: https://miniorange.com
Tags: active directory, active directory integration, ldap, authentication, ldap authentication, ldap directory, sso, kerberos, ntlm, windows sso, ad login, active directory login
Requires at least: 5.0
Tested up to: 5.9
Requires PHP: 5.2.0
Stable tag: 3.7.1
License: MIT/Expat
License URI: https://docs.miniorange.com/mit-license

Active Directory Integration/LDAP Integration supports login into WordPress using Active Directory/other Directory credentials,ACTIVE SUPPORT PROVIDED

== Description ==

Active Directory Integration / LDAP Integration for Intranet sites plugin provides login to WordPress using credentials stored in your Active Directory / other LDAP-based directory.
It allows users to authenticate against various Active Directory / LDAP implementations like:
1. `Microsoft Active Directory`
2. `Azure Active Directory`
3. `Sun Active Directory`
4. `OpenLDAP Directory`
5. `JumpCloud`
6. `FreeIPA Directory`
7. `Synology`
8. `OpenDS`
9. and several other LDAP directory systems.

We support user management features such as creating users not present in WordPress from Active Directory / other LDAP Directory, adding users, editing users and so on.
We also provide additional add-ons that improve the functionality of the basic plugin drastically. User information is in sync with the information in Active Directory / other LDAP Directory. This plugin is free to use under the GNU/GPLv2 license. If you wish to use enhanced features, then there is a provision to upgrade as well. There is also a provision to use our services to deploy and configure this plugin.

= Minimum Requirements =
* Compatible with WordPress version 5.0 or higher
* Compatible with PHP version 5.2.0 or higher


= Free Version Features :- =

*	Login to WordPress using your Active Directory / other LDAP Directory credentials ( Additionally login with WordPress credentials supported if enabled )
*	Automatic user registration after login if the user is not already registered with your site.
*	Keep user profile information in sync with Active Directory / other LDAP Directory upon authentication.
*	Uses LDAP or LDAPS for secure connection to your Active Directory / other LDAP Directory.
*	Test connection to your Active Directory / other LDAP Directory.
*	Test authentication using credentials stored in your Active Directory / other LDAP Directory.
*	Ability to test against demo Active Directory / other LDAP Directory and demo credentials.

**You can find out how to configure the Active Directory Integration / LDAP Integration plugin through the video below**

https://www.youtube.com/watch?v=VE7KJrjfBaI

= Premium Version Features (Check out the Licensing tab to know more):- =

*	<strong>Custom Wordpress Profile Mapping: </strong>Mapping of your Active Directory / other LDAP Directory user profile attributes to the wordpress profile.
*	<strong>Assign WordPress Roles based on LDAP groups: </strong>Mapping of LDAP groups from your Active Directory / other LDAP Directory to WordPress Roles upon authentication.
*   <strong>Support for fetching LDAP groups Automatically for Role Mapping: </strong>Fetches the LDAP Security Groups present in your Active Directory / other LDAP Directory.
*	<strong>Authenticate Users from Multiple LDAP Search Bases: </strong>Authenticate users against multiple search bases from your Active Directory / other LDAP Directory.
*   <strong>Support for Automatic Selection of LDAP OU's as a Search Base: </strong>Fetches the list of Organization Unit's (OU's) from your Active Directory / other LDAP Directory.
*	<strong>Multiple Username Attributes: </strong>Authenticate users against multiple user attributes like uid, cn, mail, sAMAccountName according to your Active Directory / other LDAP Directory.
*	<strong>Automatic Custom Search Filter Builder with Group Restriction: </strong>Automatic customer search filter builder based on selected LDAP user attributes and LDAP groups.
*	<strong>Authenticate Users from both LDAP and WordPress: </strong>Fallback to local WordPress password in case Active Directory / other LDAP Directory is unreacheable.
*	<strong>WordPress to LDAP User Profile Update: </strong>Update the user profile in Active Directory / other LDAP Directory when updated from WordPress.
*   <strong>Auto-register of LDAP users in WordPress site: </strong>Allows users of Active Directory / other LDAP Directory to auto-register in WordPress.
*	<strong>Redirect to Custom URL after Authentication: </strong>Redirect to WordPress Profile page/ Home page/ Custom URL after successful authentiction from your Active Directory / other LDAP Directory.
*   <strong>Support for LDAPS for Secure Connection to LDAP Server: </strong>Allows you to securely connect with your Active Directory / other LDAP Directory.
*	<strong>Detailed User Authentication Report: </strong> Keep track of users authentication requests of your WordPress site. Get detailed logging information of individual user.
*	<strong>Support for Import/Export Plugin Configuration: </strong> Export your plugin configuration from the staging / testing site and Import on the production / live site.
*   <strong>Auto-login (SSO) into WordPress site with Kerberos/NTLM: </strong>Allows auto-login (SSO) into your WordPress site on domain joined machine's.
*	<strong>Multisite Support: </strong> Available as a separate plugin
*   <strong>Failed Logon Notifications: </strong>User/Admin email notification on failed logon attempt. Contact us in case you require this functionality. Available as an add-on.

**You can find out Active Directory Integration / LDAP Integration Premium Version Features through the video below**

https://www.youtube.com/watch?v=r0pnB2d0QP8

= Add-ons List :- =

*   Sync Users LDAP Directory: Synchronize Wordpress users with Active Directory / other LDAP directory and vice versa. Schedules can be configured for the synchronization to run at a specific time and after a specific interval.
*   Sync BuddyPress Extended Profiles: Integration with BuddyPress to sync extended profile of users with Active Directory / other LDAP Directory attributes upon login.
*   Password sync with Active Directory / other LDAP Directory: Synchronize your Wordpress profile password with your Acitve Directory / other LDAP Directory user profile.
*   Profile Picture Sync for WordPress and BuddyPress: Update your WordPress and Buddypress profile picture with thumbnail photos stored in your Active Directory / other LDAP Directory.
*   Ultimate Member Login Integration: Login to Ultimate Member with Active Directory / other LDAP Directory Credentials.
*   Page/Post Restriction: Allows you to control access to your site's content (pages/posts) based on LDAP groups/WordPress roles.
*   Search Staff From Active Directory / other LDAP Directory: You can search/display your Active Directory / other LDAP Directory users on your website using search widget and shortcode.
*   Third Party Plugin User Profile Integration: Update profile information of any third-party plugin with information from your Active Directory / other LDAP Directory.
*   Gravity Forms Integration: Populate Gravity Form fields with information from Active Directory / other LDAP Directory. You can integrate with unlimited forms.
*   Sync BuddyPress Groups: Assign BuddyPress groups to users based on group membership in Active Directory / other LDAP Directory.
*   MemberPress Plugin Integration: Login to Member Press protected content with Active Directory / other LDAP Directory Credentials.
*   eMember Plugin Integration: Login to eMember profiles with Active Directory / other LDAP Directory Credentials.

= Why the free plugins are not sufficient? :- =
*    With authentication being one of the essential functions of the day, a fast and <strong>priority support</strong> (provided in paid versions) ensure that any issues you face on a live production site can be resolved in a timely manner.
*   <strong>Regular updates</strong> to the premium plugin compatible with the latest WordPress version. The updates include security and bug fixes. These updates <strong>ensure that you are updated with the latest security fixes</strong>.
*   Ensure timely update for <strong>new WordPress/PHP releases</strong> with our premium plugins and compatibility updates to make sure you have adequate support for smooth transitions to new versions for WordPress and PHP.
*   <strong>Reasonably priced</strong> with various plans tailored to suit your needs.
*   <strong>Easy to setup</strong> with lots of support and documentation to assist with the setup.
*   High level of <strong>customization</strong> and <strong>add-ons</strong> to support specific requirements.

= Other Use-Cases we support :- =
*   miniOrange also supports VPN usecases. Log in into your VPN client using Active Directory /other LDAP Directory credentials and Multi-Factor Authentication.
*   miniOrange supports SSO into plethora of applications and supports various protocols(RADIUS,LDAP etc) using Active Directory /other LDAP Directory Credentials.
*   Contact us at info@xecurify.com to know more.

= Need support? =
Please email us at info@xecurify.com or <a href="https://xecurify.com/contact" target="_blank">Contact us</a>

== Installation ==

= Prerequisites =
Active Directory Integration / LDAP Integration requires a few prerequisites before you can enable LDAP login for your wordpress sites.

I. Active Directory Integration / LDAP Integration requires a few `PHP Modules` to be enabled. Make sure you have enabled them.

1. **PHP LDAP Module**:
Step-1: Open php.ini file.
Step-2: Search for "extension=php_ldap.dll" in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.

2. **OPENSSL Module**:
Step-1: Open php.ini file.
Step-2: Search for "extension=php_openssl.dll" in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.

II. To install Active Directory Integration / LDAP Integration the minimum requirements are:
1. **Wordpress version 5.0**
2. **PHP version 5.2.0**

= From your WordPress dashboard =
1. Visit `Plugins > Add New`
2. Search for `Active Directory Integration for Intranet sites`. Find and Install `Active Directory Integration for Intranet sites`
3. Activate the plugin from your Plugins page

= From WordPress.org =
1. Download Active Directory Integration for Intranet sites.
2. Unzip and upload the `ldap-login-for-intranet-sites` directory to your `/wp-content/plugins/` directory.
3. Activate Active Directory Integration for Intranet sites from your Plugins page.

= Once Activated =
1. Go to `Settings-> LDAP Login Config`, and follow the instructions.
2. Click on `Save`

Make sure that if there is a firewall, you `OPEN THE FIREWALL` to allow incoming requests to your LDAP from your WordPress Server IP and open port 389(636 for SSL or ldaps).

== Frequently Asked Questions ==

Click [here](https://faq.miniorange.com/faq/ldap-authentication/) to view our FAQ'S page.

For support or troubleshooting help please email us at info@xecurify.com or [Contact us](https://miniorange.com/contact).


== Screenshots ==

1. Configure LDAP plugin
2. LDAP Groups to WordPress Users Role Mapping
3. User Attributes Mapping between LDAP and WP

== Changelog ==

= 3.7.1 =
* Active Directory Integration :
 * Compatibility with WordPress 5.9.
 * Usability Improvements.
 
= 3.7 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.99 =
* Active Directory Integration :
 * New Year Offers.
 * Bug fix in default email domain mapping.

= 3.6.98 =
* Active Directory Integration :
 * Christmas Offers & Usability Improvements.

= 3.6.97 =
* Active Directory Integration :
 * Usability & Security Improvements.

= 3.6.96 =
* Active Directory Integration :
 * Vulnerabilities Fixes & Security Improvements.

= 3.6.95 =
* Active Directory Integration :
 * Bug Fixes - Sanitization of input fields.

= 3.6.94 =
* Active Directory Integration :
 * Usability Improvements.
 * Added option to set user's email to username@email_domain in WordPress, if the "mail" attribute is not set in LDAP directory.

= 3.6.93 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.92 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.91 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.9 =
* Active Directory Integration :
 * Compatible with WordPress 5.8.
 * Usability Improvements.

= 3.6.8 =
* Active Directory Integration :
 * Integrated a support form for scheduling a call for assistance.

= 3.6.7 =
* Active Directory Integration :
 * Bug Fix for auto registration of LDAP user.

= 3.6.6 =
* Active Directory Integration :
 * Added new add-ons to integrate with third party plugins.
 * Usability Improvements.

= 3.6.5 =
* Active Directory Integration :
 * Usability Improvements.
 * Default Role Mapping feature.
  * Assign default WordPress role for all users after login.

= 3.6.4 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.3 =
* Active Directory Integration :
 * Tested for WordPress 5.7.
 * Compatibility Fixes for PHP 8.0.
 * Usability Improvements.
 
= 3.6.2 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.1 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6 =
* Active Directory Integration :
 * Added setup guides and videos for premium add-ons.
 * Compatible with WordPress 5.6

= 3.5.93 =
* Active Directory Integration :
 * Added dropdown to select Directory Server Type.
 * Improvements in "Premium Plugin Trial Request" feature.
 * Usability Improvemnts in Licensing Page.

= 3.5.92 =
* Active Directory Integration :
 * Improvements for possible Base DNs from Active Directory.
 * Plugin tour fixes and usability improvements.
 * Added "Premium Plugin Trial Request" feature.

= 3.5.91 =
* Active Directory Integration :
 * Compatibility with WordPress 5.5.
 * Usability improvements and fixes
 * fetch users DN from Active Directory.

= 3.5.9 =
* Active Directory Integration : Usability improvements for Active Directory Integration

= 3.5.85 =
* Active Directory Integration : Usability improvement to fetch list of possible Base DNs from Active Directory

= 3.5.8 =
* Active Directory Integration : Usability improvements.

= 3.5.7 =
* Active Directory Integration : Usability improvements and bug fixes.

= 3.5.6 =
* Active Directory Integration : Compatibility with 5.4.2, Usability improvements for search attribute.

= 3.5.5 =
* Active Directory Integration : Usability changes and fix for fetching email address at login time.

= 3.5.4 =
* Active Directory Integration : PHP 7.4 and WordPress 5.4 compatibility

= 3.5.3 =
* Active Directory Integration : Compatibility fixes

= 3.5.2 =
* Active Directory Integration : Fixes
 * Compatibility Fixes
 * UI fixes

= 3.5.1 =
* Active Directory Integration : Usability Improvements.

= 3.5 =
* Active Directory Integration : 
 * Compatibility to WordPress 5.3
 * Bug Fixes and Improvements.

= 3.0.13 =
* Active Directory Integration : UI fix.

= 3.0.12 =
* Active Directory Integration : UI fix.

= 3.0.11 =
* Active Directory Integration : Bug fix for anonymous bind and uploading/editing images in wordpress.

= 3.0.10 =
* Active Directory Integration : Change in Contact Us email.

= 3.0.9 =
* Active Directory Integration : Improvements
 * Audit logs for authentication
 * Compatibility to WordPress 5.2
 * Bug Fixes and Improvements.

= 3.0.8 =
* Active Directory Integration : Bug Fixes and Improvements.

= 3.0.7 =
* Active Directory Integration : Bug Fixes and Improvements.

= 3.0.6 =
* Active Directory Integration : Multisite upgrade links added.

= 3.0.5 =
* Active Directory Integration : Bug Fixes and Improvement.

= 3.0.4 =
* Active Directory Integration : Bug Fixes and Improvement.

= 3.0.3 =
* Active Directory Integration : Bug Fixes and Improvement.

= 3.0.2 =
* Active Directory Integration : Improvements
 * Improved Visual Tour
 * Added tab for making feature requests
 * Made registration optional
 * Listed add-ons in licensing plans.

= 3.0.1 =
* Active Directory Integration : Compatibility Fix
 * Support for PHP version > 5.3
 * Wordpress 5.0.1 Compatibility

= 3.0 =
* Active Directory Integration : Added Visual Tour

= 2.92 =
* Active Directory : Role Mapping bug fixes

= 2.91 =
* Active Directory : Improvements
 * Usability fixes
 * Bug fixes
 * Licensing page revamp

= 2.9 =
* Active Directory : Usability fixes

= 2.8.3 =
* Active Directory : Added Feedback Form

= 2.8 =
* Active Directory : Removed MCrypt dependency. Bug fixes

= 2.7.7 =
* Active Directory : Phone number visible in profile

= 2.7.6 =
* Active Directory : Compatible with WordPress 4.9.4 and removed external links

= 2.7.43 =
* Active Directory : On-premise IdP information

= 2.7.42 =
* Active Directory : WordPress 4.9 Compatibility

= 2.7.4 =
* Active Directory : Fix for login with user name/email

= 2.7.3 =
* Active Directory : Additional feature links.

= 2.7.2 =
* Active Directory : Licensing fixes.

= 2.7.1 =
* Active Directory : Activation warning fix. Basic registration fields required for upgrade.

= 2.7 =
* Active Directory : Registration removal, role mapping fixes and user name attribute configurable.

= 2.6.6 =
* Active Directory : Updating Plugin Title

= 2.6.5 =
* Active Directory : Licensing fix

= 2.6.4 =
Name fixes

= 2.6.2 =
Name changed

= 2.6.1 =
Added TLS support

= 2.5.8 =
Increased priority for authentication hook

= 2.5.7 =
Licensing fixes

= 2.5.6 =
WordPress 4.6 Compatibility

= 2.5.5 =
Added option to authenticate Administrators from both LDAP and WordPress

= 2.5.4 =
More page fixes

= 2.5.3 =
Page fixes

= 2.5.2 =
Registration fixes

= 2.5.1 =
*	UI improvement and fix for WP 4.5

= 2.5 =
Added more descriptive error messages and licensing plans updated.

= 2.3 =
Support for Integrated Windows Authentication - contact info@xecurify.com if interested

= 2.2 =
+Added alternate verification method for user activation.

= 2.1 =
+Minor Bug fixes.

= 2.0 =
Attribute Mapping and Role Mapping Bug fixes and Enhancement.

= 1.9 =
Attribute Mapping bug fixes

= 1.8 =
Role Mapping Bug fixes

= 1.7 =
Fallback to local password in case LDAP server is unreacheable.

= 1.6 =
Added attribute mapping and custom profile fields from LDAP.

= 1.5 =
Added mutiple role support in WP users to LDAP Group Role Mapping.

= 1.4 =
Improved encryption to support special characters.

= 1.3 =
Enhanced Usability and UI for the plugin.

= 1.2 =
Added LDAP groups to WordPress Users Role Mapping

= 1.1 =
Enhanced Troubleshooting

= 1.0 =
* this is the first release.

== Upgrade Notice ==

= 3.7.1 =
* Active Directory Integration :
 * Compatibility with WordPress 5.9.
 * Usability Improvements.

= 3.7 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.99 =
* Active Directory Integration :
 * New Year Offers.
 * Bug fix in default email domain mapping.


= 3.6.98 =
* Active Directory Integration :
 * Christmas Offers & Usability Improvements.

= 3.6.97 =
* Active Directory Integration :
 * Usability & Security Improvements.

= 3.6.96 =
* Active Directory Integration :
 * Vulnerabilities Fixes & Security Improvements.

= 3.6.95 =
* Active Directory Integration :
 * Bug Fixes - Sanitization of input fields.

= 3.6.94 =
* Active Directory Integration :
 * Usability Improvements.
 * Added option to set user's email to username@email_domain in WordPress, if the "mail" attribute is not set in LDAP directory.

= 3.6.93 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.92 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.91 =
* Active Directory Integration :
 * Usability Improvements.
 
= 3.6.9 =
* Active Directory Integration :
 * Compatible with WordPress 5.8.
 * Usability Improvements.

= 3.6.8 =
* Active Directory Integration :
 * Integrated a support form for scheduling a call for assistance.

= 3.6.7 =
* Active Directory Integration :
 * Bug Fix for auto registration of LDAP user.
 
= 3.6.6 =
* Active Directory Integration :
 * Added new add-ons to integrate with third party plugins.
 * Usability Improvements.

= 3.6.5 =
* Active Directory Integration :
 * Usability Improvements.
 * Default Role Mapping feature.
   * Assign default WordPress role for all users after login.

= 3.6.4 =
* Active Directory Integration :
 * Usability Improvements.
 
= 3.6.3 =
* Active Directory Integration :
 * Tested for WordPress 5.7.
 * Compatibility Fixes for PHP 8.0.
 * Usability Improvements.

= 3.6.2 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6.1 =
* Active Directory Integration :
 * Usability Improvements.

= 3.6 =
* Active Directory Integration :
 * Added setup guides and videos for premium add-ons.
 * Compatible with WordPress 5.6

= 3.5.93 =
* Active Directory Integration :
 * Added dropdown to select Directory Server Type.
 * Improvements in "Premium Plugin Trial Request" feature.
 * Usability Improvements in Licensing Page.

= 3.5.92 =
* Active Directory Integration :
 * Improvements for possible Base DNs from Active Directory.
 * Plugin tour fixes and usability improvements.
 * Added "Premium Plugin Trial Request" feature.

= 3.5.91 =
* Active Directory Integration :
 * Compatibility with WordPress 5.5.
 * Usability improvements and fixes
 * fetch users DN from Active Directory.

= 3.5.9 =
* Active Directory Integration : Usability improvements for Active Directory Integration

= 3.5.85 =
* Active Directory Integration : Usability improvement to fetch list of possible Base DNs from Active Directory

= 3.5.8 =
* Active Directory Integration : Usability improvements.

= 3.5.7 =
* Active Directory Integration : Usability improvements and bug fixes.

= 3.5.6 =
* Active Directory Integration : Compatibility with 5.4.2, Usability improvements for search attribute.

= 3.5.5 =
* Active Directory Integration : Usability changes and fix for fetching email address at login time.

= 3.5.4 =
* Active Directory Integration : PHP 7.4 and WordPress 5.4 compatibility

= 3.5.3 =
* Active Directory Integration : Compatibility fixes

= 3.5.2 =
* Active Directory Integration : Fixes
 * Compatibility Fixes
 * UI fixes

= 3.5.1 =
* Active Directory Integration : Usability Improvements.

= 3.5 =
* Active Directory Integration : 
 * Compatibility to WordPress 5.3
 * Bug Fixes and Improvements.

= 3.0.13 =
* Active Directory Integration : UI fix.

= 3.0.12 =
* Active Directory Integration : UI fix.

= 3.0.11 =
* Active Directory Integration : Bug fix for anonymous bind and uploading/editing images in wordpress.

= 3.0.10 =
* Active Directory Integration : Change in Contact Us email.

= 3.0.9 =
* Active Directory Integration : Improvements
 * Audit logs for authentication
 * Compatibility to WordPress 5.2
 * Bug Fixes and Improvements.

= 3.0.8 =
* Active Directory Integration : Bug Fixes and Improvements.

= 3.0.7 =
* Active Directory Integration : Bug Fixes and Improvements.

= 3.0.6 =
* Active Directory Integration : Multisite upgrade links added.

= 3.0.5 =
* Active Directory Integration : Bug Fixes and Improvement.

= 3.0.4 =
* Active Directory Integration : Bug Fixes and Improvement.

= 3.0.3 =
* Active Directory Integration : Bug Fixes and Improvement.

= 3.0.2 =
* Active Directory Integration : Improvements
 * Improved Visual Tour
 * Added tab for making feature requests
 * Made registration optional
 * Listed add-ons in licensing plans.

= 3.0.1 =
* Active Directory Integration : Compatibility Fix
 * Support for PHP version > 5.3
 * Wordpress 5.0.1 Compatibility

= 3.0 =
* Active Directory Integration : Added Visual Tour

= 2.92 =
* Active Directory : Role Mapping bug fixes

= 2.91 =
* Active Directory : Improvements
 * Usability fixes
 * Bug fixes
 * Licensing page revamp

= 2.9 =
* Active Directory : Usability fixes

= 2.8.3 =
* Active Directory : Added Feedback Form

= 2.8 =
* Active Directory : Removed MCrypt dependency. Bug fixes

= 2.7.7 =
* Active Directory : Phone number visible in profile

= 2.7.6 =
* Active Directory : Compatible with WordPress 4.9.4 and removed external links

= 2.7.43 =
* Active Directory : On-premise IdP information

= 2.7.42 =
* Active Directory : WordPress 4.9 Compatibility

= 2.7.4 =
* Active Directory : Fix for login with username/email

= 2.7.3 =
* Active Directory : Additional feature links.

= 2.7.2 =
* Active Directory : Licensing fixes.

= 2.7.1 =
* Active Directory : Activation warning fix. Basic registration fields required for upgrade.

= 2.7 =
* Active Directory : Registration removal, role mapping fixes and username attribute configurable.

= 2.6.6 =
* Active Directory : Updating Plugin Title

= 2.6.5 =
* Active Directory : Licensing fix

= 2.6.4 =
Name fixes

= 2.6.2 =
Name changed

= 2.6.1 =
Added TLS support

= 2.5.8 =
Increased priority for authentication hook

= 2.5.7 =
Licensing fixes

= 2.5.6 =
WordPress 4.6 Compatibility

= 2.5.5 =
Added option to authenticate Administrators from both LDAP and WordPress

= 2.5.4 =
More page fixes

= 2.5.3 =
Page fixes

= 2.5.2 =
Registration fixes

= 2.5.1 =
*	UI improvement and fix for WP 4.5

= 2.5 =
Added more descriptive error messages and licensing plans updated.

= 2.3 =
Support for Integrated Windows Authentication - contact info@xecurify.com if interested

= 2.2 =
+Added alternate verification method for user activation.

= 2.1 =
+Minor Bug fixes.

= 2.0 =
Attribute Mapping and Role Mapping Bug fixes and Enhancement.

= 1.9 =
Attribute Mapping bug fixes

= 1.8 =
Role Mapping Bug fixes

= 1.7 =
Fallback to local password in case LDAP server is unreacheable.

= 1.6 =
Added attribute mapping and custom profile fields from LDAP .

= 1.5 =
Added mutiple role support in WP users to LDAP Group Role Mapping .

= 1.4 =
Improved encryption to support special characters.

= 1.3 =
Enhanced Usability and UI for the plugin.

= 1.2 =
Added LDAP groups to WordPress Users Role Mapping

= 1.1 =
Enhanced Troubleshooting

= 1.0 =
First version of plugin.