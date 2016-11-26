<?php
include_once('DB.php');
include_once('School.php');
include_once('Request.php');
$conn = new DB;
$conn->connect();

$request = new Request();
$errors = '';

try {
	$action = $request->input('action');
} catch (Exception $e) {
	$errors = 'Virhe tietojenkäsittelyssä';
}

if($action == 0 || $action == 1)
{
	try {
		$schoolname = $request->input('schoolname');
	} catch (Exception $e) {
		$errors = 'Virhe tietojenkäsittelyssä.';	
	}

	try {
		$city = $request->input('city');
	} catch (Exception $e) {
		$errors = 'Virhe tietojenkäsittelyssä.';	
	}

	try {
		$country = $request->input('country');
	} catch (Exception $e) {
		$errors = 'Virhe tietojenkäsittelyssä.';	
	}

	try {
		$placeid = $request->input('placeid');
	} catch (Exception $e) {
		$errors = 'Virhe tietojenkäsittelyssä.';	
	}

	try {
		$departments = $request->input('departments');
	} catch (Exception $e) {
		$errors = 'Virhe tietojenkäsittelyssä.';	
	}

	if($action == 0)
	{
		$addschool = new School($conn);
		try {
			$addschool->create([
				'name' => $schoolname,
				'country' => $country,
				'city' => $city,
				'place_id' => $placeid,
				'departments' => $departments,
			])->save();	
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	else if($action == 1)
	{
		try {
			$schoolid = $request->input('schoolid');
		} catch (Exception $e) {
			$errors = 'Virhe tietojenkäsittelyssä.';	
		}
		$schoolid = intval($schoolid);
		$updateschool = new School($conn);
		$updateschool = $updateschool->where([
			'id' => $schoolid
			])->first();

		try {
			$updateschool->update([
				'id' => $schoolid,
				'name' => $schoolname,
				'country' => $country,
				'city' => $city,
				'place_id' => $placeid,
				'departments' => $departments,
			])->save();	
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
else if($action == 2)
{
	try {
		$schoolid = $request->input('schoolid');
	} catch (Exception $e) {
		$errors = 'Virhe tietojenkäsittelyssä.';	
	}
	$schoolid = intval($schoolid);
	$deleteschool = new School($conn);

	$deleteschool = $deleteschool->where([
		'id' => $schoolid
		])->first();

	try {
		$deleteschool->delete([
			'id' => $schoolid,
			]);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}