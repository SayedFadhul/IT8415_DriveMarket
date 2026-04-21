<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('creator');

$conn = getConnection();

$sql = "SELECT * FROM dbProj_cars WHERE creator_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include '../includes/header.php';
?>

<div class="creator-cars-page">
    <div class="form-hero creator-hero">
        <span class="dashboard-badge">Creator Panel</span>
        <h2>My Car Listings</h2>
        <p>View, review, and update all the cars you have added to DriveMarket.</p>
    </div>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="cars-grid">
            <?php while ($car = mysqli_fetch_assoc($result)): ?>
                <div class="car-card creator-car-card">
                    <?php if (!empty($car['image'])): ?>
                        <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" class="car-card-image">
                    <?php else: ?>
                        <div class="car-card-image car-card-placeholder">No Image</div>
                    <?php endif; ?>

                    <div class="car-card-body">
                        <div class="creator-car-top">
                            <h3 class="car-card-title"><?php echo htmlspecialchars($car['title']); ?></h3>
                            <span class="creator-status-badge <?php echo $car['status'] === 'published' ? 'published' : 'draft'; ?>">
                                <?php echo htmlspecialchars(ucfirst($car['status'])); ?>
                            </span>
                        </div>

                        <div class="car-card-meta">
                            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                            <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                            <p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
                            <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
                        </div>

                        <p class="car-card-description"><?php echo htmlspecialchars($car['short_description']); ?></p>

                        <div class="creator-car-actions">
                            <a href="../car_details.php?id=<?php echo $car['car_id']; ?>" class="car-card-link">View</a>
                            <a href="edit_car.php?id=<?php echo $car['car_id']; ?>" class="car-card-link secondary-link">Edit</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state-box">
            <h3>No car listings yet</h3>
            <p>You have not added any car listings yet. Start by creating your first listing.</p>
            <a href="add_car.php" class="car-card-link">Add New Car</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>