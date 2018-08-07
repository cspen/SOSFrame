<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');

class SOSModel {
	private $view;
	private $dbconn;
	
	public function __construct($view) {
		$this->view = $view;
		$db = new DBConnection();
		$this->dbconn = $db->getConnection();
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
			$title = end($params);
			echo 'TITLE : '.$title;
			$output = $this->getArticle($title, $topic);
			$this->view->articlePage($output);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-Za-z0-9-]+)\/$/', $requestURI)) {
			// Topic page	
			end($params);
			$topic = prev($params);
						
			$output = $this->getTopic($topic);
			$this->view->topicPage($output);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/$/', $requestURI)) {
			$output = $this->getHome();
			$this->view->homePage($output);
		} else {
			header('HTTP/1.1 404 Not Found');
			// Need custom 404 page
			echo '404 NOT FOUND';
		}		
	}
	
	private function getArticle($title, $topic) {
		return new SOSOutput(
				$title,
				"This is the description",
				"This is the Content Title",
				"This is the Content Body",
				$this->getMenu(),
				"Prev content",
				"Next content");
	}
	
	private function getTopic($topic) { 
		$query = "SELECT * FROM article WHERE topic=:topic";
		$stmt = $this->dbconn->prepare($query);
		$stmt->bindParam(':topic', $topic);
		if($stmt->execute()) {
			
		} else {
			header('HTTP/1.1 504 Internal Server Error');
			exit;
		}
		
		return new SOSOutput(
				$topic,
				"This is the description",
				"Topic Content Title",
				"Topic Content Body",
				$this->getMenu(),
				"Prev content",
				"Next content");
	}
	
	private function getHome() {
		return new SOSOutput(
				"Science of Stupidity",
				"This is the description",
				"Home Page Content Title",
				"Home Page Content Body",
				$this->getMenu(),
				"Prev content",
				"Next content");
	}
	
	private function getMenu() {
		// TO-DO: Make db query for topics and pass
		// to view. (View should create html list)
		$query = "SELECT distinct topic FROM article";
		$stmt = $this->dbconn->prepare($query);
		$results = array();
		if($stmt->execute()) {
			$count = $stmt->rowCount();
			$i = 0;
			while($i < $count) {
				$r = $stmt->fetch(PDO::FETCH_ASSOC);
				$results[] = $r['topic'];
				$i++;
			}
		} else {
			// Handle the error
			$results = array("Error");
		}		
		return $results;
	}
}