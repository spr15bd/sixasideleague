<?php
session_start();
if (!isset($_SESSION["manager"])) {
	header("location: admin_login.php?destination=delete_result.php");
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

if (!empty($_GET["delete_id"])) {
	$sql1 = mysqli_query($connection, "SELECT * FROM result WHERE id=".$_GET["delete_id"]);
	while ($row = mysqli_fetch_array($sql1)) {
				$home_team = $row["home_team"];
				$away_team = $row["away_team"];
				$home_goals = $row["home_goals"];
				$away_goals = $row["away_goals"];
	}
	$sql2 = mysqli_query($connection, "DELETE FROM matchevent WHERE resultid=".$_GET["delete_id"]);
	$sql3 = mysqli_query($connection, "DELETE FROM result WHERE id=".$_GET["delete_id"]);

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

	$homeplayed -= 1;
	$awayplayed -= 1;
	if ($home_goals > $away_goals) {
		$homewon -=1;
		$awaylost -= 1;
		$homepoints-=3;
	} else if ($home_goals < $away_goals) {
		$homelost -= 1;
		$awaywon -= 1;
		$awaypoints-=3;
	} else {
		$homepoints -= 1;
		$awaypoints -=1;
		$homedrawn -= 1;
		$awaydrawn -= 1;
	}
	$homegoalsfor -= $home_goals;
	$homegoalsagainst -= $away_goals;
	$awaygoalsfor -= $away_goals;
	$awaygoalsagainst -= $home_goals;
	$homegoaldifference = $homegoalsfor - $homegoalsagainst;
	$awaygoaldifference = $awaygoalsfor - $awaygoalsagainst;

	$sql = mysqli_query($connection, "UPDATE leaguetable SET played=$homeplayed, won=$homewon, drawn=$homedrawn, lost=$homelost, goalsfor=$homegoalsfor, goalsagainst=$homegoalsagainst, goaldifference=$homegoaldifference, points=$homepoints WHERE team=\"$home_team\"") or die(mysql_error()); 
	$sql = mysqli_query($connection, "UPDATE leaguetable SET played=$awayplayed, won=$awaywon, drawn=$awaydrawn, lost=$awaylost, goalsfor=$awaygoalsfor, goalsagainst=$awaygoalsagainst, goaldifference=$awaygoaldifference, points=$awaypoints WHERE team=\"$away_team\"") or die(mysql_error());
	header("location: delete_result.php");
	exit();
}
?>

<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete a Result</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
	<?php include_once("../template_header.php");?>
	<div id="pageContent">
		<table align=center><tr valign=top height=50><td align=center colspan=6><h2>Choose the result to delete</h2></td></tr><tr><td height=30></td></tr>
		<?php 
		
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT * FROM result ORDER BY match_date");
		$resultCount = mysqli_num_rows($sql);	//count the number of records (results)
		
		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<tr>";
				echo "<td>".$row["home_team"]."</td>";
				echo "<td>".$row["home_goals"]."</td>";
				echo "<td>".$row["away_team"]."</td>";
				echo "<td>".$row["away_goals"]."</td>";
				echo "<td>".$row["match_date"]."</td>";
				echo "<td><a href=\"delete_result.php?delete_id=".$row["id"]."\">Delete</a></td>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td>There are not yet any results.</td></tr>";
		}
		
		?>
		</table>
	</div>
	<?php include_once("../template_footer.php");?>
</div>
</body>
</html>