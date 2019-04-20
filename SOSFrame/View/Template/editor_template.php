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

<body>
<!-- Page Container -->
<div id="main-content">

	<!-- The Grid -->
	<div class="">

		<!-- Left Column -->
		<div class="">
			<a>Science of Stupidity</a>	
			<hr>
			<ul class="navlist">
				<li style="padding: 0;"><button onclick="signOut()">Sign out</button></li>	
				<li style=""><button onclick="fresh()">New</button></li>
				<li style="">
					<select id="draftList" onchange="draftListChange()">
						<!-- Populate list with drafts
							this list is not part of the form.
							Need to handle events separately. -->
						<option>Title of Draft 1</option>
						<option>Title of Draft 2</option>
					</select>
				</li>				
			</ul>				
		</div>					
		<!-- End Left Column -->

		<!-- Right Column -->
		<div class="">

			<form action="javascript:formPost();" style="border: ;">
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

	<footer class="">
		<p>Powered by <a href="" target="_blank">SOSFrame</a></p>
	</footer>

<script>
function formPost() {
		alert("FORM SUBMIT");
}

function draftListChange() {
	alert("DRAFT LIST CHANGE");
}

function signOut() {
	alert("SIGN OUT");
}

function fresh() {
	alert("NEW");
}

</script>

</body>
</html>
EOT;
?>