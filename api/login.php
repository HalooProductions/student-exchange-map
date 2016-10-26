<?php
include_once('DB.php');

$conn = new DB;
$conn->connect();

$user = $_POST["name"];
$password = md5($_POST["pwd"]);

$response = [
	'success' => false,
];

if($conn->exists('users', ['username' => $user, 'password' => $password]))
{
	$response['success' => true];
}

echo(json_encode($response));