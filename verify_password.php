<?php
session_start();
header('Content-Type: application/json');

// Simulate fetching hashed password from database
$adminPasswordHash = '123456';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
$adminPassword = $data['adminPassword'];

// Verify password (replace this with actual verification logic)
if (password_verify($adminPassword, $adminPasswordHash)) {
  // Fetch hashed password for the company from database
  $companyId = $data['companyId'];
  // For demonstration, we use a static value
  $hashedPassword = '123456';

  echo json_encode(['success' => true, 'hashedPassword' => $hashedPassword]);
} else {
  echo json_encode(['success' => false]);
}
?>
