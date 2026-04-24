<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('creator');

$conn = getConnection();
$user_id = $_SESSION['user_id'];
$limit = 9;
$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;

$count_sql = "SELECT COUNT(*) AS total FROM dbProj_cars WHERE creator_id = ?";
$count_stmt = mysqli_prepare($conn, $count_sql);
mysqli_stmt_bind_param($count_stmt, "i", $user_id);
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = (int) mysqli_fetch_assoc($count_result)['total'];
$total_pages = max(1, (int) ceil($total_records / $limit));

if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM dbProj_cars WHERE creator_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iii", $user_id, $limit, $offset);
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
                            <span class="creator-status-badge <?php echo $car['status'] === 'published' ? 'published' : ($car['status'] === 'removed' ? 'removed' : 'draft'); ?>">
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

        <?php if ($total_pages > 1): ?>
            <div class="pagination-box">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="my_cars.php?page=<?php echo $i; ?>" class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state-box">
            <h3>No car listings yet</h3>
            <p>You have not added any car listings yet. Start by creating your first listing.</p>
            <a href="add_car.php" class="car-card-link">Add New Car</a>
        </div>
    <?php endif; ?>

    <p style="margin-top: 20px;">
        <a href="creator_dashboard.php" class="back-link">Return to Creator Dashboard</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>