<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: pages-login.php");
    exit();
}

include 'config/db.php';

$email = $_SESSION['email'];

// Get user name and email from the register table
$getAdminData = "SELECT * FROM register WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";
$resultData = mysqli_query($conn, $getAdminData);

if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_id = mysqli_real_escape_string($conn, $_POST['company']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch']);
    $barcode = mysqli_real_escape_string($conn, $_POST['barcode']);
    $rec_date = mysqli_real_escape_string($conn, $_POST['rec_date']);
    $sender = mysqli_real_escape_string($conn, $_POST['sender']);
    $rec_via = mysqli_real_escape_string($conn, $_POST['rec_via']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Insert data into box table
    $sql = "INSERT INTO box (companiID_FK, branchID_FK, barcode, rec_date, sender, rec_via, status) 
            VALUES ('$company_id', '$branch_id', '$barcode', '$rec_date', '$sender', '$rec_via', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("location: createBox.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Handle AJAX request to check if barcode already exists
if (isset($_POST['checkBarcode']) && $_POST['checkBarcode'] == 'true') {
    $barcode = mysqli_real_escape_string($conn, $_POST['barcode']);
    $query = "SELECT * FROM `box` WHERE `barcode`='$barcode'";
    $result = mysqli_query($conn, $query);

    // If the barcode exists, return JSON response
    if ($result->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
    exit(); // Prevent further execution of the script
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

        .mt-5 {
            margin-top: 7rem !important;
            margin-left: -1rem;
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

        /*styles for form*/
        .card-body {
            padding: 0 20px 20px 20px;
            font-size: 0.8rem;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>add box</title>


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
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="Companies.php">
                    <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
                    <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="showItems.php">
                    <i class="ri-shopping-cart-line"></i><span>Items</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="order.php">
                    <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="racks.php">
                    <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="store.php">
                    <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>


            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
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
                <a class="nav-link collapsed" href="logout.php">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
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
    <div class="headerimg text-center">
    <img src="image/create.png" alt="network-logo" width="50" height="50">
    <h2>Add a box</h2>
</div>

<div class="container d-flex justify-content-center">
    <div class="card custom-card shadow-lg mt-3">
        <div class="card-body">
            <br>
            <form class="row g-3 needs-validation" action="" method="POST" id="boxForm">

                <div class="col-md-6">
                    <label class="form-label">Barcode</label>
                    <input type="text" class="form-control" name="barcode" id="box_barcode" required>
                    <div id="barcodeFeedback" class="invalid-feedback">
                        <!-- Error message will be displayed here -->
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="company">Select Company:</label>
                    <select id="company" class="form-select" name="company" required>
                        <option value=""> Select a Company </option>
                        <?php
                        $result = $conn->query("SELECT comp_id, comp_name FROM compani");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['comp_id']}'>{$row['comp_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="branch">Select a Branch:</label>
                    <select id="branch" class="form-select" name="branch" required>
                        <option value="">Select a Branch</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="rec_date">Receive date</label>
                    <input type="datetime-local" class="form-control" name="rec_date" id="rec_date" required>
                </div>

                <div class="col-md-6">
                    <label for="sender">Sender:</label>
                    <input type="text" class="form-control" name="sender" id="sender" pattern="[a-zA-Z\s]+"
                        title="Only alphabets and spaces are allowed" required>
                </div>

                <div class="col-md-6">
                    <label for="rec_via">Receive via:</label>
                    <select id="rec_via" class="form-select" name="rec_via" required>
                        <option value="">Select an option</option>
                        <option value="Self">Self</option>
                        <option value="Courier">Courier</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="status">Status:</label>
                    <select id="status" class="form-select" name="status" required>
                        <option value="">Select Status</option>
                        <option value="In" selected>In</option>
                    </select>
                </div>

                <div class="text-center mt-4 mb-2">
                    <button type="reset" class="btn btn-outline-info mr-1" onclick="window.location.href = 'Box.php';">Go back</button>
                    <button type="submit" class="btn btn-outline-primary mr-1" id="submitBtn">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" onclick="localStorage.clear()">Finalize</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Duplicate Barcode -->
<div class="modal fade" id="duplicateBarcodeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Duplicate Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                The barcode you entered already exists. Please use a different barcode.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('box_barcode').addEventListener('input', function() {
    let barcode = this.value;

    if (barcode.length === 7) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'createBox.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    // Show modal popup if barcode exists
                    let duplicateModal = new bootstrap.Modal(document.getElementById('duplicateBarcodeModal'));
                    duplicateModal.show();
                    document.getElementById('submitBtn').disabled = true; // Disable submit button
                } else {
                    document.getElementById('submitBtn').disabled = false; // Enable submit button
                }
            }
        };
        xhr.send('checkBarcode=true&barcode=' + barcode);
    } else {
        document.getElementById('submitBtn').disabled = false; // Enable submit button for other lengths
    }
});

</script>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script>
        $(document).ready(function() {
            // When company is changed, fetch the branches
            $('#company').change(function() {
                var company_id = $(this).val();

                // AJAX request to get branches for the selected company
                $.ajax({
                    url: 'get_branches.php',
                    type: 'POST',
                    data: {
                        company_id: company_id
                    },
                    success: function(response) {
                        try {
                            var branches = JSON.parse(response);
                            // Clear existing branches
                            $('#branch').empty();
                            $('#branch').append('<option value="">Select a Branch</option>');
                            // Add the new options from the response
                            $.each(branches, function(index, branch) {
                                $('#branch').append('<option value="' + branch.branch_id + '">' + branch.branch_name + '</option>');
                            });
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('company');
            const branchSelect = document.getElementById('branch');
            const boxSelect = document.getElementById('box');

            // Retrieve the previously selected company from localStorage
            const selectedCompany = localStorage.getItem('selectedCompany');
            if (selectedCompany) {
                companySelect.value = selectedCompany;
                loadBranches(selectedCompany); // Load branches based on the selected company
            }

            // Store the selected company in localStorage on change
            companySelect.addEventListener('change', function() {
                localStorage.setItem('selectedCompany', this.value);
                loadBranches(this.value); // Load branches based on the new selection
            });

            // Retrieve the previously selected branch from localStorage
            const selectedBranch = localStorage.getItem('selectedBranch');
            if (selectedBranch) {
                branchSelect.value = selectedBranch;
            }

            // Store the selected branch in localStorage on change
            branchSelect.addEventListener('change', function() {
                localStorage.setItem('selectedBranch', this.value);
                loadBoxes(this.value); // Load boxes based on the selected branch
            });

            // Retrieve the previously selected box from localStorage
            const selectedBox = localStorage.getItem('selectedBox');
            if (selectedBox) {
                boxSelect.value = selectedBox;
            }

            // Store the selected box in localStorage on change
            boxSelect.addEventListener('change', function() {
                localStorage.setItem('selectedBox', this.value);
            });


            // Function to load branches via AJAX
            function loadBranches(company_id) {
                $.ajax({
                    url: 'get_branches.php',
                    type: 'POST',
                    data: {
                        company_id: company_id
                    },
                    success: function(response) {
                        try {
                            const branches = JSON.parse(response);
                            branchSelect.innerHTML = '<option value="">Select a Branch</option>';
                            branches.forEach(function(branch) {
                                branchSelect.innerHTML += `<option value="${branch.branch_id}">${branch.branch_name}</option>`;
                            });

                            // Set previously selected branch again, if available
                            const selectedBranch = localStorage.getItem('selectedBranch');
                            if (selectedBranch) {
                                branchSelect.value = selectedBranch;
                            }
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            }

        });

        //another function gets previous values of the sender, rec_via, rec_date
        $(document).ready(function() {
            // Utility function to safely set the value of an input field
            function setInputValue(id, value) {
                var element = document.getElementById(id);
                if (element) {
                    element.value = value;
                }
            }

            // Retrieve the previously submitted form data from localStorage
            const recDate = localStorage.getItem('rec_date');
            const sender = localStorage.getItem('sender');
            const recVia = localStorage.getItem('rec_via');

            // Safely set the values if they exist in localStorage
            if (recDate) {
                setInputValue('rec_date', recDate);
            }

            if (sender) {
                setInputValue('sender', sender);
            }

            if (recVia) {
                setInputValue('rec_via', recVia);
            }

            // Store the values in localStorage when the user changes input
            $('#rec_date').on('input', function() {
                localStorage.setItem('rec_date', $(this).val());
            });

            $('#sender').on('input', function() {
                localStorage.setItem('sender', $(this).val());
            });

            $('#rec_via').on('change', function() {
                localStorage.setItem('rec_via', $(this).val());
            });
        });
    </script>

    <!--corrected jquery version-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js">
    </script>
    <!-- Bootstrap JS (Optional)
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/z1gk35k1RA6QQg+SjaK6MjpS3TdeL1h1jDdED5+ZIIbsSdyX/twQvKZq5uY15B" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9BfDxO4v5a9J9TZz1ck8vTAvO8ue+zjqBd5l3eUe8n5EM14ZlXyI4nN" crossorigin="anonymous"></script>
 -->

    <!-- <script>
            const dataTable = new simpleDatatables.DataTable("#myTable2", {
                searchable: false,
                fixedHeight: true,
            })
        </script> -->
    <script src="assets/js/main.js"></script>
</body>

</html>