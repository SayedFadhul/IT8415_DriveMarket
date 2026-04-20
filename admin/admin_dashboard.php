<?php
require_once '../includes/auth.php';
requireRole('admin');
include '../includes/header.php';
?>

<h2>Admin Dashboard</h2>
<p>Welcome, Admin. You can manage users, cars, comments, and reports here.</p>

<ul>
    <li><a href="manage_users.php">Manage Users</a></li>
    <li><a href="manage_cars.php">Manage Cars</a></li>
    <li><a href="manage_comments.php">Manage Comments</a></li>
    <li><a href="reports.php">Reports</a></li>
</ul>

<?php include '../includes/footer.php'; ?>