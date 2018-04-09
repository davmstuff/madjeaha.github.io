<?php
$servername = "localhost";//"mysql.hostinger.fr";
$username = "root";//"u932683326_admin";
$password = "";//"F6y2ixnCgA074K2";
$dbname = "aha";//"u932683326_aha";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>