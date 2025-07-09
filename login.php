<?php

include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and Password are required!'); window.history.back();</script>";
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: menu.php"); 
            exit;
        } else {
            echo "<script>alert('Invalid Password!'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('No user found with that email!'); window.history.back();</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Pizza-3007395.jpg/1200px-Pizza-3007395.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
<header>
        <h1>Pizza Shop</h1>
    </header>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
