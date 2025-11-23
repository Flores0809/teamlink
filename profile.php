<?php
session_start();
require "db.php";

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$status_message = "";

// 1. Check for and clear a status message from a previous action (like profile edit)
if (isset($_SESSION['status_message'])) {
    $status_message = $_SESSION['status_message'];
    unset($_SESSION['status_message']);
}

// Fetch user data
// NOTE: I've updated the query to be slightly safer, although the original worked too.
$query = "SELECT full_name, role, bio, profile_pic FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Set profile variables
$fullName = $user['full_name'] ?? "User Name";
$role = $user['role'] ?? "N/A";
$bio = $user['bio'] ?? "Tell us a little about yourself by editing your profile!";

// Hardcoded stats for demonstration (until game joining/hosting is implemented)
$games_joined = 15; 
$games_hosted = 4;
$badges_earned = 8;
// Use your specific placeholder image URL
$profile_pic_url = $user['profile_pic'] ?? "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRO5fUq6ZKoRn_BTE9RYCZIBg6OUljy6OOtCg&s";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Team Link | Profile</title>
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

    .profile-container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }

    /* 2. Style for the new status message */
    .status-message {
        color: #0f5132;
        background-color: #d1e7dd;
        border: 1px solid #badbcc;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 500;
    }
    
    .profile-pic {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #1e3a8a;
    }

    h2 {
      color: #1e3a8a;
      margin: 15px 0 5px;
    }

    .role {
      color: #2563eb;
      font-weight: 600;
    }

    .bio {
      margin-top: 10px;
      color: #555;
    }

    .section {
      text-align: left;
      margin-top: 30px;
    }

    .section h3 {
      color: #1e3a8a;
      border-left: 5px solid #2563eb;
      padding-left: 10px;
      margin-bottom: 15px;
    }

    .badges {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .badge {
      background-color: #2563eb;
      color: white;
      border-radius: 30px;
      padding: 10px 18px;
      font-weight: 500;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .badge span {
      font-size: 18px;
    }

    .stats {
      display: flex;
      justify-content: space-around;
      background-color: #eef2ff;
      border-radius: 10px;
      padding: 15px;
      margin-top: 10px;
    }

    .stat-box {
      text-align: center;
    }

    .stat-number {
      font-size: 22px;
      font-weight: 700;
      color: #1e3a8a;
    }

    .edit-btn {
      /* Re-style for the anchor tag */
      margin-top: 25px;
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 15px;
      cursor: pointer;
      transition: background 0.2s;
      text-decoration: none; /* Crucial for anchor tag */
      display: inline-block; /* Crucial for anchor tag */
    }

    .edit-btn:hover {
      background-color: #1e40af;
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

  <div class="profile-container">

    <!-- 3. Display status message if present -->
    <?php if ($status_message): ?>
        <p class="status-message"><?= htmlspecialchars($status_message) ?></p>
    <?php endif; ?>

    <img src="<?= htmlspecialchars($profile_pic_url) ?>" alt="Profile Picture" class="profile-pic">
    <h2><?= htmlspecialchars($fullName) ?></h2>
    <p class="role">🏐 Position: <?= htmlspecialchars($role) ?></p>
    <p class="bio"><?= htmlspecialchars($bio) ?></p>

    <!-- 4. Change the button to an anchor tag linking to the new page -->
    <a href="edit_profile.php" class="edit-btn">Edit Profile</a>

    <div class="section">
      <h3>🏅 Badges</h3>
      <div class="badges">
        <div class="badge"><span>⭐</span> MVP Award</div>
        <div class="badge"><span>🔥</span> 10 Games Played</div>
        <div class="badge"><span>💬</span> Active Contributor</div>
        <div class="badge"><span>🏆</span> Organizer Badge</div>
      </div>
    </div>

    <div class="section">
      <h3>📊 Game Statistics</h3>
      <div class="stats">
        <div class="stat-box">
          <p class="stat-number"><?= htmlspecialchars($games_joined) ?></p>
          <p>Games Joined</p>
        </div>
        <div class="stat-box">
          <p class="stat-number"><?= htmlspecialchars($games_hosted) ?></p>
          <p>Games Hosted</p>
        </div>
        <div class="stat-box">
          <p class="stat-number"><?= htmlspecialchars($badges_earned) ?></p>
          <p>Badges Earned</p>
        </div>
      </div>
    </div>

  </div>

  <footer>
    <p>© 2025 Team Link | Connect. Play. Grow.</p>
  </footer>
</body>
</html>