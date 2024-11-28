<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Price_Tracker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $product_url = $_POST["product_url"];
    $target_price = $_POST["target_price"];

    $stmt = $conn->prepare("INSERT INTO tracked_products (product_name, product_url, target_price) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssd", $product_name, $product_url, $target_price);

    if ($stmt->execute()) {
        $message = "Product added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1>Add Product</h1>
    </header>
    <div class="form-container">
        <form method="post" action="">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required>

            <label for="product_url">Product URL:</label>
            <input type="url" name="product_url" required>

            <label for="target_price">Target Price:</label>
            <input type="number" name="target_price" step="0.01" required>

            <button type="submit" class="btn">Add Product</button>
        </form>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
