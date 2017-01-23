<?PHP
require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/header.php';
$post_id = gf_get_var('id');
require '100_sql.php';
?>


<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('/_app/assets/img/post-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?PHP echo $Array[0]['title']; ?></h1>
                    <h2 class="subheading"><?PHP echo $Array[0]['sub_title']; ?></h2>
                    <span class="meta">Posted by Michael Hanon<?PHP //echo $Array[0]['created_by_name']; ?>
                        on <?PHP echo $Array[0]['publish_date']; ?></span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-md-offset-1">
                <?PHP echo $Array[0]['markup']; ?>
            </div>
            <div class="col-lg-2">
                <div>
                    <!-- Blog Post Sidebar -->
                    <?PHP require '../_app/includes/ads/blog_post_sidebar_ad.php'; ?>
                </div>
            </div>
        </div>
    </div>
</article>
<style>
    blockquote p {
        margin-bottom: 30px !important;
    }
</style>
<script>
    var twitter_page_specific_link = '<?PHP echo $Array[0]['title']; ?> via @MichaelHanon\'s blog';

</script>
<script src="post.js"></script>
<?PHP require ROOT . '/_app/components/footer.php'; ?>
