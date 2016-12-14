<?php
session_start();

include_once('DB.php');

$conn = new DB;
$conn->connect();

if (isset($_GET["logout"]) && $_GET["logout"] === "true")
{
	$_SESSION["s41pt"] = "";
	header('Location: ../index.html');
}
else
{
	$user = $_POST["name"];
	$password = $_POST["pwd"];

	$response = [
		'success' => false,
	];

	if($conn->exists('users', ['username' => $user, 'password' => $password]))
	{
		$response['success'] = true;
		$_SESSION["s41pt"] = "985737xz7v8z8sdf859724";
	}


	echo(json_encode($response));
}



