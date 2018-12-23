<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/SOSArticleOutput.php');

class SOSView {
	
	public function __construct($model) {
		$this->model = $model;
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	public function adminPage() {
		require_once('Template/editor_template.php');
		echo $html;
		exit;
	}
	
	public function showPage() {
		$output = $this->model->output();
		
		if(!empty($output)) {
			$pageTitle = $output->pageTitle();
			$description = $output->description();
			$contentTitle = $output->contentTitle();
			$contentBody = $output->contentBody();
			$topicsMenu = $this->createTopicsMenu($output->topicsMenu());
		
			$obj = new SOSArticleOutput();
			if($output instanceof $obj) {
				$author = $output->author();
				$publishDate = $output->publishDate();
				$next = $output->contentNext();
				$prev = $output->contentPrev();
			}
		} else {
			$this->template = SOSView::TOPIC;
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