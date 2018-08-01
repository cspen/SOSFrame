<?php

$html = <<< EOT
<!DOCTYPE html>
<html>
<title>$pageTitle</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="$description">
<link rel="stylesheet" href="../styles/template.css">

<body class="w3-light-grey">

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

<!-- The Grid -->
<div class="w3-row-padding">

<!-- Left Column -->
<div  class="w3-center w3-container">
<p>Google Ad Goes Here</p>
</div>
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
<p>$contentBody</p>
<hr>
		
</div>
		
		
<!-- End Right Column -->
</div>
<p style="text-align:center">Goolge Ad Goes Here</p>
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

// echo $html;
?>
