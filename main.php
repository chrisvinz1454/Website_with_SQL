<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="icon" href="download.png" type="image/x-icon"> <!-- Adjust the path to your favicon -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            height: 100vh;
            background: #f4f4f9;
            color: #333;
        }

        .container {
            text-align: center;
            background: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 2em;
            font-weight: 700;
            color: #4a90e2;
            margin-bottom: 0.5em;
        }

        p {
            font-size: 1.1em;
            margin-bottom: 1.5em;
            color: #555;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #4a90e2;
            padding: 0.6em 1.2em;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>You have successfully logged in.</p>
        <a href="Mainpage.html">CONTINUE</a>
    </div>
</body>
</html>
