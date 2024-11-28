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
    $id = $_POST["id"];
    $current_price = $_POST["current_price"];
    $last_checked = date("Y-m-d H:i:s");

    $sql = "UPDATE tracked_products 
            SET current_price = '$current_price', last_checked = '$last_checked' 
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Price updated successfully.";
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
    <title>Update Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1>Update Product</h1>
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

            <label for="current_price">Current Price:</label>
            <input type="number" name="current_price" step="0.01" required>

            <button type="submit" class="btn">Update Price</button>
        </form>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <a href="dashboard.php" class="btn back-btn">Back to Dashboard</a>
    </div>
</body>
