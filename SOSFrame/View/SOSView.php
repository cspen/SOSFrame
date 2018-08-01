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
		$this->showPage($output, 'Template/home_template.php');
	}
	
	public function topicPage($output) {
		$this->showPage($output, 'Template/topic_template.php');
	}
	
	public function articlePage($output) {
		$this->showPage($output, 'Template/article_template.php');
	}
	
	private function showPage($output, $template) {
		$pageTitle = $output->pageTitle();
		$description = $output->description();
		$contentTitle = $output->contentTitle();
		$contentBody = $output->contentBody();
		$topicsMenu = $output->topicsMenu();
		require_once($template);
		echo $html;
	}
}