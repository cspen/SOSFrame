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
	
	// Called during program execution
	public function process_request() {
		$path = str_replace(Settings::APP_URL, "", $_SERVER['REQUEST_URI']);
		$tail = substr($_SERVER['REQUEST_URI'], -1);
						
		// Set the view
		if(empty($path)) {
			$this->view->setTemplate(SOSView::HOME);
			$this->model->update_state($path, null);
		} else if($tail === "/") {
			if($_SERVER['REQUEST_METHOD'] === 'PUT') {
				$this->view->headerOnly('405 Method Not Allowed');
			}
			$this->view->setTemplate(SOSView::TOPIC);
			$this->model->update_state($path, SOSModel::TOPIC);
		} else { 
			if(strcmp($path, Settings::ADMIN_LOGIN_PAGE) == 0) {
				$this->token();
				$this->model->login($_SESSION['token']);
				$this->view->setTemplate(SOSView::ADMIN_LOGIN);
			} else if(strcmp($path, Settings::SYS_OPS) == 0) {
				$this->system_operation($tail);
				exit;
			} else {
				$this->view->setTemplate(SOSView::ARTICLE);
				$this->model->update_state($path, SOSModel::ARTICLE);
			}
		}
	}
	
	/**
	 * Validate the login form credentials
	 * and the form token.
	 */
	public function login() {
		session_start(); 
		if(isset($_POST['name']) && isset($_POST['pword'])
				&& $_POST['token']) {
			if($this->verify_token()) { 
				if($this->model->validate_login()) {
					$this->view->setTemplate(SOSView::EDITOR);
				} else {
					$this->token();
					$this->model->login($_SESSION['token']);
					$this->view->setTemplate(SOSView::ADMIN_LOGIN);
				}
				return;
			} else {
				echo 'BAD TOKEN';
			}
		}
		exit;
	}
	
	public function signout() {
		session_start();
		session_destroy();
		$home_url = 'http://'.$_SERVER['HTTP_HOST'].Settings::APP_URL;
		echo $home_url;
		header('Location: '.$home_url);
		exit;
	}
	
	public function newpost() {
		$postList = array("title", "content", "description", "topic", "status");
		if($this->checkPostValues($postList)) {
			// need to pass to the model
			// to cache the data in the db
			$this->model->savePost();
		} else {
			// Return error header
			$this->view->headerOnly("HTTP/1.1 400 Bad Request");
		}
	}
	
	/**
	 * Application operations accessed via
	 * administration backend.
	 */
	private function system_operation() {
		if($_SERVER['REQUEST_METHOD'] === "POST") {
			if($this->allset()) {
				$this->model->savePost();
			} else {
				$this->view->headerOnly('HTTP/1.1 400 Bad Request');
			}
		} else if($_SERVER['REQUEST_METHOD'] === "DELETE") {
			if(substr($_SERVER['REQUEST_URI'], -1) === "/") {
				if(!$this->model->delete_topic())
					$this->view->headerOnly('HTTP/1.1 504 Internal Server Error');
			} else {
				if(!$this->model->delete_article())
					$this->view->headerOnly('HTTP/1.1 504 Internal Server Error');
			}
			$this->view->headerOnly('HTTP/1.1 200 Ok');
		} else if($_SERVER['REQUEST_METHOD'] === "PUT") {
			// Put will only work for articles, not topics.
			if(isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
				$this->view->headerOnly('HTTP/1.1 412 Precondition Failed');
			}
 			
			$putVar = json_decode(file_get_contents("php://input"), true);
			if(isset($putVar)) {
				if($this->checkPutValues($putVar)) {
					// Need to update the database
					// then return the appropriate header
				} else {
					// Need to complete this header
					$this->view->headerOnly("HTTP/1.1 ");
				}					
			} else {
				// Return error header
			}
		} else {
			// Unsupported operation
		}
	}
	 
	/**
	 * Set session token for form validation
	 * to prevent CSFR attack.
	 */
	private function token() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if (empty($_SESSION['token'])) { 
			$_SESSION['token'] = bin2hex(random_bytes(32));
		}
	}	
	
	/**
	 * Prevent CSRF attack by verifying the token
	 * sent with the form. The token is created
	 * when the form is created and the token value
	 * is stored in the session variable.
	 */ 
	private function verify_token() {
		if (!empty($_POST['token']) && !empty($_SESSION['token'])) {
			if (hash_equals($_SESSION['token'], $_POST['token'])) {
				return true;
			}
		}
		return false;
	}
	
	private function checkPostValues($values) {
		foreach($values as $v) {
			if(empty($_POST[$v])) {				
				return false;
			}
		}
	}
	
	private function checkPutValues($values) {
		if(isset($values['title'], $values['content'], $values['description'],
				$values['topics'], $values['status'], $values['parent'])) {
			return true;
		}
		return false;
	}
	
	// Determine if correct post variables
	// are set for creating a new article
	// returns true if all values set
	// and with parameters. Returns false
	// otherwise
	private function allset() {
		if(isset($_POST['title'], $_POST['content'], $_POST['description'],
				$_POST['topics'], $_POST['status'], $_POST['parent'])) {
			return true;
		}
		return false;
	}	
	
	private $model;
	private $view;
}
?>