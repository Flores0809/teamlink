<?php
// NOTE: I've added the PHP logic from our previous conversation here for completeness
session_start();
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // You should use prepared statements for security in production!
    $fullName = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if username already exists
    $check_query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $message = "Username already taken. Please choose another.";
    } else {
        // Insert new user (replace with password_hash() for security)
        $insert_query = "INSERT INTO users (full_name, email, username, password, role) 
                         VALUES ('$fullName', '$email', '$username', '$password', '$role')";
        
        if (mysqli_query($conn, $insert_query)) {
            // Redirect to login after successful registration
            header("Location: login.php?registered=true");
            exit;
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Display success message if redirected from a successful registration
if (isset($_GET['registered']) && $_GET['registered'] == 'true') {
    $message = "Registration successful! You can now log in.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Team Link | Register</title>
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
      max-width: 450px;
      margin: 60px auto;
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
      color: #1e3a8a;
      text-align: center;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-top: 12px;
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
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
      text-align: center;
      margin-top: 15px;
    }

    a {
      color: #2563eb;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .message {
      text-align: center;
      padding: 10px;
      background-color: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    
    footer {
      text-align: center;
      background-color: #1e3a8a;
      color: white;
      padding: 15px 0;
      margin-top: 60px;
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
    <h2>Create an Account</h2>
    <?php if ($message): ?>
      <p class="message"><?= $message ?></p>
    <?php endif; ?>
    
    <form method="POST">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" placeholder="e.g. Alex Santos" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="example@email.com" required>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Choose a username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password" required>

      <label for="role">Preferred Role</label>
      <select id="role" name="role" required>
        <option value="">Select Role</option>
        <option value="Spiker">Spiker</option>
        <option value="Setter">Setter</option>
        <option value="Libero">Libero</option>
        <option value="Middle Blocker">Middle Blocker</option>
        <option value="Opposite Hitter">Opposite Hitter</option>
      </select>

      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>

  <footer>
    <p>© 2025 Team Link | Connect. Play. Grow.</p>
  </footer>
</body>
</html>