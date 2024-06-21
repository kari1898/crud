<?php
include "credentials.php";

$mysqli = new mysqli('localhost',$user,$pw,$db);
$Records = $mysqli->prepare("select * from kenworth");
$Records->execute();
$Result = $Records->get_result();
?>
