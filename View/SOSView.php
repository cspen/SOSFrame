<?php

require_once('../SOSFrame/Classes/SOSOutput.php');

class SOSView {
	
	public function __construct() {
		// Initialize this view
	}
	
	/**
	 * 
	 * @param Output $output
	 */
	public function respond($output) {
		$pageTitle = $output->pageTitle();
		$description = $output->description();
		$contentTitle = $output->contentTitle();
		$contentBody = $output->contentBody();
		$contentPrev = $output->contentPrev();
		$contentNext = $output->contentNext();
		
		require_once('Template/Article.php');
		echo $html;
	}
}