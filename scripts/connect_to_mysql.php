<?php
$db_host = "localhost";

$db_username = "root";

$db_pass= "parachute";

$db_name = "bd2772";

$connection  = mysqli_connect("$db_host","$db_username", "$db_pass") or die ("Could not connect to mysql");
mysqli_select_db($connection,"$db_name") or die ("No database");

?>