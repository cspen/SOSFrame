<?php
/**
 * 
 * @author Craig Spencer <craigspencer@modintro.com>
 *
 */

interface DBQueries {
	
	const ARTICLE_QUERY = " ";
	
	const TOPIC_QUERY = "SELECT * FROM article WHERE topic=:topic";
	
	const HOME_QUERY = " ";
	
	const LOGIN_QUERY = "SELECT password FROM user WHERE name=:name";
	
	const TOPIC_MENU_QUERY = "";
}

?>