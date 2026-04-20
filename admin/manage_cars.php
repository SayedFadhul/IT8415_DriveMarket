<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove_car_id'])) {
    $remove_car_id = (int) $_POST['remove_car_id'];

    $remove_sql = "UPDATE dbProj_cars
                   SET status = 'removed',
                       short_description = CONCAT(short_description, ' [Removed by admin]')
                   WHERE car_id = ?";
    $remove_stmt = mysqli_prepare($conn, $remove_sql);
    mysqli_stmt_bind_param($remove_stmt, "i", $remove_car_id);

    if (mysqli_stmt_execute($remove_stmt)) {
        $message = "Car listing removed successfully.";
    } else {
        $message = "Error removing car listing.";
    }
}

$sql = "SELECT c.*, u.username
        FROM dbProj_cars c
        JOIN dbProj_users u ON c.creator_id = u.user_id
        ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $sql);

include '../includes/header.php';
?>

<h2>Manage Cars</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($car = mysqli_fetch_assoc($result)): ?>
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px;">
            <h3><?php echo htmlspecialchars($car['title']); ?></h3>

            <?php if (!empty($car['image'])): ?>
                <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" style="width:250px; height:auto; border-radius:8px; margin-bottom:10px;">
            <?php endif; ?>

            <p><strong>Creator:</strong> <?php echo htmlspecialchars($car['username']); ?></p>
            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
            <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
            <p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
            <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($car['status']); ?></p>
            <p><?php echo htmlspecialchars($car['short_description']); ?></p>

            <?php if ($car['status'] !== 'removed'): ?>
                <form method="POST" style="margin-top:10px;">
                    <input type="hidden" name="remove_car_id" value="<?php echo $car['car_id']; ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to remove this car?');">Remove Car</button>
                </form>
            <?php else: ?>
                <p><strong>System Message:</strong> This listing has been removed by the administrator.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No car listings found.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>