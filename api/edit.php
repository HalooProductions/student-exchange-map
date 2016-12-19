<?php
include_once('DB.php');
include_once('School.php');
include_once('Request.php');
include_once('Experience.php');

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

		try {
			$deplength = $request->input('deplength');
		} catch (Exception $e) {
			$errors = 'Virhe tietojenkäsittelyssä.';	
		}

		$schoolid = intval($schoolid);
		$updateschool = new School($conn);
		$updateschool = $updateschool->where([
			'id' => $schoolid
			])->first();

		if ($deplength == "none") 
		{
			$deletedepartments = new School($conn);

			try {
				$updateschool->update([
					'id' => $schoolid,
					'name' => $schoolname,
					'country' => $country,
					'city' => $city,
					'place_id' => $placeid,
				])->save();	
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			$deletedepartments = $deletedepartments->where([
				'id' => $schoolid,
				])->first();
			try {
				$deletedepartments->deleteDepartments([
					'id' => $schoolid,
					]);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		} 
		else {
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
else if ($action == 3)
{
	try {
		$schoolid = $request->input('schoolid');
		$writer = $request->input('writer');
		$url = $request->input('url');

		$experience = new Experience($conn);
		$experience = $experience->create([
			'writer' => $writer,
			'url' => $url,
			'school_id' => $schoolid
		])->save();
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}