<?php

include_once('DB.php');
include_once('School.php');

$conn = new DB;
$conn->connect();

$asd = new School($conn);

/*$asd->create([
	'name' => 'Savonia Ammattikorkeakoulu',
	'country' => 1,
	'city' => 2,
	'place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28',
	'departments' => [1, 3],
])->save();

echo $asd->name;*/

var_dump($asd->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28']));
var_dump($asd->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28'])->first());
var_dump($asd->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28'])->first()->name);