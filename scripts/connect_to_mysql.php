<?php
$db_host = getenv('OPENSHIFT_MYSQL_DB_HOST');

$db_port = getenv('OPENSHIFT_MYSQL_DB_PORT');

$db_username = getenv('OPENSHIFT_MYSQL_DB_USERNAME');

$db_pass= getenv('OPENSHIFT_MYSQL_DB_PASSWORD');

$db_name = getenv('OPENSHIFT_GEAR_NAME');

$connection  = mysqli_connect("$db_host","$db_username", "$db_pass", "", $db_port) or die ("Could not connect to mysql");
mysqli_select_db($connection,"$db_name") or die ("No database");

?>