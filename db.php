<?php
session_start();

$HOSTNAME= 'localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='catmarketing';

$conn= mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$conn){
    echo"error during database connection";
}

?>