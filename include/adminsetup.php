<?php

function pmapi_add_action_links($links)
{
	$mylinks = array('<a href="'.admin_url('options-general.php?page=pmapi-plugin-settings').'">Settings</a>',
					'<a href="http://www.hillplace.info">Author Site</a>');
	$links = array_merge($mylinks, $links);
	return $links;
}

function pmapi_plugin_settings() 
{
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_server_url' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_api_dir' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_api_password' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_site_password' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_version' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_avatar_max' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_useradmin' );
	register_setting( 'pmapi-plugin-settings-group', 'pmapi_gameadmin' );
}

function pmapi_plugin_menu() 
{
	add_options_page('Poker Mavens Plugin Settings', 'API for Poker Mavens', 'administrator', 'pmapi-plugin-settings', 'pmapi_plugin_settings_page');
	add_menu_page('Poker Mavens User Admin Settings', 'Poker Players', esc_attr(get_option('pmapi_useradmin')), 'pmapi-player-admin', 'pmapi_player_admin_page', 'dashicons-admin-users');
	add_menu_page('Poker Mavens Game Admin Settings', 'Poker Games', esc_attr(get_option('pmapi_gameadmin')), 'pmapi-game-admin', 'pmapi_game_admin_page', 'dashicons-clipboard');
}

add_filter( 'plugin_action_links_' . PMAPI_BASE, 'pmapi_add_action_links');
add_action('admin_menu', 'pmapi_plugin_menu');
add_action('admin_init', 'pmapi_plugin_settings');

?>