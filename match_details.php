<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Details</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
	<?php include_once("template_header.php");?>
	<div id="pageContent">
		<table align=center width=400><tr valign=top height=50><td align=center colspan=4><h1>Match Summary</h1></td></tr><tr><td height=30 colspan=4></td></tr>
		<?php 
		// Connect to the MySQL database
		include "scripts/connect_to_mysql.php";
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT * FROM matchevent WHERE resultid=".$_GET["matchid"]);
		$sql2 = mysqli_query($connection, "SELECT * FROM result WHERE id=".$_GET["matchid"]);
		$resultCount = mysqli_num_rows($sql);	//count the number of records (events occurring in the match)
		$resultCount2 = mysqli_num_rows($sql2);
		if ($resultCount2 > 0) {
			while ($row = mysqli_fetch_array($sql2)) {
				echo "<tr><td colspan=4 align=center>";
				echo "<h3>".$row["home_team"]."  ".$row["home_goals"]." ".$row["away_team"]." ".$row["away_goals"]."</h3>";
				echo "</td></tr>";
				echo "<tr><td colspan=4 align=center>";
				echo "<h3>".$row["match_date"]."</h3>";
				echo "</td></tr>";
			}
		}
		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<tr>";
				echo "<td align=center>".$row["minutes"]."</td>";
				echo "<td align=center>".$row["event"]."</td>";
				echo "<td align=center>".$row["player"]."</td>";
				echo "<td align=center>".$row["team"]."</td>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td align=center>There were no events during this match.</td></tr>";
		}
		echo "<tr><td colspan=4 height=5%></td></tr>";
		echo "<tr><td colspan=4 align=center><a href=".$_GET["frompage"].">Back</a></td></tr>";
		echo "<tr><td height=30%></td></tr>";
		?>
		</table>
	</div>
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>