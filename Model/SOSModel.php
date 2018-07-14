<?php

require_once('../SOSFrame/Classes/SOSOutput.php');

class SOSModel {
	private $view;
	
	public function __construct($view) {
		$this->view = $view;
	}
	
	public function updateState($value) {
		$path = str_replace("/Ozone/SOSFrame/Public/", "", $_SERVER['REQUEST_URI']);
		$request = explode("/", $path);
		
		if(is_array($request)) {
			$c = count($request);
			if($c >= 2 && $request[1] != "") {
				// Article page
				echo '<br> Article page - '.$request[1];
				// Do database search based on article title
			} else if($c <= 2) {
				// Topic page
				echo '<br> Topic page - '.$request[0];
				// Do database search based on topic
			}
		}
		
		
		/*
		$output = new SOSOutput(
				$value,
				"This is the description",
				"This is the Content Title",
				"This is the Content Body",
				"Prev content",
				"Next content");
		$this->view->respond($output);	
		*/	
	}
}