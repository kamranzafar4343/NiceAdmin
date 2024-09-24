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

// Get company ID from employee data
$emp_sql = "SELECT comp_FK_emp FROM employee WHERE emp_id = $emp_id";
$result_emp = $conn->query($emp_sql);
$emp_data = $result_emp->fetch_assoc();
$company_id = $emp_data['comp_FK_emp'];

// Delete employee data
$delete_sql = "DELETE FROM employee WHERE emp_id = $emp_id";

if ($conn->query($delete_sql) === TRUE) {
  header("Location: CompanyInfo.php?id=$company_id");
  exit();
} else {
  echo "Error deleting employee: " . $conn->error;
}
?>