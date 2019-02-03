<?php
require_once('../SOSFrame/Classes/Interfaces/Settings.php');

$styleSheet = Settings::APP_URL."styles/template.css";

$html = <<< EOT
<!DOCTYPE html>
<html>
<title>Editor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="$styleSheet">
<style>
	input, textarea { width: 100% }
</style>

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
<h2 id="blogtitle">Science of Stupidity</h2>
<small id="tagline">Better living through trial and error</small><hr>
</div>
</div>
<div class="w3-container">
<p><a href="javascript:void(0)">Contact</a></p>
<p><a href="javascript:void(0)">About</a></p>
<hr>

<p class="w3-large">
	<b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>
	$sideMenuTitle</b>
</p>
$topicsMenu
<br>
</div>
</div><br>

<!-- End Left Column -->
</div>

<!-- Right Column -->
<div class="w3-twothird">

<div class="w3-container w3-card w3-white w3-margin-bottom">
<h2 class="w3-text-grey w3-padding-16">Editor</h2>
<select>
	<option>Title of Draft 1</option>
	<option>Title of Draft 2</option>
</select>
<div class="w3-container">
<label for="title">Title: <input type="text" name="title" id="title"></label>
<br>
<label for="body">Content:
<textarea rows="20" style="font-size: xx-large;"></textarea></label>
<hr>
<label for="description">Description: <input type="text" id="description"></label>

<label for="topiclist">Topic:
<input list="topics" id="topiclist" name="topiclist"></label>
<datalist id="topics" name="topics">
  <!-- Need to make a list of topics -->
  <option value="Internet Explorer">
  <option value="Firefox">
  <option value="Chrome">
  <option value="Opera">
  <option value="Safari">
</datalist>
<br><br>

<select>
	<option>Draft</option>
	<option>Publish</option>
</select>
<button type="button">Update</button>

</div>


<!-- End Right Column -->
</div>
<!-- End Grid -->
</div>

<!-- End Page Container -->
</div>

<footer class="w3-container w3-teal w3-center w3-margin-top">
<p>Powered by <a href="" target="_blank">SOSFrame</a></p>
</footer>

</body>
</html>
EOT;
?>