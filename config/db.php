<?php
//error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$HOSTNAME= 'sql12.freemysqlhosting.net';
$USERNAME='sql12733988';
$PASSWORD='uUqxLbg8KS';
$DATABASE='sql12733988';

$conn= mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$conn){
    echo"error during database connection";
}

?>