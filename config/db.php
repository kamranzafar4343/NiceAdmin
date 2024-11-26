<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//using env. var's
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'datatech1_test';


$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$conn) {
    echo "error during database connection";
}
