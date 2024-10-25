<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
  header("Location: pages-login.php");
  exit();
}

// Include database connection
include 'config/db.php';

// Get employee ID from query string
$emp_id = $_GET['id'];

// Get branch ID from employee data
$emp_sql = "SELECT branch_id_fk FROM employee WHERE emp_id = $emp_id";
$result_emp = $conn->query($emp_sql);

//getting branch to redirect on branch info page
$emp_data = $result_emp->fetch_assoc();
$branch_id = $emp_data['branch_id_fk'];

// Delete employee data
$delete_sql = "DELETE FROM employee WHERE emp_id = $emp_id";

if ($conn->query($delete_sql) === TRUE) {
  header("Location: branchInfo.php?id=$branch_id");
  exit();
} else {
  echo "Error deleting employee: " . $conn->error;
}
?>