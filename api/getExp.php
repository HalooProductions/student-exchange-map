<?php 

include_once('DB.php');
include_once('Request.php');
include_once('Experience.php');

$conn = new DB;
$conn->connect();

$request = new Request();

try {
	$schoolid = $request->input('school');
} catch (Exception $e) {
	$schoolid = '-1';
}

$exp = new Experience($conn);
$exp = $exp->where(['school_id' => $schoolid]);

echo json_encode($exp->items);