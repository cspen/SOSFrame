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
	private $contentPrev;		// Link to previous related content
	private $contentNext;		// Link to next related content
	
	public function __construct() {
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
	
	function __construct6($pageTitle, $description, $contentTitle,
			$contentBody, $contentPrev, $contentNext) {
		$this->pageTitle = $pageTitle;
		$this->description = $description;
		$this->contentTitle = $contentTitle;
		$this->contentBody = $contentBody;
		$this->contentPrev = $contentPrev;
		$this->contentNext = $contentNext;
	}
	
	function pageTitle() {
		return $this->pageTitle;
	}
	
	function description() {
		return $this->description;
	}
	
	function contentTitle() {
		return $this->contentTitle;
	}
	
	function contentBody() {
		return $this->contentBody;
	}
	
	function contentPrev() {
		return $this->contentPrev;
	}
	
	function contentNext() {
		return $this->contentNext;
	}	
}