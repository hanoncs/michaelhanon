<?PHP
require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/header.php';
$Array = [];
require 'posts/100_sql.php';
?>

    <!-- Page Header -->
    <header class="intro-header" style="background-image: url('/_app/assets/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>My Blog</h1>
                        <hr class="small">
                        <span class="subheading">A Blog written by Michael Hanon</span>
                    </div>

                    <div id="ads-blocked-alert" class="alert alert-info" style="display: none; font-size:12px; text-align: center;">
                        It seems that you're using an ad blocker. The ads are used to pay for hosting this site.<br/>
                        Please think about disabling ad block for this site.
                    </div>
                    <script>
                        if (ads_being_blocked == "yes") {
                            $("#ads-blocked-alert").css('display', '');
                        }
                    </script>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-md-offset-1">


                <?PHP foreach ($Array as $Row): ?>

                    <div class="post-preview">
                        <?PHP if (check_logged_in($Conn) == true): ?>
                            <a href="/addpost/?id=<?PHP echo $Row['id']; ?>"
                               class="post-edit-link"
                               style="float:right;">Edit</a>
                        <?PHP endif; ?>
                        <a href="/post?post-title=<?PHP echo str_replace(' ', '-', $Row['title']); ?>&id=<?PHP echo $Row['id']; ?>">
                            <h2 class="post-title">
                                <?PHP echo $Row['title']; ?>
                            </h2>
                            <h3 class="post-subtitle">
                                <?PHP echo $Row['sub_title']; ?>
                            </h3>
                        </a>
                        <p class="post-meta">
                            Posted by Michael Hanon on <?PHP echo $Row['publish_date']; ?>
                            <br/>
                            Tags:
                            <?PHP $tags_array = explode(',', gf_isset_return($Row, 'tags'));
                            $tag_count = count($tags_array);
                            $loop_count = 0;
                            foreach ($tags_array as $tag):
                                echo '<a href="#">' . trim($tag) . '</a>';
                                $loop_count++;
                                echo($loop_count < $tag_count ? ", " : "");
                            endforeach
                            ?>
                        </p>
                    </div>
                    <hr>

                <?PHP endforeach; ?>
            </div>

            <div class="col-lg-2">
                <div>
                    <?PHP require '_app/includes/ads/blog_posts_sidebar_ad.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .post-edit-link {
            display: none;
            font-size: 14px;
            position: relative;
            top: 10px;
            text-decoration: underline;
        }

        .post-preview:hover .post-edit-link {
            display: inline;
            font-size: 14px;
            position: relative;
            top: 10px;
            text-decoration: underline;
        }

        .post-meta > a {
            color: #777777 !important;
        }
    </style>
    <script src="posts/home.js"></script>
<?PHP require ROOT . '/_app/components/footer.php'; ?>