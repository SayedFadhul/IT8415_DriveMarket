<?php
require_once 'config/db.php';
$conn = getConnection();

$sql = "SELECT c.*, 
        AVG(r.rating_value) AS avg_rating, 
        COUNT(r.rating_id) AS total_ratings
        FROM dbProj_cars c
        LEFT JOIN dbProj_ratings r ON c.car_id = r.car_id
        WHERE c.status = 'published'
        GROUP BY c.car_id
        ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<h2>Available Cars</h2>

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
            <p><strong>Rating:</strong>
                <?php
                if ($car['total_ratings'] > 0) {
                    echo number_format($car['avg_rating'], 1) . " / 5";
                    echo " (" . (int) $car['total_ratings'] . " ratings)";
                } else {
                    echo "No ratings yet";
                }
                ?>
            </p>
            <p><?php echo htmlspecialchars($car['short_description']); ?></p>

            <a href="car_details.php?id=<?php echo $car['car_id']; ?>">View More</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No cars available at the moment.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>