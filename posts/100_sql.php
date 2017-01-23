<?PHP

$q = "CREATE TEMPORARY TABLE active_blog_posts (
      id INT(11),
      title VARCHAR(500) DEFAULT '',
      sub_title VARCHAR(200) DEFAULT '',
      markup LONGTEXT,
      publish_date DATE,
      created_by INT,
      created_by_name VARCHAR(500),
      tags VARCHAR(1000)
  );";
dbQuery($q);

$q = "INSERT INTO active_blog_posts 
      (id, title, sub_title, markup, publish_date, created_by, tags)
      SELECT id, title, sub_title, markup, publish_date, created_by, tags
      FROM blog.blog_post
      WHERE display_status>0 
      AND publish_date<= curdate()
      ORDER BY date_created;";
dbQuery($q);

$q = "UPDATE active_blog_posts AS bp
      INNER JOIN secure_login.site_users AS su ON su.id = bp.created_by
      SET created_by_name = su.username;";
dbQuery($q);

$q = "SELECT id, title, sub_title, markup, DATE_FORMAT(publish_date,'%m/%d/%Y') AS publish_date, created_by, created_by_name, tags
      FROM active_blog_posts
      ORDER BY publish_date DESC ";
$Array = dbArray($q, []);