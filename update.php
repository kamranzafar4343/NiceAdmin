<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .img {
            border-radius: 30%;
        }
    </style>
</head>

<body>
    <?php
    include "db.php";
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $sql = "SELECT * FROM `compani` WHERE `comp_id`='$user_id'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        $comp_name = $row['comp_name'];
        $phone = $row['phone'];
        $email = $row['email'];
        $password = $row['password'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $registration = $row['registration'];
        $expiry = $row['expiry'];
    }

    if (isset($_POST['update'])) {
        $user_id = $_POST['comp_id'];
        $comp_name = mysqli_real_escape_string($conn, $_POST['comp_name']);
        $phone =  mysqli_real_escape_string($conn, $_POST['phone']);
        $email =  mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $registration = mysqli_real_escape_string($conn, $_POST['registration']);
        $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);

        $sql = "UPDATE `compani` SET `comp_name`='$comp_name', `phone`='$phone', `email`='$email', `password`='$password', `city`='$city', `state`='$state', `country`='$country', `registration`='$registration', `expiry`='$expiry'  WHERE `comp_id`='$user_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully.";
            header("location:tables-data.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    ?>

    <section class="container my-2 w-50 p-2">
        <form class="row g-3 p-3" action="" method="POST" enctype="multipart/form-data">
            <h1>Update Company</h1>
            <div class="col-md-6">
                <label class="form-label">Company name</label>
                <input type="text" class="form-control" value="<?php echo $comp_name; ?>" name="comp_name" required>
                <input type="hidden" name="comp_id" placeholder="" value="<?php echo $user_id; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" value="<?php echo $phone; ?>" class="form-control" name="phone" required>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" value="<?php echo $email; ?>" class="form-control" id="inputEmail4" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" value="<?php echo $password; ?>" class="form-control" id="inputPassword4" name="password">
            </div>

            <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" value="<?php echo $city; ?>" class="form-control" id="inputEmail4" name="city" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">State</label>
                <input type="text" value="<?php echo $state; ?>" class="form-control" id="inputEmail4" name="state" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Country</label>
                <input type="text" value="<?php echo $country; ?>" class="form-control" id="inputEmail4" name="country" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Registration date</label>
                <input type="date" class="form-control" value="<?php echo $registration; ?>" name="registration" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Expiry date</label>
                <input type="date" class="form-control" value="<?php echo $expiry; ?>" name="expiry"  required>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="update" value="update">update</button>
            </div>
        </form>
    </section>


</body>

</html>
<?php





?>

<?php
//} else {
//      echo "No record found for the given ID.";
// }
//}
?>