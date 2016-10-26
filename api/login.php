<?php
session_start();

include_once('DB.php');

$conn = new DB;
$conn->connect();

$user = $_POST["name"];
$password = $_POST["pwd"];

$response = [
	'success' => false,
];

if($conn->exists('users', ['username' => $user, 'password' => $password]))
{
	$response['success'] = true;
	$_SESSION["s41pt"] = true;
}

echo(json_encode($response));