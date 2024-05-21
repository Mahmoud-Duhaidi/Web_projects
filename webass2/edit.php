<?php
require 'dbconfig.in.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt= $pdo->prepare("SELECT * FROM product Where id=:id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $product= $stmt->fetch();

    

    if($product){
        $name=$product['name'];
        $category=$product['category'];
        $price=$product['price'];
        $quantity=$product['quantity'];
        $rating=$product['rating'];
        $description=$product['description'];
        $image=$product['image'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name=isset($_POST['name']) ? $_POST['name'] : '';
            $price=isset($_POST['price']) ? $_POST['price'] : '';
            $description=isset($_POST['description']) ? $_POST['description'] : '';
            $quantity=isset($_POST['quantity']) ? $_POST['quantity'] : '';
            $image_file=isset($_FILES['image']) ? $_FILES['image'] : '';
            
            if (!empty($image_file['name'])) {
                $fileExtension = strtolower(pathinfo($image_file['name'], PATHINFO_EXTENSION));
        
                if ($fileExtension !== 'jpeg') {
                    echo "Invalid Extension. Please choose a photo with the extension .jpeg";
                } else {
                    $fileDirectory = 'images/';
                    $image = $id . "." . $fileExtension;
                    $filePath = $fileDirectory . $image;
        
                    move_uploaded_file($image_file['tmp_name'], $filePath);
                }
            }
            
            
            $stmt=$pdo->prepare("UPDATE product SET name = :name, price = :price, quantity = :quantity, description = :description,  image = :image WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':price', $price);
            $stmt->bindValue(':quantity', $quantity);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':image', $image);
            $stmt->execute();

            header('Location: products.php');
            exit();
        }
    }
    else{
        die("error: Invalid product ID !!!");
    }
    

}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>product Update Page</title>
    </head>
    <body> 
        <form action=" " method="post" enctype="multipart/form-data">
                <fieldset>

                    <legend>product Profile:</legend>

                        <p>
                            <label> Product ID: </label>
                            <input type="text" name="id" value="<?php echo (isset($id)) ? $id : ''; ?>" disabled>
                        </p>

                        <p>
                            <label> Product Name: </label>
                            <input type="text" name="name" value="<?php echo (isset($name)) ? $name : ''; ?>" required>
                        </p>

                        <p>
                            <label>Category: </label>
                            <select name="category" disabled>
                                <option value="New Arrival">New Arrival</option>
                                <option value="On Sale">On Sale</option>
                                <option value="Featured">Featured</option>
                                <option value="High Demand">High Demand</option>
                                <option value="Select Category" selected>Normal</option>
                                
                            </select>
                        </p>

                        <p>
                            <label>Price: </label>
                            <input type="number" name="price" value="<?php echo (isset($price)) ? $price : ''; ?>" required>
                        </p>

                        <p>
                            <label>Quantity: </label>
                            <input type="number" name="quantity" value="<?php echo (isset($quantity)) ? $quantity : ''; ?>" required>
                        </p>

                        <p>
                            <label>Rating: </label>
                            <input type="text" name="rating" value="<?php echo (isset($rating)) ? $rating : ''; ?>" disabled >
                        </p>

                        <p>
                            <label>Description: </label>
                            <input type="text" name="description" value="<?php echo (isset($description)) ? $description : ''; ?>" required>
                        </p>

                        <p>
                            <label>product Photo:</label>
                            <br>
                            <?php
                            if (isset($image)) {
                                echo "<img src='images/{$image}' alt='product Photo' width='100' height='100' ><br>";
                            }
                            ?>
                            <input type="file" name="image" accept=".jpeg">
                        </p>
                        
                        <div>
                            <input type="submit" name="button_Update" value="Update">
                        </div>

                </fieldset>

            </form>
    </body>

</html>    