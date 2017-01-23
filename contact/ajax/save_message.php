<?PHP
require $_SERVER['DOCUMENT_ROOT'] . '/_app/components/ajax-header.php';

$contact_name = filter_input(INPUT_POST, 'contact-name', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$contact_email = filter_input(INPUT_POST, 'contact-email', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$contact_message = filter_input(INPUT_POST, 'contact-message', FILTER_SANITIZE_STRING, ['options' => ['default' => '']]);
$contact_ip = $_SERVER["REMOTE_ADDR"];

if (vars_set($contact_name, $contact_email, $contact_message, $contact_ip)) {
    insert_record($Conn, $contact_name, $contact_email, $contact_message, $contact_ip);
}

function vars_set($contact_name, $contact_email, $contact_message, $contact_ip)
{
    if ($contact_name == '') {
        gf_toast_error('Error, contacts cannot be blank.');
        return false;
    }
    if (strlen($contact_name) > 500) {
        gf_toast_error('Error, contacts cannot be longer than 500 characters.');
        return false;
    }
    if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
        gf_toast_error('Error, please enter a valid email.');
        return false;
    }
    if ($contact_email == '') {
        gf_toast_error('Error, email cannot be blank.');
        return false;
    }
    if (strlen($contact_email) > 500) {
        gf_toast_error('Error, email cannot be longer than 500 characters.');
        return false;
    }
    if ($contact_message == '') {
        gf_toast_error('Error, message cannot be blank.');
        return false;
    }
    if (strlen($contact_message) > 5000) {
        gf_toast_error('Error, message cannot be longer than 5000 characters.');
        return false;
    }
    return true;
}


function insert_record($Conn, $contact_name, $contact_email, $contact_message, $contact_ip)
{

    $q = "INSERT INTO blog.contacts
          (name, email, message, ip) 
          VALUES (?, ?, ?, ?)";

    if ($insert_stmt = $Conn->prepare($q)) {
        $insert_stmt->bind_param('ssss', $contact_name, $contact_email, $contact_message, $contact_ip);
        if ($insert_stmt->execute()) {
            gf_toast_success('Thank you for reaching out, I\'ll get back to you soon!');
        } else {
            gf_toast_error('There was an error.');
            echo("Error description: " . mysqli_error($Conn));
        }
    } else {
        gf_toast_error('There was an error.');
        echo("Error description: " . mysqli_error($Conn));
    }
}