<?php
ob_start(); 


session_start();

date_default_timezone_set("America/New_York");

try {
     $con = new PDO("mysql:dbname=MeTube_hu35;host=mysql1.cs.clemson.edu;", "MeTube_hez3", "youtubeclone@2020");
    //$con = new PDO("mysql:dbname=Metube;host=localhost; ", "root", "");

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>