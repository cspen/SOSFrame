<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/SOSArticleOutput.php');
require_once('../SOSFrame/Classes/Interfaces/Settings.php');

class SOSView implements Settings {
	
	public function __construct($model) {
		$this->model = $model;
		$this->template = $this::HOME; // Default
	}
	
	/**
	 * Set the template for this view
	 * 
	 * @param Template $template
	 */ 
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	/**
	 * Send only a header to the client,
	 * no content body
	 * 	 
	 * @param String $hdr the header to send
	 */
	public function headerOnly($hdr) {
		header($hdr);
		exit;
	}
	
	public function showPage() {
		$output = $this->model->output();
		 
		if($this->model->error()) {
			// Set header
			header("HTTP/1.1 504 Internal Server Error");
			
			// Show error page
			$this->template = $this::TOPIC;
			$pageTitle = "504 Internal Server Error";
			$description = "Internal Server Error";
			$contentTitle = "504 Internal Server Error";
			$contentBody = "Oops! Something went wrong.";
			$sideMenuTitle = "SIDE MENU TITLE";
			$sideMenu = null;
			
		} else if(!empty($output)) {
			$pageTitle = $output->pageTitle();
			$description = $output->description();
			$contentTitle = $output->contentTitle();
			$contentBody = $output->contentBody();
			
			if(is_array($contentBody)) {
				$a = array();
				$b = array();
				foreach($contentBody as $c) {
					$url = "";
					$u = str_replace(Settings::APP_URL, "", $_SERVER['REQUEST_URI']);
					$d = str_replace($u, "", $c);
					if($contentTitle != Settings::HOME_PAGE_TITLE) {					
						if(substr_count($c, "/") > 1) {  // Link to "Directory"
							if(substr_count($d, "/") > 0)
								$url = $c = substr($d, 0, strpos($d, "/")+1);
							else
								$url = $c = $d;
						} else {	// Link to "File"							
							$pos = strpos($c, "/");
							$c = substr($c, $pos+1);
							$url = Settings::APP_URL.$contentTitle.str_replace(" ", "-", $c);
						}
					} else {
						$url = Settings::APP_URL.str_replace(" ", "-", $c);						
					}
				
					if(strpos($c, "/"))
						$b[] = '<a href="'.$url.'">'.$c.'</a><br>';
					else
						$a[] = '<a href="'.$url.'">'.$c.'</a><br>';
				}
				$contentBody = "";
				$a = array_unique($a);	// Remove duplicates
				$b = array_unique($b);
				foreach($a as $c)
					$contentBody .= $c;
				foreach($b as $c)
					$contentBody .= $c;
				
				// Site navigation
				$contentTitle = rtrim($contentTitle, "/");
				$contentTitle = $this->linkify($contentTitle);
			}	
			$sideMenuTitle = $output->sideMenuTitle();
			$sideMenu = $this->createSideMenu($output->sideMenu());
			$u = str_replace(Settings::APP_URL, "", $_SERVER['REQUEST_URI']);
			$pos = strrpos($u, "/");
			$u = substr($u, 0, $pos);		
			
			$navLink = $this->linkify($u);
			
			if($output instanceof SOSArticleOutput) {
				$author = $output->author();
				$publishDate = $output->publishDate();
				$next = $output->contentNext();
				$prev = $output->contentPrev();
			}			
		} else {
			if($_SERVER['REQUEST_METHOD'] === "DELETE" ||
					$_SERVER['REQUEST_METHOD'] === "PUT") {
				header('HTTP/1.1 204 No Content');
				exit;
			} else {			
				// Set header
				header('HTTP/1.1 404 Not Found');
			
				// Set error page
				$this->template = $this::TOPIC;
				$pageTitle = "404 Not Found";
				$description = "The page could not be found on this system";
				$contentTitle = "404 Not Found";
				$contentBody = "The page could not be found on this system";
				$sideMenuTitle = "SIDE MENU TITLE";
				$sideMenu = null;
			}
		}
		require_once($this->template);
		$this->setHeaders($html);
		
		if($_SERVER['REQUEST_METHOD'] == "GET") {
			echo $html;
		} 
	}
	
	private function createSideMenu($menuItems) {
		$list = "";
		foreach($menuItems as $item) {
			$list .= '<p><a href="'.Settings::APP_URL.$item.'/">'.$item.'</a></p>';
		}
		return $list;
	}
	
	private function linkify($str) {
		$parts = explode("/", $str);
		$links = "";
		$t = "";
		foreach($parts as $p) {
			$t .= $p.'/';
			$links .= '<a href="'.Settings::APP_URL.$t.'">'.$p.'</a> / ';
		}
		return $links;
	}
	
	private function setHeaders($output) {
		header('HTTP/1.1 200 OK');
		header('Content-Length: '.strlen($output));
		
		// TO-DO: Add headers for etag and last modified
		// header('');
		// header('');
		
	}
	
	private $model;
	private $template;
	
	const HOME = "Template/home_template.php";
	const ARTICLE = "Template/article_template.php";
	const TOPIC = "Template/topic_template.php";
	const EDITOR = "Template/editor_template.php";
	const ADMIN_LOGIN = "Template/admin_login_template.php";
}