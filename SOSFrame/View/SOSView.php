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
	public function homePage($output) {		
		$pageTitle = $output->pageTitle();
		$description = $output->description();
		$contentTitle = $output->contentTitle();		
		$contentBody = $output->contentBody();
		require_once('Template/home_template.php');
		echo $html;
	}
	
	public function topicPage($output) {
		require_once('Template/topic_template.php');
		echo $html;
	}
	
	public function articlePage($output) {
		require_once('Template/article_template.php');
		echo $html;
	}
}