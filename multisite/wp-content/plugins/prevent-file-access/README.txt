=== Prevent files / folders access ===
Contributors: cyberlord92
Donate link: https://miniorange.com
Tags: prevent downloads, secure-files, content-restriction, protect-folders, Protection
Requires at least: 3.0.1
Tested up to: 5.9
Requires PHP: 5.6
Stable tag: 2.4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows to protect your files and folders (wp-content, uploads, images, pdf, documents) from public access, prevent downloads from public access, Role base folder access, User base folder access, giving access to only logged in users.

== Description ==

WordPress Prevent files /folders access provides an easiest way to protect your wordpress files from public users so that your content can be accessed only by **WordPress logged in** users.

For restricted access you can choose to redirect users to **403 forbidden page**, your **custom page**, SSO login page (if you are using OAuth or SAML SSO). 

**No change required** or **no manual work** needed to create a private link to protect your files. Our plugin take care of everything.

We support level of security where you can choose either cookie base restriction or session base restriction.
Also we support Apache, NGINX and IIS server to prevent the media files.

It prevent downloads of the media files from the public access and only the logged in users can access and downloads the files.

We support any level of customization according to your requirement.

= File Based Protection =

WordPress Prevent file/folder access developed in a way that it allows you to protect many types of files in your customized way. It will protect files based on their extension. 
You can protect file types below:

* Images - Every type of image files can be protected. eg: jpeg, jpg, gif, png, bmp, webp, pfg, ico, psd, etc.
* Videos - Every type of video files can be protected. eg: mp4, m4a, m4v, f4v, f4a, m4b, m4r, f4b, mov, 3gp, avi etc.
* Documents - Every type of document files can be protected. eg: doc, docx, html, pdf, txt, ppt, xls, xlsx, pptx, odt.

= Redirect  =

WordPress Prevent file/folder access allows you to customize redirect option after the files restriction.

* 403 forbidden page (DEFAULT) - Users will be shown with 403 forbidden page with restricted access messasge.
* Display custom page - We can redirect users to any WordPress custom page when they try to access a restricted files or folders.
* WordPress login - Users will be redirected to the WordPress default login page.
* IDP login - Users will redirect to the selected IDP (SAML/OAuth) login page and after IdP authentication they can see the restricted content.

= Protected folder =

* Our plugin also gives you a protected folder where you can add all file type extensions and restriction will be applied to all files inside protected folder.

= Folder Based Protection =

* WordPress Prevent files / folders access allows you to protect your folders too, the wp-content or uploads folder where all the media files like image, video and document files stored will also be protected.
* Users have option to protect particular month's media files.
* User Base Restriction - A single user can access only a single folder. (Admin would be able to access all the folders)
* Role Base Restriction - All the users of the particular role can access only a single folder. (Admin would be able to access all the folders)

We support LearnDash and other LMS to restrict files and folders according to different groups.

Also, We provide Page and Post Restriction which provides content control for WordPress sites.
This provides Page Restriction and Post Restriction i.e. control on content access based on User Roles. It also allows providing content access to only Logged In Users to specific or all pages and posts.

You can customize the restriction rules and use it as per needs.

This functionality operates at the server level, thus if the Apache server rules doesn't work, or also The WPengine, Siteground and other servers like this runs on a nginx server, which requires the use of nginx configuration rules. If you face any issues Please email us at info@xecurify.com or oauthsupport@xecurify.com. We would recommend you to please ensure your PHP server and rules first which will work on your server before purchasing it or else **contact us we will help you to set up the plugin according to your requirements on your site.**

== Frequently Asked Questions ==
= I need to customize the plugin or I need support and help? =
Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.


== Screenshots ==

1. Configuration
2. Permission to update htaccess file
3. Rules preview based on configuration
4. Upload files in protected folder
5. Folder based restriction
6. Contact us or support

== Changelog ==

= 2.4.3 =
* Added Compatibility with wordpress 5.9
* Some minor fixes

= 2.4.2 =
* Security Improvements

= 2.4.1 =
* Minor issues
* SEO changes

= 2.3.1 =
* WordPress 5.6 Compatibility

= 2.3.0 =
* Bug fixes
* Added support for NGINX server within the premium and Enterprise plugin

= 2.2.0 =
* Bug fixes
* New Enterprise plan

= 2.1.0 =
* Fix file permissions issue for the protected folder

= 1.1.4 =
* Fix the Bootstrap conflict with the WP-admin and Permission issue

= 1.1.3 =
* Change method of writing rules in htaccess file

= 1.1.2 =
* File Deletion issue fixed

= 1.1.1 =
* Initial release

== Upgrade Notice ==

= 2.4.2 =
* Security Improvements

= 2.4.1 =
* Minor issues
* SEO changes

= 2.3.1 =
* WordPress 5.6 Compatibility

= 2.3.0 =
* Bug fixes
* Added support for NGINX server within the premium and Enterprise plugin

= 2.2.0 =
* Bug fixes
* New Enterprise plan

= 2.1.0 =
* Fix file permissions issue for the protected folder

= 1.1.4 =
* Fix the Bootstrap conflict with the WP-admin and Permission issue

= 1.1.3 =
* Change method of writing rules in htaccess file

= 1.1.2 =
* File Deletion issue fixed

= 1.1.1 =
* Initial release
