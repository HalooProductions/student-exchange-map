<?php 

include_once('DB.php');
include_once('Experience.php');
$conn = new DB;
$conn->connect();

$exp = new Experience($conn);
$exp = $exp->get(['1' => '1']);

echo json_encode($exp->items);