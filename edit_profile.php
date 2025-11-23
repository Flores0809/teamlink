<?php
session_start();
require "db.php";

// 1. Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// 2. Handle POST request for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and escape all input data
    $fullName = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $new_password = $_POST['new_password']; 

    // Start building the update query
    $update_query = "UPDATE users SET 
        full_name = '$fullName', 
        email = '$email', 
        role = '$role', 
        bio = '$bio'";
    
    // Check if a new password was provided and update it
    // WARNING: In a production environment, you MUST use a secure hashing function like password_hash()!
    if (!empty($new_password)) {
        $escaped_password = mysqli_real_escape_string($conn, $new_password);
        $update_query .= ", password = '$escaped_password'";
        $message = "Profile and Password updated successfully!";
    } else {
        $message = "Profile updated successfully!";
    }

    $update_query .= " WHERE id = $user_id";

    if (mysqli_query($conn, $update_query)) {
        // Set a session message for display on the profile page
        $_SESSION['status_message'] = $message;
        header("Location: profile.php");
        exit;
    } else {
        $message = "Error updating record: " . mysqli_error($conn);
    }
}

// 3. Fetch current user data for form pre-filling
$query = "SELECT full_name, email, username, role, bio FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

// Set variables, using defaults if data is missing
$fullName = htmlspecialchars($user_data['full_name'] ?? '');
$email = htmlspecialchars($user_data['email'] ?? '');
$username = htmlspecialchars($user_data['username'] ?? 'User');
$currentRole = htmlspecialchars($user_data['role'] ?? '');
$bio = htmlspecialchars($user_data['bio'] ?? '');

$roles = [
    "Spiker", 
    "Setter", 
    "Libero", 
    "Middle Blocker", 
    "Opposite Hitter",
    "Coach",
    "Casual Player"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile | Team Link</title>
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
    header h1 { margin: 0; font-size: 24px; }
    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 500;
    }
    nav a:hover { text-decoration: underline; }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    h2 {
      text-align: center;
      color: #1e3a8a;
      margin-bottom: 25px;
    }
    
    .username-display {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.1em;
        font-weight: 600;
        color: #0d385f;
        padding: 10px;
        background-color: #e0f2fe;
        border-radius: 8px;
        border: 1px solid #90cdf4;
    }

    label { 
        display: block;
        font-weight: 600; 
        margin-top: 15px;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="email"], input[type="password"], select, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-sizing: border-box; 
    }
    textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group.password-hint {
        font-size: 0.9em;
        color: #666;
        margin-top: -10px;
        margin-bottom: 20px;
    }

    button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-size: 17px;
      font-weight: 600;
      transition: background-color 0.2s;
    }

    button:hover { background-color: #1e40af; }

    .message {
        color: #1e3a8a;
        background-color: #d1e7dd;
        border: 1px solid #a3cfb5;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 500;
    }

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
  <h2>Edit Your Profile</h2>

  <?php if ($message): ?>
      <p class="message"><?= $message ?></p>
  <?php endif; ?>

  <p class="username-display">Username: **<?= $username ?>** (Cannot be changed)</p>

  <form method="POST">
    
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" value="<?= $fullName ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= $email ?>" required>

    <label for="role">Preferred Role</label>
    <select id="role" name="role" required>
        <?php foreach ($roles as $roleOption): ?>
            <option value="<?= $roleOption ?>" <?= ($currentRole === $roleOption) ? 'selected' : '' ?>>
                <?= $roleOption ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="bio">Biography / About Me</label>
    <textarea id="bio" name="bio" rows="5"><?= $bio ?></textarea>

    <label for="new_password">Change Password (Optional)</label>
    <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current password">
    <div class="form-group password-hint">
        *Warning: Your current password will be updated if you enter a value here.
    </div>

    <button type="submit">Save Changes</button>
  </form>
</div>

<footer>
  <p>© 2025 Team Link | Connect. Play. Grow.</p>
</footer>

</body>
</html>