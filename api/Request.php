<?php

class Request 
{
	private $get;
	private $post;

	function __construct() {
		$this->get = $_GET;
		$this->post = $_POST;
	}

	function input($key) {
		if (isset($this->get[$key])) {
			return $this->get[$key];
		} elseif (isset($this->post[$key])) {
			return $this->post[$key];
		} else {
			throw new Exception("Error: input not found in GET or POST");			
		}
	}
}
