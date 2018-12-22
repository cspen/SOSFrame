<?php
/**
 * The purpose of the SOSController is to
 * ensure all necessary conditions are met
 * to continue processing the request.
 * 
 * 
 * 
 * @author Craig Spencer <craigspencer@modintro.com>
 *
 */

class SOSController {
	
	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}
	
	public function invoke() {
		$requestURI = explode("?", $_SERVER['REQUEST_URI']);
		$requestURI = $requestURI[0];
		$params = explode("/", $_SERVER['REQUEST_URI']);
		
		// Determine which page was requested
		if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-za-z0-9-]+)\/([A-za-z0-9-]+)$/', $requestURI)) {
			// Article page
			$title = end($params);
			$topic = prev($params);
			$this->view->setTemplate()
			$this->model->article($title, $topic);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-Za-z0-9-]+)\/$/', $requestURI)) {
			// Topic page
			end($params);
			$topic = prev($params);
			
			if($topic == 'secret') {}
				/*
				session_start();
				if(isset($_POST['name']) && isset($_POST['pword'])
						&& $this->verifyToken()) {
							
							// Need to get hash from database
							$stmt = $this->dbconn->prepare(DBQueries::LOGIN_QUERY);
							$stmt->bindParam(":name", $_POST['name']);
							if($stmt->execute()) {
								$results = $stmt->fetch();
								$hash = $results['password'];
								if(password_verify($_POST['pword'], $hash)) {
									$this->view->adminPage();
								} else {
									echo 'LOGIN FAILED';
									exit;
								}
							} else {
								header('HTTP/1.1 504 Internal Server Error');
							}
							exit;
						} else {
							// Send login page
							if (empty($_SESSION['token'])) {
								// To prevent CSFR attack
								$_SESSION['token'] = bin2hex(random_bytes(32));
							}
							$output = $this->createLogin($_SESSION['token']);
						}
			} else {
				$output = $this->getTopic($topic);
			}
			*/
			$this->view->setTemplate(SOSView::TOPIC);
			$this->model->topic($topic);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/$/', $requestURI)) {
			$this->view->setTemplate(SOSView::HOME);
			$this->model->home();
		} else {
			header('HTTP/1.1 404 Not Found');
			// Need custom 404 page
			echo '404 NOT FOUND';
		}		
	}
	
	public function login() {
		session_start();
		if(isset($_POST['name']) && isset($_POST['pword'])
				&& $this->verifyToken()) {
			$this->model->login();					
		} else {
			// Send login page
			if (empty($_SESSION['token'])) {
				// To prevent CSFR attack
				$_SESSION['token'] = bin2hex(random_bytes(32));
			}
			$output = $this->createLogin($_SESSION['token']);
		}
	}
	
	public function topic() {
		
	}
	
	public function article() {
		
	}
	
	public function clicked() {
		
	}
	
	// Prevent CSRF attack
	private function verifyToken() {
		if (!empty($_POST['token'])) {
			if (hash_equals($_SESSION['token'], $_POST['token'])) {
				return true;
			}
		}
		return false;
	}
	
	private $model;
	private $view;
}
?>