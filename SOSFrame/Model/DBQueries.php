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
	
	const TOPIC_QUERY = 'SELECT article_path FROM article WHERE 
			article_path LIKE CONCAT(:path, "%")';
	
	const HOME_QUERY = 'SELECT * FROM article ORDER BY article_publish_date
			DESC LIMIT 10';
	
	const LOGIN_QUERY = 'SELECT user_password FROM user WHERE 
			user_first_name=:fname AND user_last_name=:lname';
	
	const TOPIC_MENU_QUERY =
			'SELECT DISTINCT SUBSTRING_INDEX(article_path, "/", 1) AS
			topic FROM article';
}

?>