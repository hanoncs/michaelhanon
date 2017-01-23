<?PHP require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/header.php'; ?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('/_app/assets/img/contact-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>Contact Me</h1>
                        <hr class="small">
                        <span class="subheading">Have questions? I have answers (maybe).</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p>Want to get in touch with me? Fill out the form below to send me a message!</p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <span>Your Name:</span>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" name="contact-name" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <span>Email Address:</span>
                    </div>
                    <div class="col-sm-9">
                        <input type="email" name="contact-email" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <span>Message:</span>
                    </div>
                    <div class="col-sm-9">
                        <textarea name="contact-message" class="form-control" rows="6"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="btn-contact-submit"type="submit"
                                class="btn btn-default pull-right ClickSubmit"
                                data-path="ajax/save_message.php"
                                data-method="POST"
                                data-success="send_message_success">Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="contact.js"></script>
<?PHP require ROOT . '/_app/components/footer.php'; ?>