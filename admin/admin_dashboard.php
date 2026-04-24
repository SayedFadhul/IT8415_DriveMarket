<?php
require_once '../includes/auth.php';
requireRole('admin');
include '../includes/header.php';
?>

<div class="dashboard-page">
    <div class="dashboard-hero admin-hero">
        <div>
            <span class="dashboard-badge">Admin Panel</span>
            <h2>Admin Dashboard</h2>
            <p>Welcome, Admin. Manage users, cars, comments, and reports from one place with full control over the platform.</p>
        </div>
    </div>

    <div class="dashboard-card-grid">
        <a href="manage_users.php" class="dashboard-action-card dashboard-image-card admin-users-card">
            <div class="dashboard-card-overlay"></div>
            <div class="dashboard-card-content">
                <h3>Manage Users</h3>
                <p>View user accounts, manage roles, and keep the platform organized.</p>
            </div>
        </a>

        <a href="manage_cars.php" class="dashboard-action-card dashboard-image-card admin-cars-card">
            <div class="dashboard-card-overlay"></div>
            <div class="dashboard-card-content">
                <h3>Manage Cars</h3>
                <p>Review all car listings, control published content, and maintain quality.</p>
            </div>
        </a>

        <a href="manage_comments.php" class="dashboard-action-card dashboard-image-card admin-comments-card">
            <div class="dashboard-card-overlay"></div>
            <div class="dashboard-card-content">
                <h3>Manage Comments</h3>
                <p>Moderate user comments and remove inappropriate content when needed.</p>
            </div>
        </a>

        <a href="reports.php" class="dashboard-action-card dashboard-image-card admin-reports-card">
            <div class="dashboard-card-overlay"></div>
            <div class="dashboard-card-content">
                <h3>Reports</h3>
                <p>Generate report insights for popularity, creators, and platform activity.</p>
            </div>
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>