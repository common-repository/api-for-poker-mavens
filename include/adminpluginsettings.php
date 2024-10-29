<?php

function pmapi_plugin_settings_page() {
 ?>
	<div class="wrap">
	<h2>API for Poker Mavens Settings:</h2>
	!!Warning - This Interface will overwrite the Custom Field for PM Users!!<br/>
	To verify the wordpress user owns the Player account, the PW 
	hash will be stored in the PM User Custom Field.<br/><br/>
	<form method="post" action="options.php">
		<?php settings_fields( 'pmapi-plugin-settings-group' ); ?>
		<?php do_settings_sections( 'pmapi-plugin-settings-group' ); ?>
		<table  border="0" cellspacing="0" cellpadding="0" style="text-align:left"><tr valign="top"><th scope="row">Poker Mavens Server: </th>
		<td><input type="text" name="pmapi_server_url" value="<?php echo esc_attr( get_option('pmapi_server_url') ); ?>" size="35" /></td>
		</tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(ex. http://poker.servername.com:8087)</td>
		</tr><tr valign="top"><th scope="row">API Directory: </th>
		<td><input type="text" name="pmapi_api_dir" value="<?php echo esc_attr( get_option('pmapi_api_dir') ); ?>" /></td>
		</tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(the default is "api" in the Poker Maven's server.)</td>
		</tr><tr valign="top"><th scope="row">API Password: </th>
		<td><input type="password" name="pmapi_api_password" value="<?php echo esc_attr( get_option('pmapi_api_password') ); ?>" /></td>
		</tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(Keep this secret and safe.)</td>
		</tr><tr valign="top"><th scope="row">Site Password: </th>
		<td><input type="password" name="pmapi_site_password" value="<?php echo esc_attr( get_option('pmapi_site_password') ); ?>" /></td>
		</tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(This is not necessary, if you enter it links from your site to the server won't ask for it.)</td>
		</tr><tr valign="top"><th scope="row">PM Version: </th>
		<td><input type="number" name="pmapi_version" value="<?php echo esc_attr( get_option('pmapi_version') ); ?>" min="3" max="5"/></td>
		</tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(Used for avatar image size.)</td>
		</tr><tr valign="top"><th scope="row">Max Avatars: </th>
		<td><input type="number" name="pmapi_avatar_max" value="<?php echo esc_attr( get_option('pmapi_avatar_max') ); ?>" min="1" max="64"/></td>
		</tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(total avatars 1-64)</td>
		<?php echo '<tr valign="top"><th scope="row">User Admin: </th><td><select name="pmapi_useradmin"><option value="administrator"' .selected('administrator',esc_attr(get_option('pmapi_useradmin')),false) . '>Adminitrator</option><option value="edit_others_pages"' .selected('edit_others_pages',esc_attr(get_option('pmapi_useradmin')),false) . '>Editor</option></select></td></tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(Who can edit user accounts?)</td></tr>'; ?>
		<?php echo '<tr valign="top"><th scope="row">Game Admin: </th><td><select name="pmapi_gameadmin"><option value="administrator"' .selected('administrator',esc_attr(get_option('pmapi_gameadmin')),false) . '>Adminitrator</option><option value="edit_others_pages"' .selected('edit_others_pages',esc_attr(get_option('pmapi_gameadmin')),false) . '>Editor</option></select></td></tr><tr valign="top"><td>&nbsp;<br/>&nbsp;</td><td>(Who can edit user accounts?)</td></tr>'; ?>
		</tr></table>
		<?php echo get_submit_button(); ?>
	</form>
	<hr>
	<p>This adds the Poker Mavens API features from several of the examples given on the
	poker mavens support website.  This is minimal and will link up a wordpress username with
	a username on the Poker Mavens Server.</p>
	<p>BE AWARE: if the name already exists on the Poker Server, this plugin in it's form does not
	verify the password to log in.  If you can log in to the Wordpress site, and use this API the same
	username will be linked to it, and it will not verify that the wordpress user actually own's that account.
	(Contact me if you would like customizations done, I will be happy to discuss a custom plugin for your site.)
	If the username does not already exist on the server this plugin will offer to create a new account using the
	same username.
	<p>This plugin shows that it is realitivly easy to set up a website to support your Server using Wordpress 
	making it easy to build an astetically pleasing site with verly little programming skill.</p>
	<p>Shortcodes: [pmapi_server_stats] [pmapi_server_top players="#"] [pmapi_userinfo] [pmapi_rawdata] [pmapi_login]</p>
	</div>
<?php
}


?>