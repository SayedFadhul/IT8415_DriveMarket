<?php include 'includes/header.php'; ?>

<h2>Welcome to DriveMarket</h2>
<p>This is the home page of the Car Listing and Review Web Application.</p>

<?php if (isset($_SESSION['user_id'])): ?>
    <p><strong>You are logged in as:</strong> <?php echo htmlspecialchars($_SESSION['role']); ?></p>
<?php else: ?>
    <p><strong>You are currently browsing as a guest.</strong></p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>