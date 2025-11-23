<?php
// NOTE: I've added the PHP logic from our previous conversation here for completeness
session_start();
require "db.php";

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // You should use prepared statements for security in production!
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && ($password === $user['password'])) { // Replace with password_verify() for production
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Team Link | Login</title>
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #f3f4f6;
      color: #333;
    }

    header {
      background-color: #1e3a8a;
      color: white;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 24px;
      margin: 0;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .container {
      max-width: 400px;
      margin: 80px auto;
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      color: #1e3a8a;
      margin-bottom: 25px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    button {
      width: 100%;
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 12px;
      margin-top: 20px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }

    button:hover {
      background-color: #1e40af;
    }

    p {
      margin-top: 20px;
    }

    a {
      color: #2563eb;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .error-msg {
        color: red;
        font-weight: bold;
        margin-bottom: 15px;
    }

    footer {
      text-align: center;
      background-color: #1e3a8a;
      color: white;
      padding: 15px 0;
      margin-top: 80px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Team Link</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="games.php">Games</a>
      <a href="create_game.php">Create Game</a>
      <a href="profile.php">Profile</a>
      <a href="login.php">Login</a>
    </nav>
  </header>

  <div class="container">
    <h2>Login to Your Account</h2>

    <?php if ($error_message): ?>
      <p class="error-msg"><?= $error_message ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Username or Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>

  <footer>
    <p>© 2025 Team Link | Connect. Play. Grow.</p>
  </footer>
</body>
</html>