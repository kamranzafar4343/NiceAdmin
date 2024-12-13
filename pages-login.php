<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Get user input and escape for security
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);
  $login_type = $conn->real_escape_string($_POST['role']);

  // Query to check if the email and password are correct and retrieve the role
  $result = $conn->query("SELECT * FROM register WHERE email='$email' AND password='$password' AND role='$login_type'");

  // If a match is found, set session and redirect based on role
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Set session variables
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $user['role'];  // Store the role (admin or user)
    $_SESSION['id'] = $user['id'];  // Store the name of the user
    $_SESSION['name'] = $user['name'];  // Store the name of the user

    // Redirect to index.php
    header("Location: index.php");
    exit();
  } else {
    // Error message for invalid login
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

  <!-- Favicons -->
  <link href="assets/img/dtl.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- ALERTIFY CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.rtl.min.css" />
  <!-- google recaptcha -->

  <style>
    .w-100 {
      margin-left: 122px;
      width: 100% !important;
    }

    .py-4 {
      padding-top: 1.5rem !important;
      padding-bottom: 0rem !important;
    }

    .logo img {
      max-height: 78px !important;
      margin-right: -14px !important;
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
                  <img src="assets/img/dtl.png" alt="">
                  <span class="d-none d-lg-block"></span>
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
                      <input type="email" name="email" class="form-control" id="yourEmail" placeholder="Enter your Email" style="font-size: 13px;" required>
                      <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" placeholder="........" style="font-size: 13px;" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="" class="mb-2">Login Type:</label>
                      <select id="" class="form-select" name="role" style="font-size: 13px;" required>
                        <option value="">Select</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="Labour">Warehouse Staff</option>
                      </select>
                    </div>

                    <div class="col-8 d-flex mt-3">
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

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- ALERTIFY JavaScript -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

  <?php if (!empty($error_message)): ?>
    <script>
      // Set Alertify to display notifications at the top of the page
      alertify.set('notifier', 'position', 'top-center');
      alertify.error("<?= $error_message ?>");
    </script>
  <?php endif; ?>

</body>

</html>