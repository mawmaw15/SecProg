<?php

include "./../database/db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];
    $hash_password = sha1($password);

    $sql = "INSERT INTO users VALUES(
        null,
        '$username',
        '$hash_password'
    )";

    $conn->query($sql);
    header("location: ./../login.php");
}

