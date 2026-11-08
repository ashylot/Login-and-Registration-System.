<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="card dash">
        <h1>Hello, <?= htmlspecialchars($_SESSION["fullname"]) ?></h1>
        <p class="subtitle">You are logged in.</p>
        <form action="logout.php" method="post">
            <button type="submit">Log out</button>
        </form>
    </main>
</body>
</html>
