<?php
// MVC structure
require_once('../SOSFrame/Model/SOSModel.php');
require_once('../SOSFrame/Controller/SOSController.php');
require_once('../SOSFrame/View/SOSView.php');



// Create MVC objects
$view = new SOSView();
$model = new SOSModel($view);
$controller = new SOSController($model);
$controller->invoke();


?>