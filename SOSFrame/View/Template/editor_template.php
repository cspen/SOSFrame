<?php
$html = <<< EOT
<!DOCTYPE html>
<html>
<title>Editor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/template.css">
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

<p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Topics</b></p>
<p><a href="javascript:void(0)">Health &amp; Fitness</a></p>
<p><a href="javascript:void(0)">Photography</a></p>
<p><a href="javascript:void(0)">Illustrator</a></p>
<p><a href="javascript:void(0)">Media</a></p>
<br>
</div>
</div><br>

<!-- End Left Column -->
</div>

<!-- Right Column -->
<div class="w3-twothird">

<div class="w3-container w3-card w3-white w3-margin-bottom">
<h2 class="w3-text-grey w3-padding-16">Title</h2>
<div class="w3-container">

<label for="title">Title: <input type="text" name="title" id="title"></label>
<br>
<label for="body">Content:
<textarea rows="20"></textarea></label>
<hr>
<label for="description">Description: <input type="text" id="description"></label>

<input list="browsers" name="browser">
<datalist id="browsers">
  <!-- Need to make a list of topics -->
  <option value="Internet Explorer">
  <option value="Firefox">
  <option value="Chrome">
  <option value="Opera">
  <option value="Safari">
</datalist>

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