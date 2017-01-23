<?PHP

if ($id != -1):
    $q = "SELECT id, title, sub_title, markdown, DATE_FORMAT(publish_date,'%Y-%m-%d') AS publish_date, created_by, tags, display_status
      FROM blog.blog_post
      WHERE ID=?";
    $stmt = $Conn->prepare($q);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $Array = $res->fetch_assoc();
endif;