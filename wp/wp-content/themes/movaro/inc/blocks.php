<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function register_blocks()
{
    $blocks_directory = get_theme_file_path('src/blocks');

    if (file_exists($blocks_directory)) {
        $block_json_files = glob($blocks_directory . '/*/block.json');
        foreach ($block_json_files as $block_json_file) {

            $block_json_file = str_replace('block.json', '', $block_json_file);
            register_block_type($block_json_file);
        }
    }
}
add_action('init', 'register_blocks');
