<!-- This page used to connect the database -->
<?php
$username = "root";
$password = "";
$hostname = "localhost";
//connection to the database
$db = mysql_connect ($hostname, $username, $password)
     or die ("Unable to connect to MySQL");
	 echo "  ";
?>
	 
<?php
//selectselect a database to work with
$selected = mysql_select_db("carwashing",$db)
           or  die("Could not select database");
?>

