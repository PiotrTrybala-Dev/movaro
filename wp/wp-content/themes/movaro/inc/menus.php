<?php
if (! defined('ABSPATH')) {
    exit;
}

add_action('init', 'register_menus');

function register_menus()
{
    register_nav_menus(
        array(
            "header-menu" => __("Menu nagłówka", 'movaro'),
        )
    );
}