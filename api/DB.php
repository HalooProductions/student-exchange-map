<?php

class DB 
{
	var $dbname = 'kartta';
	var $loginName = 'root';
	var $password = '';
	var $db;

	function connect() {
		$this->db = new PDO('mysql:host=localhost;dbname=' . $this->dbname . ';charset=utf8mb4', $this->loginName, $this->password);
	}

	function get($table, $options = []) {
		$query = "SELECT * FROM $table WHERE ";
		
		$i = 0;
		$len = count($options);
		foreach ($options as $key => $option) {
			if ($i < $len - 1) {
				$query .= $key . ' = ' . $this->db->quote($option) . ' AND ';
			} else {
				$query .= $key . ' = ' . $this->db->quote($option);
			}
			$i++;
		}

		$result = $this->db->query($query);

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	function exists($table, $options = []) {
		$query = "SELECT * FROM $table WHERE ";
		
		$i = 0;
		$len = count($options);
		foreach ($options as $key => $option) {
			if ($i < $len - 1) {
				$query .= $key . ' = ' . $this->db->quote($option) . ' AND ';
			} else {
				$query .= $key . ' = ' . $this->db->quote($option);
			}
			$i++;
		}

		$result = $this->db->query($query);

		$exists = false;

		$exists = $result->fetchAll(PDO::FETCH_ASSOC);

		if ($exists) {
			$exists = true;
		} else if (count($exists) == 0) {
			$exists = false;
		}

		return $exists;
	}

	function update($table, $where = [], $values = []) {
		$query = "UPDATE $table SET ";

		$i = 0;
		$len = count($values);
		foreach ($values as $key => $value) {
			if ($i < $len - 1) {
				$query .= $key . ' = ' . $this->db->quote($value) . ', ';
			} else {
				$query .= $key . ' = ' . $this->db->quote($value);
			}
			$i++;
		}

		$query .= " WHERE " . $where['col'] . " = " . $this->db->quote($where['val']);

		$result = $this->db->exec($query);

		return $this->db->lastInsertId();
	}

	function create($table, $cols = [], $values = []) {
		// INSERT INTO schools (name, place_id, city) VALUES ('Savonia', 'asdasd', 2)
		$query = "INSERT INTO $table (";

		$i = 0;
		$len = count($cols);
		foreach ($cols as $key => $col) {
			if ($i < $len - 1) {
				$query .= $col . ', ';
			} else {
				$query .= $col;
			}
			$i++;
		}

		$query .= ") VALUES (";

		$i = 0;
		$len = count($values);
		foreach ($values as $key => $value) {
			if ($i < $len - 1) {
				$query .= $this->db->quote($value) . ', ';
			} else {
				$query .= $this->db->quote($value);
			}
			$i++;
		}

		$query .= ")";

		$result = $this->db->exec($query);

		return $this->db->lastInsertId();
	}
	Function delete($table, $id) {

		$query = "DELETE FROM $table WHERE id = ";
		$query .= $this->db->quote($id);
	}
}