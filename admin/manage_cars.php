<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();
$message = '';
$message_type = '';
$limit = 12;
$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['remove_car_id'])) {
        $remove_car_id = (int) $_POST['remove_car_id'];

        $remove_sql = "UPDATE dbProj_cars
                       SET status = 'removed'
                       WHERE car_id = ?";
        $remove_stmt = mysqli_prepare($conn, $remove_sql);
        mysqli_stmt_bind_param($remove_stmt, "i", $remove_car_id);

        if (mysqli_stmt_execute($remove_stmt)) {
            $message = "Car listing removed successfully.";
            $message_type = 'success';
        } else {
            $message = "Error removing car listing.";
            $message_type = 'error';
        }
    }

    if (isset($_POST['restore_car_id'])) {
        $restore_car_id = (int) $_POST['restore_car_id'];

        $restore_sql = "UPDATE dbProj_cars
                        SET status = 'draft'
                        WHERE car_id = ?";
        $restore_stmt = mysqli_prepare($conn, $restore_sql);
        mysqli_stmt_bind_param($restore_stmt, "i", $restore_car_id);

        if (mysqli_stmt_execute($restore_stmt)) {
            $message = "Car listing restored to draft successfully.";
            $message_type = 'success';
        } else {
            $message = "Error restoring car listing.";
            $message_type = 'error';
        }
    }

    header("Location: manage_cars.php?page=" . $page);
    exit();
}

$count_sql = "SELECT COUNT(*) AS total FROM dbProj_cars";
$count_result = mysqli_query($conn, $count_sql);
$total_records = (int) mysqli_fetch_assoc($count_result)['total'];
$total_pages = max(1, (int) ceil($total_records / $limit));

if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT c.*, u.username
        FROM dbProj_cars c
        JOIN dbProj_users u ON c.creator_id = u.user_id
        ORDER BY c.created_at DESC
        LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include '../includes/header.php';
?>

<div class="admin-manage-page">
    <div class="form-hero admin-hero">
        <span class="dashboard-badge">Admin Panel</span>
        <h2>Manage Cars</h2>
        <p>Review all car listings, monitor their status, remove listings, and restore removed cars back to draft.</p>
    </div>

    <?php if ($message !== ''): ?>
        <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="cars-grid">
            <?php while ($car = mysqli_fetch_assoc($result)): ?>
                <div class="car-card admin-car-card">
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
                            <p><strong>Creator:</strong> <?php echo htmlspecialchars($car['username']); ?></p>
                            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                            <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                            <p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
                            <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
                        </div>

                        <p class="car-card-description"><?php echo htmlspecialchars($car['short_description']); ?></p>

                        <?php if ($car['status'] === 'removed'): ?>
                            <p class="admin-system-note"><strong>System Message:</strong> This listing has been removed by the administrator.</p>
                        <?php endif; ?>

                        <div class="creator-car-actions">
                            <a href="../car_details.php?id=<?php echo $car['car_id']; ?>" class="car-card-link">View</a>

                            <?php if ($car['status'] !== 'removed'): ?>
                                <form method="POST" class="inline-action-form">
                                    <input type="hidden" name="remove_car_id" value="<?php echo $car['car_id']; ?>">
                                    <button type="submit" class="danger-btn" onclick="return confirm('Are you sure you want to remove this car?');">Remove</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" class="inline-action-form">
                                    <input type="hidden" name="restore_car_id" value="<?php echo $car['car_id']; ?>">
                                    <button type="submit" class="restore-btn">Restore to Draft</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination-box">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="manage_cars.php?page=<?php echo $i; ?>" class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state-box">
            <h3>No car listings found</h3>
            <p>There are currently no car listings in the system.</p>
        </div>
    <?php endif; ?>

    <p style="margin-top: 20px;">
        <a href="admin_dashboard.php" class="back-link">Return to Admin Dashboard</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>