<?php
$db_host = getenv('OPENSHIFT_MYSQL_DB_HOST');

$db_port = getenv('OPENSHIFT_MYSQL_DB_PORT');

$db_username = 'adminsdtxdFf';

//getenv('OPENSHIFT_MYSQL_DB_USERNAME');

$db_pass= 'Lq7TiuHQ8zdc';

//getenv('OPENSHIFT_MYSQL_DB_PASSWORD');

$db_name = 'personalprojects';

//getenv('OPENSHIFT_GEAR_NAME');

$connection  = mysqli_connect("$db_host","$db_username", "$db_pass", "", $db_port) or die ("Could not connect to the mysql5.5 database.");
mysqli_select_db($connection,"$db_name") or die ("No database");

?>