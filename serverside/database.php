<?php
date_default_timezone_set('Asia/Kabul');
$server="localhost";
$user="root";
$password="root";
$database="roster";
$connection= mysqli_connect($server,$user,$password,$database);
if (!$connection)
        {
       die("Failed to connect to MySQL: " . mysqli_connect_error());
        }
?>
