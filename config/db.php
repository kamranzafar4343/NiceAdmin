<?php


// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->Load();

//using env. var's
$HOSTNAME = 'sql12.freemysqlhosting.net';
$USERNAME = 'sql12733988';
$PASSWORD = 'uUqxLbg8KS';
$DATABASE = 'sql12733988';

$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$conn) {
    echo "error during database connection";
}
