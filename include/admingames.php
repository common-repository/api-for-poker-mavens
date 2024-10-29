<?php

function pmapi_game_admin_page() 
{
	$retval .= "<div class=\"wrap\"><h2>Poker Game Admin:</h2>";
	//RING GAME Update, Online/Offline, Add/Delete
	if(isset($_POST['pmapi_ringgame']))
	{
		$ringgamename = $_POST['pmapi_ringgame'];
		$params = array("Name" => $ringgamename,
						"Description" => $_POST["Description"],
						"Auto" => $_POST["Auto"],
						"Game" => $_POST["Game"],
						"MixedList" => $_POST["MixedList"],
						"PW" => $_POST["PW"],
						"Private" => $_POST["Private"],
						"PermPlay" => $_POST["PermPlay"],
						"PermObserve" => $_POST["PermObserve"],
						"PermPlayerChat" => $_POST["PermPlayerChat"],
						"PermObserverChat" => $_POST["PermObserverChat"],
						"SuspendChatAllIn" => $_POST["SuspendChatAllIn"],
						"Seats" => $_POST["Seats"],
						"SmallestChip" => $_POST["SmallestChip"],
						"BuyInMin" => $_POST["BuyInMin"],
						"BuyInMax" => $_POST["BuyInMax"],
						"BuyInDef" => $_POST["BuyInDef"],
						"RakePercent" => $_POST["RakePercent"],
						"RakeCap" => $_POST["RakeCap"],
						"TurnClock" => $_POST["TurnClock"],
						"TurnWarning" => $_POST["TurnWarning"],
						"TimeBank" => $_POST["TimeBank"],
						"BankSync" => $_POST["BankSync"],
						"BankReset" => $_POST["BankReset"],
						"DisProtect" => $_POST["DisProtect"],
						"SmallBlind" => $_POST["SmallBlind"],
						"BigBlind" => $_POST["BigBlind"],
						"AllowStraddle" => $_POST["AllowStraddle"],
						"SmallBet" => $_POST["SmallBet"],
						"BigBet" => $_POST["BigBet"],
						"Ante" => $_POST["Ante"],
						"AnteAll" => $_POST["AnteAll"],
						"BringIn" => $_POST["BringIn"],
						"DupeIPs" => $_POST["DupeIPs"],
						"RatholeMinutes" => $_POST["RatholeMinutes"],
						"SitoutMinutes" => $_POST["SitoutMinutes"],
						"SitoutRelaxed" => $_POST["SitoutRelaxed"]);		
		if($_POST['pmgameadmin'] == "Create New Game" )
		{
			$params["Command"] = "RingGamesAdd";
			$params["Name"] = $_POST["NewName"];
			$params = array_map('stripslashes', $params);
			$ringgamename = $_POST["NewName"];
			$api = PMAPI_Poker_API($params);
		}		
		if($_POST['pmgameadmin'] == "Online" )
		{
			$api = pmapi_RingGamesOnline($ringgamename);
		}		
		if($_POST['pmgameadmin'] == "Offline" )
		{
			$api = pmapi_RingGamesOffline($ringgamename);
		}		
		if($_POST['pmgameadmin'] == "Delete" )
		{
			$api = pmapi_RingGamesDelete($ringgamename);
		}		
		if($_POST['pmgameadmin'] == "Update" ) 
		{
			$params["Command"] = "RingGamesEdit";
			if($ringgamename <> $_POST["NewName"])
				$params["NewName"] = $_POST["NewName"];
			$params = array_map('stripslashes', $params);
			$api = PMAPI_Poker_API($params);
		}
		if($api->Result == "Error") 
			$retval .= "Error: " . $api->Error;
		else if($api->Result == "Ok")  
		{
			$retval .= "Success";
			if($ringgamename <> $_POST["NewName"])
				$ringgamename = $_POST["NewName"];
			if($_POST['pmgameadmin'] <> "Delete" )
				$retval .=  pmapi_ringgame_form($ringgamename);
		}
		else
		{
			$retval .=  pmapi_ringgame_form($ringgamename);
		}
	}
	else if($_POST['pmapi_newringgame']=='Create New Game')
		$retval .=  pmapi_ringgame_form('');

	//Tournaments Update, Online/Offline, Add/Delete
	else if(isset($_POST['pmapi_tournament']))
	{
		$tournamentname = $_POST['pmapi_tournament'];
		$params = array("Name" => $tournamentname,
						"Game" => $_POST["Game"],
						"MixedList" => $_POST["MixedList"],
						"Shootout" => $_POST["Shootout"],
						"Description" => $_POST["Description"],
						"Auto" => $_POST["Auto"],
						"PW" => $_POST["PW"],
						"Private" => $_POST["Private"],
						"PermRegister" => $_POST["PermRegister"],
						"PermUnregister" => $_POST["PermUnregister"],
						"PermObserve" => $_POST["PermObserve"],
						"PermPlayerChat" => $_POST["PermPlayerChat"],
						"PermObserverChat" => $_POST["PermObserverChat"],
						"SuspendChatAllIn" => $_POST["SuspendChatAllIn"],
						"Tables" => $_POST["Tables"],
						"Seats" => $_POST["Seats"],
						"StartFull" => $_POST["StartFull"],
						"StartMin" => $_POST["StartMin"],
						"StartCode" => $_POST["StartCode"],
						"StartTime" => $_POST["StartTime"],
						"RegMinutes" => $_POST["RegMinutes"],
						"LateRegMinutes" => $_POST["LateRegMinutes"],
						"MinPlayers" => $_POST["MinPlayers"],
						"RecurMinutes" => $_POST["RecurMinutes"],
						"NoShowMinutes" => $_POST["NoShowMinutes"],
						"BuyIn" => $_POST["BuyIn"],
						"EntryFee" => $_POST["EntryFee"],
						"Ticket" => $_POST["Ticket"],
						"TicketRequired" => $_POST["TicketRequired"],
						"TicketFunded" => $_POST["TicketFunded"],
						"PrizeBonus" => $_POST["PrizeBonus"],
						"MultiplyBonus" => $_POST["MultiplyBonus"],
						"Chips" => $_POST["Chips"],
						"AddOnChips" => $_POST["AddOnChips"],
						"TurnClock" => $_POST["TurnClock"],
						"TurnWarning" => $_POST["TurnWarning"],
						"TimeBank" => $_POST["TimeBank"],
						"BankSync" => $_POST["BankSync"],
						"BankReset" => $_POST["BankReset"],
						"DisProtect" => $_POST["DisProtect"],
						"Level" => $_POST["Level"],
						"RebuyLevels" => $_POST["RebuyLevels"],
						"Threshold" => $_POST["Threshold"],
						"MaxRebuys" => $_POST["MaxRebuys"],
						"RebuyCost" => $_POST["RebuyCost"],
						"RebuyFee" => $_POST["RebuyFee"],
						"BreakTime" => $_POST["BreakTime"],
						"BreakLevels" => $_POST["BreakLevels"],
						"StopOnChop" => $_POST["StopOnChop"],
						"BringInPercent" => $_POST["BringInPercent"],
						"Blinds" => $_POST["Blinds"],
						"Payout" => $_POST["Payout"],
						"PayoutTickets" => $_POST["PayoutTickets"],
						"UnregLogout" => $_POST["UnregLogout"]);		
		if($_POST['pmgameadmin'] == "Create New Game" )
		{
			$params["Command"] = "TournamentsAdd";
			$params["Name"] = $_POST["NewName"];
			$params = array_map('stripslashes', $params);
			$tournamentname = $_POST["NewName"];
			$api = PMAPI_Poker_API($params);
		}		
		if($_POST['pmgameadmin'] == "Online" )
		{
			$api = pmapi_TournamentsOnline($tournamentname);
		}		
		if($_POST['pmgameadmin'] == "Offline" )
		{
			$api = pmapi_TournamentsOffline($tournamentname);
		}		
		if($_POST['pmgameadmin'] == "Delete" )
		{
			$api = pmapi_TournamentsDelete($tournamentname);
		}		
		if($_POST['pmgameadmin'] == "Update" ) 
		{
			$params["Command"] = "TournamentsEdit";
			if($tournamentname <> $_POST["NewName"])
				$params["NewName"] = $_POST["NewName"];
			$params = array_map('stripslashes', $params);
			$api = PMAPI_Poker_API($params);
		}
		if($api->Result == "Error") 
			$retval .= "Error: " . $api->Error;
		else if($api->Result == "Ok")  
		{
			$retval .= "Success";
			if($tournamentname <> $_POST["NewName"])
				$tournamentname = $_POST["NewName"];
			if($_POST['pmgameadmin'] <> "Delete" )
				$retval .=  pmapi_tournament_form($tournamentname);
		}
		else
		{
			$retval .=  pmapi_tournament_form($tournamentname);
		}
	}
	else if($_POST['pmapi_newtournament']=='Create New Game')
		$retval .=  pmapi_tournament_form('');

	else
	{   
		//Ring Game Table Starts Here.
		$api = pmapi_RingGamesList("Name,Status,Seats,BuyInMin,BuyInMax,SmallBlind,BigBlind,Ante");
		if ($result == "Error") 
			$retval .=   "Error: " . $api -> Error;
		else
		{
			$ringgames = $api -> RingGames;
			$retval .= "<form method=\"post\"><table border='1' cellpadding='5'>";
			$retval .= "<tr><th colspan='5'>Total RingGames: " . $ringgames . " -- " . 
			pmapi_submit_link('Create New Game', 'pmapi_newringgame') . "</th></tr>";
			$retval .= "<tr><th>Name</th><th>Status</th><th>Seats</th><th>Blinds</th><th>Buy In</th></tr>";
			for ($i = 0; $i < $ringgames; $i++)
			{
			$retval .= 	"<tr>" .
						"<td>" . pmapi_submit_link($api -> Name[$i], 'pmapi_ringgame') . "</td>" .
						"<td>" . $api -> Status[$i] . "</td>" .
						"<td>" . $api -> Seats[$i] . "</td>" .
						"<td>" . $api -> SmallBlind[$i] . "/" . $api -> BigBlind[$i] . "/" . $api -> Ante[$i] . "</td>" .
						"<td>" . $api -> BuyInMin[$i] . "/" . $api -> BuyInMax[$i] . "</td>" .
						"</tr>";
			}
		}
		$retval .= "</table></form><br/><br/>";
		//Tournaments Table Starts Here.
		$api = pmapi_TournamentsList("Name,Status,Tables,Seats,BuyIn,EntryFee");
		if ($result == "Error") 
			$retval .=   "Error: " . $api -> Error;
		else
		{
			$tournaments = $api -> Tournaments;
			$retval .= "<form method=\"post\"><table border='1' cellpadding='5'>";
			$retval .= "<tr><th colspan='5'>Total Tournaments: " . $tournaments . " -- " . 
			pmapi_submit_link('Create New Game', 'pmapi_newtournament') . "</th></tr>";
			$retval .= "<tr><th>Name</th><th>Status</th><th>Seats</th><th>Tables</th><th>Buy In/Entry</th></tr>";
			for ($i = 0; $i < $tournaments; $i++)
			{
			$retval .= 	"<tr>" .
						"<td>" . pmapi_submit_link($api -> Name[$i], 'pmapi_tournament') . "</td>" .
						"<td>" . $api -> Status[$i] . "</td>" .
						"<td>" . $api -> Seats[$i] . "</td>" .
						"<td>" . $api -> Tables[$i] . "</td>" .
						"<td>" . $api -> BuyIn[$i] . "/" . $api -> EntryFee[$i] . "</td>" .
						"</tr>";
			}
			$retval .= "</table></form>";
		}
	}
	$retval .= "</div>";
	echo pmapi_output_cleaner($retval);
}

function pmapi_ringgame_form($name)
{
	if($_POST['pmapi_newringgame']<>'Create New Game')
		$pmapi_api = pmapi_RingGamesGet($name);
	else
	{
		$pmapi_api  = (object) array("NewName" => "",
			"Description" => "",
			"Auto" => "Yes",
			"Game" => "",
			"MixedList" => "",
			"Private" => "No",
			"PermPlay" => "",
			"PermObserve" => "",
			"PermPlayerChat" => "",
			"PermObserverChat" => "",
			"SuspendChatAllIn" => "No",
			"Seats" => "10",
			"SmallestChip" => "1",
			"BuyInMin" => 1000,
			"BuyInMax" => 2000,
			"BuyInDef" => 1200,
			"RakePercent" => 0,
			"RakeCap" => 0,
			"TurnClock" => 20,
			"TurnWarning" => 5,
			"TimeBank" => 60,
			"BankSync" => "Yes",
			"BankReset" => 50,
			"DisProtect" => "Yes",
			"SmallBlind" => 5,
			"BigBlind" => 10,
			"AllowStraddle" => "No",
			"SmallBet" => 10,
			"BigBet" => 20,
			"Ante" => 0,
			"AnteAll" => "No",
			"BringIn" => 0,
			"DupeIPs" => "No",
			"RatholeMinutes" => 5,
			"SitoutMinutes" => 5,
			"SitoutRelaxed" => "Yes");	
	}
	$retval  = "<form method=\"post\"><table>";
	$retval .= "<tr><th>Current Name:</th><th><h2>" . $name . "</h2></th></tr>";
	$retval .= "<tr><td>Status:</td><td><h2>" . $pmapi_api->Status . "</h2></td></tr>";
	$retval .= "<td>New Name:</td><td><input type=\"text\" name=\"NewName\" value=\"" . $name . "\"/></td></tr>";
	$retval .= "<td>Description:</td><td><textarea cols=\"40\" rows=\"4\" name=\"Description\">" . $pmapi_api->Description . "</textarea></td></tr>";
	$retval .= "<td>Auto:</td><td>". pmapi_formdropdown("Auto",array("Yes","No"),$pmapi_api->Auto) . "</td></tr>";
	$retval .= "<td>Game:</td><td>". pmapi_formdropdown("Game",array("Limit Hold'em", "Pot Limit Hold'em", "No Limit Hold'em", "Limit Omaha", "Pot Limit Omaha", "No Limit Omaha", "Limit Omaha Hi-Lo", "Pot Limit Omaha Hi-Lo", "No Limit Omaha Hi-Lo", "Limit Razz", "Limit Stud", "Limit Stud Hi-Lo", "Mixed"),$pmapi_api->Game) . "</td></tr>";
	$retval .= "<td>MixedList:</td><td><input type=\"text\" name=\"MixedList\" value=\"" . $pmapi_api->MixedList . "\"/></td></tr>";
	$retval .= "<td>PW:</td><td><input type=\"text\" name=\"PW\" value=\"" . $pmapi_api->PW . "\"/></td></tr>";
	$retval .= "<td>Private:</td><td>". pmapi_formdropdown("Private",array("Yes","No"),$pmapi_api->Private) . "</td></tr>";
	$retval .= "<td>PermPlay:</td><td><input type=\"text\" name=\"PermPlay\" value=\"" . $pmapi_api->PermPlay . "\"/></td></tr>";
	$retval .= "<td>PermObserve:</td><td><input type=\"text\" name=\"PermObserve\" value=\"" . $pmapi_api->PermObserve . "\"/></td></tr>";
	$retval .= "<td>PermPlayerChat:</td><td><input type=\"text\" name=\"PermPlayerChat\" value=\"" . $pmapi_api->PermPlayerChat . "\"/></td></tr>";
	$retval .= "<td>PermObserverChat:</td><td><input type=\"text\" name=\"PermObserverChat\" value=\"" . $pmapi_api->PermObserverChat . "\"/></td></tr>";
	$retval .= "<td>SuspendChatAllIn:</td><td>". pmapi_formdropdown("SuspendChatAllIn",array("Yes","No"),$pmapi_api->SuspendChatAllIn) . "</td></tr>";
	$retval .= "<td>Seats:</td><td><input type=\"number\" name=\"Seats\" value=\"" . $pmapi_api->Seats . "\" min=\"1\" max=\"10\" /></td></tr>";
	$retval .= "<td>SmallestChip:</td><td>". pmapi_formdropdown("SmallestChip",array(0.01, 0.05, 0.25, 1, 5, 25, 100, 500, 1000, 5000, 25000, 100000, 500000, 1000000, 5000000, 25000000, 100000000, 500000000, 1000000000),$pmapi_api->SmallestChip) . "</td></tr>";
	$retval .= "<td>BuyInMin:</td><td><input type=\"number\" name=\"BuyInMin\" value=\"" . $pmapi_api->BuyInMin . "\"/></td></tr>";
	$retval .= "<td>BuyInMax:</td><td><input type=\"number\" name=\"BuyInMax\" value=\"" . $pmapi_api->BuyInMax . "\"/></td></tr>";
	$retval .= "<td>BuyInDef:</td><td><input type=\"number\" name=\"BuyInDef\" value=\"" . $pmapi_api->BuyInDef . "\"/></td></tr>";
	$retval .= "<td>RakePercent:</td><td><input type=\"number\" name=\"RakePercent\" value=\"" . $pmapi_api->RakePercent . "\" min=\"0\" max=\"100\" /></td></tr>";
	$retval .= "<td>RakeCap:</td><td><input type=\"number\" name=\"RakeCap\" value=\"" . $pmapi_api->RakeCap . "\"/></td></tr>";
	$retval .= "<td>TurnClock:</td><td><input type=\"number\" name=\"TurnClock\" value=\"" . $pmapi_api->TurnClock . "\" min=\"10\" max=\"120\" /></td></tr>";
	$retval .= "<td>TurnWarning:</td><td><input type=\"number\" name=\"TurnWarning\" value=\"" . $pmapi_api->TurnWarning . "\" min=\"5\" max=\"119\" /></td></tr>";
	$retval .= "<td>TimeBank:</td><td><input type=\"number\" name=\"TimeBank\" value=\"" . $pmapi_api->TimeBank . "\" min=\"0\" max=\"600\" /></td></tr>";
	$retval .= "<td>BankSync:</td><td>". pmapi_formdropdown("BankSync",array("Yes","No"),$pmapi_api->BankSync) . "</td></tr>";
	$retval .= "<td>BankReset:</td><td><input type=\"number\" name=\"BankReset\" value=\"" . $pmapi_api->BankReset . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>DisProtect:</td><td>". pmapi_formdropdown("DisProtect",array("Yes","No"),$pmapi_api->DisProtect) . "</td></tr>";
	$retval .= "<td>SmallBlind:</td><td><input type=\"number\" name=\"SmallBlind\" value=\"" . $pmapi_api->SmallBlind . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>BigBlind:</td><td><input type=\"number\" name=\"BigBlind\" value=\"" . $pmapi_api->BigBlind . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>AllowStraddle:</td><td>". pmapi_formdropdown("AllowStraddle",array("Yes","No"),$pmapi_api->AllowStraddle) . "</td></tr>";
	$retval .= "<td>SmallBet:</td><td><input type=\"number\" name=\"SmallBet\" value=\"" . $pmapi_api->SmallBet . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>BigBet:</td><td><input type=\"number\" name=\"BigBet\" value=\"" . $pmapi_api->BigBet . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>Ante:</td><td><input type=\"number\" name=\"Ante\" value=\"" . $pmapi_api->Ante . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>AnteAll:</td><td>". pmapi_formdropdown("AnteAll",array("Yes","No"),$pmapi_api->AnteAll) . "</td></tr>";
	$retval .= "<td>BringIn:</td><td><input type=\"number\" name=\"BringIn\" value=\"" . $pmapi_api->BringIn . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>DupeIPs:</td><td>". pmapi_formdropdown("DupeIPs",array("Yes","No"),$pmapi_api->DupeIPs) . "</td></tr>";
	$retval .= "<td>RatholeMinutes:</td><td><input type=\"number\" name=\"RatholeMinutes\" value=\"" . $pmapi_api->RatholeMinutes . "\" min=\"0\" max=\"120\" /></td></tr>";
	$retval .= "<td>SitoutMinutes:</td><td><input type=\"number\" name=\"SitoutMinutes\" value=\"" . $pmapi_api->SitoutMinutes . "\" min=\"1\" max=\"120\" /></td></tr>";
	$retval .= "<td>SitoutRelaxed:</td><td>". pmapi_formdropdown("SitoutRelaxed",array("Yes","No"),$pmapi_api->SitoutRelaxed) . "</td></tr>";
	$retval .= "</table><input type=\"hidden\" name=\"pmapi_ringgame\" value=\"" . $name . "\" />";

	if($_POST['pmapi_newringgame']=='Create New Game')
		$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Create New Game\" />";
	else if($pmapi_api->Result == "Ok")
	{
		if($pmapi_api->Status == "Offline")
		{
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Update\" />";	
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Online\" />";	
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Delete\" />";	
		}
		else
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Offline\" />";
	}
	$retval .= "</form>";
	return pmapi_output_cleaner($retval);
}

function pmapi_tournament_form($name)
{
	if($_POST['pmapi_newtournament']<>'Create New Game')
		$pmapi_api = pmapi_TournamentsGet($name);
	else
	{
		$pmapi_api  = (object) array("NewName" => "",
			"Game" => "",
			"MixedList" => "",
			"Shootout" => "No",
			"Description" => "",
			"Auto" => "Yes",
			"PW" => "",
			"Private" => "No",
			"PermRegister" => "",
			"PermUnregister" => "",
			"PermObserve" => "",
			"PermPlayerChat" => "",
			"PermObserverChat" => "",
			"SuspendChatAllIn" => "No",
			"Tables" => 5,
			"Seats" => 10,
			"StartFull" => "Yes",
			"StartMin" => 0,
			"StartCode" => 0,
			"StartTime" => "0000-00-00 00:00",
			"RegMinutes" => 0,
			"LateRegMinutes" =>0,
			"MinPlayers" => 50,
			"RecurMinutes" => 1,
			"NoShowMinutes" => 0,
			"BuyIn" => 100,
			"EntryFee" => 10,
			"Ticket" => "",
			"TicketRequired" => "No",
			"TicketFunded" => "No",
			"PrizeBonus" => 0,
			"MultiplyBonus" => "No",
			"Chips" => 1500,
			"AddOnChips" => 0,
			"TurnClock" => 20,
			"TurnWarning" => 5,
			"TimeBank" => 60,
			"BankSync" => "Yes",
			"BankReset" => 50,
			"DisProtect" => "Yes",
			"Level" => 10,
			"RebuyLevels" => 0,
			"Threshold" => 0,
			"MaxRebuys" => 0,
			"RebuyCost" => 0,
			"RebuyFee" => 0,
			"BreakTime" => 2,
			"BreakLevels" => 3,
			"StopOnChop" => "No",
			"BringInPercent" => 1,
			"Blinds" => "",
			"Payout" => "",
			"PayoutTickets" => "",
			"UnregLogout" => "No");	
	}
	$retval  = "<form method=\"post\"><table>";
	$retval .= "<tr><th>Current Name:</th><th><h2>" . $name . "</h2></th></tr>";
	$retval .= "<tr><td>Status:</td><td><h2>" . $pmapi_api->Status . "</h2></td></tr>";
	$retval .= "<td>New Name:</td><td><input type=\"text\" name=\"NewName\" value=\"" . $name . "\"/></td></tr>";
	$retval .= "<td>Description:</td><td><textarea cols=\"40\" rows=\"4\" name=\"Description\">" . $pmapi_api->Description . "</textarea></td></tr>";
	$retval .= "<td>Auto:</td><td>". pmapi_formdropdown("Auto",array("Yes","No"),$pmapi_api->Auto) . "</td></tr>";
	$retval .= "<td>Game:</td><td>". pmapi_formdropdown("Game",array("Limit Hold'em", "Pot Limit Hold'em", "No Limit Hold'em", "Limit Omaha", "Pot Limit Omaha", "No Limit Omaha", "Limit Omaha Hi-Lo", "Pot Limit Omaha Hi-Lo", "No Limit Omaha Hi-Lo", "Limit Razz", "Limit Stud", "Limit Stud Hi-Lo", "Mixed"),$pmapi_api->Game) . "</td></tr>";
	$retval .= "<td>MixedList:</td><td><input type=\"text\" name=\"MixedList\" value=\"" . $pmapi_api->MixedList . "\"/></td></tr>";
	$retval .= "<td>Shootout:</td><td>". pmapi_formdropdown("Shootout",array("Yes","No"),$pmapi_api->Shootout) . "</td></tr>";
	$retval .= "<td>PW:</td><td><input type=\"text\" name=\"PW\" value=\"" . $pmapi_api->PW . "\"/></td></tr>";
	$retval .= "<td>Private:</td><td>". pmapi_formdropdown("Private",array("Yes","No"),$pmapi_api->Private) . "</td></tr>";
	$retval .= "<td>PermRegister:</td><td><input type=\"text\" name=\"PermRegister\" value=\"" . $pmapi_api->PermRegister . "\"/></td></tr>";
	$retval .= "<td>PermUnregister:</td><td><input type=\"text\" name=\"PermUnregister\" value=\"" . $pmapi_api->PermUnregister . "\"/></td></tr>";
	$retval .= "<td>PermObserve:</td><td><input type=\"text\" name=\"PermObserve\" value=\"" . $pmapi_api->PermObserve . "\"/></td></tr>";
	$retval .= "<td>PermPlayerChat:</td><td><input type=\"text\" name=\"PermPlayerChat\" value=\"" . $pmapi_api->PermPlayerChat . "\"/></td></tr>";
	$retval .= "<td>PermObserverChat:</td><td><input type=\"text\" name=\"PermObserverChat\" value=\"" . $pmapi_api->PermObserverChat . "\"/></td></tr>";
	$retval .= "<td>SuspendChatAllIn:</td><td>". pmapi_formdropdown("SuspendChatAllIn",array("Yes","No"),$pmapi_api->SuspendChatAllIn) . "</td></tr>";
	$retval .= "<td>Tables:</td><td><input type=\"number\" name=\"Tables\" value=\"" . $pmapi_api->Tables . "\" min=\"1\" max=\"100\" /></td></tr>";
	$retval .= "<td>Seats:</td><td><input type=\"number\" name=\"Seats\" value=\"" . $pmapi_api->Seats . "\" min=\"1\" max=\"10\" /></td></tr>";
	$retval .= "<td>StartFull:</td><td>". pmapi_formdropdown("StartFull",array("Yes","No"),$pmapi_api->StartFull) . "</td></tr>";
	$retval .= "<td>StartMin:</td><td><input type=\"number\" name=\"StartMin\" value=\"" . $pmapi_api->StartMin . "\" min=\"0\" max=\"10\" /></td></tr>";
	$retval .= "<td>StartCode:</td><td><input type=\"number\" name=\"StartCode\" value=\"" . $pmapi_api->StartCode . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>StartTime:</td><td><input type=\"text\" name=\"StartTime\" value=\"" . $pmapi_api->StartTime . "\"/></td></tr>";
	$retval .= "<td>RegMinutes:</td><td><input type=\"number\" name=\"RegMinutes\" value=\"" . $pmapi_api->RegMinutes . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>LateRegMinutes:</td><td><input type=\"number\" name=\"LateRegMinutes\" value=\"" . $pmapi_api->LateRegMinutes . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>MinPlayers:</td><td><input type=\"number\" name=\"MinPlayers\" value=\"" . $pmapi_api->MinPlayers . "\" min=\"2\" max=\"1000\" /></td></tr>";
	$retval .= "<td>RecurMinutes:</td><td><input type=\"number\" name=\"RecurMinutes\" value=\"" . $pmapi_api->RecurMinutes . "\" min=\"-1\" max=\"999999\" /></td></tr>";
	$retval .= "<td>NoShowMinutes:</td><td><input type=\"number\" name=\"NoShowMinutes\" value=\"" . $pmapi_api->NoShowMinutes . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>BuyIn:</td><td><input type=\"number\" name=\"BuyIn\" value=\"" . $pmapi_api->BuyIn . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>EntryFee:</td><td><input type=\"number\" name=\"EntryFee\" value=\"" . $pmapi_api->EntryFee . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>Ticket:</td><td><input type=\"text\" name=\"Ticket\" value=\"" . $pmapi_api->Ticket . "\"/></td></tr>";
	$retval .= "<td>TicketRequired:</td><td>". pmapi_formdropdown("TicketRequired",array("Yes","No"),$pmapi_api->TicketRequired) . "</td></tr>";
	$retval .= "<td>TicketFunded:</td><td>". pmapi_formdropdown("TicketFunded",array("Yes","No"),$pmapi_api->TicketFunded) . "</td></tr>";
	$retval .= "<td>PrizeBonus:</td><td><input type=\"number\" name=\"PrizeBonus\" value=\"" . $pmapi_api->PrizeBonus . "\" min=\"0\" /></td></tr>";
	$retval .= "<td>MultiplyBonus:</td><td>". pmapi_formdropdown("MultiplyBonus",array("Yes","No","Min"),$pmapi_api->MultiplyBonus) . "</td></tr>";
	$retval .= "<td>Chips:</td><td><input type=\"number\" name=\"Chips\" value=\"" . $pmapi_api->Chips . "\" min=\"10\" max=\"25000\" /></td></tr>";
	$retval .= "<td>AddOnChips:</td><td><input type=\"number\" name=\"AddOnChips\" value=\"" . $pmapi_api->AddOnChips . "\" min=\"0\" max=\"50000\" /></td></tr>";
	$retval .= "<td>TurnClock:</td><td><input type=\"number\" name=\"TurnClock\" value=\"" . $pmapi_api->TurnClock . "\" min=\"10\" max=\"120\" /></td></tr>";
	$retval .= "<td>TurnWarning:</td><td><input type=\"number\" name=\"TurnWarning\" value=\"" . $pmapi_api->TurnWarning . "\" min=\"5\" max=\"119\" /></td></tr>";
	$retval .= "<td>TimeBank:</td><td><input type=\"number\" name=\"TimeBank\" value=\"" . $pmapi_api->TimeBank . "\" min=\"0\" max=\"600\" /></td></tr>";
	$retval .= "<td>BankSync:</td><td>". pmapi_formdropdown("BankSync",array("Yes","No"),$pmapi_api->BankSync) . "</td></tr>";
	$retval .= "<td>BankReset:</td><td><input type=\"number\" name=\"BankReset\" value=\"" . $pmapi_api->BankReset . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>DisProtect:</td><td>". pmapi_formdropdown("DisProtect",array("Yes","No"),$pmapi_api->DisProtect) . "</td></tr>";
	$retval .= "<td>Level:</td><td><input type=\"number\" name=\"Level\" value=\"" . $pmapi_api->Level . "\" min=\"1\" max=\"1000\" /></td></tr>";
	$retval .= "<td>RebuyLevels:</td><td><input type=\"number\" name=\"RebuyLevels\" value=\"" . $pmapi_api->RebuyLevels . "\" min=\"0\" max=\"1000\" /></td></tr>";
	$retval .= "<td>Threshold:</td><td><input type=\"number\" name=\"Threshold\" value=\"" . $pmapi_api->Threshold . "\" min=\"0\" max=\"999999\" /></td></tr>";
	$retval .= "<td>MaxRebuys:</td><td><input type=\"number\" name=\"MaxRebuys\" value=\"" . $pmapi_api->MaxRebuys . "\" min=\"-1\"  /></td></tr>";
	$retval .= "<td>/RebuyCost:</td><td><input type=\"number\" name=\"RebuyCost\" value=\"" . $pmapi_api->RebuyCost . "\" min=\"0\"  /></td></tr>";
	$retval .= "<td>/RebuyFee:</td><td><input type=\"number\" name=\"RebuyFee\" value=\"" . $pmapi_api->RebuyFee . "\" min=\"0\"  /></td></tr>";
	$retval .= "<td>BreakTime:</td><td><input type=\"number\" name=\"BreakTime\" value=\"" . $pmapi_api->BreakTime . "\" min=\"0\" max=\"60\" /></td></tr>";
	$retval .= "<td>BreakLevels:</td><td><input type=\"number\" name=\"BreakLevels\" value=\"" . $pmapi_api->BreakLevels . "\" min=\"0\" max=\"1000\" /></td></tr>";
	$retval .= "<td>StopOnChop:</td><td>". pmapi_formdropdown("StopOnChop",array("Yes","No"),$pmapi_api->StopOnChop) . "</td></tr>";
	$retval .= "<td>BringInPercent:</td><td><input type=\"number\" name=\"BringInPercent\" value=\"" . $pmapi_api->BringInPercent . "\" min=\"1\" max=\"99\" /></td></tr>";
	$retval .= "<td>Blinds:</td><td><textarea cols=\"40\" rows=\"4\" name=\"Blinds\">" . $pmapi_api->Blinds . "</textarea></td></tr>";
	$retval .= "<td>Payout:</td><td><textarea cols=\"40\" rows=\"4\" name=\"Payout\">" . $pmapi_api->Payout . "</textarea></td></tr>";
	$retval .= "<td>PayoutTickets:</td><td><input type=\"text\" name=\"PayoutTickets\" value=\"" . $pmapi_api->PayoutTickets . "\"/></td></tr>";
	$retval .= "<td>UnregLogout:</td><td>". pmapi_formdropdown("UnregLogout",array("Yes","No"),$pmapi_api->UnregLogout) . "</td></tr>";
	$retval .= "</table><input type=\"hidden\" name=\"pmapi_tournament\" value=\"" . $name . "\" />";

	if($_POST['pmapi_newtournament']=='Create New Game')
		$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Create New Game\" />";
	else if($pmapi_api->Result == "Ok")
	{
		if($pmapi_api->Status == "Offline")
		{
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Update\" />";	
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Online\" />";	
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Delete\" />";	
		}
		else
			$retval .= "<input type=\"submit\" name=\"pmgameadmin\" value=\"Offline\" /><br/>".
					"<div>!!!WARNING - This will take the Tournament offline now!!!</div>";
	}
	$retval .= "</form>";
	return pmapi_output_cleaner($retval);
}


?>