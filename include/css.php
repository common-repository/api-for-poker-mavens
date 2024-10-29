<?php

add_action('wp_enqueue_scripts', 'pmapi_register_plugin_styles');
add_action('admin_enqueue_scripts', 'pmapi_register_plugin_styles');

function pmapi_register_plugin_styles() 
{
	wp_register_style('api-for-poker-mavens', PMAPI_URL . 'include/pmstyle.css');
	wp_enqueue_style('api-for-poker-mavens');
}

?>