<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get the user input and escape it for security
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);

  // Query to check if the email and password are correct
  $result = $conn->query("SELECT * FROM register WHERE email='$email' AND password='$password'");

  // If a match is found, set the session
  if ($result->num_rows > 0) {
    $_SESSION['email'] = $email; // Set session variable
    header("Location: index.php"); // Redirect to the dashboard or home page
    exit();
  } else {
    // Store the error message in a variable to use in the HTML
    $error_message = "Invalid email or password!";
  }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- ALERTIFY CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.rtl.min.css"/>

  <style>
    .w-100 {
      margin-left: 122px;
      width: 100% !important;
    }
  </style>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo3.png" alt="">
                  <span class="d-none d-lg-block">FingerLog</span>
                </a>
              </div>

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password</p>
                  </div>

                  <form class="row g-3 needs-validation" method="POST" action="">
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-6 d-flex">
                      <button class="btn btn-outline-primary w-100" type="submit" name="submit" value="submit">Login</button>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>
    </div>
    </section>
  </main>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- ALERTIFY JavaScript -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

  <!-- Display Alertify Pop-up at the Top of the Page -->
  <?php if (!empty($error_message)): ?>
    <script>
      // Set Alertify to display notifications at the top of the page
      alertify.set('notifier','position', 'top-center');
      alertify.error("<?= $error_message ?>");
    </script>
  <?php endif; ?>

</body>

</html>
