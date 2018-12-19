<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');
require_once('DBQueries.php');

class SOSModel implements DBQueries {
	private $view;
	private $dbconn;
	private $output;
	
	public function __construct($view) {
		$this->view = $view;
		$db = new DBConnection();
		$this->dbconn = $db->getConnection();
	}
		
	public function output() {
		return $this->output;
	}	
	
	private function getArticle($title, $topic) {
		$this->output = new SOSArticleOutput(
				$title,
				"This is the description",
				preg_replace("/-/", " ", $title),
				"This is the Content Body",
				$this->getMenu(),
				"Prev content",
				"Next content",
				"Bob Marley",
				"2019-20-20");
	}
	
	public function getTopic($topic) { 
		$stmt = $this->dbconn->prepare(DBQueries::TOPIC_QUERY);
		$stmt->bindParam(':topic', $topic);
		
		$body = "";
		if($stmt->execute()) {
			$body = "SUCCESS";
		} else {
			header('HTTP/1.1 504 Internal Server Error');
			exit;
		}
		
		$this->output = new SOSOutput(
				$topic,
				"This is the description",
				"Topic Content Title",
				$body,
				$this->getMenu());
	}
	
	public function getHome() {
		$this->output =  new SOSOutput(
				"Science of Stupidity",
				"This is the description",
				"Home Page Content Title",
				"Home Page Content Body",
				$this->getMenu());
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
	
	
	
	/********************************************************
	 * CODE BELOW FOR BACKEND ADMINISTRATION ACCESS.
	 */
	private function createLogin($token) {		
		$loginForm = '<form action="/Ozone/SOSFrame/Public/secret/" method="post"><table>';
		$loginForm .= '<tr><td>';
		$loginForm .= '<label for="name">Name: <label></td><td><input type="text" name="name" id="name"></td>';
		$loginForm .= '<tr><td>';
		$loginForm .= '<label for="pword">Password: </label></td><td><input type="password" name="pword" id="pword"></td>';
		$loginForm .= '</tr><tr><td></td><td><input type="submit" value="Login"></td>';
		$loginForm .= '</tr></table>';
		$loginForm .= '<input type="hidden" name="token" value="'.$token.'"></form>';
		
		return new SOSOutput(
				"Secret",
				"Admin login page",
				"Login",
				$loginForm,
				$this->getMenu());
	}
	
}