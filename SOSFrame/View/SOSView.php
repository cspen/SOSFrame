<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/SOSArticleOutput.php');
require_once('../SOSFrame/Classes/Interfaces/Settings.php');

class SOSView implements Settings {
	
	public function __construct($model) {
		$this->model = $model;
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	public function showPage() {
		$output = $this->model->output();
		$siteURL = Settings::APP_URL;
		$siteTitle = Settings::SITE_TITLE;
		
		if(!empty($output)) {
			$pageTitle = $output->pageTitle();
			$description = $output->description();
			$contentTitle = $output->contentTitle();
			$contentBody = $output->contentBody();
			if(is_array($contentBody)) {
				$a = "";
				foreach($contentBody as $c) {
					$url = "";
					if($contentTitle != Settings::HOME_PAGE_TITLE) {
						$url = Settings::APP_URL.$contentTitle.str_replace(" ", "-", $c);
					} else {
						$url = Settings::APP_URL.str_replace(" ", "-", $c);						
					}
					$a .= '<a href="'.$url.'">'.$c.'</a><br>';
				}
				$contentBody = $a;
			} 			
			$topicsMenu = $this->createTopicsMenu($output->topicsMenu());
		
			if($output instanceof SOSArticleOutput) {
				$author = $output->author();
				$publishDate = $output->publishDate();
				$next = $output->contentNext();
				$prev = $output->contentPrev();
			}
		} else {
			$this->template = $this::TOPIC;
			$pageTitle = "404 Not Found";
			$description = "The page could not be found on this system";
			$contentTitle = "404 Not Found";
			$contentBody = "The page could not be found on this system";
			$topicsMenu = null;
		}
		require_once($this->template); 
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
	
	private $model;
	private $template;
	
	const HOME = "Template/home_template.php";
	const ARTICLE = "Template/article_template.php";
	const TOPIC = "Template/topic_template.php";
	const EDITOR = "Template/editor_template.php";
}