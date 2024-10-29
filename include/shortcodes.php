<?php

function pmapi_exec_stats()
{
	$params = array("Command" => "SystemStats");
	$api = PMAPI_Poker_API($params);
	$retval = "<h3>Poker Server Status</h3>";
	if ($api -> Result == "Error") return($retval . "Error: " . $api -> Error);
	$retval .= "Logins: " . $api -> Logins . "<br/>";
	$retval .= "Filled Seats: " . $api -> FilledSeats . "<br/>";
	$retval .= "Occupied Tables: " . $api -> OccupiedTables . "<br/>";
	$retval .= "Up Time: " . $api -> UpTime . "<br/>";
	return $retval;
}
add_shortcode( 'pmapi_server_stats' , 'pmapi_exec_stats' );

function pmapi_exec_top($atts)
{
	$atts = shortcode_atts( array('players' => 10,), $atts );
	$topcount = $atts['players'];
	$params = array("Command" => "SystemGet", "Property" => "SiteName");
	$api = PMAPI_Poker_API($params);
	$result = $api -> Result;
	if ($result == "Error") return("Error: " . $api -> Error);
	$sitename = $api -> Value;
	$params = array("Command" => "AccountsList", "Fields" => "Player,Balance");
	$api = PMAPI_Poker_API($params);
	$result = $api -> Result;
	if ($result == "Error") return("Error: " . $api -> Error);
	$accounts = $api -> Accounts;
	$chips = array();
	for ($i = 0; $i < $accounts; $i++)
	{
		$player = $api -> Player[$i];
		$chips[$player] = $api -> Balance[$i];
	}
	arsort($chips);
	$retval = "<table border='1' cellpadding='5'>";
	$retval .= "<tr><th colspan='3'>$sitename - Chip Leaders</th></tr>";
	$retval .= "<tr><th>Rank</th><th>Player</th><th>Balance</th></tr>";
	$rank = 0;
	foreach ($chips as $p => $c)
	{
		$rank++;
		$retval .= "<tr><td>$rank</td><td>$p</td><td>$c</td></tr>";
		if ($rank == $topcount) break;
	}
	$retval .= "</table><br>";
	return $retval;
}
add_shortcode( 'pmapi_server_top' , 'pmapi_exec_top');

function pmapi_exec_userinfo()
{
	if(pmapi_pwvalidated())
		return pmapi_userinfo_form();
	return pmapi_validate_button("Validate Account");
}
add_shortcode( 'pmapi_userinfo' , 'pmapi_exec_userinfo' );

function pmapi_exec_rawdata()
{
	global $current_user;
	get_currentuserinfo();
	$params = array("Command" => "AccountsGet", "Player" => $current_user->user_login);
	$api = PMAPI_Poker_API($params);
	$retval = var_dump($api);
	$retval .= "<hr>";
	$retval .=  var_dump($current_user);
	return $retval;
}
 
add_shortcode( 'pmapi_rawdata' , 'pmapi_exec_rawdata' );

function pmapi_exec_login()
{
	$username = pmapi_CurrentWPUser();
	$login = "";
	if($username =='')
		$login = pmapi_signin_form();
	else
	{
		if(pmapi_pwvalidated())
		{
			if(pmapi_getsessionkey()<>null)
				$playbutton =  pmapi_play_button();
		}
		else
			$playbutton = pmapi_validate_button("Play");
		$login = "<div class=\"pmapi-login\">" .
				"<div class=\"pmapi-loginavatar\">" . pmapi_avatar() . "</div>" . 
				"<div class=\"pmapi-loginsignout\">" . pmapi_signout_button() . "</div>".
				"<div class=\"pmapi-loginplay\">" . $playbutton . "</div>".
				"<div class=\"pmapi-logintext\">User: \"" . $username . "\"</div></div>";
	}
	return  pmapi_output_cleaner($login);
}
add_shortcode( 'pmapi_login' , 'pmapi_exec_login' );

function pmapi_exec_playbutton($atts)
{
	$atts = shortcode_atts( array('signin' => 'no', 'signintext' => 'Sign In'), $atts );
	$showsignin = $atts['signin'];
	$signintext = $atts['signintext'];
	$username = pmapi_CurrentWPUser();
	$login = "";
	if($username == '')
	{
		if($showsignin == "yes")
			$login = "<a href=\"". wp_login_url( get_permalink()) . "\">" . $signintext . "</a>";
	}
	else
	{
		if(pmapi_pwvalidated())
		{
			if(pmapi_getsessionkey()<>null)
				$playbutton =  pmapi_play_button();
		}
		else
			$playbutton = pmapi_validate_button("Play");
		$login = $playbutton;
	}
	return  pmapi_output_cleaner($login);
}
add_shortcode( 'pmapi_playbutton' , 'pmapi_exec_playbutton' );
?>