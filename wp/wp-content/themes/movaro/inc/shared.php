<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function shared_script_manifest() {
	static $manifest;
	if ( null === $manifest ) {
		$file = get_template_directory() . '/build/shared-scripts.json';
		$manifest = file_exists( $file ) ? json_decode( file_get_contents( $file ), true ) : array();
	}
	return is_array( $manifest ) ? $manifest : array();
}

function script_dependencies( $file, $dependencies = array() ) {
	$manifest = shared_script_manifest();
	return array_values( array_unique( array_merge( $dependencies, $manifest['entries'][ $file ] ?? array() ) ) );
}