<?php
require 'dbconfig.in.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt= $pdo->prepare("SELECT * FROM product Where id=:id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $stud= $stmt->fetch();

    

    if($stud){
        $stmt= $pdo->prepare("DELETE FROM product Where id=:id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        header('Location: products.php');
        exit();
    }
    else{
        die("error: Invalid product ID !!!");
    }
    

}
?>