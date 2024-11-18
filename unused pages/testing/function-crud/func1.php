<?php
// Database connection (replace with your own connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catmarketing";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$name = '';
$email = '';
$action = 'add'; // Default action is 'add'

// Check if editing (if user_id is passed)
if ($user_id) {
    // Fetch user data for editing
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $email = $user['email'];
        $action = 'edit'; // Change action to 'edit'
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form submission handler (add or edit)
    $name = $_POST['name'];
    $email = $_POST['email'];

    if ($_POST['action'] == 'add') {
        // Insert new user
        $sql = "INSERT INTO employees (name, email) VALUES ('$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "New user added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($_POST['action'] == 'edit' && isset($_POST['user_id'])) {
        // Update existing user
        $sql = "UPDATE employees SET name = '$name', email = '$email' WHERE id = {$_POST['user_id']}";
        if ($conn->query($sql) === TRUE) {
            echo "User updated successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!-- HTML Form for Add/Edit -->
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $action == 'add' ? 'Add User' : 'Edit User'; ?></title>
</head>
<body>

<h2><?php echo $action == 'add' ? 'Add New User' : 'Edit User'; ?></h2>

<form method="post" action="">
    <input type="hidden" name="action" value="<?php echo $action; ?>">
    
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>
    
    <input type="submit" value="<?php echo $action == 'add' ? 'Add User' : 'Update User'; ?>">
</form>

</body>
</html>
