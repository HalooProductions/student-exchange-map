<?php

class Collection 
{
	var $items = [];

	function __construct($arr) {
		if (!is_array($arr)) {
			throw new Exception("Error creating a collection: First parameter has to be an array!");		
		}

		$this->items = $arr;
	}

	function first() {
		return $this->items[0];
	}

	function each($closure) {
		foreach ($this->items as $key => $value) {
			$closure($value);
		}
	}

	function push($data) {
		$this->items[] = $data;

		return $this;
	}
}