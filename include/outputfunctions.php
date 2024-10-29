<?php

function pmapi_setup_button($buttonname)
{
	$retval  = "<form method=\"post\" action=\"". esc_url(home_url())."\">";
	$retval .= "<input type=\"submit\" value=\"". $buttonname."\">";
	$retval .= "<input type=\"hidden\" name=\"pmpage\" value=\"setup\"></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_validate_button($buttonname)
{
	if(!is_user_logged_in())
		return "Please Sign In.";
	$retval  = "<form method=\"post\" action=\"". esc_url(home_url())."\">";
	$retval .= "<input type=\"submit\" value=\"". $buttonname."\">";
	$retval .= "<input type=\"hidden\" name=\"pmpage\" value=\"PMAPI_Validate\"></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_signin_form()
{
	$retval  = "<div class=\"login-form-container\"><form method=\"post\" action=\"".wp_login_url()."\">";
	$retval .= "<input type=\"text\" name=\"log\" id=\"user_login\" placeholder=\"username\">";
	$retval .= "<br/><input type=\"password\" name=\"pwd\" id=\"user_pass\" placeholder=\"password\"><br/>";
	$retval .= "<input type=\"submit\" value=\"Sign In\"><input type=\"hidden\" name=\"redirect_to\" value=\"".get_permalink()."\">";
	$retval .= "</form></div>";
	return pmapi_output_cleaner($retval);
}

function pmapi_signout_button()
{
	$retval  = "<form method=\"post\" action=\"".wp_logout_url(get_permalink())."\">";
	$retval .= "<input type=\"submit\" value=\"Sign Out\"></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_play_button()
{
	$retval  = "<form method=\"post\" action=\"".get_option('pmapi_server_url')."\">";
	$retval .= "<input type=\"submit\" value=\"Play\"><input type=\"hidden\" name=\"SitePassword\" value=\"".get_option('pmapi_site_password')."\">";
	$retval .= "<input type=\"hidden\" name=\"LoginName\" value=\"".pmapi_CurrentWPUser()."\">";
	$retval .= "<input type=\"hidden\" name=\"SessionKey\" value=\"".pmapi_getsessionkey()."\"></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_userinfo_form()
{
	if(!is_user_logged_in())
		return "Please Sign In to use this function.";
	$pmapi_api = pmapi_CurrentPMUser();
	if($pmapi_api->Result <> "Ok")
		return "Account not Setup on Server.<br/>Click the button:<br/>" . pmapi_setup_button("Setup");
	$avatarurl = get_option('pmapi_server_url') . "/Image?Name=Avatars";
	$avatarsize = pmapi_avatarsize();
	$avatarmax = get_option('pmapi_avatar_max');

	$retval  = "<form method=\"post\"><table><tr><td>Your real name:</td><td>";
	$retval .= "<input type=\"text\" name=\"RealName\" value=\"".$pmapi_api->RealName."\"/></td></tr>";
	$retval .= "<tr><td>Your gender:</td><td><input type=\"radio\" name=\"Gender\" Value=\"Male\"";
	$retval .= checked( "Male", $pmapi_api->Gender, false); 
	$retval .= ">Male<br/><input type=\"radio\" name=\"Gender\" Value=\"Female\"";
	$retval .= checked( "Female", $pmapi_api->Gender, false); 
	$retval .= ">Female</td></tr><tr><td>Your location:</td><td>";
	$retval .= "<input type=\"text\" name=\"Location\" \" value=\"".$pmapi_api->Location."\"/></td></tr>";
	$retval .= "<tr><td>Your avatar:</td><td><div style=\"width: 100px; height: 175px; overflow: auto; border: solid 2px\">";
	for ($i = 0; $i < $avatarmax; $i++)
	{
		$a = "display: inline-block; width: " . $avatarsize . "px; height: " . $avatarsize . "px; background: " . 
			   "url('" . $avatarurl . "') no-repeat -" . ($i * $avatarsize) . "px 0px;"; 
		$s = "<input type='radio' name='Avatar' value='" . ($i + 1) . "'";
		if ($i+1 == $pmapi_api->Avatar) $s .= " checked";
		$s .= ">"; 
		$s .= "<div style=\"" . $a . "\"></div>";
		$retval .= $s . "<br><br>";
	}
	$retval .= "</div></td></tr></table><input type=\"hidden\" name=\"pmpage\" value=\"PMUpdate\" />";
	$retval .= "<input type=\"submit\" name=\"PMButton\" value=\"Submit\" /></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_useradmin_form($player)
{
	$pmapi_api = pmapi_AccountsGet($player);
	if($pmapi_api->Result <> "Ok")
		return "Error: ". $pmapi_api->Error;
	$avatarurl = get_option('pmapi_server_url') . "/Image?Name=Avatars";
	$avatarsize = pmapi_avatarsize();
	$avatarmax = get_option('pmapi_avatar_max');

	$retval  = "<form method=\"post\"><table><tr>";
	$retval .= "<td>User Name:</td><td><h2>" . $player . "</h2></td></tr>";
	$retval .= "<td>Real name:</td><td><input type=\"text\" name=\"RealName\" value=\"" . $pmapi_api->RealName . "\"/></td></tr>";
	$retval .= "<td>Title:</td><td><input type=\"text\" name=\"Title\" value=\"" . $pmapi_api->Title . "\"/></td></tr>";
	$retval .= "<td>Level:</td><td><input type=\"text\" name=\"Level\" value=\"" . $pmapi_api->Level . "\"/></td></tr>";
	$retval .= "<td>Location:</td><td><input type=\"text\" name=\"Location\" value=\"" . $pmapi_api->Location . "\"/></td></tr>";
	$retval .= "<td>Email:</td><td><input type=\"text\" name=\"Email\" value=\"" . $pmapi_api->Email . "\"/></td></tr>";
	$retval .= "<tr><td>Gender:</td><td><input type=\"radio\" name=\"Gender\" Value=\"Male\"";
	$retval .= checked( "Male", $pmapi_api->Gender, false); 
	$retval .= ">Male<br/><input type=\"radio\" name=\"Gender\" Value=\"Female\"";
	$retval .= checked( "Female", $pmapi_api->Gender, false); 
	$retval .= ">Female</td></tr>";
	$retval .= "<tr><td>Avatar:</td><td><div style=\"width: 100px; height: 175px; overflow: auto; border: solid 2px\">";
	for ($i = 0; $i < $avatarmax; $i++)
	{
		$a = "display: inline-block; width: " . $avatarsize . "px; height: " . $avatarsize . "px; background: " . 
			   "url('" . $avatarurl . "') no-repeat -" . ($i * $avatarsize) . "px 0px;"; 
		$s = "<input type='radio' name='Avatar' value='" . ($i + 1) . "'";
		if ($i+1 == $pmapi_api->Avatar) $s .= " checked";
		$s .= ">"; 
		$s .= "<div style=\"" . $a . "\"></div>";
		$retval .= $s . "<br><br>";
	}
	$retval .= "</div></td></tr></table>";
	$retval .= "<input type=\"hidden\" name=\"pmapi_player\" value=\"" . $player . "\" />";
	$retval .= "<input type=\"submit\" name=\"pmuseradmin\" value=\"Update\" /></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_userbalance_form($player)
{
	$pmapi_api = pmapi_AccountsGet($player);
	if($pmapi_api->Result <> "Ok")
		return "Error: ". $pmapi_api->Error;
	$retval  = "<form method=\"post\"><table><tr>";
	$retval .= "<td>Account Balance:</td><td><h2>" . $pmapi_api->Balance . "</h2></td></tr>";
	$retval .= "<td>Adjust:</td><td><input type=\"text\" name=\"Amount\" value=\"\"/></td></tr>";
	$retval .= "<tr><td>Adjust Balance:</td><td><input type=\"radio\" name=\"Adjust\" Value=\"Add\" checked>Add<br/><input type=\"radio\" name=\"Adjust\" Value=\"Remove\">Remove</td></tr>";
	$retval .= "</td></tr></table>";
	$retval .= "<input type=\"hidden\" name=\"pmapi_player\" value=\"" . $player . "\" />";
	$retval .= "<input type=\"submit\" name=\"pmuseradmin\" value=\"Set Balance\" /></form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_submit_link( $text = '', $name = 'submit') 
{
    $class = 'pmapilink';
    $id = $name;
    // Don't output empty name and id attributes.
    $name_attr = $name ? ' name="' . esc_attr( $name ) . '"' : '';
    $id_attr = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	$button = '<input type="submit"' . $name_attr . $id_attr . ' class="' . esc_attr( $class );
    $button .= '" value="' . esc_attr( $text ) . '" />';
    return $button;
}
?>