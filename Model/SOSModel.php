<?php

require_once('../SOSFrame/Classes/SOSOutput.php');

class SOSModel {
	private $view;
	
	public function __construct($view) {
		$this->view = $view;
	}
	
	public function updateState($value) {
		// Database query goes here
		$output = new SOSOutput(
				$value,
				"This is the description",
				"This is the Content Title",
				"This is the Content Body",
				"Prev content",
				"Next content");
		$this->view->respond($output);		
	}
}