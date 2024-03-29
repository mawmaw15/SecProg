<?php

include "./../database/db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $id = $_GET['id'];

    // image in database
    $image_name = $_FILES['image']['name'];

    $allowed_extensions = ["jpg", "jpeg", "png"];
    $image_extension = PATHINFO(
        $image_name, 
        PATHINFO_EXTENSION
    );

    session_start();
    if($_FILES['image']['size'] > 10000000) {
        $_SESSION['error'] = "size 2 big";
        header("location: ./../update.php?id=$id");
    } else if(in_array($image_extension, $allowed_extensions) == false) {
        $_SESSION['error'] = "extension not allowed";
        header("location: ./../update.php?id=$id");
    } else {
        // image in server
        $document_root = $_SERVER['DOCUMENT_ROOT'];
        $full_upload_path = "$document_root/NIM/public/image/product/$image_name";
    
        move_uploaded_file(
            $_FILES['image']['tmp_name'], 
            $full_upload_path
        );
    
        $sql = "UPDATE handphone SET 
        type = '$type',
        brand = '$brand',
        price = $price,
        image = '$image_name' 
        WHERE id = $id
        ";
    
        $conn->query($sql);
        header("location: ./../index.php");
    }


}