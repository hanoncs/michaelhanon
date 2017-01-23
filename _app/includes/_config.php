<?PHP

if (!defined('CONFIG_SET')) {
    define('CONFIG_SET', true);


    define('ROOT', $_SERVER['DOCUMENT_ROOT']);


    //database
    define('DB_SERVERNAME', '192.168.0.2');
    define('DB_DATABASE', 'secure_login');
    define('DB_USERNAME', 'secure_user');
    define('DB_PASSWORD', 'lJKkN7986GkJbbn');


    define("CAN_REGISTER", "any");
    define("DEFAULT_ROLE", "member");

    define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!


    define('CURRENT_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}