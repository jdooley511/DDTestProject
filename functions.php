<?php
/* * **f* functions/db_connect
 * NAME
 * db_connect
 * SYNOPSIS
 * db_connect()
 * FUNCTION
 * Provides a database connection PDO Object
 * INPUTS
 * 
 * RETURN VALUE
 * PDO or false if the connection fails
 * ERRORS
 *
 * EXAMPLE
 * $db = db_connect();
 * NOTES
 *
 * SEE ALSO
 * 
 * ** */
function db_connect() {
    // Database configuration
    $hostname = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;

    try {
        $db = new PDO("mysql:host=$hostname;dbname=mysql", $username, $password);
        return $db;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

/* * **f* functions/table_sort_helper
 * NAME
 * table_sort_helper
 * SYNOPSIS
 * table_sort_helper()
 * FUNCTION
 * Helper function to sort table data
 * INPUTS
 * 
 * RETURN VALUE
 * INT
 * ERRORS
 *
 * EXAMPLE
 * 
 * NOTES
 *
 * SEE ALSO
 * 
 * ** */
function table_sort_helper($a,$b) {
    return ($a["Conversion Rate %"] >= $b["Conversion Rate %"]) ? -1 : 1;
}

?>