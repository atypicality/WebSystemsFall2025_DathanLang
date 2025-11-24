<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT userId, firstName, lastName, password_hash, password_salt FROM users WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: register.php");
        exit;
    }

    $user = $result->fetch_assoc();
    $hashCheck = hash('sha256', $password . $user['password_salt']);

    if ($hashCheck === $user['password_hash']) {
        $_SESSION['userId'] = $user['userId'];
        $_SESSION['firstName'] = $user['firstName'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Incorrect password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.7);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #fff;
        }
        input[type="number"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border-radius: 4px;
            border: 1px solid #555;
            background-color: #1e1e1e;
            color: #e0e0e0;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #00bfff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        input[type="submit"]:hover {
            background-color: #009acd;
        }
        .error {
            color: #ff6b6b;
            margin-bottom: 15px;
        }
        a {
            color: #00bfff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            User ID: <input type="number" name="userId" required>
            Password: <input type="password" name="password" required>
                <input type="submit" value="Login">
        </form>
        <p style="text-align:center;">No account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
