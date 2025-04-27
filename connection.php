<?php

$servername = "localhost";
$username = "hammouda"; 
$password = "3eb"; 
$dbname = "quiz_app"; 

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection ->connect_error){ die("Connection failed: " . $connection->connect_error); }
// not a real connection 3amo
?>
