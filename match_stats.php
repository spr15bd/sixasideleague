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
		<table align=center width=40% height=540><tr valign=top height=50><td align=center colspan=3><h1>Match Stats</h1></td></tr><tr><td height=30></td></tr>
		<?php 
		// Connect to the MySQL database
		include "scripts/connect_to_mysql.php";
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT * FROM result WHERE id=".$_GET["matchid"]);
		$resultCount = mysqli_num_rows($sql);	//count the number of records (results)
		
		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<tr><td colspan=3 align=center>";
				echo "<h3>".$row["home_team"]."  ".$row["home_goals"]." ".$row["away_team"]." ".$row["away_goals"]."</h3>";
				echo "</td></tr>";
				echo "<tr><td colspan=3 align=center>";
				echo "<h3>".$row["match_date"]."</h3>";
				echo "</td></tr>";
				echo "<tr>";
				echo "<td width=\"30%\">".$row["home_team"]."</td><td align=\"center\">v</td><td width=\"30%\" align=\"right\">".$row["away_team"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_shots"]."</td><td align=\"center\">Shots</td><td align=\"right\">".$row["away_shots"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_shots_on_target"]."</td><td align=\"center\">Shots on target</td><td align=\"right\">".$row["away_shots_on_target"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_possession"]."%</td><td align=\"center\">Possession</td><td align=\"right\">".$row["away_possession"]."%</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_corners"]."</td><td align=\"center\">Corners</td><td align=\"right\">".$row["away_corners"]."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$row["home_fouls"]."</td><td align=\"center\">Possession</td><td align=\"right\">".$row["away_fouls"]."</td>";
				echo "</tr>";
				
			}
		} else {
			echo "<tr><td align=center>No stats to report.</td></tr>";
		}
		echo "<tr><td height=5%></td></tr>";
		echo "<tr><td colspan=5 align=center><a href=".$_GET["frompage"].">Back</a></td></tr>";
		echo "<tr><td height=40%></td></tr>";
		?>
		</table>
	</div>
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>