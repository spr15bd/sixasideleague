<?php


error_reporting(E_ALL);
ini_set( 'display_errors',true); 



session_start();
if (!isset($_SESSION["manager"])) {
	header("location: admin_login.php?destination=add_result.php");
	exit();
}

// Check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i','', $_SESSION["id"]);	//filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]);	//filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);	//filter everything but numbers and letters
// Run MySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database
include "../scripts/connect_to_mysql.php";
$sql = mysqli_query($connection, "SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1");	//query the database
// ............ MAKE SURE PERSON EXISTS IN THE DATABASE ...................
$existCount = mysqli_num_rows($sql);	// Count the number of rows
if ($existCount == 0) {
	
	header("location: ../index.php");
	exit();
} 


$max_events = 22;	//declare the maximum possible events per match; 22 is enough for a 50 minute match

?>
<?php
// Parse the log in form if the user has filled it out and pressed "Add result"
if (isset($_POST["home_team"]) && isset($_POST["home_goals"]) && isset($_POST["away_team"]) && isset($_POST["away_goals"]) && isset($_POST["match_date"])) {
	$home_team = preg_replace('#[^A-Za-z0-9\s]#i', '', $_POST["home_team"]);	//filter everything but spaces, numbers and letters
	$home_goals = preg_replace('#[^0-9]#i', '', $_POST["home_goals"]);	//filter everything but numbers
	$home_kit = preg_replace('#[^A-Za-z\s]#i', '', $_POST["home_kit"]);	//filter everything but letters and spaces
	$home_shots = preg_replace('#[^0-9]#i', '', $_POST["home_shots"]);	//filter everything but numbers
	$home_shots_on_target = preg_replace('#[^0-9]#i', '', $_POST["home_shots_on_target"]);	//filter everything but numbers
	$home_possession = preg_replace('#[^0-9]#i', '', $_POST["home_possession"]);	//filter everything but numbers
	$home_corners = preg_replace('#[^0-9]#i', '', $_POST["home_corners"]);	//filter everything but numbers
	$home_fouls = preg_replace('#[^0-9]#i', '', $_POST["home_fouls"]);	//filter everything but numbers
	$away_team = preg_replace('#[^A-Za-z0-9\s]#i', '', $_POST["away_team"]);	//filter everything but spaces, numbers and letters
	$away_goals = preg_replace('#[^0-9]#i', '', $_POST["away_goals"]);	//filter everything but numbers
	$away_kit = preg_replace('#[^A-Za-z\s]#i', '', $_POST["away_kit"]);	//filter everything but letters and spaces
	$away_shots = preg_replace('#[^0-9]#i', '', $_POST["away_shots"]);	//filter everything but numbers
	$away_shots_on_target = preg_replace('#[^0-9]#i', '', $_POST["away_shots_on_target"]);	//filter everything but numbers
	$away_possession = preg_replace('#[^0-9]#i', '', $_POST["away_possession"]);	//filter everything but numbers
	$away_corners = preg_replace('#[^0-9]#i', '', $_POST["away_corners"]);	//filter everything but numbers
	$away_fouls = preg_replace('#[^0-9]#i', '', $_POST["away_fouls"]);	//filter everything but numbers
	$attendance = preg_replace('#[^0-9]#i', '', $_POST["attendance"]);	//filter everything but numbers
	$match_date = $_POST["match_date"];				//filter nothing	
	$referee = preg_replace('#[^A-Za-z\s]#i', '', $_POST["referee"]);	//filter everything but letters and spaces

	
	// Update the results table
	$sql3 = mysqli_query($connection, "INSERT INTO result (home_team, home_goals, home_kit, home_shots, home_shots_on_target, home_possession, home_corners, home_fouls, away_team, away_goals, away_kit, away_shots, away_shots_on_target, away_possession, away_corners, away_fouls, attendance, match_date, referee) VALUES (\"$home_team\", \"$home_goals\", \"$home_kit\", \"$home_shots\", \"$home_shots_on_target\", \"$home_possession\", \"$home_corners\", \"$home_fouls\", \"$away_team\", \"$away_goals\", \"$away_kit\", \"$away_shots\", \"$away_shots_on_target\", \"$away_possession\", \"$away_corners\", \"$away_fouls\", \"$attendance\", \"$match_date\", \"$referee\")") or die(mysql_error()); 
	//$sql4 = mysqli_query($connection, "INSERT INTO result (home_team, home_goals, home_kit, home_shots, home_shots_on_target, home_possession, home_corners, home_fouls, away_team, away_goals, away_kit, away_shots, away_shots_on_target, away_possession, away_corners, away_fouls, attendance, match_date, referee) VALUES ('$home_team', 999, 'home', 2, 2, 2, 2, 2,  'totteridge', 2, 'away', 3, 3, 33, 3, 3, 83, '2014-12-14 12:45:00', 'Trev')") or die(mysql_error()); 
	$id_query = mysqli_query($connection, "SELECT id FROM result WHERE home_team = \"$home_team\" AND away_team = \"$away_team\"") or die(mysql_error());
	while ($row = mysqli_fetch_array($id_query)) {
				$id = $row["id"];
	}
	
	// Update the matchevents table
	for ($i=1; $i< $max_events+1; $i++) {
		if (!empty($_POST["minutes".$i]) && !empty($_POST["event".$i]) && !empty($_POST["player".$i]) && !empty($_POST["team".$i])) {
			$minutes = preg_replace('#[^0-9]#i', '', $_POST["minutes".$i]);	//filter everything but numbers
			$event = preg_replace('#[^A-Za-z\s]#i', '', $_POST["event".$i]);	//filter everything but spaces and letters
			$player = preg_replace('#[^A-Za-z\s]#i', '', $_POST["player".$i]);	//filter everything but spaces and letters
			$team = preg_replace('#[^A-Za-z0-9\s]#i', '', $_POST["team".$i]);	//filter everything but spaces, numbers and letters

			
			$sql = mysqli_query($connection, "INSERT INTO matchevent (resultid, minutes, event, player, team) VALUES ($id, $minutes, \"$event\", \"$player\", \"$team\")") or die(mysql_error()); 
			//$sql = mysqli_query($connection, "INSERT INTO matchevent (resultid, minutes, event, player, team) VALUES ($id, 5, \"yellow card\", \"Cantona\", \"Man Utd\")") or die(mysql_error()); 
		}
	}


	// Update the league table
	$hometeam_query = mysqli_query($connection, "SELECT * FROM leaguetable WHERE team = \"$home_team\"") or die(mysql_error());
	while ($row = mysqli_fetch_array($hometeam_query)) {
				$homeplayed = $row["played"];
				$homewon = $row["won"];
				$homedrawn = $row["drawn"];
				$homelost = $row["lost"];
				$homegoalsfor = $row["goalsfor"];
				$homegoalsagainst= $row["goalsagainst"];
				$homegoaldifference= $row["goaldifference"];
				$homepoints = $row["points"];
	}
	$awayteam_query = mysqli_query($connection, "SELECT * FROM leaguetable WHERE team = \"$away_team\"") or die(mysql_error());
	while ($row = mysqli_fetch_array($awayteam_query)) {
				$awayplayed = $row["played"];
				$awaywon = $row["won"];
				$awaydrawn = $row["drawn"];
				$awaylost = $row["lost"];
				$awaygoalsfor = $row["goalsfor"];
				$awaygoalsagainst= $row["goalsagainst"];
				$awaygoaldifference= $row["goaldifference"];
				$awaypoints = $row["points"];
	}

	$homeplayed += 1;
	$awayplayed += 1;
	if ($home_goals > $away_goals) {
		$homewon +=1;
		$awaylost += 1;
		$homepoints+=3;
	} else if ($home_goals < $away_goals) {
		$homelost += 1;
		$awaywon += 1;
		$awaypoints+=3;
	} else {
		$homepoints += 1;
		$awaypoints +=1;
		$homedrawn += 1;
		$awaydrawn += 1;
	}
	$homegoalsfor += $home_goals;
	$homegoalsagainst += $away_goals;
	$awaygoalsfor += $away_goals;
	$awaygoalsagainst += $home_goals;
	$homegoaldifference = $homegoalsfor - $homegoalsagainst;
	$awaygoaldifference = $awaygoalsfor - $awaygoalsagainst;

	$sql = mysqli_query($connection, "UPDATE leaguetable SET played=$homeplayed, won=$homewon, drawn=$homedrawn, lost=$homelost, goalsfor=$homegoalsfor, goalsagainst=$homegoalsagainst, goaldifference=$homegoaldifference, points=$homepoints WHERE team=\"$home_team\"") or die(mysql_error()); 
	$sql = mysqli_query($connection, "UPDATE leaguetable SET played=$awayplayed, won=$awaywon, drawn=$awaydrawn, lost=$awaylost, goalsfor=$awaygoalsfor, goalsagainst=$awaygoalsagainst, goaldifference=$awaygoaldifference, points=$awaypoints WHERE team=\"$away_team\"") or die(mysql_error());
	
	header("location: add_result.php");
	exit();
} 
?>


<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add New Result</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />

</head>

<body>
<div align="center" id="mainWrapper">
	<?php include_once("../template_header.php");?>
	<div id="pageContent" align="left">
		<br/>
		<center><h2>Enter the new result here</h2></center>
		<form id="form1" name="form1" method="post" action="add_result.php">
		<table width="90%" align="center"><tr>
		<td>Home team</td><td><input name="home_team" type="text" id="home_team" size="10" /></td>
		
		<td>Home goals</td><td><input name="home_goals" type="text" id="home_goals" size="1" /></td>

		<td>Home kit</td><td><input name="home_kit" type="text" id="home_kit" size="6" /></td>

		<td>Home shots</td><td><input name="home_shots" type="text" id="home_shots" size="2" /></td>

		<td>Home shots on target</td><td><input name="home_shots_on_target" type="text" id="home_shots_on_target" size="2" /></td>

		<td>Home possession</td><td><input name="home_possession" type="text" id="home_possession" size="2" /></td>

		<td>Home corners</td><td><input name="home_corners" type="text" id="home_corners" size="2" /></td>

		<td>Home fouls</td><td align="right"><input name="home_fouls" type="text" id="home_fouls" size="2" /></td>
		</tr>
		<tr>
		<td>Away team</td><td><input name="away_team" type="text" id="away_team" size="10" /></td>		

		<td>Away goals</td><td><input name="away_goals" type="text" id="away_goals" size="1" /></td>

		<td>Away kit</td><td><input name="away_kit" type="text" id="away_kit" size="6" /></td>

		<td>Away shots</td><td><input name="away_shots" type="text" id="away_shots" size="2" /></td>

		<td>Away shots on target</td><td><input name="away_shots_on_target" type="text" id="away_shots_on_target" size="2" /></td>

		<td>Away possession</td><td><input name="away_possession" type="text" id="away_possession" size="2" /></td>

		<td>Away corners</td><td><input name="away_corners" type="text" id="away_corners" size="2" /></td>

		<td>Away fouls</td><td align="right"><input name="away_fouls" type="text" id="away_fouls" size="2" /></td>
		</tr>
		<tr>
		<td>Attendance</td><td><input name="attendance" type="text" id="attendance" size="5" /></td>

		<td>Match date</td><td><input name="match_date" type="text" id="match_date" size="7" /></td>

		<td>Name of referee</td><td><input name="referee" type="text" id="referee" size="8" /></td>
		<td colspan="10" align="right"><input name="submit" type="submit"  value="Add result" /></td>
		</tr>
		
		<tr><td></td></tr>
		<tr><td colspan=16><center><h2>(Optional) - Enter match events here</h2></center></td><tr>
		<?php
		for ($i = 0; $i < ($max_events/2); $i++) {		//2 events per row so divide the max possible by 2 here
			echo "<tr>
				<td>Minutes</td><td><input name=\"minutes".($i*2+1)."\" type=\"text\" id=\"minutes".($i*2+1)."\" size=\"1\" /></td>
				<td>Event</td><td><input name=\"event".($i*2+1)."\" type=\"text\" id=\"event".($i*2+1)."\" size=\"7\" /></td>
				<td>Player</td><td><input name=\"player".($i*2+1)."\" type=\"text\" id=\"player".($i*2+1)."\" size=\"7\" /></td>
				<td>Team</td><td><input name=\"team".($i*2+1)."\" type=\"text\" id=\"team".($i*2+1)."\" size=\"7\" /></td>
				<td>Minutes</td><td><input name=\"minutes".($i*2+2)."\" type=\"text\" id=\"minutes".($i*2+2)."\" size=\"7\" /></td>
				<td>Event</td><td><input name=\"event".($i*2+2)."\" type=\"text\" id=\"event".($i*2+2)."\" size=\"7\" /></td>
				<td>Player</td><td><input name=\"player".($i*2+2)."\" type=\"text\" id=\"player".($i*2+2)."\" size=\"7\" /></td>
				<td>Team</td><td><input name=\"team".($i*2+2)."\" type=\"text\" id=\"team".($i*2+2)."\" size=\"7\" /></td>
			</tr>";
		}
		?>
		
		</table>
		</form>
		<br />
	<br />
	</div>
	<?php include_once("../template_footer.php");?>
</div>
</body>
</html>