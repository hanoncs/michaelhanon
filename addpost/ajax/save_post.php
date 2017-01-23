<?PHP
require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/ajax-header.php';

$title = filter_input(INPUT_POST, 'blog-post-title', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$markdown = filter_input(INPUT_POST, 'editormd-markdown-doc', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$markup = $_POST['editormd-html-code'];
$publish_date = filter_input(INPUT_POST, 'publish-date', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$sub_title = filter_input(INPUT_POST, 'blog-post-sub-title', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$tags = filter_input(INPUT_POST, 'blog-post-tags', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$post_id = filter_input(INPUT_POST, 'blog-post-id', FILTER_SANITIZE_STRING, ['options' => ['default' => '-1']]);
$post_display_status = filter_input(INPUT_POST, 'blog-post-display-status', FILTER_SANITIZE_NUMBER_INT, ['options' => ['default' => -1]]);


if (vars_set($title, $sub_title, $markdown, $markup, $publish_date, $tags, $post_display_status)) {
    if ($post_id != '-1') {
        update_record($Conn, $title, $sub_title, $markdown, $markup, $publish_date, $tags, $post_display_status, $post_id);
    } else {
        insert_record($Conn, $title, $sub_title, $markdown, $markup, $publish_date, $tags, $post_display_status);
    }
}

function vars_set($title, $sub_title, $markdown, $markup, $publish_date, $tags, $post_display_status)
{
    if ($title == '') {
        gf_toast_error('Error, Please enter a title.');
        return false;
    }
    if ($sub_title == '') {
        gf_toast_error('Error, Please enter a sub title.');
        return false;
    }
    if ($markdown == '') {
        gf_toast_error('Error, Markdown cannot be blank.');
        return false;
    }
    if ($markup == '') {
        gf_toast_error('Error, Markup cannot be blank.');
        return false;
    }
    if ($publish_date == '') {
        gf_toast_error('Error, Please enter a publish date.');
        return false;
    }
    if ($tags == '') {
        gf_toast_error('Error, Please enter tags.');
        return false;
    }
    if ($post_display_status == -1) {
        gf_toast_error('Error, Please select display status.');
        return false;
    }
    return true;
}

function update_record($Conn, $title, $sub_title, $markdown, $markup, $publish_date, $tags, $post_display_status, $post_id)
{

    $q = "UPDATE blog.blog_post 
          SET title=?, sub_title=?, markdown=?, markup=?, publish_date=?, modified_by=?, tags=?, display_status=?
          WHERE ID=?";

    if ($insert_stmt = $Conn->prepare($q)) {
        $insert_stmt->bind_param('sssssssss', $title, $sub_title, $markdown, $markup, $publish_date, $_SESSION['user_id'], $tags, $post_display_status, $post_id);
        if ($insert_stmt->execute()) {
            gf_toast_success('Successfully updated. ');
        } else {
            gf_toast_error('There was an error updating the database.');
        }
    } else {
        gf_toast_error('There was an error preparing the update query.');
    }
}

function insert_record($Conn, $title, $sub_title, $markdown, $markup, $publish_date, $tags, $post_display_status)
{

    $q = "INSERT INTO blog.blog_post 
          (title, sub_title, markdown, markup, publish_date, created_by, tags, display_status) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($insert_stmt = $Conn->prepare($q)) {
        $insert_stmt->bind_param('ssssssss', $title, $sub_title, $markdown, $markup, $publish_date, $_SESSION['user_id'], $tags, $post_display_status);
        if ($insert_stmt->execute()) {
            gf_toast_success('Successfully saved. ');
        } else {
            gf_toast_error('There was an error saving to the database.');
        }
    } else {
        gf_toast_error('There was an error preparing the insert query.');
    }
}