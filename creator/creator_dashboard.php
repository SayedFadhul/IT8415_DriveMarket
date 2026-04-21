<?php
require_once '../includes/auth.php';
requireRole('creator');
include '../includes/header.php';
?>

<div class="dashboard-page">
    <div class="dashboard-hero creator-hero">
        <div>
            <span class="dashboard-badge">Creator Panel</span>
            <h2>Creator Dashboard</h2>
            <p>Welcome, Creator. Manage your car listings, add new entries, and keep track of your published content.</p>
        </div>
    </div>

    <div class="dashboard-card-grid">
        <a href="add_car.php" class="dashboard-action-card dashboard-image-card add-car-card">
            <div class="dashboard-card-overlay"></div>
            <div class="dashboard-card-content">
                <h3>Add New Car Listing</h3>
                <p>Create a new car listing with title, details, image, and pricing information.</p>
            </div>
        </a>

        <a href="my_cars.php" class="dashboard-action-card dashboard-image-card my-cars-card">
            <div class="dashboard-card-overlay"></div>
            <div class="dashboard-card-content">
                <h3>View My Cars</h3>
                <p>See all your car listings, review their details, and manage your content easily.</p>
            </div>
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>