<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DriveMarket</title>
        <link rel="stylesheet" href="/~u202301830/DriveMarket/assets/css/style.css">
    </head>
    <body>

        <header class="site-header">
            <div class="container">
                <h1 class="logo">DriveMarket</h1>
                <nav class="navbar">
                    <a href="/~u202301830/DriveMarket/index.php">Home</a>
                    <a href="/~u202301830/DriveMarket/cars.php">Cars</a>
                    <a href="/~u202301830/DriveMarket/search.php">Search</a>
                    <a href="/~u202301830/DriveMarket/offers.php">Offers</a>
                    <a href="/~u202301830/DriveMarket/appointments.php">Appointments</a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/~u202301830/DriveMarket/my_activity.php">My Activity</a>

                        <?php if ($_SESSION['role'] === 'creator'): ?>
                            <a href="/~u202301830/DriveMarket/creator/creator_dashboard.php">Creator Dashboard</a>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="/~u202301830/DriveMarket/admin/admin_dashboard.php">Admin Dashboard</a>
                        <?php endif; ?>

                        <a href="/~u202301830/DriveMarket/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="/~u202301830/DriveMarket/login.php">Login</a>
                        <a href="/~u202301830/DriveMarket/register.php">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <main class="container">