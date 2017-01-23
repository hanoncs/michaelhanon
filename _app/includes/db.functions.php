<?php
//CREATE CONNECTION
$Conn = dbConnect();


//Create PDO connection
//THIS IS DIFFERENT FROM THE BELOW FUNCTIONS. THE BELOW FUNCTIONS ARE INSECURE.
//MUST BE USED IF YOU WANT TO PREVENT SQL INJECTION
//try {
//    $PDO = new PDO("sqlsrv:server=" . DB_SERVERNAME . " ; Database =" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
//    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//    // echo 'Connection failed: ' . $e->getMessage();
//    err($e->getMessage());
//}


function dbGrid($_IncomingSQL, $_CaptionTitle = 'dbGrid Table', $AllowSorting = true, $StickyHeader = true)
{
    $dbGridResult = dbQuery($_IncomingSQL, SQLSRV_CURSOR_KEYSET);
    $str = '';

    $str .= "<table class=\"Tbl dbGrid\">
                <caption>
                 " . $_CaptionTitle . "
                  <a class=\"XLSXExportLink\" data-exportid=\"0001\" href=\"#\">Export To Excel</a>
                </caption>
                <thead>
                    <tr>
                        <th>#</th>";

    foreach (sqlsrv_field_metadata($dbGridResult) as $fieldMetadata) {
        foreach ($fieldMetadata as $name => $value) {
            if ($name == 'Name') {
                $str .= '<th>';
                if ($AllowSorting == true) {
                    $str .= '<a href="#">';
                }
                $str .= $value;
                if ($AllowSorting == true) {
                    $str .= '</a>';
                }
                $str .= '</th>';
            }
        }
    }

    $str .= "</tr></thead><tbody>";
    $i = 1;
    $MyArray = [];
    while ($row = sqlsrv_fetch_array($dbGridResult, SQLSRV_FETCH_NUMERIC)) {
        $MyArray[] = $row;
    }
    if ($AllowSorting == true and gf_get_var('pSort') != '') {
        usort($MyArray, 'gfSortArray');
    }

    foreach ($MyArray as $Row) {
        $str .= '<tr class="TblRow">';
        $str .= '<td>' . $i++ . '</td>';
        foreach ($Row as $rowvalue) {
            $str .= '<td>' . $rowvalue . '</td>';
        }
        $str .= '</tr>';
    }
    //if no results
    if (sqlsrv_num_rows($dbGridResult) == 0) {
        $str .= '<tr><td colspan="6" ><span class="NoResults">No Results</span></td></tr>';
    }

    $str .= "</tbody>
        </table>
    <hr class=\"TblEndLine\" />";
    if ($StickyHeader == true) {
        $str .= '<script>
                    $(function () {
                        $(".dbGrid").stickyTableHeaders();
                    });
                </script>';
    }
    return $str;
}


function dbArray($_IncomingSql, $_DefaultValue = 0, $ArrayReturnType = MYSQLI_BOTH)
{ // Default Value may not necessary
    $MyArray = [];
    $Result = dbQuery($_IncomingSql);

    if (mysqli_num_rows($Result)) {
        while ($Row = mysqli_fetch_array($Result, $ArrayReturnType)) {
            $MyArray[] = $Row;
        }
        return $MyArray;
    } else {
        return $_DefaultValue;
    }
}


function dbConnect()
{

    $Conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($Conn === false) {
        //If connection fails, try one more time before erroring out.
        $Conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($Conn === false) {
            //Still could not connect
//            ff("A connection could not be established.<br /><br />Please contact the RMSI Help Desk at 925-262-7162 for assistance.<br />");
//            if (SEND_ERROR_EMAILS === TRUE) {
//                $Path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//                gfErrEmail('<strong>Database ConnectionError: </strong>' . print_r(sqlsrv_errors(), true), $Path, 'Database Connection Failed');
//            }
            if (ON_SCREEN_ERRORS === TRUE) {
                ff(mysqli_connect_error());
            }
            //Kill script to prevent further issues if connection failed.
            die();
        } else {
            return $Conn;
        }
    } else {
        return $Conn;
    }
}


function dbQuery($_IncomingSql)
{
    global $Conn;
    if (!$Result = mysqli_query($Conn, $_IncomingSql)) {
        if (ON_SCREEN_ERRORS === TRUE) {
            echo("Error description: " . mysqli_error($Conn));
        }
    } else {
        return $Result;

    }

    //var_dump($Result);


    //Catch sql errors on query
//    if ($Result === false) {
//        if (($errors = mysqli_error()) != null) {
//            $Result = CatchSQLErrors($errors, $_IncomingSql);
//        }
//    } else {
//        return $Result;
//    }


}


function dbDelete($_IncomingSql)
{
    global $Conn;
    dbQuery($_IncomingSql);
    return mysqli_affected_rows($Conn);

}


function dbInsert($_IncomingSql)
{
    global $Conn;
    $Result = dbQuery($_IncomingSql);

    $InsertID = mysqli_insert_id($Conn);
    if ($InsertID != '') {
        return $InsertID;
    } else {
        return 0;
    }

}


/**
 * Selects a set of records and returns a delimited string of the results.
 * CASE 1: If you do not enter a delimiter parameter, or pass an empty delimiter, you will get a comma separated string with no spaces, eg. 1,2,3,4,5,6,7.
 * CASE 2: If you enter "," for the delimiter you will get a comma separated string with a space eg. 1, 2, 3, 4, 5, 6, 7.
 * CASE 3: If you enter "', '" for the delimiter you will get a comma separated string with a space, surounded by quotes eg. '1', '2', '3', '4', '5', '6', '7'.
 * CASE 4: If you enter any other character you can create a string delimited by the character you enter. You can enter an optional space after the character to space out each value in the string.
 * @param string $_IncomingSql The sql query that you want to execute.
 * @param string $_Delimimiter OPTIONAL PARAMETER - The character that will separate each result.
 * @param string $_DefaultValue OPTIONAL PARAMETER - The Value to Return if no records found.
 * @Return string $_DefaultValue will Return if no records found in query.
 */
function dbJoin($_IncomingSql, $_Delimimiter = "", $_DefaultValue = 0)
{
    $Return = '';
    $Str = '';
    $Result = dbQuery($_IncomingSql);
    if (mysqli_num_rows($Result)) {
        while ($Row = mysqli_fetch_array($Result, MYSQLI_NUM)) {
            if ($_Delimimiter === "") {
                $Str .= $Row[0] . ",";
                $Return = rtrim($Str, ",");
            } elseif ($_Delimimiter === ", ") {
                $Str .= $Row[0] . ", ";
                $Return = rtrim($Str, ", ");
            } elseif ($_Delimimiter === "', '") {
                $Str .= "'" . $Row[0] . "', ";
                $Return = rtrim($Str, ", ");
            } else {
                $Str .= $Row[0] . $_Delimimiter;
                $Return = rtrim($Str, $_Delimimiter);
            }
        }
    } else {
        $Return = $_DefaultValue;
    }
    return $Return;
}


function CatchSQLErrors($errors, $_IncomingSql)
{
    foreach ($errors as $error) {
        //error display
        $Path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $Err = '<strong>SQL ERROR<br />
        </strong>' . $_IncomingSql . '<br />
            <span style="font-weight: 600;">Error: </span>' . $error['message'] . '<br/>
        <span style="font-weight: 600;">Page: </span>' . $Path;
        if (ON_SCREEN_ERRORS === TRUE) {
            err($Err);
        }
        $Err = Format($_IncomingSql) . '<br /><span style="font-weight: 600;">Error: </span>' . $error['message'];
        if (SEND_ERROR_EMAILS === TRUE) {
            gfErrEmail($Err, $Path, 'SQL Error');
        }
    }
    return 0;
}


function dbStr($_IncomingSql, $_DefaultValue = 0)
{
    $Result = dbQuery($_IncomingSql);
    if (mysqli_num_rows($Result)) {
        $Row = mysqli_fetch_array($Result, MYSQLI_NUM);
        return $Row[0];
    } else {
        return $_DefaultValue;
    }
}


function dbUpdate($_IncomingSql)
{
    global $Conn;
    dbQuery($_IncomingSql);
    $AffectedRows = mysqli_affected_rows($Conn);
    if ($AffectedRows) {
        return $AffectedRows;
    } else {
        return 0;
    }

}

function dbDropTable($TableName)
{
    $q = "IF OBJECT_ID('$TableName') IS NOT NULL DROP TABLE $TableName;";
    dbExecute($q);
}


/**
 *
 * Executes on script shutdown to close database connection
 */
function dbShutDown()
{
    global $Conn;
    mysqli_close($Conn);
}

register_shutdown_function('dbShutDown');