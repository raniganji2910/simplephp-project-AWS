<?php
require 'db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass  = $_POST['password'] ?? '';
    $pass2 = $_POST['confirm'] ?? '';

    if ($name === '' || $email === '' || $pass === '') $errors[] = 'Please fill in all fields.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($pass !== $pass2) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        // Check if email already exists in the table
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'This email is already registered.';
        } else {
            // Save the new user in the database table
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $ins = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $ins->bind_param('sss', $name, $email, $hashed);
            $ins->execute();
            header('Location: login.php?registered=1');   // -> login page
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
  <h1>Create account</h1>
  <?php foreach ($errors as $err): ?><div class="err"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post">
    <label>Full name</label>
    <input name="name" value="<?= e($_POST['name'] ?? '') ?>" required>
    <label>Email</label>
    <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
    <label>Password (min 6 characters)</label>
    <input type="password" name="password" required>
    <label>Confirm password</label>
    <input type="password" name="confirm" required>
    <button type="submit">Register</button>
  </form>
  <div class="link">Already registered? <a href="login.php">Log in</a></div>
</div>
</body>
</html>
