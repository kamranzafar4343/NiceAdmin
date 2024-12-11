<!-- head.html -->
<head>
    <title><?php echo $pageTitle; ?></title>
    <!-- Other head content -->
</head>
<!-- In each file, set $pageTitle before including the head.html: -->

<!-- php
Copy code -->

<?php 
$pageTitle = "Home Page"; 
include 'header.html'; 
?>