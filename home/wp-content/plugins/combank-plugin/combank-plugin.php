<?php
/**
Plugin Name: Combank Intranet - General Plugin
Description: The official WordPress hooks plugin of the Combank Intranet. Do not either deactivate or delete this plugin under any circumstance.
Author: Commercial Bank - IT Department
Version: 1.0.0
Author URI: https://combank.lk
*/

// Head
add_action( 'wp_head', 'combank_intranet_head' );
function combank_intranet_head () {
    require_once '../common_files/head.php';
}

// Footer
add_action( 'wp_footer', 'combank_intranet_footer' );
function combank_intranet_footer () {
    require_once '../common_files/footer.php';
}

?>