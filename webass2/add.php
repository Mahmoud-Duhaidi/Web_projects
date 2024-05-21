<?php
include_once 'dbconfig.in.php';
$numProduct=1;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name=isset($_POST['name']) ? $_POST['name'] : '';
    $category=isset($_POST['category']) ? $_POST['category'] : '';
    $price=isset($_POST['price']) ? $_POST['price'] : '';
    $quantity=isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $rating=isset($_POST['rating']) ? $_POST['rating'] : '';
    $description=isset($_POST['description']) ? $_POST['description'] : '';
    $image_file=isset($_FILES['image']) ? $_FILES['image'] : '';
    $image='';

    if (!empty($image_file['name'])) {
        $fileExtension = strtolower(pathinfo($image_file['name'],PATHINFO_EXTENSION));

        if ($fileExtension!=='jpeg') {
            echo ("Invalid Extension. Please choose a photo with the extension .jpeg");
        } 
        else {
                $stmt = $pdo->prepare("SELECT id FROM product ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $product_id= $stmt->fetch();
                if(isset($product_id)==null){
                    $numProduct=1;
                }
                else{
                    $numProduct=$product_id['id']+1;
                }
            } 
            


            $fileDirectory = 'images/';
            $image = $numProduct . "." . $fileExtension;
            $filePath = $fileDirectory . $image;

            move_uploaded_file($image_file['tmp_name'], $filePath);

            
            $stmt=$pdo->prepare("INSERT INTO product (id,name, category, price, quantity, rating, description, image) VALUES (:numProduct,:name, :category, :price, :quantity, :rating, :description, :image)");
            $stmt->bindValue(':numProduct', $numProduct);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':category', $category);
            $stmt->bindValue(':price', $price);
            $stmt->bindValue(':quantity', $quantity);
            $stmt->bindValue(':rating', $rating);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':image', $image);
            $stmt->execute();

            header('Location: products.php');
            exit();
             
        }
    }
    
   
    


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Product Page</title>
    </head>
    <body> 
        <form action="add.php" method="post" enctype="multipart/form-data">
                <fieldset>

                    <legend>Product Record:</legend>

                        <p>
                            <label>Product Name: </label>
                            <input type="text" name="name" required>
                        </p>

                        <p>
                            <label>Category: </label>
                            <select name="category" required>
                                <option value="Swimwear">Swimwear</option>
                                <option value="Dress">Dress</option>
                                <option value="Shorts">Shorts</option>
                                <option value="Shirt "> Shirt</option>
                                <option value="Select Category" selected>Select Category</option>
                                
                            </select>
                        </p>

                        <p>
                            <label>Price: </label>
                            <input type="number" name="price" required>
                        </p>

                        <p>
                            <label>Quantity: </label>
                            <input type="number" name="quantity" required>
                        </p>

                        <p>
                            <label>Rating: </label>
                            <input type="number" name="rating" min="1" max="5" required>
                        </p>

                        <p>
                            <label>Description: </label>
                            <input type="text" name="description" required>
                        </p>

                        <p>
                            <label>Product Photo:</label>
                            <input type="file" name="image" accept=".jpeg" required>
                        </p>
                        
                        <div>
                            <input type="submit" name="button_Insert" value="Insert">
                        </div>

                </fieldset>

            </form>
    </body>

</html>    