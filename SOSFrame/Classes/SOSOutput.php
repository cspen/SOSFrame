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
	private $sideMenu;			// Menu displayed on left side bar
	private $contentPrev;		// Link to previous related content
	private $contentNext;		// Link to next related content
	
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
		$this->pageTitle = $pageTitle;
		$this->description = $description;
		$this->contentTitle = $contentTitle;
		$this->contentBody = $contentBody;
	}
	
	function __construct5($pageTitle, $description, $contentTitle,
			$contentBody, $sideMenu) {
				$this->pageTitle = $pageTitle;
				$this->description = $description;
				$this->contentTitle = $contentTitle;
				$this->contentBody = $contentBody;
				$this->sideMenu = $sideMenu;
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
	
	public function sideMenu() {
		return $this->sideMenu;
	}	
}