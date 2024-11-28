If you don’t want to use a form and instead need a simple **download button** that fetches and downloads a file directly, you can achieve this using just a button (or a clickable link). Here's how:

---

### **Implementation Without a Form**

#### 1. **HTML Button**
You can create a clickable button that sends the `file_id` as a parameter in the URL to a PHP script.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Button</title>
</head>
<body>
    <h1>Download Attachment</h1>
    <?php
    // Fetch files from the database
    $conn = new mysqli('localhost', 'root', '', 'your_database');
    $result = $conn->query("SELECT id, file_name FROM attachments");

    while ($row = $result->fetch_assoc()) {
        echo "<button onclick=\"window.location.href='download.php?file_id=" . $row['id'] . "'\">" . $row['file_name'] . "</button><br><br>";
    }

    $conn->close();
    ?>
</body>
</html>
```

---

#### 2. **Download Script (`download.php`)**
This PHP script retrieves the file details from the database and serves it to the user for download:

```php
<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'your_database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['file_id'])) {
    $fileId = intval($_GET['file_id']);

    // Fetch file details from the database
    $query = $conn->prepare("SELECT file_name, file_path FROM attachments WHERE id = ?");
    $query->bind_param("i", $fileId);
    $query->execute();
    $query->store_result();
    $query->bind_result($fileName, $filePath);
    $query->fetch();

    if ($filePath && file_exists($filePath)) {
        // Force the file to download
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: " . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File does not exist.";
    }

    $query->close();
} else {
    echo "No file selected.";
}

$conn->close();
?>
```

---

### **How It Works**

1. **HTML Buttons**:
   - The HTML page dynamically creates buttons for each file stored in the database.
   - Each button has an `onclick` attribute that redirects to the `download.php` script with the file ID as a parameter (e.g., `download.php?file_id=1`).

2. **Download Script**:
   - The `download.php` script fetches the file path from the database using the `file_id` parameter.
   - If the file exists on the server, the script sends the file to the browser for download.

---

### **Example Output**
On the HTML page, you’ll see buttons like this:
```
[example_image.jpg]   (button)
[document.pdf]        (button)
```

Clicking the button downloads the corresponding file.

---

### **Simplified Version Without Database**
If you don’t need a database and want to serve a fixed file, here’s a simpler version:

#### HTML:
```html
<button onclick="window.location.href='download.php?file=example_image.jpg'">Download File</button>
```

#### PHP (`download.php`):
```php
<?php
if (isset($_GET['file'])) {
    $fileName = $_GET['file'];
    $filePath = "uploads/" . $fileName;

    if (file_exists($filePath)) {
        // Serve the file
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: " . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File does not exist.";
    }
} else {
    echo "No file specified.";
}
?>
```

---

### Benefits of This Approach
- **No Form Needed**: Downloads happen directly from button clicks.
- **Dynamic File Loading**: Works with databases to serve multiple files.
- **User-Friendly**: Simple and clean interface for file downloads.

Let me know if you need further assistance!