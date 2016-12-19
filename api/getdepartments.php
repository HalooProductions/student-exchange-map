<?php 

include_once('DB.php');
include_once('School.php');
include_once('Request.php');
$request = new Request();
$conn = new DB;
$conn->connect();

$schoolid = $request->input('school');

$deps = new School($conn);
$deps = $deps->where(['id'=> $schoolid])->first();
$deps = $deps->getDepartments();

echo json_encode($deps);