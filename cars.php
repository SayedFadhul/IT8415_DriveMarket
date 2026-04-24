<?php
require_once 'config/db.php';
$conn = getConnection();

$limit = 9;
$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$count_sql = "SELECT COUNT(*) AS total FROM dbProj_cars WHERE status = 'published'";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = (int) $count_row['total'];
$total_pages = ceil($total_records / $limit);

$sql = "SELECT c.*, 
        AVG(r.rating_value) AS avg_rating, 
        COUNT(r.rating_id) AS total_ratings
        FROM dbProj_cars c
        LEFT JOIN dbProj_ratings r ON c.car_id = r.car_id
        WHERE c.status = 'published'
        GROUP BY c.car_id
        ORDER BY c.created_at DESC
        LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include 'includes/header.php';
?>

<div class="cars-page">
    <h2 class="cars-page-title">Available Cars</h2>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="cars-grid">
            <?php while ($car = mysqli_fetch_assoc($result)): ?>
                <div class="car-card">
                    <?php if (!empty($car['image'])): ?>
                        <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" class="car-card-image">
                    <?php else: ?>
                        <div class="car-card-image car-card-placeholder">No Image</div>
                    <?php endif; ?>

                    <div class="car-card-body">
                        <h3 class="car-card-title"><?php echo htmlspecialchars($car['title']); ?></h3>

                        <div class="car-card-meta">
                            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                            <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                            <p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
                            <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
                        </div>

                        <p class="car-card-rating">
                            <strong>Rating:</strong>
                            <?php
                            if ($car['total_ratings'] > 0) {
                                echo number_format($car['avg_rating'], 1) . " / 5";
                                echo " (" . (int) $car['total_ratings'] . " ratings)";
                            } else {
                                echo "No ratings yet";
                            }
                            ?>
                        </p>

                        <p class="car-card-description"><?php echo htmlspecialchars($car['short_description']); ?></p>

                        <a href="car_details.php?id=<?php echo $car['car_id']; ?>" class="car-card-link">View More</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination-box">
                <?php if ($page > 1): ?>
                    <a href="cars.php?page=<?php echo $page - 1; ?>" class="pagination-link">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="cars.php?page=<?php echo $i; ?>" class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="cars.php?page=<?php echo $page + 1; ?>" class="pagination-link">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p>No cars available at the moment.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>