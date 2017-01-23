<?PHP
include $_SERVER['DOCUMENT_ROOT'] . '/_app/includes/config.php';
include ROOT . '/_app/includes/util.functions.php';
include ROOT . '/_app/includes/err.functions.php';
include ROOT . '/_app/includes/db.functions.php';

include ROOT . '/_app/security/login/register.php';
?>


<!DOCTYPE html>
<html lang="en"><!-- Closed on footer -->
<head>
    <title>Blog Title</title>
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
<?php
if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?>
<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
      method="post"
      name="registration_form">
    <style>
        html, body {
            height: 100%;
        }

        .card {
            width: 100%;
            text-align: center;
            height: 460px;
            padding: 10px;
            margin-top: 40px;
            border: 1px solid lightgrey;
            background-color: rgba(218, 218, 218, 0.19);
        }

    </style>
    <div class="container">
        <div class="row">


            <div class="col-md-offset-4 col-md-4">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <img class="img-responsive img-circle"
                                 src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"
                                 style="margin:30px auto 30px; height:90px;">
                        </div>
                        <div class="col-md-12">
                            <input type='text'
                                   class="form-control input-lg"
                                   name='username'
                                   id='username'
                                   placeholder="Username"/>
                        </div>
                        <div class="col-md-12">
                            <input type="text"
                                   class="form-control input-lg"
                                   name="email"
                                   id="email"
                                   placeholder="Email"/>
                        </div>
                        <div class="col-md-12">
                            <input type="password"
                                   class="form-control input-lg"
                                   name="password"
                                   id="password"
                                   placeholder="Password"/>
                        </div>
                        <div class="col-md-12">
                            <input type="password"
                                   class="form-control input-lg"
                                   name="confirmpwd"
                                   id="confirmpwd"
                                   placeholder="Confirm Password"/>
                        </div>

                        <div class="col-md-12">
                            <button class="btn-primary btn-lg btn-block" onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);">Register
                            </button>
                        </div>
                        <div class="col-md-12">
                            <a href="#">Forgot Password</a>
                        </div>
                        <div class="col-md-12">
                            <a href="/log_in.php">Already a Member</a>
                        </div>
                    </div>
                </div>
            </div>


</form>


<ul style="list-style-type: none; padding:0px;">
    <li>Usernames may contain only digits, upper and lowercase letters and underscores</li>
    <li>Emails must have a valid email format</li>
    <li>Passwords must be at least 6 characters long</li>
    <li>Passwords must contain
        <ul>
            <li>At least one uppercase letter (A..Z)</li>
            <li>At least one lowercase letter (a..z)</li>
            <li>At least one number (0..9)</li>
        </ul>
    </li>
    <li>Your password and confirmation must match exactly</li>
</ul>

</div><!-- /row -->
</div><!-- /container -->
<script>

</script>

</form>
</body>
</html>