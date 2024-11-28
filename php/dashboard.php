<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Price_Tracker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tracked_products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Tracker Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1>Price Tracker Dashboard</h1>
    </header>
    
    <div class="button-container">
        <a href="add_product.php" class="btn">Add Product</a>
        <a href="update_product.php" class="btn">Update Product</a>
        <a href="delete.php" class="btn">Delete Products</a>
    </div>

    <div class="table-container">
        <h2>Tracked Products</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Product URL</th>
                    <th>Target Price</th>
                    <th>Current Price</th>
                    <th>Last Checked</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['product_name']}</td>
                                <td><a href='{$row['product_url']}' target='_blank'>Link</a></td>
                                <td>{$row['target_price']}</td>
                                <td>" . ($row['current_price'] ?? "N/A") . "</td>
                                <td>" . ($row['last_checked'] ?? "N/A") . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
