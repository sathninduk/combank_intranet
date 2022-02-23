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

    // Forex Rates Editor Privilege
    //function forex_editor_edit_check() {
    /*$post = $action = "";
    $post = $_GET['post'];
    $action = $_GET['action'];*/

    /*if (current_user_can('forex_rates_editor') && $action == 'edit') {
        if ($post != 92) {
            header('Location: /');
        }
    }*/

    /*}
    forex_editor_edit_check();*/

}

// Admin Head
add_action('admin_head', 'combank_intranet_admin_head');
function combank_intranet_admin_head()
{


    $user = wp_get_current_user();

    if (in_array('forex_rates_editor', (array)$user->roles)) {
        if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['post']) && $_GET['post'] != 92) {
            //header('Location: /');
            echo "<center><div style=\"max-width: 80vw; text-align: center; padding: 20px; border: 2px solid rgb(255, 0, 0); border-radius: 10px;\"><b>Unauthorized</b></div></center>";
            exit;
        }
    }

    if (in_array('staff_officer_codes_editor', (array)$user->roles)) {
        echo "Staff Code";
    }
    if (in_array('notice_board_editor', (array)$user->roles)) {
        echo "Notice";
    }
    if (in_array('history_logs_viewer', (array)$user->roles)) {
        echo "History";
    }
    if (in_array('circular_editor', (array)$user->roles)) {
        echo "Circular";
    }


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

?>