<?php
require 'db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $nickName = $_POST['nickName'];
    $password = $_POST['password'];

    $salt = bin2hex(random_bytes(16));
    $password_hash = hash('sha256', $password . $salt);

    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, nickName, password_hash, password_salt) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $nickName, $password_hash, $salt);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        input[type="text"], input[type="password"] {
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
        <h2>Register</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            First Name: <input type="text" name="firstName" required>
            Last Name: <input type="text" name="lastName" required>
            Nickname: <input type="text" name="nickName">
            Password: <input type="password" name="password" required>
            <input type="submit" value="Register">
        </form>
        <p style="text-align:center;">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
