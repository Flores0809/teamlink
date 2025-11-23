<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $needed = $_POST['needed'];
    $description = $_POST['description'];
    $organizer = $_SESSION['username'] ?? "Guest";

    $query = "INSERT INTO games (title, location, game_date, game_time, players_needed, description, organizer)
              VALUES ('$title', '$location', '$date', '$time', '$needed', '$description', '$organizer')";
    mysqli_query($conn, $query);

    header("Location: games.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Game | Team Link</title>
  <style>

    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #f3f4f6;
    }

    header {
      background-color: #1e3a8a;
      color: white;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 500;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 25px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #1e3a8a;
    }

    label { font-weight: 600; }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 8px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover { background-color: #1e40af; }

    footer {
      margin-top: 50px;
      background-color: #1e3a8a;
      color: white;
      padding: 15px;
      text-align: center;
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
  <h2>Create New Game</h2>

  <form method="POST">
    <label>Game Title:</label>
    <input type="text" name="title" required>

    <label>Location:</label>
    <input type="text" name="location" required>
    
    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Time:</label>
    <input type="time" name="time" required>

    <label>Players Needed:</label>
    <input type="number" name="needed" required>

    <label>Description:</label>
    <textarea name="description" rows="4"></textarea>

    <button type="submit">Create Game</button>
  </form>
</div>

<footer>
  <p>© 2025 Team Link | Connect. Play. Grow.</p>
</footer>

</body>
</html>