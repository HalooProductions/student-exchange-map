<?php
include_once('DB.php');

$conn = new DB;
$conn->connect();

$schoolname = $_POST["schoolname"];
$city = $_POST["city"];
$country = $_POST["country"];
$placeid = $_POST["placeid"];

$addschool = new School($conn);

try {
	$addschool->create([
		'name' => $schoolname,
		'county' => $country,
		'city' => $city,
		'place_id' => $placeid
	])->save();	
} catch (Exception $e) {
	echo $e->getMessage();
}