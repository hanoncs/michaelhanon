<?PHP

function gf_isset_echo($array, $key, $default = '')
{
    if (isset($array[$key])) {
        echo $array[$key];
    } else {
        echo $default;
    }
}

function gf_isset_return($array, $key, $default = '')
{
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}

function gf_force_https()
{
    if (!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off') {
        $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $redirect_url");
        exit();
    }
}

function gf_force_logged_in()
{
    global $Conn;
    if (check_logged_in($Conn) == false) {
        gf_redirect('/');
    }
}

function gf_redirect($path)
{
    header("Location: $path");
    die;
}

function gf_toast_error($val)
{
    echo json_encode(['result' => 'error', 'result_string' => $val]);
}

function gf_toast_success($val)
{
    echo json_encode(['result' => 'success', 'result_string' => $val]);
}


/**
 * Used to safely get the value of a querystring variable.
 *
 * This function is designed to return the value of a specific key in the querystring. If the key exists but is empty, it will return the $_EmptyReturnValue.
 *
 * @param mixed $_Var The key of the value that you want to retrieve from the querystring. Case sensitive, must match key.
 * @param mixed $_EmptyReturnValue The value that you want to return if the key is empty or does not exist in the querystring.
 * @return mixed
 */
function gf_get_var($_Key, $_EmptyReturnValue = '')
{
    $return = '';
    if (isset($_Key) and $_Key !== '') {
        if (isset($_POST[$_Key]) and $_POST[$_Key] !== '') {
            $return = $_POST[$_Key];
        } else if (isset($_GET[$_Key]) and $_GET[$_Key] !== '') {
            $return = $_GET[$_Key];
        } else {
            $return = $_EmptyReturnValue;
        }
    } else {
        trigger_error('You must pass a value to the ' . __FUNCTION__ . '() function call on ' . CURRENTPAGE);
    }
    return $return;
}


function start_secure_session()
{
    $session_name = 'sec_session_id';   // Set a custom session name
    /*Sets the session name.
     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP.
     */
    session_name($session_name);

    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = SECURE;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    session_start();            // Start the PHP session
    session_regenerate_id(true);    // regenerated the session, delete the old one.
}

function gf_login_user($email, $password, $mysqli)
{
    $user_id = 0;
    $username = '';
    $db_password = '';
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT id, username, password 
                                  FROM site_users
                                  WHERE email = ?
                                  LIMIT 1")
    ) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
                    // login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $q = "INSERT INTO login_attempts (user_id, time)
                          VALUES ('$user_id', '$now')";
                    $mysqli->query($q);
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}


function checkbrute($user_id, $mysqli)
{
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    $q = "SELECT time 
          FROM login_attempts 
          WHERE user_id = ? 
          AND time > '$valid_attempts'";
    if ($stmt = $mysqli->prepare()) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function check_logged_in($mysqli)
{
    $password = '';
    // Check if all session variables are set
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $q = "SELECT password 
              FROM site_users 
              WHERE id = ? 
              LIMIT 1";
        if ($stmt = $mysqli->prepare($q)) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if (hash_equals($login_check, $login_string)) {
                    // Logged In!!!!
                    return true;
                } else {
                    //echo '1'; debugging
                    // Not logged in
                    return false;
                }
            } else {
                //echo '2'; debugging
                // Not logged in
                return false;
            }
        } else {
            /// echo '3'; debugging
            // Not logged in
            return false;
        }
    } else {
        // echo '4'; debugging
        // Not logged in
        return false;
    }
}

function esc_url($url)
{

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string)$url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
