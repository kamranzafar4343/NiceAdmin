<?php


// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->Load();

//using env. var's
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'my';


$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$conn) {
    echo "error during database connection";
}
