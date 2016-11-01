<?php
use PHPUnit\Framework\TestCase;

include_once(dirname(__FILE__) . '/../api/School.php');
include_once(dirname(__FILE__) . '/../api/DB.php');

$conn = new DB;
$conn->connect();


class SchoolTest extends TestCase
{
    // ...

    public function testCanBeNegated()
    {
        // Arrange
        $a = new School($conn);

        // Act
        $a->create([
            'name' => 'Savonia Ammattikorkeakoulu',
            'country' => 1,
            'city' => 2,
            'place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28',
            'departments' => [1, 3],
        ])->save();

        $b = new School($conn);

        // Assert
        $this->assertEquals('ChIJUYf0dHe6hEYRKaYg4vlkF28', $b->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28'])->first()->name);
    }
}