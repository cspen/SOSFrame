<?php

interface Output {
	public function pageTitle();		// Title of web page
	public function description();		// Meta tag description for SEO
	public function contentTitle();		// Title of page content
	public function contentBody();		// Page content
	public function contentPrev();		// Link to previous related content
	public function contentNext();		// Link to next related content
}
?>