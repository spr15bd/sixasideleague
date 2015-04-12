<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Stats</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />

</head>

<body>
<div align="center" id="mainWrapper">
	<?php include_once("template_header.php");?>
	<div id="pageContent">
		<?php 
		// Connect to the MySQL database
		include "leagueStandingsScripts/connect_to_mysql.php";
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT * FROM result WHERE id=".$_GET["matchid"]);
		$resultCount = mysqli_num_rows($sql);	//count the number of records (results)
		

		echo "<br>";

		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<h3>".$row["home_team"]."  ".$row["home_goals"]." ".$row["away_team"]." ".$row["away_goals"]."</h3>";
				echo "<h3>".$row["match_date"]."</h3>";
			
		
				echo "<table>";
				echo "<tr>";
				echo "<td width=\"40%\">".$row["home_team"]."</td><td>&nbsp</td><td align=\"center\">v</td><td>&nbsp</td><td width=\"40%\" align=\"right\">".$row["away_team"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_shots"]."</td><td>&nbsp</td><td align=\"center\">Shots</td><td>&nbsp</td><td align=\"right\">".$row["away_shots"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_shots_on_target"]."</td><td>&nbsp</td><td align=\"center\">Shots on target</td><td>&nbsp</td><td align=\"right\">".$row["away_shots_on_target"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_possession"]."%</td><td>&nbsp</td><td align=\"center\">Possession</td><td>&nbsp</td><td align=\"right\">".$row["away_possession"]."%</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_corners"]."</td><td>&nbsp</td><td align=\"center\">Corners</td><td>&nbsp</td><td align=\"right\">".$row["away_corners"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_fouls"]."</td><td>&nbsp</td><td align=\"center\">Possession</td><td>&nbsp</td><td align=\"right\">".$row["away_fouls"]."</td>";
				echo "</tr>";
				echo "</table>";
			}
		} else {
			echo "No stats to report.";
		}
		
		echo "<br></br><a href=".$_GET["frompage"].">Back</a>";
		?>
	</div>
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>