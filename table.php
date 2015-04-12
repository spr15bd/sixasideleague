<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Current Table</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />

</head>

<body>
<div align="center" id="mainWrapper">
	<?php include_once("template_header.php");?>
	<div id="pageContent">
		<?php 
		// Connect to the MySQL database
		include "scripts/connect_to_mysql.php";
		// Grab the result list ready for viewing

		$sql = mysqli_query($connection, "SELECT * FROM leaguetable ORDER BY points DESC");
		$resultCount = mysqli_num_rows($sql);	//count the number of records (teams with stats to display)
		echo "<br><br>";
		echo "<table>";
		echo "<tr>";
		echo "<td></td><td>P</td><td>W</td><td>D</td><td>L</td><td>F</td><td>A</td><td>GD</td><td>P</td>";
		echo "</tr>";
		if ($resultCount > 0) {
			while ($row = mysqli_fetch_array($sql)) {
				echo "<tr>";
				echo "<td>".$row["team"]."</td>";
				echo "<td>".$row["played"]."</td>";
				echo "<td>".$row["won"]."</td>";
				echo "<td>".$row["drawn"]."</td>";
				echo "<td>".$row["lost"]."</td>";
				echo "<td>".$row["goalsfor"]."</td>";
				echo "<td>".$row["goalsagainst"]."</td>";
				echo "<td>".$row["goaldifference"]."</td>";
				echo "<td>".$row["points"]."</td>";
				echo "</tr>";
			}
		} else {
			echo "There are not yet any results";
		}
		echo "</table>";
		?>

	</div>
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>