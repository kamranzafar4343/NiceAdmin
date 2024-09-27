<?php
//include db
include 'config/db.php';

if (isset($_POST['requestor_name'])){

    //get requestor_name from ajax
    $requestor_name = mysqli_real_escape_string($conn, $_POST['requestor_name']);
    $branch_id = mysqli_real_escape_string($conn,$_POST['branch_id']);

    //check use auth_status
    $sql= "SELECT * FROM `employee` where `name`='$requestor_name' AND `auth_status`=  'Authorized' AND branch_FK_emp = '$branch_id'";
    $result = $conn->query($sql);

     // Log the values being checked
     error_log("Requestor Name: " . $requestor_name);
     error_log("Branch ID: " . $branch_id);

    if($result->num_rows>0){
        echo 'user exist and verified';
    }
    else{
        echo'not';
    }
}
?>