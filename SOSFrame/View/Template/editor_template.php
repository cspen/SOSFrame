<?php
require_once('../SOSFrame/Classes/Interfaces/Settings.php');

$styleSheet = Settings::APP_URL."styles/editor.css";
$siteTitle = Settings::SITE_TITLE;
$siteURL = Settings::APP_URL;

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
<div id="main-content">

	<!-- The Grid -->
	<div class="w3-row-padding">

		<!-- Left Column -->
		<div class="">
			<a>Science of Stupidity</a>	
			<hr>
			<ul class="navlist">
				<li style="padding: 0;"><button>Sign out</button></li>	
				<li style="float: left;"><button>New</button><li>
				<li style="float: left;">
					<select class="">
						<option style="font-style:italic;">Title of Draft 1</option>
						<option>Title of Draft 2</option>
					</select>
				</li>				
				
			</ul>				
		</div>
					
		<br>
		<!-- End Left Column -->

		<!-- Right Column -->
		<div class="w3-twothird">

			<form action="javascript:void(0);" method="POST" style="border: 1px solid red;">
				<label for="title">Title: </label>
				<input type="text" name="title" id="title" class="inline-input">
				<br>
				
				<label for="content">Content: </label>
				<textarea rows="20" style="" id="content"></textarea>
				<hr>
				<label for="description">Description: </label>
				<input type="text" id="description" class="inline-input">

				<label for="topiclist">Topic: </label>
				<input list="topics" id="topiclist" name="topiclist" class="inline-input">
				<datalist id="topics" name="topics">
  					<!-- Need to make a list of topics -->
  					<option value="Internet Explorer">
  					<option value="Firefox">
  					<option value="Chrome">
  					<option value="Opera">
  					<option value="Safari">
				</datalist>
				
				<ul class="navlist" style="border: 1px solid blue">
					<li>
						<select>
							<option>Draft</option>
							<option>Publish</option>
						</select>
					</li>
					<li><input type="submit" value="Update"></li>
				</ul>
			</form>
			
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