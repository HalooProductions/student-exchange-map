<?php
use PHPUnit\Framework\TestCase;

//require_once 'PHPUnit/Autoload.php';
include_once(dirname(__FILE__) . '/../api/School.php');
include_once(dirname(__FILE__) . '/../api/DB.php');


class SchoolTest extends TestCase
{
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    public function testCreate()
    {
        $conn = new DB;
        $conn->connect();

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
        $this->assertEquals('Savonia Ammattikorkeakoulu', $b->where(['place_id' => 'ChIJUYf0dHe6hEYRKaYg4vlkF28'])->first()->name);
    }

    public function testUpdate()
    {
        $conn = new DB;
        $conn->connect();

        $a = new School($conn);

        $a->create([
            'name' => 'Savonia Ammattikoulu',
            'country' => 1,
            'city' => 2,
            'place_id' => 'ajasdkljljkjklfklr',
            'departments' => [1, 3],
        ])->save();

        $b = new School($conn);

        $b->where([
            'place_id' => 'ajasdkljljkjklfklr'
        ])->first();

        $b->update([
            'name' => 'Kiuruveden Yläkoulu',
            'city' => 1,
        ])->save();

        $c = new School($conn);

        $c->where([
            'place_id' => 'ajasdkljljkjklfklr'
        ])->first();

        $this->assertEquals('Kiuruveden Yläkoulu', $c->name);
        $this->assertEquals(1, $c->city);
    }

    public function testDelete()
    {
        $conn = new DB;
        $conn->connect();

        $a = new School($conn);

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

        $b->delete();

        $c = new School($conn);
        
        try {
            $c->where([
                'place_id' => 'asdggwp'
            ])->first();
        } catch (Exception $e){
            $message = $e->getMessage();
        }

        $this->assertEquals('Error while retrieving schools: No records found in database!', $message);
    }
}