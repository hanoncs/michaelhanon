<?PHP
require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/ajax-header.php';

start_secure_session();

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p'];
    $refer_url = rawurldecode($_POST['refer']);

    if (gf_login_user($email, $password, $Conn) == true) {

        if ($refer_url == '') {
            // login success
            gf_redirect('/');
        } else {
            gf_redirect($refer_url);
        }

    } else {

        // login failed
        gf_redirect('/?error=1');

    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}