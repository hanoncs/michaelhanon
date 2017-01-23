<?PHP
$q = "CREATE TEMPORARY TABLE active_blog_posts (
id INT(11),
title VARCHAR(500) DEFAULT '',
sub_title VARCHAR(200) DEFAULT '',
markup LONGTEXT,
publish_date DATE,
created_by INT,
created_by_name VARCHAR(500)
);";
dbQuery($q);

$q = "INSERT INTO active_blog_posts
(id, title, sub_title, markup, publish_date, created_by)
SELECT id, title, sub_title, markup, publish_date, created_by
FROM blog.blog_post
WHERE id='$post_id'";
dbQuery($q);

$q = "UPDATE active_blog_posts AS bp
INNER JOIN secure_login.site_users AS su ON su.id = bp.created_by
SET created_by_name = su.username;";
dbQuery($q);

$q = "SELECT id, title, sub_title, markup, DATE_FORMAT(publish_date,'%m/%d/%Y') AS publish_date, created_by, created_by_name
FROM active_blog_posts";
$Array = dbArray($q);