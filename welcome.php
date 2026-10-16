<?php
require 'db.php';
if (empty($_SESSION['user_id'])) {   // block access unless logged in
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card center">
  <div style="font-size:48px">🎉</div>
  <h1>Welcome, <?= e($_SESSION['user_name']) ?>!</h1>
  <p>Thank you for registering and logging in. We're glad to have you with us.</p>
  <a class="btn" href="logout.php">Log out</a>
</div>
</body>
</html>
