<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');
require_once('../SOSFrame/Classes/Interfaces/Settings.php');
require_once('DBQueries.php');

class SOSModel implements DBQueries, Settings {
		
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
			if($type == $this::ARTICLE) {
				// Get data for path
				$this->article_data($path);
			} else if($type == $this::TOPIC) {
				$this->topic_data($path);
			}
		}		
	}
		
	// Called by the view object
	public function output() {
		return $this->output;
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
		$stmt = $this->dbconn->prepare(DBQueries::HOME_QUERY);
		if($stmt->execute()) {
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			// print_r($results);
			
			$articles = array();
			foreach($results as $r) {
				$articles[] = str_replace("-", " ", $r['article_path']);
				// $article[] = $r['article_path'];
				// $articles[] = $article;
			}
			
			$this->output =  new SOSOutput(
					Settings::SITE_TITLE,
					Settings::HOME_PAGE_DESCRIPTION,
					Settings::HOME_PAGE_TITLE,
					$articles,
					$this->getMenu());
		} else {
			echo 'OUT';
		}
	}
	
	private function article_data($path) {
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
					$results['user_first_name']." ".$results['user_last_name'],
					$results['article_publish_date']);
			} 			
		} else {
			header("HTTP/1.1 504 Internal Server Error");
			exit;
		}
	}
	
	private function topic_data($path) {
		$stmt = $this->dbconn->prepare(DBQueries::TOPIC_QUERY);
		$stmt->bindParam(':path', $path);
		if($stmt->execute()) {
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$a = array();
			foreach($results as $r)
				$a[] = $r['article_title'];
			
			$this->output = new SOSOutput(
					rtrim($path, "/"),
					"No description",
					$path,
					$a,
					$this->getMenu());
		} else {
			echo "504 Internal Server Error";
		}		
	}
	
	// Validate user login
	public function validate_login() {
		$name = explode(" ", $_POST['name']);
		$stmt = $this->dbconn->prepare(DBQueries::LOGIN_QUERY);
		$stmt->bindParam(":fname", $name[0]);
		$stmt->bindParam(":lname", $name[1]);
		if($stmt->execute()) {
			$results = $stmt->fetch();
			$hash = $results['user_password'];
			if(password_verify($_POST['pword'], $hash)) {
				// $this->view->adminPage();
				$this->output = new SOSOutput(
						"Editor",
						"No description",
						"Admin Page",
						"Admin Page",
						$this->getMenu());
				return true;
			} else {
				echo 'ICEBURGER';
				return false;
			}
		} else {
			header('HTTP/1.1 504 Internal Server Error');
			return false;
		}
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
	
	/********************************************************
	 * BACKEND ADMINISTRATION ACCESS.
	 */
	public function login() {
		$this->output = new SOSOutput(
				"Secret",
				"Admin login page",
				"Login",
				"",
				$this->getMenu());
	}
	
	private $dbconn;
	private $output;
	
	const TOPIC	= 0;
	const ARTICLE = 1;
}