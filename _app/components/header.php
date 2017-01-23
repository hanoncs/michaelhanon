<?PHP
include $_SERVER['DOCUMENT_ROOT'] . '/_app/includes/config.php';
include ROOT . '/_app/includes/util.functions.php';
include ROOT . '/_app/includes/db.functions.php';
include ROOT . '/_app/includes/err.functions.php';


if ($_SERVER['LOCAL_ADDR'] != '192.168.0.2') {
    include ROOT . '/_app/includes/google_analytics.php';
    gf_force_https();
}
start_secure_session();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Michael Hanon">

        <title>MichaelHanon.com</title>

        <!-- STYLES -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
        <link href="/_app/assets/css/clean-blog.css" rel="stylesheet">

        <!-- SCRIPTS -->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="/_app/assets/js/plugins/jquery.form.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="/_app/assets/js/site.js"></script>
        <?PHP include ROOT . '/_app/includes/google_page_level_ads.php'; ?>

        <!-- Custom Fonts -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet'>
        <link
            href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
            rel='stylesheet'>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script>
            localStorage.setItem("ads-blocked", "");
        </script>
        <script src="/_app/assets/js/ads.js"></script>
        <script>
            //            if (document.getElementById('detect-ads-div')) {
            //                var ads_being_blocked = 'no';
            //                console.warn('Blocking Ads: No');
            //            } else {
            //                var ads_being_blocked = 'yes';
            //                console.warn('Blocking Ads: Yes');
            //            }


            if (localStorage.getItem("ads-blocked") == "no") {
                var ads_being_blocked = 'no';
                console.warn('Blocking Ads: No');
            }
            else {
                var ads_being_blocked = 'yes';
                console.warn('Blocking Ads: Yes');
            }


            if (typeof ga !== 'undefined') {
                ga('send', 'event', 'Blocking Ads', ads_being_blocked, {'nonInteraction': 1});
            } else if (typeof _gaq !== 'undefined') {
                _gaq.push(['_trackEvent', 'Blocking Ads', ads_being_blocked, undefined, undefined, true]);
            }
        </script>

    </head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/">Michael Hanon</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/">Blog Posts</a>
                    </li>
                    <li>
                        <a href="/about">About</a>
                    </li>
                    <li>
                        <a href="/contact">Contact</a>
                    </li>
                    <?PHP if (check_logged_in($Conn) == true): ?>
                        <li>
                            <a href="/addpost">Add Post</a>
                        </li>
                    <?PHP endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <form>
<?PHP
//<li>
//    <a href="/App/security/login/logout.php?refer= echo rawurlencode(CURRENT_URL); ">Logout</a>
//</li>
// else:
//<li>
//    <a href="/log_in.php?refer=<?PHP echo rawurlencode(CURRENT_URL);">Login</a>
//</li>
?>