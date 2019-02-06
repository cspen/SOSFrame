<?php
/**
 * The SOSOutput class is used to pass data from 
 * the model to the view.
 * 
 * @author Craig Spencer <craigspencer@modintro.com>
 *
 */
require_once('Interfaces/Output.php');

class SOSOutput implements Output {
	
	private $pageTitle;			// Title of web page
	private $description;		// Meta tag description for SEO
	private $contentTitle;		// Title of page content
	private $contentBody;		// Page content
	private $sideMenuTitle;		// Title of side menu
	private $sideMenu;			// Menu displayed on side bar
	private $contentPrev;		// Link to previous related content
	private $contentNext;		// Link to next related content
	private $etag;				
	private $lastModified;		
	
	function __construct() {
		$args = func_get_args();
		$num = func_num_args();
		if (method_exists($this,$f='__construct'.$num)) {
			call_user_func_array(array($this,$f),$args);
		}
	}
	
	function __construct2($contentTitle, $contentBody) {
		$this->contentTitle = $contentTitle;
		$this->contentBody = $contentBody;
	}
	
	function __construct4($pageTitle, $description, $contentTitle,
			$contentBody) {
		$this::__construct2($contentTitle, $contentBody);
		$this->pageTitle = $pageTitle;
		$this->description = $description;
	}
	
	function __construct6($pageTitle, $description, $contentTitle,
			$contentBody, $sideMenuTitle, $sideMenu) {
				$this::__construct4($pageTitle, $description, $contentTitle,
						$contentBody);
				$this->sideMenuTitle = $sideMenuTitle;
				$this->sideMenu = $sideMenu;
	}
	
	function __construct8($pageTitle, $description, $contentTitle,
				$contentBody, $sideMenuTitle, $sideMenu, $etag,
				$lastModified) {
					$this::__construct6($pageTitle, $description,
							$contentTitle, $contentBody, $sideMenuTitle,
							$sideMenu);
					$this->etag = $etag;
					$this->lastModified = $lastModified;		
	}
	
	public function pageTitle() {
		return $this->pageTitle;
	}
	
	public function description() {
		return $this->description;
	}
	
	public function contentTitle() {
		return $this->contentTitle;
	}
	
	public function contentBody() {
		return $this->contentBody;
	}
	
	public function sideMenuTitle() {
		return $this->sideMenuTitle;
	}
	
	public function sideMenu() {
		return $this->sideMenu;
	}	
}