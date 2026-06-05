<?php

session_start();
require_once 'config.php';

if(isset($_POST['register'])) {
    $name=$_POST['username'];
    $email=$_POST['email'];
    $course=$_POST['course'];
    $age=$_POST['age'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);

}

$checkEmail= $conn->query("SELECT email FROM users WHERE email='$email'");
    if($checkEmail->num_rows > 0){
        $_SESSION[register_error] = "Email already exists. Please use a different email.";
        $_SESSION[active_form] = 'register';
} else {
$insert = $conn->query("INSERT INTO users (username, email, age, password) VALUES ('$name', '$email', '$age', '$password')");
    }
    header("Location: apply.php");
    exit();


    if(isset($_POST['login']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = $conn->query("SELECT * FROM users WHERE email='$email'");
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION[login_error] = "Incorrect password. Please try again.";
                $_SESSION[active_form] = 'login';
            }
        } else {
            $_SESSION[login_error] = "Email not found. Please register first.";
            $_SESSION[active_form] = 'login';
        }
        header("Location: apply.php");
        exit();
    }
?>