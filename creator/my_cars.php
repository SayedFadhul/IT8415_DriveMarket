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

<h2>My Car Listings</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($car = mysqli_fetch_assoc($result)): ?>
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px;">
            <h3><?php echo htmlspecialchars($car['title']); ?></h3>

            <?php if (!empty($car['image'])): ?>
                <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" style="width:250px; height:auto; border-radius:8px; margin-bottom:10px;">
            <?php endif; ?>

            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
            <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
            <p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
            <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($car['status']); ?></p>
            <p><?php echo htmlspecialchars($car['short_description']); ?></p>

            <a href="edit_car.php?id=<?php echo $car['car_id']; ?>">Edit</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>You have not added any car listings yet.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>