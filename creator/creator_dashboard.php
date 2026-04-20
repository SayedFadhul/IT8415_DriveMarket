<?php
require_once '../includes/auth.php';
requireRole('creator');
include '../includes/header.php';
?>

<h2>Creator Dashboard</h2>
<p>Welcome, Creator. You can manage your car listings here.</p>

<ul>
    <li><a href="add_car.php">Add New Car Listing</a></li>
    <li><a href="my_cars.php">View My Cars</a></li>
</ul>

<?php include '../includes/footer.php'; ?>