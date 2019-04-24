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
			$this->view->setTemplate(SOSView::TOPIC);
			$this->model->update_state($path, SOSModel::TOPIC);
		} else { 
			if(strcmp($path, Settings::ADMIN_LOGIN_PAGE) == 0) {
				$this->token();
				$this->model->login($_SESSION['token']);
				$this->view->setTemplate(SOSView::ADMIN_LOGIN);
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
	
	private $model;
	private $view;
}
?>