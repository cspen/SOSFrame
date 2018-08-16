<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/SOSArticleOutput.php');

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
		$topicsMenu = $this->createTopicsMenu($output->topicsMenu());
		
		// Needed to use instanceof operator
		$obj = new SOSArticleOutput();
		if($output instanceof $obj) {
			$author = $output->author();
			$publishDate = $output->publishDate();
			$next = $output->contentNext();
			$prev = $output->contentPrev();
		}
		require_once($template);
		echo $html;
		exit;
	}
	
	private function createTopicsMenu($menuItems) {
		$list = "";
		foreach($menuItems as $item) {
			$list .= '<p><a href="/Ozone/SOSFrame/Public/'.$item.'/">'.$item.'</a></p>';
		}
		return $list;
	}
}