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
			$this->view->setTemplate(SOSView::ARTICLE);
			$this->model->article($title, $topic);
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/([A-Za-z0-9-]+)\/$/', $requestURI)) {
			// Topic page
			end($params);
			$topic = prev($params);
			
			if($topic == 'secret') {
				session_start();
				if (empty($_SESSION['token'])) {
					// To prevent CSFR attack
					$_SESSION['token'] = bin2hex(random_bytes(32));
					echo 'TOKEN: '.$_SESSION['token'];
					$this->view->setTemplate(SOSView::TOPIC);
					$this->model->login($_SESSION['token']);
				} else {
					echo 'REDIRECT TO EDITOR PAGE';
				}
			} else {
				$this->view->setTemplate(SOSView::TOPIC);
				$this->model->topic($topic);
			}
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
							
						}
			} else {
				$output = $this->getTopic($topic);
			}
			*/
			
		} else if(preg_match('/^\/Ozone\/SOSFrame\/Public\/$/', $requestURI)) {
			$this->view->setTemplate(SOSView::HOME);
			$this->model->home();
		} else {
			// NOTE: Need to have a central header setting
			// location in the code -
			header('HTTP/1.1 404 Not Found');
			// SOSView will display custom page
		}		
	}
	
	public function login() {
		session_start(); 
		if(isset($_POST['name']) && isset($_POST['pword'])
				&& $_POST['token']) {
					echo ' TP: '.$_POST['token'].'<br>';
					echo ' TS: '.$_SESSION['token'].'<br>';
			if($this->verifyToken()) { 
				$this->view->setTemplate(SOSView::TOPIC);
				$this->model->login($_POST['token']);
			} else {
				echo 'BAD TOKEN';
			}
			exit;
		} else {
			exit;
		}
	}
	
	public function topic() {
		
	}
	
	public function article() {
		
	}
	
	public function clicked() {
		
	}
	
	// Prevent CSRF attack
	private function verifyToken() { echo ' TOKEN TIME ';
		if (!empty($_POST['token']) && !empty($_SESSION['token'])) {
			echo ' TWO TOKENS ';
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