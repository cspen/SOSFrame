<?php
// MVC structure
require_once('../SOSFrame/Model/SOSModel.php');
require_once('../SOSFrame/Controller/SOSController.php');
require_once('../SOSFrame/View/SOSView.php');

// Create MVC objects
$model = new SOSModel();
$view = new SOSView($model);
$controller = new SOSController($model, $view);

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$controller->{$_GET['action']}();
} else if (isset($_POST['action']) && !empty($_POST['action'])) {
	$controller->{$_POST['action']}();
} else {
	$controller->invoke();
}

$view->showPage();
?>