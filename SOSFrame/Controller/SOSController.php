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
require_once('../SOSFrame/Classes/Interfaces/Settings.php');

class SOSController implements Settings {
	
	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}
	
	// New design
	public function process_request() {
		$path = str_replace(Settings::APP_URL, "", $_SERVER['REQUEST_URI']);
		$tail = substr($_SERVER['REQUEST_URI'], -1);
						
		// Set the view
		if(empty($path)) {
			$this->view->setTemplate(SOSView::HOME);
			$this->model->update_state($path, null);
		} else if($tail === "/") {
			$this->view->setTemplate(SOSView::TOPIC);
			$this->model->update_state($path, SOSModel::TOPIC);
		} else {
			if(strcmp($path, Settings::APP_URL.'/secret')) {
				echo 'ADMIN LOGIN ';exit;
			}
			$this->view->setTemplate(SOSView::ARTICLE);
			$this->model->update_state($path, SOSModel::ARTICLE);
		}
	}
	
	// Method to be removed - old design
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
			
			if($topic == 'secret') { // Admin login
				session_start();
				if (empty($_SESSION['token'])) {
					// To prevent CSFR attack
					$_SESSION['token'] = bin2hex(random_bytes(32));
					$this->view->setTemplate(SOSView::TOPIC);
					$this->model->login($_SESSION['token']);
				} else {
					// Check if logged in
					echo 'REDIRECT TO EDITOR PAGE';
				}
			} else {
				$this->view->setTemplate(SOSView::TOPIC);
				$this->model->topic($topic);
			}			
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
			if($this->verify_token()) { 
				$this->view->setTemplate(SOSView::EDITOR);
				$this->model->editor();
				return;
			} else {
				echo 'BAD TOKEN';
			}
		}
		exit;
	}
	
	// Prevent CSRF attack
	private function verify_token() {
		if (!empty($_POST['token']) && !empty($_SESSION['token'])) {
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