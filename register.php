<?php
session_start();

include 'config/db.php'; // Make sure your database connection is correct

if (isset($_POST['register'])) {
    // Get form data and sanitize inputs
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $role = mysqli_real_escape_string($conn, trim($_POST['role']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error_message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        // Check if the email is already registered
        $email_check_query = "SELECT * FROM register WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $email_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if email exists
            $error_message = "Email is already registered!";
        } else {
            // Store the plain password directly (not recommended for security reasons)
            $sql = "INSERT INTO register (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "Registration successful!";
                header('Location: pages-login.php'); // Redirect to login page after successful registration
                exit();
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
    $conn->close();
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- ALERTIFY CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.rtl.min.css" />

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
                                        <h5 class="card-title text-center pb-0 fs-4">Register a New Account</h5>
                                        <p class="text-center small">Enter your name, email, password, and select your role</p>
                                    </div>

                                    <form class="row g-3 needs-validation" method="POST" action="" novalidate>
                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Your Name</label>
                                            <input type="text" name="name" class="form-control" id="yourName" required>
                                            <div class="invalid-feedback">Please enter your name!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Your Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail" required>
                                            <div class="invalid-feedback">Please enter a valid email address!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required minlength="8">
                                            <div class="invalid-feedback">Please enter a password with at least 8 characters!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="">Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a role!</div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-outline-primary" type="submit" name="register" value="register">Register</button>
                                            <button class="btn btn-outline-secondary" type="reset">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Google reCAPTCHA -->
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