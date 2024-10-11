<?php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

// Include the database connection
include 'config/db.php';

// Get session email 
$email = $_SESSION['email'];

// Get user name, email, and role from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
    $userRole = $row2['role']; // Assuming you have a 'role' column in the 'register' table
}

// Check if the user is an admin, otherwise redirect
if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
    // If the user is not an Admin, redirect to index page
    header("Location: index.php");
    exit();
}


if (isset($_POST['submit'])) {
    $acc_1 = mysqli_real_escape_string($conn, $_POST['acc_level_no']);
    $acc_desc = mysqli_real_escape_string($conn, $_POST['account_desc']);
    $registration = mysqli_real_escape_string($conn, $_POST['registration']);
    $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);
    $foc = mysqli_real_escape_string($conn, $_POST['foc']);
    $foc_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
    $address2 = mysqli_real_escape_string($conn, $_POST['address2']);

    // Insert the record into the database
    $sql = "INSERT INTO `compani` (`acc_lev_1`, `acc_desc`, `registration`, `expiry`, `foc`, `foc_phone`, `add_1`, `add_2`, `add_3`) 
            VALUES ('$acc_1', '$acc_desc', '$registration', '$expiry', '$foc', '$foc_phone', '$address', '$address1', '$address2')";

    $result = $conn->query($sql);

    if ($result === true) {
        header("Location: Companies.php");
        exit();
    } else {
        echo 'error';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <style>
        /* Custom CSS to decrease font size of the table */
        .custom {
            font-size: 0.9rem;
            /* Adjust as needed */
            font-family: monospace;
        }

        .company-name {
            font-size: 1rem;
        }

        .company-title {
            font-size: 1.1rem;
        }

        .burger {
            left: -10px;
            top: -20px;
        }

        .headerimg {
            margin-top: 100px;
            margin-left: 260px;
        }

        .custom-header {
            background-color: white;
            /* Light gray background */
            color: #343a40;
            /* Dark text color */
            font-weight: bold;
            /* Bold text */
            text-align: center;
            /* Center align text */
            padding: 14px;
            /* Bottom border */
            margin-left: 19px;
        }


        /*styles for form*/
        .card-body {
            padding: 0 20px 20px 20px;
            font-size: 0.8rem;
        }

        .form-control[type=file]:not(:disabled):not([readonly]) {
            cursor: pointer;
            font-size: 0.8rem;

        }

        input[type=date].form-control {
            appearance: none;
            font-size: 0.8rem;
        }

        @media (min-width: 1200px) {

            .h2,
            h2 {
                font-size: 1.5rem;
            }
        }

        /* Define the pulse animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Define the click animation */
        @keyframes clickEffect {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .company-name {
            color: #000;
            text-decoration: none;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .company-name:hover {
            color: #007bff;
            /* Change color on hover */
            animation: pulse 10s ease-in-out;
            /* Apply the pulse animation on hover */
        }

        .company-name:active {
            animation: clickEffect 0.s ease;
            /* Apply the click effect animation on click */
            color: #0056b3;
            /* Darken color on click */
        }

        * {
            margin: 0;

            padding: 0;

            box-sizing: border-box;
        }

        .custom-card {
            width: 100%;
            margin-top: 64px;
            margin-left: 290px;
            box-shadow: none;

            border: none;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Register Company</title>


</head>

<body> <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <img class="navbar-image" src="assets/img/logo3.png" alt="">
            <a href="index.php" class="logo d-flex align-items-center">

                <span class="d-none d-lg-block">FingerLog</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <!-- 
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>
    End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->


                <li class="nav-item profileimage dropdown pe-3 mr-4">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="image/admin-png.png" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $adminName ?></span>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $adminName ?></h6>
                            <span><?php echo $adminEmail ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </li>

            </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->


    <?php
    include "config/db.php";

    $role = $_SESSION['role'];
    ?>

    <!-- ======= Sidebar ======= -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Dashboard Link (Visible to all users) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <!-- Admin-only Links -->
                <li class="nav-item">
                    <a class="nav-link active" href="Companies.php">
                        <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Companies Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="showItems.php">
                        <i class="ri-shopping-cart-line"></i><span>Items</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Items Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="order.php">
                        <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Work Orders Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->

            <?php } else { ?>
                <!-- User-only Links -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="showItems.php">
                        <i class="ri-shopping-cart-line"></i><span>Items</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Items Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="order.php">
                        <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Work Orders Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->
            <?php } ?>


            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                    <i class="bi bi-person"></i><span>Profile</span>
                </a>
            </li><!-- End Profile Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.php">
                    <i class="bi bi-box-arrow-right"></i><span>Login</span>
                </a>
            </li><!-- End Login Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="logout.php">
                    <i class="bi bi-box-arrow-left"></i><span>Logout</span>
                </a>
            </li><!-- End Logout Nav -->

        </ul>
    </aside>
    <!--------------- End sidebar ------------------>


    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <img src="image/create.png" alt="network-logo" width="50" height="50">
        <h2>Create Account</h2>
    </div>
    <!-- End Header form -->
    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <!-- <h5 class="card-title ml-4">Create Company </h5> -->
            <div class="card-body">
                <br>
                <!-- Multi Columns Form -->
                <form class="row g-3 needs-validation" action="" method="POST">
                    <div class="col-md-6">
                        <label for="comp_acc_level" class="form-label">Acc-Lev-1</label>
                        <input type="text" class="form-control" id="account_lev_no" name="acc_level_no" required>
                    </div>

                    <div class="col-md-6">
                        <label for="account_description" class="form-label">Account Description</label>
                        <textarea type="text" class="form-control" id="acc_desc" name="account_desc" rows="1" columns="20"></textarea>
                    </div>


                    <div class="col-md-6">
                        <label for="registration" class="form-label">Setup Date</label>
                        <input type="date" class="form-control" id="registration" name="registration" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="expiry" class="form-label">Conract Exp_Date</label>
                        <input type="date" class="form-control" id="expiry" name="expiry">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Contact Person</label>
                        <input type="text" class="form-control" id="" name="foc" required pattern="[A-Za-z\s\.]+" required minlength="3" maxlength="38" title="only letters allowed; at least 3" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="" name="foc_phone" required>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Fax</label>
                        <input type="text" class="form-control" id="" name="foc_fax">
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="" name="address" required>
                        <br>
                        <input type="text" class="form-control" id="" name="address1">
                        <br>
                        <input type="text" class="form-control" id="" name="address2">

                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-2" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary ">Reset</button>
                    </div>
                </form>
                <!------------------------  Form end ---------------------->

            </div>
        </div>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js">
    </script>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/z1gk35k1RA6QQg+SjaK6MjpS3TdeL1h1jDdED5+ZIIbsSdyX/twQvKZq5uY15B" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9BfDxO4v5a9J9TZz1ck8vTAvO8ue+zjqBd5l3eUe8n5EM14ZlXyI4nN" crossorigin="anonymous"></script>
    <!-- Template Main JS File -->



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countryStateCityData = {
                Pakistan: {
                    Punjab: ["Lahore", "Faisalabad", "Rawalpindi", "Multan", "Gujranwala", "Okara", "Pattoki", "Sialkot", "Sargodha", "Bahawalpur", "Jhang", "Sheikhupura"],
                    KPK: ["Peshawar", "Mardan", "Mingora", "Abbottabad", "Mansehra", "Kohat", "Dera Ismail Khan"],
                    Sindh: ["Karachi", "Hyderabad", "Sukkur", "Larkana", "Nawabshah", "Mirpur Khas", "Shikarpur", "Jacobabad"],
                    Balochistan: ["Quetta", "Gwadar", "Turbat", "Sibi", "Khuzdar", "Zhob"],

                },
                USA: {
                    California: ["Los Angeles", "San Francisco", "San Diego"],
                    Texas: ["Houston", "Austin", "Dallas"]
                    // Add more states and cities
                },
                Canada: {
                    Ontario: ["Toronto", "Ottawa", "Hamilton"],
                    Quebec: ["Montreal", "Quebec City"]
                    // Add more provinces and cities
                },
            };

            const countrySelect = document.getElementById('country');
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            // Update states dropdown when a country is selected
            countrySelect.addEventListener('change', function() {
                const selectedCountry = countrySelect.value;
                stateSelect.innerHTML = '<option value="">Select State</option>'; // Reset states
                citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

                if (selectedCountry) {
                    const states = Object.keys(countryStateCityData[selectedCountry]);
                    states.forEach(function(state) {
                        const option = document.createElement('option');
                        option.value = state;
                        option.text = state;
                        stateSelect.add(option);
                    });
                }
            });

            // Update cities dropdown when a state is selected
            stateSelect.addEventListener('change', function() {
                const selectedCountry = countrySelect.value;
                const selectedState = stateSelect.value;
                citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

                if (selectedCountry && selectedState) {
                    const cities = countryStateCityData[selectedCountry][selectedState];
                    cities.forEach(function(city) {
                        const option = document.createElement('option');
                        option.value = city;
                        option.text = city;
                        citySelect.add(option);
                    });
                }
            });
        });
    </script>
    <script>
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            const imageError = document.getElementById('image-error');
            const sizeError = document.getElementById('size-error');
            const dimensionError = document.getElementById('dimension-error');

            // Reset error messages
            imageError.style.display = 'none';
            sizeError.style.display = 'none';
            dimensionError.style.display = 'none';

            if (file) {
                const reader = new FileReader();

                // Validate file size (2 MB limit)
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    sizeError.style.display = 'block';
                    this.value = ''; // Clear the file input
                    return;
                }

                // Validate file header (magic number)
                reader.onload = function(e) {
                    const header = new Uint8Array(e.target.result).subarray(0, 4);
                    let valid = false;

                    const jpg = header[0] === 0xFF && header[1] === 0xD8 && header[2] === 0xFF;
                    const png = header[0] === 0x89 && header[1] === 0x50 && header[2] === 0x4E && header[3] === 0x47;

                    if (jpg || png) {
                        valid = true;
                    }

                    if (!valid) {
                        imageError.style.display = 'block';
                        document.getElementById('image').value = ''; // Clear the file input
                        return;
                    } else {
                        imageError.style.display = 'none';

                        // Validate image dimensions
                        const img = new Image();
                        img.src = URL.createObjectURL(file);

                        img.onload = function() {
                            const maxWidth = 1024; // Example standard width
                            const maxHeight = 768; // Example standard height

                            if (img.width > maxWidth || img.height > maxHeight) {
                                dimensionError.style.display = 'block';
                                document.getElementById('image').value = ''; // Clear the file input
                            } else {
                                dimensionError.style.display = 'none';
                            }
                        };
                    }
                };

                reader.readAsArrayBuffer(file);
            }
        });
    </script>
    <!-- Validation Script of the header and the size of the image -->
    <script>
        const dataTable = new simpleDatatables.DataTable("#myTable2", {
            searchable: false,
            fixedHeight: true,
        })
    </script>
    <script>
        //prevent resubmission on refresh
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>