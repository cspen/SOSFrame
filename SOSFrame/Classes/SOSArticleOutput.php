<?php
require_once('SOSOutput.php');
require_once('SOSArticleOutput.php');

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
	
	function __construct9($pageTitle, $description, $contentTitle,
			$contentBody, $topicsMenu, $contentPrev, $contentNext,
			$author, $publishDate) {
		
			$this->author = $author;
			$this->publishDate = $publishDate;
			$this->contentPrev = $contentPrev;
			$this->contentNext = $contentNext;
			
			parent::__construct($pageTitle, $description, $contentTitle,
					$contentBody, $topicsMenu);		
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