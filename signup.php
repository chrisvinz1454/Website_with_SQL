<?php
$pdo = new PDO("mysql:host=localhost;dbname=my_website_db", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) { // check for special character
        $error = "Password must contain at least one special character.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Username already taken. Please choose another one.";
        } else {
            // Insert new user into database
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed_password])) {
                $success = "Account created successfully! <a href='signin.php'>Sign In</a>";
            } else {
                $error = "Error creating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="download.png" type="image/x-icon"> <!-- Adjust the path to your favicon -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Basic styling similar to previous page */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: linear-gradient(135deg, #4a90e2, #56c1f9); color: #333; }
        .container { background: #ffffff; padding: 2em; border-radius: 8px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; text-align: center; }
        h2 { font-size: 2em; font-weight: 700; color: #333; margin-bottom: 1em; }
        form { display: flex; flex-direction: column; gap: 15px; }
        input[type="text"], input[type="password"] { padding: 0.8em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; width: 100%; }
        button { padding: 0.8em; font-size: 1em; color: white; background-color: #4a90e2; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease; }
        button:hover { background-color: #357abd; }
        p { margin-top: 1em; color: #666; }
        a { color: #4a90e2; text-decoration: none; font-weight: bold; transition: color 0.3s ease; }
        a:hover { color: #357abd; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create an Account</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
        <form action="signup.php" method="post" onsubmit="return validateForm()">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="signin.php">Sign In</a></p>
    </div>

    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            // Check for at least one special character
            const specialCharPattern = /[!@#$%^&*(),.?":{}|<>]/;
            if (!specialCharPattern.test(password)) {
                alert("Password must contain at least one special character.");
                return false;
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
