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
		
		if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-za-z0-9-]+)\/([A-za-z0-9-]+)$/', $requestURI)) {
			// Article page
			$title = end($params);
			$topic = prev($params);
			$output = $this->getArticle($title, $topic);
			$this->view->articlePage($output);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-Za-z0-9-]+)\/$/', $requestURI)) {
			// Topic page	
			end($params);
			$topic = prev($params);
			
			if($topic == 'secret') { 
				if(isset($_POST['name']) && isset($_POST['pword'])) {
					// Need to get hash from database
					$query = "SELECT password FROM user WHERE name=:name";
					$stmt = $this->dbconn->prepare($query);
					$stmt->bindParam(":name", $_POST['name']);
					if($stmt->execute()) {
						$results = $stmt->fetch(); 
						$hash = $results['password'];
						if(password_verify($_POST['pword'], $hash)) {
							echo 'LOGIN SUCCEEDED';
						} else {
							echo 'LOGIN FAILED';
						}
					} else {
						header('HTTP/1.1 504 Internal Server Error');
						exit;
					}
					
					
					exit;
				} else {
					// Send login page
					$output = $this->getLogin();
				}
			} else {			
				$output = $this->getTopic($topic);
			}
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
		return new SOSArticleOutput(
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
				$this->getMenu());
	}
	
	private function getHome() {
		return new SOSOutput(
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
	 * CODE BELOW FOR BACKEND ADMINISTRATION.
	 */
	private function getLogin() {
		$loginForm = '<form action="/Ozone/SOSFrame/Public/secret/" method="post"><table>';
		$loginForm .= '<tr><td>';
		$loginForm .= '<label for="name">Name: <label></td><td><input type="text" name="name" id="name"></td>';
		$loginForm .= '<tr><td>';
		$loginForm .= '<label for="pword">Password: </label></td><td><input type="password" name="pword" id="pword"></td>';
		$loginForm .= '</tr><tr><td></td><td><input type="submit" value="Login"></td>';
		$loginForm .= '</tr></table></form>';
		
		return new SOSOutput(
				"Secret",
				"Admin login page",
				"Login",
				$loginForm,
				$this->getMenu());
	}
	
}