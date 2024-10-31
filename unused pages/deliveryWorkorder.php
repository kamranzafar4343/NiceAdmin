<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

// Include database connection
include "config/db.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Retrieve and sanitize the 'id' to prevent SQL injection
    $delivery_no = intval($_GET['id']);

    //get data of the selected row against branch id
    $sql3 = "SELECT * FROM orders WHERE order_no= '$delivery_no'";
    $result3 = $conn->query($sql3);
    if ($result3->num_rows > 0) {
        $row3 = $result3->fetch_assoc();
        $delivery_order_no = $row['order_no'];
        $company_FK_emp = $row3['company'];
        $branch_FK_emp = $row3['branch'];
        $box_FK_emp = $row3['box'];
        $barcode = $row3['item'];
        $req_name = $row3['name'];
        $req_date = $row3['date'];
    }

    //run second query
    $query2 = "INSERT INTO `delivery_orders` (delivery_order_no, company, branch, box, item, name, date) VALUES ('$delivery_order_no', '$company_FK_emp', '$branch_FK_emp' , '$box_FK_emp', '$barcode', '$req_name', '$req_date')";

    // Execute the query
    if ($conn->query($query2) === TRUE) {

        //delete the specific order from order.php
        $query = "DELETE FROM `orders` WHERE `order_no` = '$delivery_order_no'";

        if ($conn->query($query) === TRUE) {

            $UpdateStatus = "UPDATE `box`  SET status = 'Out' WHERE box_id = '$box_FK_emp'";

            if ($conn->query($UpdateStatus) === TRUE) {
                header('Location: deliveredItems.php');
                exit(); // Make sure no further code is executed after redirect
            }
        }
    } else {
        // Error occurred
        echo "Error deleting record: " . $conn->error;
    }
    // Close the database connection
    $conn->close();
}
