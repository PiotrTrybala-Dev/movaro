<?php
if (! defined('ABSPATH')) {
    exit;
}

add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {

        acf_add_options_page(array(
            'page_title' => 'Ustawienia ogólne',
            'menu_title' => 'Ustawienia ogólne',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => true
        ));
    }
});