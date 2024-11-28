<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include 'config/db.php';

$email = $_SESSION['email'];

// Get user name and email from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

//get order id from url
$order_no = $_GET['id'];


//get workorder_no
$workorder_no = $_GET['id'];

//get order details
$sql = "SELECT * FROM `orders` WHERE `order_no` = '$workorder_no'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row3 = $result->fetch_assoc();
    $order_no = $row3['order_no'];
    $creator = $row3['creator'];

    $comp_id_fk = $row3['comp_id_fk'];

    //get company name from compani table
    $compName = "SELECT * FROM compani WHERE comp_id = $comp_id_fk";
    $compNameResult = $conn->query($compName);
    if ($compNameResult && $compNameResult->num_rows > 0) {
        $row4 = $compNameResult->fetch_assoc();

        $comp_name = $row4['comp_name'];
    }

    $branch_id_fk = $row3['branch_id_fk'];

    //get branch name from branch table
    $branchName = "SELECT * FROM branches WHERE branch_id = $branch_id_fk";
    $branchNameResult = $conn->query($branchName);
    if ($branchNameResult && $branchNameResult->num_rows > 0) {
        $row5 = $branchNameResult->fetch_assoc();

        $branch_name = $row5['branch_name'];
    }

    $priority = $row3['priority'];
    $flag = $row3['flag'];
    $date = $row3['date'];
    $foc = $row3['foc'];
    $phone = $row3['foc_phone'];
    $pickup_add = $row3['pickup_address'];
    $object = $row3['object_code'];

    $barcode = $row3['barcode'];

    //show location of the barcode
    $location = "SELECT * FROM store WHERE box = '$barcode'";
    $locationResult = $conn->query($location);
    if ($locationResult && $locationResult->num_rows > 0) {
        $row6 = $locationResult->fetch_assoc();
        $rack_location = $row6['rack_select'];
    }

    //convert array into json
    // $raw_items = $row3['item_barcode'];
    // $json_items = json_encode($raw_items);

    // $alt = $row3['alt'];
    // $requestor = $row3['requestor'];
    // $role = $row3['role'];
    // $req_date = $row3['req_date'];
    // $description = $row3['description'];
    // $create_date = $row3['order_creation_date'];
    // $obj_type = $row3['obj_typ'];
    // $quant = $row3['quant'];
    // $supp_req = $row3['supp_requestor'];
    // $cost_center = $row3['cost_cent'];
    // $dateTime = $row3['dateTime'];
    // $comment = $row3['comment'];
} else {
    echo "No order found";
}

//handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rec_name = mysqli_real_escape_string($conn, $_POST['rec_name']);
    $rec_phone = mysqli_real_escape_string($conn, $_POST['rec_phone']);

    //---------------------------set image variable------------------------ and its validation
    //ensure file is uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
        die("No file was uploaded.");
    }

    // Check for maximum file size (5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    if ($_FILES['image']['size'] > $maxFileSize) {
        die("File size exceeds the 5 MB limit.");
    }

    // Check allowed MIME types
    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileType = $_FILES['image']['type'];
    if (!in_array($fileType, $allowedTypes)) {
        die("Invalid file type. Only JPEG and PNG files are allowed.");
    }

    // Check allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        die("Invalid file extension. Only .jpg, .jpeg, and .png files are allowed.");
    }

    // Sanitize and set the file name and destination
    $img_name = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES['image']['name']));
    $img_des = "image/" . $img_name;

    // Move the uploaded file to the destination directory
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $img_des)) {
        die("Failed to upload image.");
    }

    //------------------end---------------------------------- of image variable and its validation

    $rec_cnic = mysqli_real_escape_string($conn, $_POST['rec_cnic']);
    $any_detail = mysqli_real_escape_string($conn, $_POST['details']);
    $cross_check = mysqli_real_escape_string($conn, $_POST['checkbox1']);
    $verification = mysqli_real_escape_string($conn, $_POST['checkbox2']);


    //insert into db
    $insertData = "UPDATE assign_task SET receiver_name = '$rec_name', receiver_phone = '$rec_phone', receiver_cnic = '$rec_cnic', proof = '$img_des', any_comments ='$any_detail', cross_check='$cross_check', verification='$verification' WHERE order_no_fk = '$order_no'";

    if ($conn->query($insertData) === TRUE) {
        // update status to 1
        $updateStatus = "UPDATE assign_task SET is_read = '1' WHERE order_no_fk = '$order_no'";
    } else {
        echo "Error: " . $insertData . "<br>" . $conn->error;
    }

    if ($conn->query($updateStatus) === TRUE) {
        //set success message and redirect to tasks page
        $_SESSION['success'] = "Task Completed";
        header("Location: tasks.php");
    } else {
        echo "Error: " . $insertData . "<br>" . $conn->error;
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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

    <!--bootstrap search and select-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">

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

    <script src="https://code.jquery.com/jquery/3.7.1/jquery.min.js"></script>
    <!--choosen-js css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <!--choosen js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

    <!-- dselect -->
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

    <!-- ALERTIFY CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.rtl.min.css" />

    <style>
        /* form text sizing */
        .form-select {
            font-size: 0.8rem;
        }

        .form-control {
            font-size: 0.8rem;
        }


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

        .error {
            color: #FF0000;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>complete task</title>


</head>

<body>
    <!-- ======= Header ======= -->
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


    <!-- ======= Sidebar ======= -->

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Dashboard Link (Visible to all users) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="labour_index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link active" href="tasks.php">
                    <i class="bi bi-list-task"></i><span>Tasks</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->


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

    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
    </div>
    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <!-- <h5 class="card-title ml-4">Create Company </h5> -->
            <div class="card-body">
                <br>
                <!-- Multi Columns Form -->
                <form class="row g-3 needs-validation" action="" method="POST" enctype="multipart/form-data">
                    
                    <?php
                    //get data from`assign_tasks` table
                    $assign_tasks = "Select * FROM assign_task WHERE order_no_fk = '$order_no'";
                    $result_assign_tasks = $conn->query($assign_tasks);
                    if ($result_assign_tasks->num_rows > 0) {
                        $row121 = $result_assign_tasks->fetch_assoc();
                        $handover_to = $row121['handover_to'];
                        $admin_instructions = $row121['admin_instruction'];
                        $bank_instructions = $row121['bank_instruction'];
                        $box_location = $row121['location'];
                    } ?>

                    <div class="col-md-6">
                        <h4 class="mb-4 text-bg-success" style="padding: 8px;">Task Details</h4>
                        <div class="row-md-4">
                            <h6>Work Order No:<strong><?php echo "#" . $order_no ?> </strong></h6>
                            <hr>
                        </div>
                        <div class="row-md-4">
                            <h6><strong>Instructions by Client:</strong></h6>
                            <p> <?php echo $bank_instructions ?> </p>
                        </div>
                        <div class="row-md-4">
                            <h6><strong>Instructions by admin:</strong></h6>
                            <p> <?php echo $admin_instructions ?> </p>
                        </div>

                        <div class="row">
                            <!-- start table of delivery items -->
                            <div class="cardBranch recent-sales overflow-auto">
                                <div class="card-body">
                                    <?php
                                    //get data from`assign_tasks` table
                                    $assign_tasks = "Select * FROM assign_task WHERE order_no_fk = '$order_no'";
                                    $result_assign_tasks = $conn->query($assign_tasks);
                                    if ($result_assign_tasks->num_rows > 0) {
                                        $row121 = $result_assign_tasks->fetch_assoc();
                                        $handover_to = $row121['handover_to'];
                                    }
                                    $showOrders = "Select * FROM orders WHERE order_no = '$order_no'";
                                    $resultShowOrders = $conn->query($showOrders);

                                    // Check if there are any results
                                    if ($resultShowOrders->num_rows > 0) {

                                        // Display table
                                        echo '<table id="orderT" class="table mt-4 nowrap" style="font-size: 12px;">
                    <thead>
                        <tr >
                        <th scope="col" style="width: 6%;">Box</th>
                        <th scope="col" style="width: 7%;">Items</th>
                        <th scope="col" style="width: 9%;">Location</th>
                        <th scope="col" style="width: 15%;">Hand over to</th>';
                                        echo '</tr>
                    </thead>
                    <tbody>';

                                        // Loop through results
                                        while ($row = $resultShowOrders->fetch_assoc()) {
                                            echo '<tr>';

                                            echo '<td>';
                                            $barcodes = explode(',', $row['barcode']); // Split comma-separated values into an array
                                            echo '<ul style="list-style: none; margin-left: -30px;">'; // Start unordered list
                                            foreach ($barcodes as $barcode) {
                                                echo '<li>' . htmlspecialchars($barcode) . '</li>'; // Escape HTML for safety
                                            }
                                            echo '</ul>'; // End unordered list
                                            echo '</td>';

                                            echo '<td>';
                                            $item_barcodes = explode(',', $row['item_barcode']); // Split comma-separated values into an array
                                            echo '<ul style="list-style: none; margin-left: -30px;">'; // Start unordered list
                                            foreach ($item_barcodes as $item_barcode) {
                                                echo '<li>' . htmlspecialchars($item_barcode) . '</li>'; // Escape HTML for safety
                                            }
                                            echo '</ul>'; // End unordered list
                                            echo '</td>';


                                            echo '</ul>'; // End unordered list
                                            echo '</td>';


                                            echo '<td>' .
                                                $box_location.
                                                '</td>';


                                            echo '<td style="font-size: 11px;">' .
                                                $handover_to .
                                                '</td>';
                                        }
                                        echo '</tbody></table>';
                                    } else {
                                        // Display message if no results
                                        echo '<p>No items found.</p>';
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- start row -->
                        <!-- <div class="row">
                            <div class="col-md-3">
                                <h6><b>Box:</b></h6>

                                34234234

                            </div>
                            <div class="col-md-3">
                                <h6><b>Items:</b></h6>
                                <ul class="" style="font-size: 10px; text-align: left;">
                                    <li>11134234</li>
                                    <li>99234234</li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <h6><b>Location:</b></h6>
                                <p>L4-B-02-C-01</p>
                            </div>
                            <div class="col-md-3">
                                <h6><b>Handover to:</b></h6>
                                <p>Courier</p>
                            </div>
                        </div> -->

                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-4 text-bg-success" style="padding: 8px;">Fill the following details</h4>

                        <div class="row-md-4 mb-2">
                            <label for="" class="form-label"><b>Enter Receiver's information</b></label>
                            <input type="text" class="form-control mb-1" id="" name="rec_name" placeholder="Receiver's Name" required>
                            <input type="text" class="form-control mb-1" id="" name="rec_phone" placeholder="Receiver's Phone Number" required>
                            <input type="text" class="form-control mb-2" id="" name="rec_cnic" placeholder="Recevier's CNIC" required>
                        </div>

                        <div class="row-md-4 mb-2">
                            <label for="image" class="form-label" style="font-size: 0.8rem; margin-top: 7px;"><b>Attach (receipt image):</b></label>
                            <input type="file" style="font-size: 0.7rem; height: 1.9rem;" class="form-control" id="image" name="image" required accept=".jpg,.jpeg,.png" title="Only JPG, JPEG, and PNG formats are allowed">
                            <!-- Error messages -->
                            <div id="image-error" style="color:red; display:none;">Invalid image format. Only JPG, JPEG, and PNG formats are allowed.</div>
                            <div id="size-error" style="color:red; display:none;">File size exceeds 2 MB.</div>
                            <div id="dimension-error" style="color:red; display:none;">Image dimensions exceed the allowed 1024x768 size.</div>
                        </div>


                        <div class="row-md-4 mb-2">
                            <label for="" class="form-label" style="font-size: 0.8rem; margin-top: 7px;"><b>Anything else to note?</b></label><br>
                            <textarea name="details" class="form-control mb-1" id=""></textarea>
                        </div>

                        <div class="row-md-4 mb-2 ml-4">
                            <input class="form-check-input" style="font-size: 0.8rem; margin-top: 7px;" type="checkbox" value="1" name="checkbox1">
                            <label class="form-check-label" for="flexCheckDefault">
                                <strong>Cross checked</strong>
                            </label>
                        </div>
                        <div class="row-md-4 mb-2 ml-4">
                            <input class="form-check-input" style="font-size: 0.8rem; margin-top: 7px;" type="checkbox" value="1" name="checkbox2">
                            <label class="form-check-label" for="flexCheckDefault">
                                <strong>Verified information</strong>
                            </label>
                        </div>
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


    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    <!-- Updated JavaScript with proper lev2Select selection -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- ALERTIFY JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <?php
    if (isset($_SESSION['success'])):
    ?>
        <script>
            // Set Alertify to display notifications at the top of the page
            alertify.set('notifier', 'position', 'top-right');
            alertify.error("<?= $_SESSION['success']; ?>");
        </script>
    <?php
        //unset message after displaying it to the user
        unset($_SESSION['success']); // Clear the message
    endif;
    ?>

    <!-- Validation Script of the header and the size of the image -->
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

    <!--datatable export buttons-->
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
</body>


</html>