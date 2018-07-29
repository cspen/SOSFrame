<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');

class SOSModel {
	private $view;
	
	public function __construct($view) {
		$this->view = $view;
	}
	
	public function updateState($value) {
		$path = str_ireplace("/Ozone/SOSFrame/Public/", "", $_SERVER['REQUEST_URI']);
		$request = explode("/", $path);
		
		$db = new DBConnection();
		$dbconn = $db->getConnection();
		$query = "";
		if(is_array($request)) {			
			$c = count($request);
			if($c == 2 && $request[1] != "") {
				// Article page
				$output = new SOSOutput(
						"Article",
						"This is the description",
						"This is the Content Title",
						"This is the Content Body",
						"Prev content",
						"Next content");
				$this->view->articlePage($output);
			} else if($c == 2) {
				// Topic page				
				// $query = "SELECT * FROM article WHERE topic=:topic";
				// $stmt->bindParam(':topic', $request[0]);
				$output = new SOSOutput(
						"Topic",
						"This is the description",
						"This is the Content Title",
						"This is the Content Body",
						"Prev content",
						"Next content");
				$this->view->topicPage($output);
			} else if($c == 1) {
				$output = new SOSOutput(
						"Home Page - ",
						"This is the description",
						"This is the Content Title",
						"This is the Content Body",
						"Prev content",
						"Next content");
				$this->view->homePage($output);
			} else {
				// echo 'ELSE';
			}
		}
		
		/*
		$stmt = $dbconn->prepare($query);
		if($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			if($rowCount == 1) {
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		*/
		
		
		
		
			
		
	}
}