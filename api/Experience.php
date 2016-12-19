<?php

include_once('Collection.php');

class Experience 
{
	public $id = 0;
	public $url;
	public $writer;
	public $school_id;
	private $conn;

	protected $required = [
		'url',
		'writer',
		'school_id',
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

		$this->url = $data['url'];
		$this->writer = $data['writer'];
		$this->school_id = $data['school_id'];

		return $this;
	}

	function delete() {
		if ($this->id === 0) {
			throw new Exception("Error with deleting school object: id not found !");
		} else {
			$this->conn->delete("school_has_department", $this->id, "school_id");		
			$this->conn->delete("experiences", $this->id);
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
				'experiences', 
				[
					'col' => 'id',
					'val' => $this->id
				], 
				[
					'url' => $this->url, 
					'writer' => $this->writer, 
					'school_id' => $this->school_id, 
				]
			);
		} else {
			$id = $this->conn->create(
				'experiences', 
				['url', 'writer', 'school_id'], 
				[$this->url, $this->writer, $this->school_id]
			);
		}

		// Ei varma toimiiko, exceptionit olisi parempi laittaa DB classista ja ottaa kiinni täällä?
		if ($id === 0) {
			throw new Exception("Error saving a new school object: Error while saving to database!");
		}
	}
	
	function where($params) {
		$records = $this->conn->get('experiences', $params);
		$returnCollection = new Collection([]);

		if (count($records) > 0) {
			foreach ($records as $key => $record) {
				$tmp = new Experience($this->conn);
				$tmp->create($record);
				$returnCollection->push($tmp);
			}
		} else {
			throw new Exception("Error while retrieving schools: No records found in database!");		
		}

		return $returnCollection;
	}

	function get($params) {
		$records = $this->conn->get('experiences', $params);
		$returnCollection = new Collection([]);
		if(count($records) > 0) {
			foreach ($records as $key => $record) {
				$tmp = new Experience($this->conn);
				$tmp->create($record);
				
				$fixedtmp = array(
					"url" => $tmp->url,
					"writer" => $tmp->writer,
					"school_id" => $tmp->school_id,
					);
				$returnCollection->push($fixedtmp);
			}
		} else {
			return $returnCollection;
		}
		return $returnCollection;
	}
}