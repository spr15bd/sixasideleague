<?php
session_start();
if (isset($_SESSION["manager"])) {
	header("location: ../index.php");
	exit();
}
?>
<?php
// Parse the log in form if the user has filled it out and pressed "Log In"
if (isset($_POST["username"]) && isset($_POST["password"])) {

	$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]);	//filter everything but numbers and letters
	$password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);	//filter everything but numbers and letters
	// Connect to the MySQL database
	include "../scripts/connect_to_mysql.php";
	$sql = mysqli_query($connection, "SELECT id FROM admin WHERE username='$manager' AND  password='$password' LIMIT 1") or die(mysql_error());  ;//query the person
	// ............ MAKE SURE PERSON EXISTS IN THE DATABASE ...................
	$existCount = mysqli_num_rows($sql);	// Count the number of rows
	printf("Result set has %d rows.\n",$existCount);
	
	if ($existCount == 1) {
		while ($row = mysqli_fetch_array($sql)) {
			$id = $row["id"];
		}
		$_SESSION["id"] = $id;
		$_SESSION["manager"] = $manager;
		$_SESSION["password"] = $password;
		
		header("location: ".$_GET["destination"]);
		exit();
	} else {
		echo "That information is incorrect, try again <a href=admin_login.php?destination=".$_GET["destination"].">Click here</a>";
		exit();
	}

}
?>
<!DOCTYPE html PUBLIC "-//WC3/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www/w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />

</head>

<body>
<div align="center" id="mainWrapper">
	<?php include_once("../template_header.php");?>
	<div id="pageContent"><br />
		<h2>Please log in to make changes to the league.</h2>
		<form id="form1" name="form1" method="post" action="admin_login.php?destination=<?php echo $_GET['destination']; ?>">
		User Name<br />
		<input name="username" type="text" id="username" size="40" />
		<br /><br />
		Password<br />
		<input name="password" type="text" id="password" size="40" />
		<br /><br />
		<input name="submit" type="submit"  value="Log In" />
		</form>
		<br /><br />
	<br />
	</div>
	<?php include_once("../template_footer.php");?>
</div>
</body>
</html>