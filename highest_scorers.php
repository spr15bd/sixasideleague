<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Highest Scorers</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />

</head>
<body>
<div align="center" id="mainWrapper">
	<?php include_once("template_header.php");?>
	<div id="pageContent">
		<table align=center width=40% height=540><tr valign=top height=50><td colspan=3 align=center><h1>Highest Scorers</h1></td></tr><tr><td height=30></td></tr>
		<?php 
		// Connect to the MySQL database
		include "scripts/connect_to_mysql.php";
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT player AS Player, team AS Team, COUNT(event) AS Goals FROM matchevent WHERE event=\"goal\" OR event=\"goal (pen)\" GROUP BY player 
ORDER BY COUNT(event) desc LIMIT 18");
		$resultCount = mysqli_num_rows($sql);	//count the number of records
		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<tr>";
				echo "<td>".$row["Player"]."</td>";
				echo "<td>".$row["Team"]."</td>";
				echo "<td>".$row["Goals"]."</td>";
				echo "</tr>";
			}
		} else {
			echo "No goals yet to display.";
		}
		echo "<tr><td height=30></td></tr>";
		echo "</table>";
		?>
	</div>
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>