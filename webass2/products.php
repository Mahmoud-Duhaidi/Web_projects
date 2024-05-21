<?php
require 'dbconfig.in.php';

$filterq = "";
$data= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve filter criteria
    $filter = $_POST['button_filter'];
    $search_product = $_POST['product_name_price'];
    $category = $_POST['product_category'];

    if ($filter === 'name') {
        $filterq = " WHERE name LIKE ?";
        $data[] = "%$search_product%";
    } elseif ($filter === 'price') {
        $filterq = " WHERE price >= ?";
        $data[] = $search_product;
    } elseif ($filter === 'category' && $category !== 'Select Category') {
        $filterq = " WHERE category = ?";
        $data[] = $category;
    }
}

$query = "SELECT * FROM product" . $filterq;

$stmt = $pdo->prepare($query);
$stmt->execute($data);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Page</title>
</head>
<body>
    <p>To Add a new Product click on the following link <a href="add.php">Add Product</a>.</p>
    <br>
    <p>Or use the actions below to edit or delete a Product's record.</p>
    <fieldset>
        <legend>Advanced Product Search</legend>
        <form method="POST" action="">
            <input type="text" name="product_name_price" placeholder="Search Product Name">
            <input type="radio" name="button_filter" value="name" required> Name
            <input type="radio" name="button_filter" value="price" required> Price
            <input type="radio" name="button_filter" value="category" required> Category
            <select name="product_category" required>
                <option value="Select Category" selected>Normal</option>
                <?php
                $stmt = $pdo->query("SELECT DISTINCT category FROM product");
                $categories = $stmt->fetchAll();
                foreach ($categories as $category) {
                    echo "<option value='{$category['category']}'>{$category['category']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Filter">
        </form>
        <br>
        <table border="1">
            <caption>Products Table Result</caption>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><img src='images/<?= $product['image'] ?>' width='100' height='100'></td>
                        <td><a href='view.php?id=<?= $product['id'] ?>'><?= $product['id'] ?></a></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td>
                            <a href='edit.php?id=<?= $product['id'] ?>'><button><img src='buttons_images/edit.png' width='27' height='27'></button></a>
                            <a href='delete.php?id=<?= $product['id'] ?>'><button><img src='buttons_images/delete.png' width='27' height='27'></button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>
</body>
</html>