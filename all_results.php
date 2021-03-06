<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Results</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />

</head>

<body>
<div align="center" id="mainWrapper">
	<?php include_once("template_header.php");?>
	<div id="pageContentAllResults">
		<table align=center width=800><tr valign=top height=50><td colspan=7 align=center><h1>All Results</h1></td></tr><tr><td height=30></td></tr>
		<?php 
		// Connect to the MySQL database
		include "scripts/connect_to_mysql.php";
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT * FROM result ORDER BY match_date");
		$resultCount = mysqli_num_rows($sql);	//count the number of records (results)
		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<tr>";
				echo "<td><a href=\"match_stats.php?frompage=all_results.php&matchid=".$row["id"]."\">Match Stats</a></td>";
				echo "<td>".$row["home_team"]."</td>";
				echo "<td>".$row["home_goals"]."</td>";
				echo "<td>".$row["away_team"]."</td>";
				echo "<td>".$row["away_goals"]."</td>";
				echo "<td align=center>".$row["match_date"]."</td>";
				echo "<td><a href=\"match_details.php?frompage=all_results.php&matchid=".$row["id"]."\">Match Summary</a></td>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td align=center>There are not yet any results</td></tr>";
		}
		echo "<tr><td height=100></td></tr>";
		echo "</table>";
		?>
	</div>
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>