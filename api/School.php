<?php

include_once('Collection.php');

class School 
{
	public $id = 0;
	public $name;
	public $country;
	public $city;
	public $place_id;
	public $departments;
	private $conn;

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

	function getDepartments() {
		$returnArr = [];

		if (count($this->departments) > 0) {
			foreach ($this->departments as $key => $department) {
				$tmp = $this->conn->get('departments', ['id' => $department]);
				if ($tmp !== NULL) {
					$returnArr[] = $tmp[0];
				}
			}
		}

		return $returnArr;
	}

	function update($data) {
		if ($this->id === 0) {
			throw new Exception("Error updating school object: Trying to update a object which isnt in the database yet!");

			return $this;
		}

		$checks = 0;
		$checkLimit = count($data);

		if (isset($data['departments'])) {
			$checkLimit--;
		}
		if (isset($data['id'])) {
			$checkLimit--;
		}

		foreach ($data as $key => $value) {
			if (in_array($key, $this->required)) {
				$checks++;
			}
		}

		if ($checks !== $checkLimit) {
			throw new Exception("Error updating school object: Invalid field(s)!");
		} else {
			foreach ($data as $key => $value) {
				if ($key === 'departments') {
					foreach ($value as $k => $val) {
						$value[$k] = strval($val);
					}
				}
				if($key != 'id')
				{
					$this->{$key} = $value;	
				}
			}
		}

		//var_dump($this);

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

		if (isset($data['departments'])) {
			$this->departments = $data['departments'];
		}

		return $this;
	}

	function delete() {
		if ($this->id === 0) {
			throw new Exception("Error with deleting school object: id not found !");
		} else {
			$this->conn->delete("school_has_department", $this->id, "school_id");
			$this->conn->delete("experiences", $this->id, "school_id");		
			$this->conn->delete("schools", $this->id);
		}
	}

	function deleteDepartments() {
		if ($this->id === 0) {
			throw new Exception("Error with deleting school object: id not found !");
		} else {
			$this->conn->delete("school_has_department", $this->id, "school_id");		
		}
	}

	function save() {
		if ($this->id !== 0) {
			$id = $this->conn->update(
				'schools', 
				[
					'col' => 'id',
					'val' => $this->id
				], 
				[
					'name' => $this->name, 
					'country' => $this->country, 
					'city' => $this->city, 
					'place_id' => $this->place_id
				]
			);

			$this->conn->delete('school_has_department', $this->id, 'school_id');
			
			foreach ($this->departments as $key => $department) {
				$this->conn->create(
					'school_has_department', 
					['school_id', 'department_id'],
					[$this->id, $department]
				);
			}
		} else {
			$id = $this->conn->create(
				'schools', 
				['name', 'country', 'city', 'place_id'], 
				[$this->name, $this->country, $this->city, $this->place_id]
			);

			foreach ($this->departments as $key => $department) {
				$this->conn->create(
					'school_has_department', 
					['school_id', 'department_id'],
					[$id, $department]
				);
			}
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
				$departments = $this->conn->get('school_has_department', ['school_id' => $record['id']]);				
				$departments_plucked = array_column($departments, 'department_id');
				$tmp->update(['departments' => $departments_plucked]);
				$returnCollection->push($tmp);
			}
		} else {
			throw new Exception("Error while retrieving schools: No records found in database!");		
		}

		return $returnCollection;
	}

	function get($params) {
		$records = $this->conn->get('schools', $params);
		$returnCollection = new Collection([]);
		if(count($records) > 0) {
			foreach ($records as $key => $record) {
				$tmp = new School($this->conn);
				$tmp->create($record);
				$departments = $this->conn->get('school_has_department', ['school_id' => $record['id']]);			
				$departments_plucked = array_column($departments, 'department_id');
				$tmp->update(['departments' => $departments_plucked]);
				$tmpcountry = $this->conn->get('countries', ['id' => $tmp->country]);
				
				$fixedtmp = array(
					"id" => $tmp->id,
					"name" => $tmp->name,
					"country" => $tmpcountry[0]['name'],
					"city" => $tmp->city,
					"place_id" => $tmp->place_id,
					"departments" => $tmp->departments,
					);
				$returnCollection->push($fixedtmp);
			}
		} else {
			return $returnCollection;
		}
		return $returnCollection;
	}
}