<?php
include "db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['send_email'])) {
    $rec_email=$_POST['rec_email'];

    // Get company data from the database
    $sql = "SELECT * FROM compani";
    $result = mysqli_query($conn, $sql);


        // Create HTML table from the fetched data
        $tableHTML = "<table border='1' cellpadding='10' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Reg. Date</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            $counter = 1;
            $tableHTML .= "<tr>
                          <td>{$counter}</td>
                          <td>{$row['comp_name']}</td>
                          <td>{$row['phone']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['city']}</td>
                          <td>{$row['state']}</td>
                          <td>{$row['country']}</td>
                          <td>{$row['registration']}</td>
                          <td>{$row['expiry']}</td>
                          </tr>";
                          $counter++; // Increment the counter for each row
        }

        $tableHTML .= "</tbody></table>";

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->Username   = 'kamranzafar4343@gmail.com';                     //SMTP username
            $mail->Password   = 'kyyextswkvluofmm';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('kamranzafar4343@gmail.com', 'Kamran Zafar');
            $mail->addAddress($rec_email, '');     //Add a recipient



            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Company Table";
            $mail->Body    = "{$tableHTML}";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {

            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Send email</title>
    <style>
        .mb-3 {
            width: 500px;
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Enter recipient Information</h2>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3"><label for="email">Email receiver email:</label>
                        <input type="text" name="rec_email" id="email" class="form-control">
                    </div>

                    <input type="submit" name="send_email" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>