<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=my_website_db", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Login success
        $_SESSION['username'] = $username;
        header("Location: main.php");
        exit();
    } else {
        // Login failure
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <title>Sign In</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" href="download.png" type="image/x-icon"> <!-- Adjust the path to your favicon -->
</head>
<body>
    <div class= "container">
    <h2>Log In to my Account</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form action="signin.php" method="post">
        <p><b>USERNAME</p></b><input type="text" name="username" placeholder="Username" required>
        <p><b>PASSWORD</p></b><input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
        <a href = "signup.php">Dont have an account yet?</a>
    </form>
</div>
</body>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #4a90e2, #56c1f9);
            color: #333;
        }

        .container {
            background: #ffffff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 2em;
            font-weight: 700;
            color: #333;
            margin-bottom: 1em;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="password"] {
            padding: 0.8em;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
        }

        button {
            padding: 0.8em;
            font-size: 1em;
            color: white;
            background-color: #4a90e2;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357abd;
        }

        p {
            margin-top: 1em;
            color: #666;
        }

        a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #357abd;
        }
    </style>
</html>
