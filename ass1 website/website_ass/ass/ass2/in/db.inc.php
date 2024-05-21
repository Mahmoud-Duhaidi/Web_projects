<?php

$dbServername = "localhost";
$dbNmae = "c130wb1200340";
$dbUsername = "root";
$dbPassword = "";


$mysqli = mysqli_connect($dbServername,$dbNmae,$dbUsername,$dbPassword);
 if ($mysqli-> mysqli_connect_error){
    die ("CONNECTION FAILED " . $mysqli_connect_error());
 }
  return $mysqli
