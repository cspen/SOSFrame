<?php

require_once('../SOSFrame/Classes/SOSOutput.php');
require_once('../SOSFrame/Classes/DBConnection.php');

class SOSModel {
	private $view;
	
	public function __construct($view) {
		$this->view = $view;
	}
	
	public function updateState($value) {
		$path = str_ireplace("/Ozone/SOSFrame/Public/", "", $_SERVER['REQUEST_URI']);
		$request = explode("/", $path);
		
		
		echo $path.'<br>';
		print_r($request);
		echo '<br>';
		echo $_SERVER['REQUEST_URI'].' &+<br>';
		
		
		$db = new DBConnection();
		$dbconn = $db->getConnection();
		$query = "";
		if(is_array($request)) {			
			$c = count($request);
			if($c >= 2 && $request[1] != "") {
				// Article page
				echo '<br> Article page - '.$request[1];
				// $query = "SELECT * FROM article WHERE title=:title";
				// $stmt->bindParam(':title', $request[1]);
			} else if($c <= 2) {
				// Topic page
				echo '<br> Topic page - '.$request[0];
				// $query = "SELECT * FROM article WHERE topic=:topic";
				// $stmt->bindParam(':topic', $request[0]);
			}
		}
		
		/*
		$stmt = $dbconn->prepare($query);
		if($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			if($rowCount == 1) {
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		*/
		
		
		
		
		
		$output = new SOSOutput(
				$value,
				"This is the description",
				"This is the Content Title",
				"This is the Content Body",
				"Prev content",
				"Next content");
		$this->view->respond($output);	
		
	}
}