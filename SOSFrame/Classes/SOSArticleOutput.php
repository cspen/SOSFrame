<?php
require_once('SOSOutput.php');
// require_once('SOSArticleOutput.php');

class SOSArticleOutput extends SOSOutput {
	
	private $author;
	private $publishDate;
	private $contentNext;
	private $contentPrev;
	
	function __construct() { 
		$args = func_get_args();
		$num = func_num_args();
		if (method_exists($this,$f='__construct'.$num)) {
			call_user_func_array(array($this,$f),$args);
		}
	}
	
	function __construct10($pageTitle, $description, $contentTitle,
			$contentBody, $sideMenuTitle, $sideMenu, $contentPrev, $contentNext,
			$author, $publishDate) {
			$this->author = $author;
			$this->publishDate = $publishDate;
			$this->contentPrev = $contentPrev;
			$this->contentNext = $contentNext;
			
			parent::__construct($pageTitle, $description, $contentTitle,
					$contentBody, $sideMenuTitle, $sideMenu);		
	}
	
	function __construct12($pageTitle, $description, $contentTitle,
			$contentBody, $sideMenuTitle, $sideMenu, $contentPrev,
			$contextNext, $author, $publishDate, $etag, $lastMod) {
			$this->etag = $etag;
			$this->lastMod = $lastMod;
			
			parent::__constuct10($pageTitle, $description, $contentTitle,
					$contentBody, $sideMenuTitle, $sideMenu, $contentPrev, $contentNext,
					$author, $publishDate);
	}
	
	public function author() {
		return $this->author;
	}
	
	public function publishDate() {
		return $this->publishDate;
	}
	
	public function contentPrev() {
		return $this->contentPrev;
	}
	
	public function contentNext() {
		return $this->contentNext;
	}
}

?>