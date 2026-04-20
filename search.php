<?php
require_once 'config/db.php';
$conn = getConnection();

$title = isset($_GET['title']) ? trim($_GET['title']) : '';
$date_from = isset($_GET['date_from']) ? trim($_GET['date_from']) : '';
$date_to = isset($_GET['date_to']) ? trim($_GET['date_to']) : '';
$creator = isset($_GET['creator']) ? trim($_GET['creator']) : '';
$min_rating = isset($_GET['min_rating']) ? trim($_GET['min_rating']) : '';

$sql = "SELECT c.*, u.username,
        AVG(r.rating_value) AS avg_rating,
        COUNT(r.rating_id) AS total_ratings
        FROM dbProj_cars c
        JOIN dbProj_users u ON c.creator_id = u.user_id
        LEFT JOIN dbProj_ratings r ON c.car_id = r.car_id
        WHERE c.status = 'published'";

$params = [];
$types = "";

if ($title !== "") {
    $sql .= " AND c.title LIKE ?";
    $params[] = "%" . $title . "%";
    $types .= "s";
}

if ($date_from !== "") {
    $sql .= " AND DATE(c.created_at) >= ?";
    $params[] = $date_from;
    $types .= "s";
}

if ($date_to !== "") {
    $sql .= " AND DATE(c.created_at) <= ?";
    $params[] = $date_to;
    $types .= "s";
}

if ($creator !== "") {
    $sql .= " AND u.username LIKE ?";
    $params[] = "%" . $creator . "%";
    $types .= "s";
}

$sql .= " GROUP BY c.car_id";

if ($min_rating !== "") {
    $sql .= " HAVING AVG(r.rating_value) >= ?";
    $params[] = (float)$min_rating;
    $types .= "d";
}

$sql .= " ORDER BY c.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include 'includes/header.php';
?>

<h2>Search Cars</h2>

<form method="GET">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"><br><br>

    <label>Date From:</label><br>
    <input type="date" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>"><br><br>

    <label>Date To:</label><br>
    <input type="date" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>"><br><br>

    <label>Creator Username:</label><br>
    <input type="text" name="creator" value="<?php echo htmlspecialchars($creator); ?>"><br><br>

    <label>Minimum Rating:</label><br>
    <select name="min_rating">
        <option value="">Any</option>
        <option value="1" <?php if ($min_rating === '1') echo 'selected'; ?>>1+</option>
        <option value="2" <?php if ($min_rating === '2') echo 'selected'; ?>>2+</option>
        <option value="3" <?php if ($min_rating === '3') echo 'selected'; ?>>3+</option>
        <option value="4" <?php if ($min_rating === '4') echo 'selected'; ?>>4+</option>
        <option value="5" <?php if ($min_rating === '5') echo 'selected'; ?>>5 only</option>
    </select><br><br>

    <button type="submit">Search</button>
</form>

<hr>

<h3>Search Results</h3>

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

            <p><strong>Rating:</strong>
            <?php
            if ($car['total_ratings'] > 0) {
                echo number_format($car['avg_rating'], 1) . " / 5";
                echo " (" . (int)$car['total_ratings'] . " ratings)";
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
    <p>No cars match your search.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>