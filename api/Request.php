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
		if (isset($get[$key])) {
			return $get[$key];
		} elseif (isset($post[$key])) {
			return $post[$key];
		} else {
			throw new Exception("Error: input not found in GET or POST");			
		}
	}
}