<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');

class SOSModel {
	private $view;
	
	public function __construct($view) {
		$this->view = $view;
	}
	
	public function updateState($value) {
		$requestURI = explode("?", $_SERVER['REQUEST_URI']);
		$requestURI = $requestURI[0];
		$params = explode("/", $_SERVER['REQUEST_URI']);
		
		$db = new DBConnection();
		$dbconn = $db->getConnection();
		$query = "";
		if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-za-z0-9-]+)\/([A-za-z0-9-]+)$/', $requestURI)) {
			// Article page
			$output = new SOSOutput(
				"Article",
				"This is the description",
				"This is the Content Title",
				"This is the Content Body",
				"Prev content",
				"Next content");
			$this->view->articlePage($output);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-Za-z0-9-]+)\/$/', $requestURI)) {
			// Topic page				
			// $query = "SELECT * FROM article WHERE topic=:topic";
			// $stmt->bindParam(':topic', $request[0]);
			$output = new SOSOutput(
				"Topic",
				"This is the description",
				"Topic Content Title",
				"Topic Content Body",
				"Prev content",
				"Next content");
			$this->view->topicPage($output);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/$/', $requestURI)) {
			$output = new SOSOutput(
				"Science of Stupidity",
				"This is the description",
				"Home Page Content Title",
				"Home Page Content Body",
				"Prev content",
				"Next content");
			$this->view->homePage($output);
		} else {
			header('HTTP/1.1 404 Not Found');
			// Need custom 404 page
			echo '404 NOT FOUND';
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