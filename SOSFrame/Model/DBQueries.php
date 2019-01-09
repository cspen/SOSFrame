<?php
/**
 * 
 * @author Craig Spencer <craigspencer@modintro.com>
 *
 */

interface DBQueries {
	
	const PATH_QUERY = 'SELECT * FROM article WHERE article_path=:path';
	
	const TOPIC_QUERY = 'SELECT * FROM article WHERE topic=:topic';
	
	const HOME_QUERY = '';
	
	const LOGIN_QUERY = 'SELECT password FROM user WHERE name=:name';
	
	const TOPIC_MENU_QUERY =
			'SELECT DISTINCT SUBSTRING_INDEX(article_path, "/", 1) AS topic FROM article';
}

?>