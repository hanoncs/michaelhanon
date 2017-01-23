<?PHP


?>

<input type="hidden" name="client_id" value="<?PHP echo(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ""); ?>">
</form>

<!-- Footer -->
<footer>
    <div class="container">

        <!-- ALL BLOG POSTS FOOTER AD-->
        <?PHP if (dirname($_SERVER['PHP_SELF']) == '\\'): ?>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <?PHP require '_app/includes/ads/blog_posts_footer_ad.php'; ?>
                </div>
            </div>
        <?PHP endif; ?>


        <!-- SINGLE BLOG POST FOOTER AD-->
        <?PHP if (dirname($_SERVER['PHP_SELF']) == '/post'): ?>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <?PHP require '../_app/includes/ads/blog_post_footer_ad.php'; ?>
                </div>
            </div>
        <?PHP endif; ?>


        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="list-inline text-center">
                    <li>
                        <a id="btn-tweet" href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/dialog/feed?
                           app_id=145634995501895
                           &display=popup&amp;caption=An%20example%20caption
                           &link=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2F
                           &redirect_uri=https://developers.facebook.com/tools/explorer">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul>
                <p class="copyright text-muted">&copy; 2016 Michael Hanon</p>
            </div>
        </div>
    </div>
    <script>
        //show link on a tag, but stop redirect so I can open new window instead of the user leaving the site
        var tweet_link = 'https://twitter.com/intent/tweet?text=' + twitter_page_specific_link + '&url=' + encodeURIComponent(window.location.href) + '&hashtags=MichaelHanonBlog';
        $('#btn-tweet').attr('href', tweet_link);
        $('#btn-tweet').click(function (e) {
            e.preventDefault();
            window.open(tweet_link, '', 'width=600,height=250')
        });
    </script>
</footer>



</body >

</html >
