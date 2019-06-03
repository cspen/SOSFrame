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
	
	const SAVE_POST_QUERY = 
			'INSERT INTO article (article_title, article_description,
			article_body, article_publish_status, article_creation_date,
			article_path, article_parent) VALUES (:title, :description,
			:body, :status, NOW(), :path, :parent)';
	
	const DELETE_ARTICLE_QUERY = "DELETE FROM article WHERE article_path=:path";
	
	const UPDATE_ARTICLE_QUERY = "UPDATE article SET
		(article_title=:title,
		 article_description=:desc,
		 article_body=:body,
		 article_publish_status=:status,
		 ) WHERE article_path=:path";
	
}

?>