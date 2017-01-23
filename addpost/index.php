<?PHP
require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/header.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT, ['options' => ['default' => -1]]);
$Array = [];
require '100_sql.php';
?>

    <!--Page Specific-->
    <link rel="stylesheet" href="/_app/assets/css/plugins/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="/_app/assets/css/plugins/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="addpost.css">
    <script src="/_app/assets/js/plugins/bootstrap-datepicker.min.js"></script>
    <script src="/_app/assets/js/plugins/bootstrap-tagsinput.js"></script>
    <script src="addpost.js"></script>


    <!-- Page Header -->
    <header class="intro-header" style="background-image: url('/_app/assets/img/contact-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>Add Post</h1>
                        <hr class="small">
                        <span class="subheading">Have ideas? Post them here.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <style>
        .input {
            width: 100%;
        }
    </style>
    <!-- Main Content -->

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">


                <!--TITLE -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <label>Title</label>
                        <input type="text"
                               class="form-control input"
                               name="blog-post-title"
                               value="<?PHP gf_isset_echo($Array, 'title'); ?>">
                    </div>
                </div>
                <br/>


                <!--SUB TITLE -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <label>Sub Title</label>
                        <input type="text"
                               class="form-control input"
                               name="blog-post-sub-title"
                               value="<?PHP gf_isset_echo($Array, 'sub_title'); ?>">
                    </div>
                </div>
                <br/>


                <!--CONTENT -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12" style="height:700px;">
                        <label>Content</label>
                        <link rel="stylesheet" href="/_app/assets/css/plugins/editormd.min.css"/>
                        <script src="/_app/assets/js/plugins/editormd.js"></script>
                        <div id="editormd" style="border-radius:4px;">
                            <textarea style="display:none;"><?PHP gf_isset_echo($Array, 'markdown'); ?></textarea>
                        </div>
                    </div>
                </div>
                <br/>
                <br/>

                <!--PUBLISH DATE -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <label>Publish Date</label>
                        <input id="bootstrap-datepicker"
                               type="text"
                               class="form-control"
                               name="publish-date"
                               value="<?PHP gf_isset_echo($Array, 'publish_date'); ?>">
                    </div>
                </div>
                <br/>


                <!--TAGS -->
                <div class="row bootstrap-tags">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <label>Tags</label>
                        <input id="bootstrap-tags"
                               type="text"
                               style="font-size:8px !important;"
                               name="blog-post-tags"
                               data-role="tagsinput"
                               value="<?PHP gf_isset_echo($Array, 'tags'); ?>">
                    </div>
                </div>
                <br/>


                <!--DISPLAY STATUS -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <label>Display</label>
                        <select class="form-control" name="blog-post-display-status">
                            <option
                                value="1" <?PHP echo(gf_isset_return($Array, 'display_status', 1) == 1 ? "selected" : ""); ?>>
                                Yes
                            </option>
                            <option
                                value="0" <?PHP echo(gf_isset_return($Array, 'display_status', 1) == 0 ? "selected" : ""); ?>>
                                No
                            </option>
                        </select>
                    </div>
                </div>
                <br/>


                <input type="hidden" name="blog-post-id" value="<?PHP echo $id; ?>">
                <!--SUBMIT-->
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit"
                                class="btn btn-default ClickSubmit pull-right"
                                data-path="ajax/save_post.php"
                                data-method="POST"
                                data-success="save_post_success">Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .toast {
            width: 400px !important;
            font-size: 15px !important;
            text-align: center;;
        }
    </style>

<?PHP require ROOT . '/_app/components/footer.php'; ?>