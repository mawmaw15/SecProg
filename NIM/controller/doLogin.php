<?php

include "./../database/db.php";

if($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];
    $hash_password = sha1($password);

    $sql = "SELECT * FROM 
        users WHERE 
        username = '$username'
        AND password = '$hash_password'";
    
    $result = $conn->query($sql);

    session_start();
    if($result->num_rows > 0) {
        // login success
        session_regenerate_id();
        $_SESSION['username'] = $username;

        if(isset($_POST['chkRemember'])) {
            setcookie(
                "username",
                $username,
                time() + 3600 * 24 * 3,
                "/",
                null,
                false,
                true
            );
            setcookie(
                "password",
                $password,
                time() + 3600 * 24 * 3,
                "/",
                null,
                false,
                true
            );
        }

        header("location: ./../index.php");
    } else {
        // login failed
        $_SESSION['error'] = "Wrong username or password";
        header("location: ./../login.php");
    }
}