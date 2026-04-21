<?php
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
        <link rel="stylesheet" href="/~u202301830/DriveMarket/assets/css/style.css">
    </head>
    <body>

        <header class="site-header">
            <div class="container site-header-inner">
                <a href="/~u202301830/DriveMarket/index.php" class="logo-wrap">
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

                <nav class="navbar">
                    <a class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/index.php">Home</a>
                    <a class="<?php echo $current_page === 'cars.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/cars.php">Cars</a>
                    <a class="<?php echo $current_page === 'search.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/search.php">Search</a>
                    <a class="<?php echo $current_page === 'offers.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/offers.php">Offers</a>
                    <a class="<?php echo $current_page === 'appointments.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/appointments.php">Appointments</a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="<?php echo $current_page === 'my_activity.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/my_activity.php">My Activity</a>
                        <a class="<?php echo $current_page === 'edit_profile.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/edit_profile.php">Edit Profile</a>

                        <?php if ($_SESSION['role'] === 'creator'): ?>
                            <a class="<?php echo $current_page === 'creator_dashboard.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/creator/creator_dashboard.php">Creator Dashboard</a>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <a class="<?php echo $current_page === 'admin_dashboard.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/admin/admin_dashboard.php">Admin Dashboard</a>
                        <?php endif; ?>

                        <a class="nav-logout <?php echo $current_page === 'logout.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/logout.php">Logout</a>
                    <?php else: ?>
                        <a class="<?php echo $current_page === 'login.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/login.php">Login</a>
                        <a class="nav-register <?php echo $current_page === 'register.php' ? 'active' : ''; ?>" href="/~u202301830/DriveMarket/register.php">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <main class="container site-main">