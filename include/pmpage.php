<?php

function pmapi_content_filter($content)
{
    if(isset($_REQUEST['pmpage']))
	{
		if($_REQUEST['pmpage'] == "setup" ) 
		{
			if(!is_user_logged_in())
				return "Please Sign In to use this function.";
			$avatarurl = get_option('pmapi_server_url') . "/Image?Name=Avatars";
			if(get_option('pmapi_version')<5)
				$avatarsize = 48;
			else 
				$avatarsize = 32;
			$avatarmax = get_option('pmapi_avatar_max');
			$retval = "<h3>Create New Account</h3><form method=\"post\"><table><tr><td>Your real name:</td><td>".
					"<input type=\"text\" name=\"RealName\" /></td></tr><tr><td>Your gender:</td><td>".
					"<input type=\"radio\" name=\"Gender\" Value=\"Male\" checked>Male".
					"<input type=\"radio\" name=\"Gender\" Value=\"Female\">Female</td></tr><tr>".
					"<td>Your location:</td><td><input type=\"text\" name=\"Location\" /></td></tr><tr>".
					"<td>Verify Password:</td><td><input type=\"password\" name=\"Password\" /></td></tr><tr>".
					"<td>Your avatar:</td><td><div style=\"width: 100px; height: 175px; overflow: auto; border: solid 2px\">";
			for ($i = 0; $i < $avatarmax; $i++)
			{
			  $a = "display: inline-block; width: " . $avatarsize . "px; height: " . $avatarsize . "px; background: " . 
				   "url('" . $avatarurl . "') no-repeat -" . ($i * $avatarsize) . "px 0px;"; 
			  $s = "<input type='radio' name='Avatar' value='" . ($i + 1) . "'";
			  if ($i == 0) $s .= " checked";
			  $s .= ">"; 
			  $s .= "<div style=\"" . $a . "\"></div>";
			  $retval .=  $s . "<br><br>";
			}
			$retval .= "</div></td></tr></table><input type=\"hidden\" name=\"pmpage\" value=\"PMCreate\" /><input type=\"submit\" name=\"PMButton\" value=\"Submit\" /></form>";
			return  pmapi_output_cleaner($retval);
		}
		if($_REQUEST['pmpage'] == "PMCreate" ) 
		{
			global $pmapi_create_api;
			if ($pmapi_create_api -> Result == "Ok") 
				return "Success!<BR/>" . pmapi_userinfo_form();
			return "Error: " . $pmapi_create_api -> Error . "<br/>Click Back Button to correct.";
		}
		if($_REQUEST['pmpage'] == "PMUpdate" ) 
		{
			global $pmapi_update_api;
			if ($pmapi_update_api -> Result == "Ok") 
				return "Account Updated<BR/>" . pmapi_userinfo_form();
			return "Error: " . $pmapi_update_api -> Error . "<br>" . pmapi_userinfo_form();
		}
		if($_REQUEST['pmpage'] == "PMAPI_Validate" ) 
		{
			if(!is_user_logged_in())
				return "Please Sign In to use this function.";
			$retval = "<h3>Poker Server Account Validation</h3>".
					"You must validate you own this poker account.<br/>".
					"This password may be different than your Website password.<br/>".
					"<form method=\"post\"><table><tr><td>Poker Account Password:</td>". 
					"<td><input type=\"password\" name=\"Password\" /></td></tr><tr>".
					"</tr></table><input type=\"hidden\" name=\"pmpage\" value=\"PMAPI_Validate_Check\" /><input type=\"submit\" name=\"PMButton\" value=\"Submit\" /></form>";
			return  pmapi_output_cleaner($retval);
			}
		if($_REQUEST['pmpage'] == "PMAPI_Validate_Check" ) 
		{
			global $pmapi_validate;
			if ($pmapi_validate -> Result == "Ok") 
				return "Success, Now Play!<BR/>" . pmapi_play_button();
			return "Error: " . $pmapi_validate -> Error . "<br>Go back and try again.";
			return  pmapi_output_cleaner($retval);
			}
		return "Page Contents Not Found.";
    }
    return $content;
}

function pmapi_title_filter($title)
{
    if(isset($_REQUEST['pmpage']) && in_the_loop())
	{
		if($_REQUEST['pmpage'] == "setup")
			return 'Account Setup';
		if($_REQUEST['pmpage'] == "PMCreate")
			return 'Setup Results:';
		if($_REQUEST['pmpage'] == "PMUpdate")
			return 'Settings:';
		return "Page";
    }
    return $title;
}

function pmapi_do_first()
{
	if($_REQUEST['pmpage'] == "PMCreate" ) 
		{
			$current_user = wp_get_current_user();
			global $pmapi_create_api;
			$Password = $_REQUEST["Password"];
			if (!wp_check_password($Password, $current_user -> user_pass, $current_user -> user_id))
			{
				$pmapi_create_api = (object) array("Result"  => "Error", "Error" => "Bad Password.");
				return;
			}
			$Player = $current_user->user_login;
			$RealName = $_REQUEST["RealName"];
			$Gender = $_REQUEST["Gender"];
			$Location = $_REQUEST["Location"];
			$Email = $current_user->user_email;;
			$Avatar = $_REQUEST["Avatar"];
			$params = array("Command"  => "AccountsAdd",
							"Player"   => $Player,
							"RealName" => $RealName,
							"PW"       => $Password,
							"Location" => $Location,
							"Email"    => $Email,
							"Avatar"   => $Avatar,
							"Gender"   => $Gender,
							"Chat"     => "Yes",
							"Custom"   => $current_user ->  user_pass,
							"Note"     => "Account created via API");
			$pmapi_create_api = PMAPI_Poker_API($params);
		}
	if($_REQUEST['pmpage'] == "PMUpdate" ) 
		{
			global $pmapi_update_api;
			$Player = pmapi_CurrentWPUser();
			$RealName = $_REQUEST["RealName"];
			$Gender = $_REQUEST["Gender"];
			$Location = $_REQUEST["Location"];
			$Email = $current_user->user_email;;
			$Avatar = $_REQUEST["Avatar"];
			$params = array("Command"  => "AccountsEdit",
							"Player"   => $Player,
							"RealName" => $RealName,
							"Location" => $Location,
							"Email"    => $Email,
							"Avatar"   => $Avatar,
							"Gender"   => $Gender);
			$pmapi_update_api = PMAPI_Poker_API($params);
		}
	if($_REQUEST['pmpage'] == "PMAPI_Validate_Check" ) 
		{
			global $pmapi_validate;
			$Password = $_REQUEST["Password"];
			$Player = pmapi_CurrentWPUser();
			$params = array("Command"  => "AccountsPassword",
							"Player"   => $Player,
							"PW" 	   => $Password);
			$pmapi_validate = PMAPI_Poker_API($params);
			if($pmapi_validate->Result=="Ok")
			{
				if($pmapi_validate->Verified=="Yes")
				{
					$current_user = wp_get_current_user();
					$params = array("Command"  => "AccountsEdit",
							"Player"   => $Player,
							"Custom"   => $current_user ->  user_pass);
					$pmapi_validate = PMAPI_Poker_API($params);
					update_user_meta($current_user->ID, "pmapi_oldpwhash", $current_user->user_pass);
				}
				else
					$pmapi_validate = (object) array('Result' => 'Error', 'Error' => 'Password Missmatch, Sorry :(...');
			}
		}
}

add_filter( 'the_content', 'pmapi_content_filter');
add_filter( 'the_title', 'pmapi_title_filter');
add_action( 'init', 'pmapi_do_first');

?>