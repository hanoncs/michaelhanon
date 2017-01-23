<?PHP

/**
 * Will take an error string and write it on the screen in a formatted, readable format.
 *
 * @param string $_Msg The message that you want to print on the screen,
 */
function err($_Msg)
{
    if ($_Msg != '') {
        echo Format('<div style="border:2px solid tomato; opacity:0.8; background-color:#F2F2F2; padding:2px 4px 2px 4px; margin:3px;">' . $_Msg . '</div>');
    }
}


/**
 * Will take a string and format the SQL into a readable format.
 *
 * @param string $_IncomingSql The message that you want to foamat.
 */
function Format($_IncomingSql) //change to gfSubFormatSQL
{
    $str = '';
    $str = str_ireplace("From", "<br />FROM", $_IncomingSql);
    $str2 = str_ireplace(" Set", "<br />SET", $str);
    $str3 = str_ireplace("Join", "<br />JOIN", $str2);
    $str4 = str_ireplace("Update", "<br />UPDATE", $str3);
    $str5 = str_ireplace("Select", "<br />SELECT", $str4);
    $str6 = str_ireplace("Where", "<br />WHERE", $str5);
    $str7 = str_ireplace("GROUP BY", "<br />GROUP BY", $str6);
    $str8 = str_ireplace("ORDER BY", "<br />ORDER BY", $str7);
    $str9 = str_ireplace("Having", "<br />HAVING", $str8);
    $str10 = str_ireplace("Union", "<br />UNION", $str9);
    $str11 = str_ireplace("Values", "<br />VALUES", $str10);
    $str12 = str_ireplace(" And", "<br />AND", $str11);
    $str13 = str_ireplace("Left", "<br />LEFT", $str12);
    $str14 = str_ireplace(", ISNULL", "<br />, ISNULL", $str13);
    $str15 = str_ireplace(") as X", "<br />) as X", $str14);
    $str16 = str_ireplace(",(", "<br />,(", $str15);
    $str17 = str_ireplace(") as ", "<br />) as ", $str16);
    $str18 = str_ireplace("Delete", "<br />DELETE", $str17);
    $str19 = str_ireplace("Insert", "<br />INSERT", $str18);
    return $str19;
}


//Set error handler function (See function below)

set_error_handler("StandardErrorHandler"); /// new php page Err Handler

/**
 * Will take an error string and if ON_SCREEN_SQL_ERRORS  is set to on, it will display the error on the screen with the SQL in a readable format and
 * if SEND_SQL_ERROR_EMAILS is set to on, it will dendthe error email with the SQL in a readable format.
 *
 *  PHP will pass these parameters automatically on error.
 *
 * @param string $errno The error type code.
 * @param string $errstr The error string.
 * @param string $errfile The file that the error occured in.
 * @param string $errline The line number that the error occured.
 */
function StandardErrorHandler($errno, $errstr, $errfile, $errline)
{
    $Err = $errstr . '<br />' . GetErrorType($errno) . 'on line ' . $errline . ' in ' . $errfile . '<br />';
    err($Err);
//    if (ON_SCREEN_ERRORS === TRUE) {
//        err($Err);
//    }
//    if ($errno == '256' and SEND_ERROR_EMAILS === TRUE) {
//        $Path = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//        gfErrEmail($Err, $Path, 'SQL Error');
//    }
}


//Set the Fatal Error Handler function (See function below)
register_shutdown_function("FatalErrorHandler");

/**
 * This function gets called on script shutdown, it will check if the last error is a fatal error. You cannot catch fatal errors,
 * but using this function we will be notified about it and be able to fix it.
 * If error is fatal, and if ON_SCREEN_FATAL_ERRORS is set to ON, this function will display the fatal error on the screen.
 * If error is fatal, and if SEND_FATAL_ERROR_EMAILS is set to ON, this function will send error email.
 *
 */
function FatalErrorHandler()
{

    $error = error_get_last();
    if ($error !== NULL) {
        if ($error["type"] == '1' || $error["type"] == '4' || $error["type"] == '16' || $error["type"] == '64' || $error["type"] == '4096') {
            $errno = GetErrorType($error["type"]);
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr = $error["message"];
            $Err = '<strong>' . $errno . '<br/></strong>' . $errstr . '<br />' . $errno . ' on line ' . $errline . ' in ' . $errfile . '<br />';
//            if (ON_SCREEN_ERRORS === TRUE) {
//                err($Err);
//            }
//            if (SEND_ERROR_EMAILS === TRUE) {
//                $Path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//                gfErrEmail($Err, $Path, $errno);
//            }
        }
    }
}


/**
 * This function receives the php error code and returns the specified string.
 *
 *
 * @return string The error title
 */
function GetErrorType($Type)
{
    switch ($Type) {
        case 1:
            // 'E_ERROR';
            return 'Fatal Error ';
        case 2:
            // 'E_WARNING';
            return 'Warning ';
        case 4:
            // 'E_PARSE';
            return 'Compile Time Parse Error ';
        case 8:
            // 'E_NOTICE';
            return 'Notice ';
        case 16:
            // 'E_CORE_ERROR';
            return 'Fatal Start up Error ';
        case 32:
            // 'E_CORE_WARNING';
            return 'Start Up Warning ';
        case 64:
            //'E_COMPILE_ERROR';
            return 'Fatal Compile Time Error ';
        case 128:
            // 'E_COMPILE_WARNING';
            return 'Compile Time Warning ';
        case 256 :
            // 'E_USER_ERROR' - USED FOR SQL ERRORS - DO NOT USE THIS ERROR CODE to TRIGGER_ERROR()
            return 'SQL Error ';
        case 512:
            // 'E_USER_WARNING';
            return 'Main Function ';
        case 1024:
            // 'E_USER_NOTICE';
            return 'Main Function ';
        case 2048:
            // 'E_STRICT';
            return 'Strict Error (PHP suggest changes to your code which will ensure the best interoperability and forward compatibility of your code.) ';
        case 4096:
            // 'E_RECOVERABLE_ERROR';
            return 'Catchable Fatal Error (This error can be caught, use a Try Catch) ';
        case 8192:
            // 'E_DEPRECATED';
            return 'Warns you of depreciated code that will not work in future versions of PHP. ';
        case 16384:
            // 'E_USER_DEPRECATED';
            return 'Programmer Triggered Error - Thrown using trigger_error() ';
    }
    return "Error Type Undefined ";
} 