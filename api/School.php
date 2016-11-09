<?php

include_once('Collection.php');

class School 
{
	var $id = 0;
	var $name;
	var $country;
	var $city;
	var $place_id;
	var $conn;

	protected $required = [
		'name',
		'country',
		'city',
		'place_id'
	];

	function __construct($db_connection) {
		if ($db_connection instanceof DB) {
			$this->conn = $db_connection;
		} else {
			throw new Exception("Error initializing School class: First parameter needs to be a instance of DB class!");
		}
	}

	function update($data) {
		if ($this->id === 0) {
			throw new Exception("Error updating school object: Trying to update a object which isnt in the database yet!");

			return $this;
		}

		$checks = 0;
		$checkLimit = count($data);

		foreach ($data as $key => $value) {
			if (in_array($key, $this->required)) {
				$checks++;
			}
		}

		if ($checks !== $checkLimit) {
			throw new Exception("Error updating school object: Invalid field(s)!");
		} else {
			foreach ($data as $key => $value) {
				$this->{$key} = $value;
			}
		}

		return $this;
	}

	function create($data) {
		$checks = 0;
		$checkLimit = count($this->required);

		foreach ($this->required as $value) {
			if (array_key_exists($value, $data)) {
				$checks++;
			}
		}

		if ($checks !== $checkLimit) {
			throw new Exception("Error creating a new school object: Required field(s) missing!");
		}

		if (isset($data['id'])) {
			$this->id = $data['id'];
		}

		$this->name = $data['name'];
		$this->country = $data['country'];
		$this->city = $data['city'];
		$this->place_id = $data['place_id'];

		return $this;
	}

	function delete() {
		if ($this->id === 0) {
			throw new Exception("Error with deleting school object: id not found !");
		} else {
			$this->conn->delete("schools", $this->id);				
		}

	}

	function save() {
		// Puuttuu departmentit
		if ($this->id !== 0) {
			$id = $this->conn->update(
				'schools', 
				['name', 'country', 'city', 'place_id'], 
				[$this->name, $this->country, $this->city, $this->place_id]
			);
		} else {
			$id = $this->conn->create(
				'schools', 
				['name', 'country', 'city', 'place_id'], 
				[$this->name, $this->country, $this->city, $this->place_id]
			);
		}

		// Ei varma toimiiko, exceptionit olisi parempi laittaa DB classista ja ottaa kiinni täällä?
		if ($id === 0) {
			throw new Exception("Error saving a new school object: Error while saving to database!");
		}
	}
	
	function where($params) {
		$records = $this->conn->get('schools', $params);
		$returnCollection = new Collection([]);

		if (count($records) > 0) {
			foreach ($records as $key => $record) {
				$tmp = new School($this->conn);
				$tmp->create($record);
				$returnCollection->push($tmp);
			}
		} else {
			throw new Exception("Error while retrieving schools: No records found in database!");		
		}

		return $returnCollection;
	}
}