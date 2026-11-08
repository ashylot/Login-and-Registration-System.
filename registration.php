<?php
require "db_connection.php";

$errors = [];
$success = "";
$fullname = $username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm  = $_POST["confirm"] ?? "";

    // 1. Validate
    if ($fullname === "" || $username === "" || $password === "" || $confirm === "") {
        $errors[] = "Please fill in every field.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = "That username is already taken.";
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $username, $hash]);
        $success = "Account created. You can now log in.";
        $fullname = $username = "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="card">
        <h1>Create your account</h1>
        <p class="subtitle">Fill in your details to get started</p>

        <?php foreach ($errors as $e): ?>
            <div class="alert error"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
        <?php if ($success): ?>
            <div class="alert success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" action="registration.php" novalidate>
            <label for="fullname">Full name</label>
            <div class="field">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
                <input type="text" id="fullname" name="fullname" placeholder="Joie Velasco" value="<?= htmlspecialchars($fullname) ?>" required>
            </div>

            <label for="username">Username</label>
            <div class="field">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0V12a9 9 0 1 0-3.5 7.1"/></svg>
                <input type="text" id="username" name="username" placeholder="joievelasco" value="<?= htmlspecialchars($username) ?>" required>
            </div>

            <label for="password">Password</label>
            <div class="field">
                <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                <input type="password" id="password" name="password" placeholder="At least 6 characters" required>
            </div>

            <label for="confirm">Confirm password</label>
            <div class="field">
                <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                <input type="password" id="confirm" name="confirm" placeholder="Re-enter your password" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <p class="switch">Already have an account? <a href="login.php">Log in</a></p>
    </main>
</body>
</html>