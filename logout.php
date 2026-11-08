<?php
// logout.php - ends the session and goes back to login
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit;