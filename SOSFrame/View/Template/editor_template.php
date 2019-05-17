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
				<li style="padding: 0;">
					<form method="POST">
						<input type="submit" value="Sign out">
						<input type="hidden" name="action" value="signout">
					</form>
				</li>	
				<li style=""><button onclick="editor.newContent()">New</button></li>
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
			<hr>	
		</div>					
		<!-- End Left Column -->

		<!-- Right Column -->
		<div class="">

			<form method="POST" onsubmit="javascript:editor.formPost()">
				<label for="title">Title: </label>
				<input type="text" name="title" id="title" class="inline-input">
				<br>
				
				<label for="content">Content: </label>
				<textarea rows="20" style="" id="content" name="content"></textarea>
				<hr>
				<label for="description">Description: </label>
				<input type="text" id="description" class="inline-input" name="description">

				<label for="topiclist">Topic: </label>
				<input list="topics" id="topiclist" name="topic" class="inline-input">
				<datalist id="topics" name="topics">
  					<!-- Need to make a list of topics -->
  					<option value="Internet Explorer">
  					<option value="Firefox">
  					<option value="Chrome">
  					<option value="Opera">
  					<option value="Safari">
				</datalist>

				<input type="button" value="Parent" onclick="editor.setParent()">
				
				<ul class="navlist" style="border: 1px solid blue">
					<li>
						<select name="status">
							<option>Draft</option>
							<option>Publish</option>
						</select>
					</li>
					<li><input type="submit" value="Update"></li>
				</ul>
				<input type="hidden" name="action" value="newpost">
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
function Editor() {

}

Editor.prototype.formPost = function()  {
	alert("FORM SUBMIT");
}

Editor.prototype.draftListChange = function () {
	alert("DRAFT LIST CHANGE");
}

Editor.prototype.signOut = function() {
	alert("SIGN OUT");
}

Editor.prototype.newContent = function() {
	alert("NEW");
}


Editor.prototype.setParent = function() {
	// Need to make an AJAX call to get the list
	// of articles from the server then call
	// the code below in a callback

	var back = document.getElementById("overlay");
	var front = document.getElementById("parent-pop-over");
	back.style.display = "block";
	front.style.display = "block";
}

Editor.prototype.cancelParentPopOver = function() {
	document.getElementById("parent-pop-over").style.display = "none";
	document.getElementById("overlay").style.display = "none";
	document.getElementById("article-list").value="";
}

Editor.prototype.okParentPopOver = function() {
	document.getElementById("parent-pop-over").style.display = "none";
	document.getElementById("overlay").style.display = "none";
	alert(document.getElementById("article-list").value);
}

var editor = new Editor();

</script>

<!- POP OVER -->
<div id="overlay">
	<div id="overlaytop">
    	<div id="parent-pop-over" class="overlaycontent" style="display: none;">
        	<fieldset>
				<legend>Article Parent</legend>
				<select size="5" style="width: 100%;" id="article-list">
					<option>Option1</option>
					<option>Option2</option>
					<option>Option3</option>
					<option>Option4</option>
					<option>Option5</option>
					<option>Option6</option>
					<option>Option7</option>
					<option>Option8</option>
					<option>Option9</option>
					<option>Option10</option>
					<option>Option11</option>
					<option>Option12</option>
					<option>Option13</option>
					<option>Option14</option>
				</select>
			</fieldset>
			<button onclick="editor.cancelParentPopOver()">Cancel</button>
			<button onclick="editor.okParentPopOver()">Ok</button>
		</div>
	</div>
</div>
 
</body>
</html>
EOT;
?>