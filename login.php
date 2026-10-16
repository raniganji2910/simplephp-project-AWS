<?php
require 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass  = $_POST['password'] ?? '';

    // Look the user up in the database table
    $stmt = $conn->prepare('SELECT id, name, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: welcome.php');                  // -> welcome page
        exit;
    }
    $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
  <h1>Log in</h1>
  <?php if (isset($_GET['registered'])): ?><div class="ok">Registration successful! Please log in.</div><?php endif; ?>
  <?php if ($error): ?><div class="err"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <label>Email</label>
    <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Log in</button>
  </form>
  <div class="link">New here? <a href="register.php">Create an account</a></div>
</div>
</body>
</html>
