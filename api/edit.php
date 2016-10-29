<?php
include_once('DB.php');

$conn = new DB;
$conn->connect();

$schoolname = $_POST["schoolname"];
$placeid = $_POST["placeid"];

try {
	$lastid = $conn->create("schools", ["name", "place_id"], [$schoolname, $placeid]);
} catch (Exception $e) {
	echo $e;
}