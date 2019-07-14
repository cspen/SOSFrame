<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');
require_once('../SOSFrame/Classes/Interfaces/Settings.php');
require_once('DBQueries.php');

class SOSModel implements DBQueries, Settings {
		
	public function __construct() {
		$db = new DBConnection();
		$this->dbconn = $db->getConnection();
		$this->error = false;		
	}
	
	// Called by the controller object
	public function update_state($path, $type) {
		if(empty($path)) {
			// Get home page data
			$this->home();
		} else {
			// Perform the requested operation
			// on the specifed path
			if($type == $this::ARTICLE) {				
				if($_SERVER['REQUEST_METHOD'] === "GET" ||
						$_SERVER['REQUEST_METHOD'] === "HEAD") {
					$this->article_data($path);
				} else if($_SERVER['REQUEST_METHOD'] === "DELETE") {
					$this->delete_article($path);
				} else if($_SERVER['REQUEST_METHOD'] === "PUT") {
					$this->put_article($path);
				}
			} else if($type == $this::TOPIC) {				
				if($_SERVER['REQUEST_METHOD'] === "GET" ||
						$_SERVER['REQUEST_METHOD'] === "HEAD") {
					$this->topic_data($path);
				} else if($_SERVER['REQUEST_METHOD'] === "DELETE") {
					$this->delate_topic($path);
				} else if($_SERVER['REQUEST_METHOD'] === "PUT") {
					$this->put_topic($path);
				}
			}
		}		
	}
		
	// Called by the view object
	public function output() {
		return $this->output;
	}
	
	// Called by the view object
	public function error() {
		return $this->error;
	}
	
	// Delete the specified article
	private function delete_article($path) {
		$stmt = $this->dbconn->prepare(DBQueries::DELETE_ARTICLE_QUERY);
		$stmt->bindParam(':path', $path);
		
		if(!$stmt->execute())
			return false;
		
		return true;
	}
	
	// Delete all articles of the specified topic
	private function delate_topic($path) {
		$stmt = $this->dbconn->prepare(DBQueries::DELETE_TOPIC_QUERY);
		$stmt->bindParam(':path', $path);
		
		if($stmt->execute()) {
			// Set output
			// Need to return 200 Ok header
		} else {
			$this->error = true;
		}
	}
	
	// Update an existing article
	private function put_article($path) {		
		// This conditional should go in the
		// controller
		if(isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
			// This should go in the view
			header('HTTP/1.1 412 Precondition Failed');
			exit;
		}
		
		// Should do this in the controller
		$putVar = json_decode(file_get_contents("php://input"), true);
		if(isset($putVar)) {
			// Need to parse the JSON input,
			// validate the input, then persist
			// if valid
		} else {
			$this->error = true;
		}		
	}
	
	// Get home page content
	private function home() {
		$stmt = $this->dbconn->prepare(DBQueries::HOME_QUERY);
		if($stmt->execute()) {
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$articles = array();
			foreach($results as $r) {
				$articles[] = str_replace("-", " ", $r['article_path']);
			}
			
			$this->output =  new SOSOutput(
					Settings::SITE_TITLE,
					Settings::HOME_PAGE_DESCRIPTION,
					Settings::HOME_PAGE_TITLE,
					$articles,
					"Topics Menu",
					$this->getSideMenu());
		} else {
			$this->error = true;
		}
	}
	
	// Get article content
	private function article_data($path) {
		$stmt = $this->dbconn->prepare(DBQueries::PATH_QUERY);
		$stmt->bindParam(':path', $path); 
		
		if($stmt->execute()) {
			$results = $stmt->fetch();
			
			if(!empty($results)) { 
				$menu = $this->getSideMenu();
				$this->output = new SOSArticleOutput(
					$path,
					$results['article_description'],
					$results['article_title'],
					$results['article_body'],
					"Topics Menu",
					$menu,
					"Content Prev",
					"Content Next",
					$results['user_first_name']." ".$results['user_last_name'],
					$results['article_publish_date']);
			}
		} else {
			$this->error = true;
		}
	}
	
	// Get topic page content
	private function topic_data($path) {
		$stmt = $this->dbconn->prepare(DBQueries::TOPIC_QUERY);
		$stmt->bindParam(':path', $path);
		if($stmt->execute()) {
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($results) > 0) {
				$a = array();
				foreach($results as $r)
					$a[] = $r['article_path'];
			
				$this->output = new SOSOutput(
						$path,
						"",
						$path,
						$a,
						"Topics",
						$this->getSideMenu());
			}
		} else {
			$this->error = true;
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
						"Shmeditor",
						"No description",
						"Admin Page",
						"Admin Page",
						"Edit Menu",
						$this->getEditorMenu());
				return true;
			} else {
				$this->output = new SOSOutput(
						"Admin login page",
						"Administration login page",
						"Admin Page",
						"Admin Page",
						"Edit Menu",
						$this->getEditorMenu());
				return false;
			}
		} else {
			$this->error = true;
			return false;
		}
	}
	
	private function getSideMenu() {
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
	
	private function getEditorMenu() {
		return array("Sign Out");
	}
	
	/********************************************************
	 * BACKEND ADMINISTRATION ACCESS.
	 */
	public function login() {
		$this->output = new SOSOutput(
				"Secret ? ",
				"Admin login page",
				"Login",
				"",
				"Menu Title",
				$this->getSideMenu());
	}
	
	public function savePost() {
		$title = $_POST["title"];
		$content = $_POST["content"];
		$desc = $_POST["description"];
		$topic = $_POST["topic"];
		$status = $_POST["status"];
		$parent = $_POST["parent"];
		
		$stmt = $this->dbconn->prepare(DBQueries::SAVE_POST_QUERY);
		$stmt->bindParam(':title', $title); 
		$stmt->bindParam(':description', $desc); 
		$stmt->bindParam(':body', $content); 
		$stmt->bindParam(':status', $status); 
		$stmt->bindParam(':path', $topic."/".$path); 
		$stmt->bindParam(':parent', $parent); 
		
		$results = array();
		if($stmt->execute()) {
			// According to the HTTP specification
			// should return a "201 Created" header
		} else {
			$this->error = true;
		}
	}
	
	private $dbconn;
	private $output;
	private $error;
	
	const TOPIC	= 0;
	const ARTICLE = 1;
}