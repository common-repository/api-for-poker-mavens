<?php

function pmapi_player_admin_page() 
{
	$retval .= "<div class=\"wrap\"><h2>Poker Player Admin:</h2>";
	
	if(isset($_POST['pmapi_player']))
	{
		if($_REQUEST['pmuseradmin'] == "Update" ) 
			{
				$Player = $_REQUEST["pmapi_player"];
				$RealName = $_REQUEST["RealName"];
				$Gender = $_REQUEST["Gender"];
				$Location = $_REQUEST["Location"];
				$Title = $_REQUEST["Title"];
				$Level = $_REQUEST["Level"];
				$Email = $_REQUEST["Email"];
				$Avatar = $_REQUEST["Avatar"];
				$params = array("Command"  => "AccountsEdit",
								"Player"   => $Player,
								"RealName" => $RealName,
								"Location" => $Location,
								"Title"	   => $Title,
								"Level"    => $Level,
								"Email"    => $Email,
								"Avatar"   => $Avatar,
								"Gender"   => $Gender);
				$api = PMAPI_Poker_API($params);
			}
		if($_REQUEST['pmuseradmin'] == "Set Balance") 
			{
				$Player = $_REQUEST["pmapi_player"];
				$Amount = $_REQUEST["Amount"];
				if($_REQUEST["Adjust"] == "Add")
					$Command = "AccountsIncBalance";
				if($_REQUEST["Adjust"] == "Remove")
					$Command = "AccountsDecBalance";
				$params = array("Command"  => $Command,
								"Player"   => $Player,
								"Amount"   => floatval($Amount));
				$api = PMAPI_Poker_API($params);
			}	
		$retval .=  pmapi_useradmin_form($_POST['pmapi_player']);
		$retval .= "<br/><hr><br/>" . pmapi_userbalance_form($_POST['pmapi_player']);
	}
	else
	{
		$api = pmapi_AccountsList("Player,Email,Balance");
		if ($result == "Error") 
			$retval .=   "Error: " . $api -> Error;
		else
		{
			$accounts = $api -> Accounts;
			$retval .= "<form method=\"post\"><table border='1' cellpadding='5'>";
			$retval .= "<tr><th colspan='3'>Total Users: " . $accounts . "</th></tr>";
			$retval .= "<tr><th>Username</th><th>Email</th><th>Balance</th></tr>";
			for ($i = 0; $i < $accounts; $i++)
			{
				$retval .= "<tr><td>" . pmapi_submit_link($api -> Player[$i], 'pmapi_player') .
				"</td><td>" . $api -> Email[$i] . 
						"</td><td>" . $api -> Balance[$i] . "</td></tr>";
			}
			$retval .= "</table></form>";
		}
	}
	$retval .= "</div>";
	echo pmapi_output_cleaner($retval);
}

?>