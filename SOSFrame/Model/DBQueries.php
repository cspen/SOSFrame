<?php
/**
 * 
 * @author Craig Spencer <craigspencer@modintro.com>
 *
 */

interface DBQueries {
	
	const PATH_QUERY = 'SELECT article_title, article_description,
			article_body, article_publish_date, article_parent, etag,
			article.last_modified, user_first_name, user_last_name
			FROM article, user, author
			WHERE author.articleID = article.articleID
			AND author.userID = user.userID
			AND article.article_path = :path';
	
	const TOPIC_QUERY = 'SELECT article_title FROM article WHERE 
			article_path LIKE CONCAT(:path, "%")';
	
	const HOME_QUERY = '';
	
	const LOGIN_QUERY = 'SELECT password FROM user WHERE name=:name';
	
	const TOPIC_MENU_QUERY =
			'SELECT DISTINCT SUBSTRING_INDEX(article_path, "/", 1) AS topic FROM article';
}

?>