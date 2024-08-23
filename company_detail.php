<?php
include 'db.php';
$company = null;
$branches = [];

if (isset($_GET['id'])) {
    $company_id = $_GET['id'];

    // Fetch company details
    $sql = "SELECT * FROM compani WHERE comp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $company_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $company = $result->fetch_assoc();
    } else {
        echo "Error executing company query: " . $stmt->error;
    }

    // Fetch branches of the company
    $sql = "SELECT * FROM branch WHERE compID_FK = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $company_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $branches[] = $row;
        }
    } else {
        echo "Error executing branch query: " . $stmt->error;
    }

}

if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    echo "Error executing query: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Company Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* #branchIcon {
            height: 30px;
            width: 30px;
            margin-left: 5px;
            
        }
        #companyText{
        font-size: 20px;
        } */
        .compImage{
            border: 1px solid white;
            padding: 2px;
            
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="mb-3">
            <br>
            <img class="compImage" src="<?php echo $company['image']; ?>" alt="Company Image" width="75" height="75">
        </div>
        <br>
        <h4>List of Branches</h4>
        

       </div>
       <br>

    <table class="table table-bordered container">
            <thead class="">
                <tr>
                    <th>Company ID</th>
                    <th>branch id</th>
                    <th>Contact person name</th>
                    <th>contact person resignation</th>
                    <th>phone</th>
                    <th>city</th>
                    <th>state</th>
                    <th>country</th>
                    <th>action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if ($result-> num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['compID_FK']; ?></td>
                            <td><?php echo $row['branch_id']; ?></td>
                            <td><?php echo $row['ContactPersonName']; ?></td>
                            <td><?php echo $row['ContactPersonResignation']; ?></td>
                            <td><?php echo $row['ContactPersonPhone']; ?></td>
                            <td><?php echo $row['City']; ?></td>
                            <td><?php echo $row['State']; ?></td>
                            <td><?php echo $row['Country']; ?></td>
                            
                            <td>
                                <a class="btn btn-danger" href="branchDelete.php?id=<?php echo $row['compID_FK']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>


  
</body>

</html>