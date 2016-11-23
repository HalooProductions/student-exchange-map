<?php 

include_once('DB.php');
include_once('School.php');
$conn = new DB;
$conn->connect();

$schools = new School($conn);
$schools = $schools->get(['1' => '1']);

echo json_encode($schools->items);