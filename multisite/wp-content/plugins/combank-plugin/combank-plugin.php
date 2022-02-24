<?php
/**
 * Plugin Name: Combank Intranet - General Plugin
 * Description: The official WordPress hooks plugin of the Combank Intranet. Do not either deactivate or delete this plugin under any circumstance.
 * Author: Commercial Bank - IT Department
 * Version: 1.0.0
 * Author URI: https://combank.lk
 */

// Head
add_action('wp_head', 'combank_intranet_head');
function combank_intranet_head()
{
    require_once 'common_files/head.php';
}

// Footer
add_action('wp_footer', 'combank_intranet_footer');
function combank_intranet_footer()
{
    require_once 'common_files/footer.php';

    echo "
<script>
// -- Site variables
// -- Advanced Scripting Functions
// Base URL
const base_url = window.location.origin;
// Page
const url_path =  window.location.href;
const the_url_path_arr = url_path.split('/');
const current_page =  the_url_path_arr[3];

// - Top navigation links
async function combankTopNavLinks () {
    // Element
    document.getElementById(\"top-navigation\").innerHTML = '<div class=\"menu-top-menu-container\"><ul id=\"top-menu\" class=\"menu\"></ul></div>';
    // Top Nav Script
    let linksArrayLength = topNavLinksArray.length;
    for (let i = 0; i < linksArrayLength; i++) {
        const node = document.createElement(\"li\");
        const node2 = document.createElement(\"a\");
        node2.setAttribute(\"href\", topNavLinksArray[i].url);
        const textNode = document.createTextNode(topNavLinksArray[i].title);
        node.appendChild(node2);
        node2.appendChild(textNode);
        document.getElementById(\"top-menu\").appendChild(node);
    }
}
combankTopNavLinks ();

// - Top navigation - Departments
function combankTopNavDeps () {
    // Departments Element
    document.getElementsByClassName(\"top-bar-social\")[0].innerHTML = 
        '<img class=\"top-nav-cmb-logo\" src=\"http://combank.intranet.com/wp-content/uploads/2022/02/combank_intra_header.png\">' +
        '<select id=\"combank-departments-top-nav\" onchange=\"combankTopNavDepsOnclick(this.value)\" class=\"combank-top-nav-deps-select\">' +
        ";
// All blog names by DB
    global $wpdb;
    global $blog_id;
    foreach ($wpdb->get_results("SELECT blog_id, domain, path FROM $wpdb->blogs WHERE archived = '0' AND deleted = '0' AND spam = '0' ORDER BY path") as $key => $blog) {

        if (absint($blog_id) == $blog->blog_id) {
            switch_to_blog($blog->blog_id);
            $option = 'blogname';
            $value = get_option($option);

            echo "'<option selected value=\"" . $blog->path . "\">" . $value . "</option>' + ";
            restore_current_blog();
        } else {
            switch_to_blog($blog->blog_id);
            $option = 'blogname';
            $value = get_option($option);

            echo "'<option value=\"" . $blog->path . "\">" . $value . "</option>' + ";
            restore_current_blog();
        }
    }
    echo "
        '</select>';
    // Departments Script
    /*let linksArrayLength = combankDepartmentsArray.length;
    for (let i = 0; i < linksArrayLength; i++) {
        const node = document.createElement(\"option\");
        node.setAttribute(\"value\", combankDepartmentsArray[i].url);
        node.setAttribute(\"id\", \"combank-departments-top-nav-\" + combankDepartmentsArray[i].url);
        const textNode = document.createTextNode(combankDepartmentsArray[i].department);
        node.appendChild(textNode);
        document.getElementById(\"combank-departments-top-nav\").appendChild(node);
    }
    document.getElementById(\"combank-departments-top-nav-\" + current_page).setAttribute(\"selected\", \"\");*/
}
combankTopNavDeps ();
function combankTopNavDepsOnclick(path) {
    window.location.href = path;
}

// Header image
function combankHeaderImage () {
    document.getElementsByClassName(\"header-ad\")[0].innerHTML = '';
}
combankHeaderImage ();
</script>
";
}

// Admin Head
add_action('admin_head', 'combank_intranet_admin_head');
function combank_intranet_admin_head()
{

    $user = wp_get_current_user();
    $current_page = $_SERVER['REQUEST_URI'];
    $current_page_array = explode("/", $current_page);

    if (in_array('forex_rates_editor', (array)$user->roles)) {
        if ($current_page_array[1] == "wp-admin") {
            if ($current_page == "/wp-admin/edit.php?post_type=page" || $current_page == "/wp-admin/post.php?post=92&action=edit") {
                if ($_SERVER['REQUEST_URI'] == "/wp-admin/edit.php?post_type=page") {
                    echo "<style>
                    #wp-admin-bar-simple-history-blog-1, .row-actions span:nth-child(2), .check-column, .bulkactions, #menu-posts-notice, #menu-users, #menu-pages .wp-submenu li:nth-child(3), #wp-admin-bar-new-content, #wp-admin-bar-simple-history-view-history, #menu-dashboard {display: none !important;}
                    .row-actions {display: none;}
                    #post-92 .row-actions {display: block !important;}
                    </style>
                    <script>document.getElementById(\"_inline_edit\").value=\"e\"</script>
                    ";
                }
            } else {
                echo "<script>window.location.href = \"/wp-admin/edit.php?post_type=page\";</script>";
                exit;
            }
        }
    }

    if (in_array('staff_officer_codes_editor', (array)$user->roles)) {
        if ($current_page_array[1] == "wp-admin") {
            if ($current_page == "/wp-admin/edit.php?post_type=page" || $current_page == "/wp-admin/post.php?post=116&action=edit") {
                if ($_SERVER['REQUEST_URI'] == "/wp-admin/edit.php?post_type=page") {
                    echo "<style>
                    #wp-admin-bar-simple-history-blog-1, .row-actions span:nth-child(2), .check-column, .bulkactions, #menu-posts-notice, #menu-users, #menu-pages .wp-submenu li:nth-child(3), #wp-admin-bar-new-content, #wp-admin-bar-simple-history-view-history, #menu-dashboard {display: none !important;}
                    .row-actions {display: none;}
                    #post-116 .row-actions {display: block !important;}
                    </style>
                    <script>document.getElementById(\"_inline_edit\").value=\"e\"</script>
                    ";
                }
            } else {
                echo "<script>window.location.href = \"/wp-admin/edit.php?post_type=page\";</script>";
                exit;
            }
        }
    }

    if (in_array('interest_rates_editor', (array)$user->roles)) {
        if ($current_page_array[1] == "wp-admin") {
            if ($current_page == "/wp-admin/edit.php?post_type=page" || $current_page == "/wp-admin/post.php?post=124&action=edit") {
                if ($_SERVER['REQUEST_URI'] == "/wp-admin/edit.php?post_type=page") {
                    echo "<style>
                    #wp-admin-bar-simple-history-blog-1, .row-actions span:nth-child(2), .check-column, .bulkactions, #menu-posts-notice, #menu-users, #menu-pages .wp-submenu li:nth-child(3), #wp-admin-bar-new-content, #wp-admin-bar-simple-history-view-history, #menu-dashboard {display: none !important;}
                    .row-actions {display: none;}
                    #post-124 .row-actions {display: block !important;}
                    </style>
                    <script>document.getElementById(\"_inline_edit\").value=\"e\"</script>
                    ";
                }
            } else {
                echo "<script>window.location.href = \"/wp-admin/edit.php?post_type=page\";</script>";
                exit;
            }
        }
    }

    if (in_array('treasury_rates_editor', (array)$user->roles)) {
        if ($current_page_array[1] == "wp-admin") {
            if ($current_page == "/wp-admin/edit.php?post_type=page" || $current_page == "/wp-admin/post.php?post=126&action=edit") {
                if ($_SERVER['REQUEST_URI'] == "/wp-admin/edit.php?post_type=page") {
                    echo "<style>
                    #wp-admin-bar-simple-history-blog-1, .row-actions span:nth-child(2), .check-column, .bulkactions, #menu-posts-notice, #menu-users, #menu-pages .wp-submenu li:nth-child(3), #wp-admin-bar-new-content, #wp-admin-bar-simple-history-view-history, #menu-dashboard {display: none !important;}
                    .row-actions {display: none;}
                    #post-126 .row-actions {display: block !important;}
                    </style>
                    <script>document.getElementById(\"_inline_edit\").value=\"e\"</script>
                    ";
                }
            } else {
                echo "<script>window.location.href = \"/wp-admin/edit.php?post_type=page\";</script>";
                exit;
            }
        }
    }

    if (in_array('notice_board_editor', (array)$user->roles)) {
        if ($current_page_array[1] == "wp-admin") {
            if ($current_page == "/wp-admin/edit.php?post_type=notice" || $current_page == "/wp-admin/post-new.php?post_type=notice") {
                if ($_SERVER['REQUEST_URI'] == "/wp-admin/edit.php?post_type=notice") {
                    echo "<style>
                    #menu-posts, #menu-comments, #menu-tools, #wp-admin-bar-simple-history-blog-1, .check-column, .bulkactions, #menu-users, #menu-pages .wp-submenu li:nth-child(3), #wp-admin-bar-new-content, #wp-admin-bar-simple-history-view-history, #menu-dashboard {display: none !important;}
                    </style>
                    <script>document.getElementById(\"_inline_edit\").value=\"e\"</script>
                    ";
                }
            } else {
                if (isset($_GET["action"])) {
                    if ($current_page_array[1] == "wp-admin" && explode("?", $current_page_array[2])[0] == "post.php" && $_GET["action"] == "edit") {
                    } else {
                        echo "<script>window.location.href = \"/wp-admin/edit.php?post_type=notice\";</script>";
                        exit;
                    }
                } else {
                    echo "<script>window.location.href = \"/wp-admin/edit.php?post_type=notice\";</script>";
                    exit;
                }

            }
        }
    }

    if (in_array('history_logs_viewer', (array)$user->roles)) {
        if ($current_page_array[1] == "wp-admin") {
            if ($current_page == "/wp-admin/options-general.php?page=simple_history_settings_menu_slug&selected-tab=debug" || $current_page == "/wp-admin/options-general.php?page=simple_history_settings_menu_slug&selected-tab=export" || $current_page == "/wp-admin/index.php?page=simple_history_page") {
                echo "<style>
                    #menu-settings ul li:nth-child(2), #menu-settings ul li:nth-child(3), #menu-settings ul li:nth-child(4), #menu-settings ul li:nth-child(5), #menu-settings ul li:nth-child(6), #menu-settings ul li:nth-child(7), #menu-dashboard ul li:nth-child(2), #menu-dashboard ul li:nth-child(3), #menu-pages, #wp-admin-bar-simple-history-blog-1, #menu-posts-notice, #menu-pages, #menu-tools, #toplevel_page_mo_ldap_local_login, #toplevel_page_searchandfilter-settings, #wp-admin-bar-new-content, #menu-appearance, #menu-users {display: none !important;}
                    </style>
                    ";
            } else {
                if ($current_page == "/wp-admin/options-general.php?page=simple_history_settings_menu_slug") {
                    echo "<script>window.location.href = \"/wp-admin/options-general.php?page=simple_history_settings_menu_slug&selected-tab=export\";</script>";
                    exit;
                } else if ($current_page == "/wp-admin/options-general.php?page=simple_history_settings_menu_slug&selected-tab=debug") {

                } else {
                    echo "<script>window.location.href = \"/wp-admin/index.php?page=simple_history_page\";</script>";
                    exit;
                }

            }
        }
    }

    if (in_array('circulars_editor', (array)$user->roles)) {

        if ($current_page == "/wp-admin/edit.php?category_name=circulars" || $current_page == "/wp-admin/post-new.php") {
            echo "<style>
                    #menu-dashboard, #menu-comments, #menu-settings ul li:nth-child(2), #menu-settings ul li:nth-child(3), #menu-settings ul li:nth-child(4), #menu-settings ul li:nth-child(5), #menu-settings ul li:nth-child(6), #menu-settings ul li:nth-child(7), #menu-dashboard ul li:nth-child(2), #menu-dashboard ul li:nth-child(3), #menu-pages, #wp-admin-bar-simple-history-blog-1, #menu-posts-notice, #menu-pages, #menu-tools, #toplevel_page_mo_ldap_local_login, #toplevel_page_searchandfilter-settings, #wp-admin-bar-new-content, #menu-appearance, #menu-users {display: none !important;}
                    </style>
                    ";
        } else {
            if (isset($_GET["action"])) {
                if ($current_page_array[1] == "wp-admin" && explode("?", $current_page_array[2])[0] == "post.php" && $_GET["action"] == "edit" && get_the_category($_GET["post"])[0]->cat_ID == 3) {

                } else {
                    echo "<script>window.location.href = \"/wp-admin/edit.php?category_name=circulars\";</script>";
                    exit;
                }
            } else {
                echo "<script>window.location.href = \"/wp-admin/edit.php?category_name=circulars\";</script>";
                exit;
            }
        }
    }

    if (in_array('news_editor', (array)$user->roles)) {

        if ($current_page == "/wp-admin/edit.php?category_name=news" || $current_page == "/wp-admin/post-new.php") {
            echo "<style>
                    #menu-dashboard, #menu-comments, #menu-settings ul li:nth-child(2), #menu-settings ul li:nth-child(3), #menu-settings ul li:nth-child(4), #menu-settings ul li:nth-child(5), #menu-settings ul li:nth-child(6), #menu-settings ul li:nth-child(7), #menu-dashboard ul li:nth-child(2), #menu-dashboard ul li:nth-child(3), #menu-pages, #wp-admin-bar-simple-history-blog-1, #menu-posts-notice, #menu-pages, #menu-tools, #toplevel_page_mo_ldap_local_login, #toplevel_page_searchandfilter-settings, #wp-admin-bar-new-content, #menu-appearance, #menu-users {display: none !important;}
                    </style>
                    ";
        } else {
            if (isset($_GET["action"])) {
                if ($current_page_array[1] == "wp-admin" && explode("?", $current_page_array[2])[0] == "post.php" && $_GET["action"] == "edit" && get_the_category($_GET["post"])[0]->cat_ID == 4) {

                } else {
                    echo "<script>window.location.href = \"/wp-admin/edit.php?category_name=news\";</script>";
                    exit;
                }
            } else {
                echo "<script>window.location.href = \"/wp-admin/edit.php?category_name=news\";</script>";
                exit;
            }
        }
    }

}

// Circulars and News Editors - Default Category Definition
function set_category_by_default($post_ID)
{
    $user = wp_get_current_user();
    if (in_array('circular_editor', (array)$user->roles)) {
        wp_set_post_categories($post_ID, 3);
    }
    if (in_array('news_editor', (array)$user->roles)) {
        wp_set_post_categories($post_ID, 4);
    }
}

add_action('publish_post', 'set_category_by_default', 5, 1);

?>