<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catmarketing2";
/* $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lednew"; */

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(0);