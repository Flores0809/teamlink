<?php
session_start();
require "db.php";

$games = mysqli_query($conn, "SELECT * FROM games ORDER BY game_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Link | Games</title>
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

    nav a:hover { text-decoration: underline; }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 10px;
    }

    h2 {
      text-align: center;
      color: #1e3a8a;
      margin-bottom: 30px;
    }

    .game-list {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      padding: 0 10px;
    }

    .game-card {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }

    .game-card:hover { transform: translateY(-5px); }

    .game-card h3 {
      color: #1e3a8a;
      margin-top: 0;
    }

    .game-card p {
      margin: 5px 0;
    }

    .game-card button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    .create-btn {
      display: block;
      margin: 30px auto;
      background-color: #2563eb;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
    }

    footer {
      text-align: center;
      background-color: #1e3a8a;
      color: white;
      padding: 15px 0;
      margin-top: 40px;
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
  <h2>Find a Game</h2>

  <div class="game-list">
    <?php while ($g = mysqli_fetch_assoc($games)): ?>
      <div class="game-card">
        <h3><?= $g['title'] ?></h3>
        <p><strong>Location:</strong> <?= $g['location'] ?></p>
        <p><strong>Date:</strong> <?= $g['game_date'] ?></p>
        <p><strong>Time:</strong> <?= $g['game_time'] ?></p>
        <p><strong>Players Needed:</strong> <?= $g['players_needed'] ?></p>
        <p><strong>Organizer:</strong> <?= $g['organizer'] ?></p>
        <button>View Details</button>
      </div>
    <?php endwhile; ?>
  </div>

  <button class="create-btn" onclick="window.location.href='create_game.php'">+ Create New Game</button>
</div>

<footer>
  <p>© 2025 Team Link | Connect. Play. Grow.</p>
</footer>

</body>
</html>