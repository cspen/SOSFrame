<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');
require_once('../SOSFrame/Classes/Interfaces/Constants.php');
require_once('DBQueries.php');

class SOSModel implements DBQueries, Constants {
		
	public function __construct() {
		$db = new DBConnection();
		$this->dbconn = $db->getConnection();
	}
	
	// Called by the controller object
	public function update_state($path, $type) {
		// Need to gather the data
		if(empty($path)) {
			// Get home page data
			$this->home();
		} else {
			// Get data for path
			$this->page_data($path);
		}		
	}
		
	// Called by the view object
	public function output() {
		return $this->output;
	}	
	
	public function article($title, $topic) {
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
	
	public function topic($topic) { 
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
	
	private function home() {
		$this->output =  new SOSOutput(
				"Science of Stupidity",
				"This is the description",
				"Home Page Content Title",
				"Home Page Content Body",
				$this->getMenu());
	}
	
	private function page_data($path) {
		// Need to determine if this is article
		// or topic page
		$stmt = $this->dbconn->prepare(DBQueries::PATH_QUERY);
		$stmt->bindParam(':path', $path); 
		
		if($stmt->execute()) {
			$results = $stmt->fetch();
			
			if(!empty($results)) {
			$this->output = new SOSArticleOutput(
					$path,
					$results['article_description'],
					$results['article_title'],
					$results['article_body'],
					$this->getMenu(),
					"Content Prev",
					"Content Next",
					"Author Name",
					$results['article_publish_date']);
			} 			
		} else {
			header("HTTP/1.1 504 Internal Server Error");
			exit;
		}
	}
	
	public function editor() {
		$stmt = $this->dbconn->prepare(DBQueries::LOGIN_QUERY);
		$stmt->bindParam(":name", $_POST['name']);
		if($stmt->execute()) {
			$results = $stmt->fetch();
			$hash = $results['password'];
			if(password_verify($_POST['pword'], $hash)) {
				// $this->view->adminPage();
				$this->output = new SOSOutput(
						"Editor",
						"No description",
						"Admin Page",
						"Admin Page",
						$this->getMenu());
			} else {
				echo 'LOGIN FAILED';
				exit;
			}
		} else {
			header('HTTP/1.1 504 Internal Server Error');
			echo 'LOGIN MESSED UP';
		}
	}
	
	
	
	/********************************************************
	 * CODE BELOW FOR BACKEND ADMINISTRATION ACCESS.
	 */
	public function login($token) {
		$loginForm = '<form action="/Ozone/SOSFrame/Public/secret/" method="post"><table>';
		$loginForm .= '<tr><td>';
		$loginForm .= '<label for="name">Name: <label></td><td><input type="text" name="name" id="name"></td>';
		$loginForm .= '<tr><td>';
		$loginForm .= '<label for="pword">Password: </label></td><td><input type="password" name="pword" id="pword"></td>';
		$loginForm .= '</tr><tr><td></td><td><input type="submit" value="Login"></td>';
		$loginForm .= '</tr></table>';
		$loginForm .= '<input type="hidden" name="token" value="'.$token.'">';
		$loginForm .= '<input type="hidden" name="action" value="login"></form>';
		
		$this->output = new SOSOutput(
				"Secret",
				"Admin login page",
				"Login",
				$loginForm,
				$this->getMenu());
	}
	
	private function getMenu() {
		// TO-DO: Make db query for topics and pass
		// to view. (View should create html list)
		$stmt = $this->dbconn->prepare(DBQueries::TOPIC_MENU_QUERY);
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
	
	private $dbconn;
	private $output;
	
	const TOPIC	= 0;
	const ARTICLE = 1;
}