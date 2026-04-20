<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: /~u202301830/DriveMarket/login.php");
        exit();
    }
}

function requireRole($role)
{
    requireLogin();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        echo "<h2>Access Denied</h2>";
        echo "<p>You do not have permission to access this page.</p>";
        exit();
    }
}
?>