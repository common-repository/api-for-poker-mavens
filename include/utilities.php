<?php

function PMAPI_Poker_API($params)
{
	$params['Password'] = get_option('pmapi_api_password');
	$params['JSON'] = 'Yes';
	$url = get_option('pmapi_server_url') . "/" . get_option('pmapi_api_dir');
	$args = array('method' => 'POST','timeout' => 30,'redirection' => 2,
				'httpversion' => '1.0','blocking' => true,'headers' => array(),
				'body' => $params,'cookies' => array(),'sslverify' => false);
	$response = wp_remote_post( $url, $args );
	if ( is_wp_error( $response ) ) 
		$obj = (object) array('Result' => 'Error', 'Error' => $response->get_error_message());
	else if (empty($response))
		$obj = (object) array('Result' => 'Error', 'Error' => 'Connection failed'); 
	else 
		$obj = json_decode(wp_remote_retrieve_body($response));
	return $obj;
}

function pmapi_output_cleaner($input)
{
	return preg_replace('/[\r\n]+/','', $input);	
}

function pmapi_AccountsGet($player)
{
	$params = array("Command" => "AccountsGet", "Player" => $player);
	$api = PMAPI_Poker_API($params);
	return $api;
}



function pmapi_AccountsList($csvlist_fields)
{
	/* valid fields are: Player, Title, Level, RealName, Location, Email, ValCode, Balance, LastReset, Avatar, AvatarFile, Logins, FirstLogin, LastLogin, Gender, Permissions, Tickets, ChipsTransfer, ChipsAccept, Chat, ChatColor1, ChatColor2, Custom, Note, ERake, PRake, TFees, RingChips, RegChips, SessionID */	
	$params = array("Command" => "AccountsList", "Fields" => $csvlist_fields);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_RingGamesList($csvlist_fields)
{
	/* Name, Status, Description, Auto, Game, MixedList, PW, Private, PermPlay, PermObserve, PermPlayerChat, PermObserverChat, SuspendChatAllIn, Seats, SmallestChip, BuyInMin, BuyInMax, BuyInDef, RakePercent, RakeCap, TurnClock, TurnWarning, TimeBank, BankSync, BankReset, DisProtect, SmallBlind, BigBlind, AllowStraddle, SmallBet, BigBet, Ante, AnteAll, BringIn, DupeIPs, RatholeMinutes, SitoutMinutes, SitoutRelaxed */	
	$params = array("Command" => "RingGamesList", "Fields" => $csvlist_fields);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_TournamentsList($csvlist_fields)
{
	/* Name, Status, Description, Auto, Game, MixedList, Shootout, PW, Private, PermRegister, PermUnregister, PermObserve, PermPlayerChat, PermObserverChat, SuspendChatAllIn, Tables, Seats, StartFull, StartMin, StartCode, StartTime, RegMinutes, LateRegMinutes, MinPlayers, RecurMinutes, NoShowMinutes, BuyIn, EntryFee, Ticket, TicketRequired, TicketFunded, PrizeBonus, MultiplyBonus, Chips, AddOnChips, TurnClock, TurnWarning, TimeBank, BankSync, BankReset, DisProtect, Level, RebuyLevels, Threshold, MaxRebuys, RebuyCost, RebuyFee, BreakTime, BreakLevels, StopOnChop, BringInPercent, Blinds, Payout, PayoutTickets, UnregLogout */	
	$params = array("Command" => "TournamentsList", "Fields" => $csvlist_fields);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_RingGamesGet($name)
{
	$params = array("Command" => "RingGamesGet", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_RingGamesOnline($name)
{
	$params = array("Command" => "RingGamesOnline", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_RingGamesOffline($name)
{
	$params = array("Command" => "RingGamesOffline", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_RingGamesDelete($name)
{
	$params = array("Command" => "RingGamesDelete", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_TournamentsGet($name)
{
	$params = array("Command" => "TournamentsGet", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_TournamentsOnline($name)
{
	$params = array("Command" => "TournamentsOnline", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_TournamentsOffline($name)
{
	$params = array("Command" => "TournamentsOffline", "Name" => $name, "Now" => "Yes");
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_TournamentsDelete($name)
{
	$params = array("Command" => "TournamentsDelete", "Name" => $name);
	$api = PMAPI_Poker_API($params);
	return $api;
}

function pmapi_CurrentWPUser()
{
	if(!is_user_logged_in())
		return "";
	$current_user = wp_get_current_user();
	return $current_user->user_login;
}

function pmapi_avatarsize()
	{if(get_option('pmapi_version')<5) return 48; else return 32;}

function pmapi_avatar()
{ 
	$pmapi_api = pmapi_CurrentPMUser();
	if($pmapi_api->Result <> "Ok")
		return "";
	$avatarsize = pmapi_avatarsize();
	$avatarindex = $pmapi_api->Avatar - 1;
	$avatarurl = get_option('pmapi_server_url') . "/Image?Name=Avatars";
	$avatar = "<div style=\"position: static; width: " . $avatarsize . "px; height: " . 
					$avatarsize . "px; background: " . "url('" . $avatarurl . "') no-repeat -" . 
					($avatarindex * $avatarsize) . "px 0px;\"></div>";
	return $avatar;
}

function pmapi_CurrentPMUser()
	{return pmapi_AccountsGet(pmapi_CurrentWPUser());}

function pmapi_pwvalidated()
{
	if(!is_user_logged_in())
		return false;
	$current_user = wp_get_current_user();
	$pmuserdata=pmapi_AccountsGet($current_user->user_login);
	if($pmuserdata->Custom=="")
		return false;
	if($current_user->user_pass == $pmuserdata->Custom)
		return true;
	if(get_user_meta($current_user->ID, "pmapi_oldpwhash", true) == $pmuserdata->Custom)
	{
		update_user_meta($current_user->ID, "pmapi_oldpwhash", $current_user->user_pass);
		$params = array("Command"  => "AccountsEdit", 
						"Player" => $current_user->user_login,
						"Custom"   => $current_user->user_pass);
		$pmapi_validate = PMAPI_Poker_API($params);
		return true;
	}
	
	return false;
}

function pmapi_getsessionkey()
{
	global $pmapi_sessionkey;
	if(isset($pmapi_sessionkey))
		return $pmapi_sessionkey;
	$params = array("Command" => "AccountsSessionKey", "Player" => pmapi_CurrentWPUser());
	$api = PMAPI_Poker_API($params);
	if($api->Result != "Ok")
		return null;
	 $pmapi_sessionkey = $api->SessionKey;
	 return $pmapi_sessionkey;
}

function pmapi_formdropdown($NameValue, $ItemArray, $SelectedValue)
{
	$retval = '<select name="'.$NameValue.'">';
	foreach($ItemArray as $option)
	{
		$retval .= '<option value="' .$option. '" '.selected($option,$SelectedValue,false).'>'.$option.'</option>';		
	}
	$retval .= '</select>';
	return $retval;
}
?>