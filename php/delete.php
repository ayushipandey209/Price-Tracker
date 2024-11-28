<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Price_Tracker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $sql = "DELETE FROM tracked_products WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Product deleted successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tracked_products";
$result = $conn->query($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1>Delete Product</h1>
    </header>
    <div class="form-container">
        <form method="post" action="">
            <label for="id">Select Product:</label>
            <select name="id" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['product_name']} (ID: {$row['id']})</option>";
                    }
                } else {
                    echo "<option disabled>No products available</option>";
                }
                ?>
            </select>

            <button type="submit" class="btn">Delete Product</button>
        </form>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
    </div>
</body>
</html>