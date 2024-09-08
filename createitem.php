<?php

// session_start(); // Start the session
session_start();

session_regenerate_id(true); // This will regenerate the session ID and delete the old one
ini_set('session.cookie_secure', '1'); // Only send cookies over HTTPS
ini_set('session.cookie_httponly', '1'); // Prevent access to cookies via JavaScript (mitigates XSS)
ini_set('session.cookie_samesite', 'Strict'); // Prevent CSRF attacks by restricting cross-site cookie sharing


// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

// Retrieve company ID from URL
$branch = isset($_GET['id']) ? intval($_GET['id']) : 0;

include "db.php";

// Validate company ID
$Query = "SELECT * FROM item WHERE branch_FK_item = $branch";
$Result = $conn->query($Query);

$comp_FK_item = "";
$box_FK_item = "";
$branch_FK_item = "";
$item_id = "";

if ($Result->num_rows > 0) {
    $row2 = $Result->fetch_assoc();
    $comp_FK_item = $row2['comp_FK_item'];
    $box_FK_item = $row2['box_FK_item'];
    $branch_FK_item = $row2['branch_FK_item'];
    $item_id = $row2['item_id'];
    //   $item_id=$row2['item_id'];
}

if (isset($_POST['submit'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_price = mysqli_real_escape_string($conn, $_POST['item_price']);
    $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);

    $company_FK_item = mysqli_real_escape_string($conn, $_POST['comp_FK_item']);
    $box_FK_item = mysqli_real_escape_string($conn, $_POST['box_FK_item']);
    $barcode = mysqli_real_escape_string($conn, $_POST['barcode']);

    $branch_FK_item = mysqli_real_escape_string($conn, $_POST['branch_FK_item']);
    //   $timestamp = mysqli_real_escape_string($conn, $_POST['timestamp']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO  item (comp_FK_item, box_FK_item, branch_FK_item, item_name, item_price, item_quantity, status, barcode) 
            VALUES ('$company_FK_item', '$box_FK_item',  '$branch_FK_item' ,'$item_name', '$item_price', '$item_quantity' ,'$status', '$barcode')";

    if ($conn->query($sql) === TRUE) {
        // header("Location: showItems.php?id=" .$company_id);
        // exit; // Ensure script ends after redirect

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //   $sql2 = "SELECT comp_FK_item, box_FK_item, branch_FK_item FROM item WHERE comp_FK_item= $company_id";
    //   $result2 = $conn->query($sql2);

    //   $comp_FK_item="";
    //   $box_FK_item="";
    //   $branch_FK_item="";

    //   if ($result2->num_rows > 0){
    //       $row2 = $result2->fetch_assoc();
    //       $comp_FK_item = $row2['comp_FK_item'];
    //       $box_FK_item = $row2['box_FK_item'];
    //       $branch_FK_item = $row2['branch_FK_item'];
    //   }
}
$conn->close();
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

    <title>create item</title>


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
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->


    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="Companies.php">
                    <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Tables Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.html">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>
            <!-- End Profile Page Nav -->



            <!-- <li class="nav-item">
    <a class="nav-link collapsed" href="pages-register.php">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li> -->

            <!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li><!-- End Login Page Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-contact.php">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li><!-- End Contact Page Nav -->

        </ul>

    </aside>


    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <img src="image/create.png" alt="network-logo" width="50" height="50">
        <h2>Add an item</h2>
    </div>
    <!-- End Header form -->
    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <!-- <h5 class="card-title ml-4">Create Company </h5> -->
            <div class="card-body">
                <br>
                <!-- Multi Columns Form -->
                <form class="row g-3 needs-validation" action="" method="POST" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="comp_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="item_name" required pattern="[A-Za-z\s\.]+" required minlength="3" maxlength="38" title="only letters allowed; at least 3">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Item price</label>
                        <input type="text" class="form-control" name="item_price" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Item quantity</label>
                        <input type="text" class="form-control" name="item_quantity" required>
                    </div>

                    <div class="col-md-6" style="display: none;">
                        <label class="form-label">Company ID</label>
                        <input type="text" class="form-control" name="comp_FK_item" value="<?php echo ($company_id); ?>" readonly>
                    </div>

                    <div class="col-md-6" style="display: none;">
                        <label class="form-label">Branch Id</label>
                        <input type="text" class="form-control" name="branch_FK_item" value="<?php echo ($branch_FK_item); ?>" readonly>
                    </div>

                    <div class="col-md-6" style="display: none;">
                        <label class="form-label">Box Id</label>
                        <input type="text" class="form-control" name="box_FK_item" value="<?php echo ($box_FK_item); ?>" readonly>
                    </div>
                    <!-- <div class="col-md-6">
                        <label class="form-label">Item Id</label>
                        <input type="text" class="form-control" name="item_id" value="<?php echo ($item_id); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                    <?php date_default_timezone_set('Asia/Karachi'); ?>
                        <label for="" class="form-label">Created at</label>
                        <input type="datetime-local" class="form-control" id="timestamp" name="timestamp" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
                    </div> -->

                    <div class="col-md-6">
                        <label for="status" class="form-label">Item Condition</label>
                        <select class="form-select" id="status" name="status">
                            <option value="New">New</option>
                            <option value="Second Hand">Second Hand</option>
                            <option value="Damaged">Damaged</option>
                            <option value="Defective">Defective</option>
                            <option value="Used - Good">Used - Good</option>
                            <option value="Used - Acceptable">Used - Acceptable</option>
                        </select>
                    </div>
       
                    <div class="col-md-6" >
                        <label class="form-label">Barcode</label>
                        <input type="text" class="form-control" name="barcode" >
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
        const dataTable = new simpleDatatables.DataTable("#myTable2", {
            searchable: false,
            fixedHeight: true,
        })
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>