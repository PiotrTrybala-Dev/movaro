<?php
if (! defined('ABSPATH')) {
    exit;
}

require_once get_theme_file_path("src/ajax/shop.php");

add_action('wp_ajax_load_more_shop', 'load_more_shop_callback');
add_action('wp_ajax_nopriv_load_shop', 'load_more_shop_callback');

