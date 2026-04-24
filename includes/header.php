<?php
require_once __DIR__ . '/../config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DriveMarket</title>
        <link rel="stylesheet" href="<?php echo APP_BASE_URL; ?>assets/css/style.css">
        <script src="<?php echo APP_BASE_URL; ?>assets/js/validation.js" defer></script>
    </head>
    <body>

        <header class="site-header">
            <div class="container site-header-inner">
                <div class="header-left">
                    <div class="brand-user-wrap">
                        <a href="<?php echo APP_BASE_URL; ?>index.php" class="logo-wrap">
                            <span class="logo-mark">
                                <svg viewBox="0 0 64 64" class="logo-car-icon" aria-hidden="true">
                                    <path d="M14 38h36l-4-10c-1-3-3-4-6-4H24c-3 0-5 1-6 4l-4 10z" fill="currentColor"></path>
                                    <rect x="10" y="36" width="44" height="10" rx="4" fill="currentColor"></rect>
                                    <circle cx="20" cy="48" r="5" fill="#fff"></circle>
                                    <circle cx="44" cy="48" r="5" fill="#fff"></circle>
                                    <rect x="24" y="27" width="16" height="7" rx="2" fill="#fff" opacity="0.9"></rect>
                                </svg>
                            </span>
                            <span class="logo">DriveMarket</span>
                        </a>

                        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username'])): ?>
                            <?php
                            $display_name = $_SESSION['username'];
                            if (mb_strlen($display_name) > 10) {
                                $display_name = mb_substr($display_name, 0, 10) . '...';
                            }
                            ?>
                            <a href="<?php echo APP_BASE_URL; ?>edit_profile.php" class="header-user-link">
                                Welcome, <?php echo htmlspecialchars($display_name); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <nav class="header-center navbar navbar-center">
                    <a href="<?php echo APP_BASE_URL; ?>index.php">Home</a>
                    <a href="<?php echo APP_BASE_URL; ?>cars.php">Cars</a>
                    <a href="<?php echo APP_BASE_URL; ?>search.php">Search</a>
                    <a href="<?php echo APP_BASE_URL; ?>offers.php">Offers</a>
                    <a href="<?php echo APP_BASE_URL; ?>appointments.php">Appointments</a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo APP_BASE_URL; ?>my_activity.php">My Activity</a>
                    <?php endif; ?>
                </nav>

                <nav class="header-right navbar navbar-right">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo APP_BASE_URL; ?>edit_profile.php">Edit Profile</a>

                        <?php if ($_SESSION['role'] === 'creator'): ?>
                            <a href="<?php echo APP_BASE_URL; ?>creator/creator_dashboard.php">Creator Dashboard</a>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a href="<?php echo APP_BASE_URL; ?>admin/admin_dashboard.php">Admin Dashboard</a>
                        <?php endif; ?>

                        <a href="<?php echo APP_BASE_URL; ?>logout.php" class="nav-logout">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo APP_BASE_URL; ?>login.php">Login</a>
                        <a href="<?php echo APP_BASE_URL; ?>register.php" class="nav-register">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <main class="container site-main">