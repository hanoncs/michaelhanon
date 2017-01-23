<?PHP
include $_SERVER['DOCUMENT_ROOT'] . '/_app/includes/config.php';
include ROOT . '/_app/includes/util.functions.php';
include ROOT . '/_app/includes/err.functions.php';
include ROOT . '/_app/includes/db.functions.php';

if ($_SERVER['LOCAL_ADDR'] != '192.168.0.2') {
    gf_force_https();
}
start_secure_session();

$LoginError = gf_get_var('error', 0);
?>

<!DOCTYPE html>
<html lang="en"><!-- Closed on footer -->
<head>
    <title>MichaelHanon.com</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- STYLES -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/JavaScript" src="/_app/assets/js/sha512.js"></script>
    <script type="text/JavaScript" src="/_app/assets/js/forms.js"></script>
</head>
<body>

<form action="/_app/security/login/process_login.php" method="post" name="login_form">
    <style>
        html, body {
            height: 100%;
        }

        .card {
            width: 100%;
            text-align: center;
            height: 385px;
            padding: 40px;
            margin-top: 140px;
            border: 1px solid lightgrey;
            background-color: rgba(218, 218, 218, 0.19);
        }

        <?PHP if($LoginError>0): ?>

        .input-validate {
            border: 1px solid #bd0000;
        }

        .error-text {
            color: #bd0000;
            font-weight: bold;
            display: inline !important;
        }

        <?PHP endif; ?>


    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-md-4">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>MichaelHanon.com</h4>
                            <img class="img-responsive img-circle"
                                 src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"
                                 style="margin:30px auto 30px; height:90px;">
                        </div>

                        <div class="col-md-12" style="margin-bottom:7px;">
                            <input type="text"
                                   name="email"
                                   class="form-control input-med input-validate"
                                   placeholder="Email">
                        </div>

                        <div class="col-md-12" style="margin-bottom:7px;">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control input-med input-validate"
                                   placeholder="Password">
                        </div>

                        <div class="col-md-12">
                            <button class="btn-primary btn btn-block"
                                    onclick="formhash(this.form, this.form.password);">Login
                            </button>
                        </div>

                        <div class="col-md-12 error-text" style="display:none;">
                            <span>Incorect username or password.</span>
                        </div>


                        <?PHP //<div class="col-md-12">?>
                        <?PHP //    <a href="#">Forgot Password</a>?>
                        <?PHP //</div>?>


                        <?PHP //  <div class="col-md-12"> ?>
                        <?PHP //    <a href="/register/">Register</a>?>
                        <?PHP // </div>?>
                    </div>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
    <input type="hidden" name="refer" value="<?PHP echo gf_get_var('refer'); ?>">
    <?PHP
    //
    //    echo 'dbStr: ' . dbStr('Select col_1 from test_table', 'nothing found') . '<br/><br/>';
    //
    //    echo 'dbArray: ';
    //    var_dump(dbArray('Select * from test_table LIMIT 1'));
    //    echo '<br/><br/>';
    //
    //    echo 'dbDelete: ' . dbDelete('Delete from test_table where ID=58') . '<br/><br/>';
    //
    //
    //    echo 'dbInsert: ' . dbInsert("Insert into test_table (col_1) VALUES ('sfgsfgsfgsfgsf')") . '<br/><br/>';
    //
    //    echo 'dbJoin: ' . dbJoin("Select ID, col_1 from test_table LIMIT 5", ', ') . '<br/><br/>';
    //
    //    echo 'dbUpdate: ' . dbUpdate("Update test_table Set col_1='ff'") . '<br/><br/>';
    //
    //
    ?>
</form>
</body>
</html>