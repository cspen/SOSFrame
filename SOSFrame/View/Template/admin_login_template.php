<?php
require_once('../SOSFrame/Classes/Interfaces/Settings.php');
$token = $_SESSION['token'];

// echo getcwd();
$html = <<< EOT
<!DOCTYPE html>
<html>
<title>$pageTitle</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="$description">
<link rel="stylesheet"
 href="http://localhost/Ozone/SOSFrame/Public//styles/template.css">
 
<body class="w3-light-grey">

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

<!-- The Grid -->
<div class="w3-row-padding">

<!-- Left Column -->
<div class="w3-third">

<div class="w3-white w3-text-grey w3-card-4">
<div class="w3-display-container">
<div class="w3-container w3-text-black">
<h2 id="blogtitle"><a href="$siteURL">$siteTitle</a></h2>
<small id="tagline">Better living through trial and error</small><hr>
</div>
</div>
<div class="w3-container">
<p><a href="javascript:void(0)">Contact</a></p>
<p><a href="javascript:void(0)">About</a></p>
<hr>

<p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Topics</b></p>
$topicsMenu;
<br>
</div>
</div><br>

<!-- End Left Column -->
</div>

<!-- Right Column -->
<div class="w3-twothird">

<div class="w3-container w3-card w3-white w3-margin-bottom">
<h2 class="w3-text-grey w3-padding-16">$contentTitle</h2>
<div class="w3-container">
<h5 class="w3-opacity"></h5>

<form action="/Ozone/SOSFrame/Public/secret/" method="post">
<table>
<tr><td>
<label for="name">Name: <label></td><td><input type="text" name="name" id="name"></td>
		<tr><td>
		<label for="pword">Password: </label></td><td><input type="password" name="pword" id="pword"></td>
		</tr><tr><td></td><td><input type="submit" value="Login"></td>
		</tr></table>
		<input type="hidden" name="token" value="'.$token.'">
		<input type="hidden" name="action" value="login"></form>
		
<hr>

</div>

<!-- End Right Column -->
</div>


<!-- End Grid -->
</div>
		
<!-- End Page Container -->
</div>
		
<footer class="w3-container w3-teal w3-center w3-margin-top">
<p>Find me on social media.</p>
<i class="fa fa-facebook-official w3-hover-opacity"></i>
<i class="fa fa-instagram w3-hover-opacity"></i>
<i class="fa fa-snapchat w3-hover-opacity"></i>
<i class="fa fa-pinterest-p w3-hover-opacity"></i>
<i class="fa fa-twitter w3-hover-opacity"></i>
<i class="fa fa-linkedin w3-hover-opacity"></i>
<p>Powered by <a href="" target="_blank">SOSFrame</a></p>
</footer>
		
</body>
</html>
EOT;
?>