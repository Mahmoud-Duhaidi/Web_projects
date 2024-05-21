<?php
require 'dbconfig.in.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt= $pdo->prepare("SELECT * FROM product Where id=:id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $product= $stmt->fetch();

    

    if($product){
        $image=$product['image'];
        $name=$product['name'];
        $id=$product['id'];
        $price=$product['price'];
        $category=$product['category'];
        $rating=$product['rating'];
        $description=$product['description'];
    }
    else{

        die("error: Invalid product ID !!!");
    }
    

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Product Info</title>
    </head>

    <body>
        <section>
            <p><img src='images/<?php echo $image; ?>' alt='Product Photo' width='100' height='100'></p>
        </section>   
        
        <section>
            <h1><strong>Product ID: <?php echo $id ?>, <?php echo $name ?></strong></h1>
            <ul>
                <li>Price: <?php echo $price ?></li>
                <li>Category: <?php echo $category ?></li>
                <li>Rating: <?php echo $rating ?>/5</li>
            </ul>   
        </section>

        <section>
            <h3>Description:</h3>
            <br>
            <?php echo $description ?>
        </section>
        

    </body>
</html>