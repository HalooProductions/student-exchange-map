<?php

include_once('DB.php');
include_once('School.php');

$conn = new DB;
$conn->connect();

$a = new School($conn);

/*$asd->create([
	'name' => 'Savonia Ammattikorkeakoulu',
	'country' => 1,
	'city' => 2,
	'place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28',
	'departments' => [1, 3],
])->save();

echo $asd->name;*/

/*var_dump($asd->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28']));
var_dump($asd->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28'])->first());
var_dump($asd->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28'])->first()->name);*/
$a->create([
    'name' => 'Savonia Ammattikoulu',
    'country' => 1,
    'city' => 2,
    'place_id' => 'asdggwp',
    'departments' => [1, 3],
])->save();

$b = new School($conn);

$b = $b->where([
    'place_id' => 'asdggwp'
])->first();

echo $b->name;

$b->delete();

$c = new School($conn);
$message = "";

try {
    $c = $c->where([
        'place_id' => 'asdggwp'
    ])->first();
    echo $c->name;
} catch (Exception $e){
    $message = $e->getMessage();
}