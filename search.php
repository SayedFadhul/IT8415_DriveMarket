<?php
require_once 'config/db.php';
$conn = getConnection();

$title = isset($_GET['title']) ? trim($_GET['title']) : '';
$date_from = isset($_GET['date_from']) ? trim($_GET['date_from']) : '';
$date_to = isset($_GET['date_to']) ? trim($_GET['date_to']) : '';
$creator = isset($_GET['creator']) ? trim($_GET['creator']) : '';
$min_rating = isset($_GET['min_rating']) ? trim($_GET['min_rating']) : '';

$limit = 10;
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$base_sql = " FROM dbProj_cars c
              JOIN dbProj_users u ON c.creator_id = u.user_id
              LEFT JOIN dbProj_ratings r ON c.car_id = r.car_id
              WHERE c.status = 'published'";

$params = [];
$types = "";

if ($title !== "") {
    $base_sql .= " AND MATCH(c.title, c.short_description) AGAINST (?)";
    $params[] = $title;
    $types .= "s";
}

if ($date_from !== "") {
    $base_sql .= " AND DATE(c.created_at) >= ?";
    $params[] = $date_from;
    $types .= "s";
}

if ($date_to !== "") {
    $base_sql .= " AND DATE(c.created_at) <= ?";
    $params[] = $date_to;
    $types .= "s";
}

if ($creator !== "") {
    $base_sql .= " AND u.username LIKE ?";
    $params[] = "%" . $creator . "%";
    $types .= "s";
}

$group_having = " GROUP BY c.car_id";

if ($min_rating !== "") {
    $group_having .= " HAVING AVG(r.rating_value) >= ?";
    $params[] = $min_rating;
    $types .= "d";
}

$count_sql = "SELECT COUNT(*) AS total FROM (
                SELECT c.car_id" . $base_sql . $group_having . "
              ) AS filtered_results";

$count_stmt = mysqli_prepare($conn, $count_sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($count_stmt, $types, ...$params);
}
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = (int)$count_row['total'];
$total_pages = ceil($total_records / $limit);

$search_sql = "SELECT c.*, u.username,
                      AVG(r.rating_value) AS avg_rating,
                      COUNT(r.rating_id) AS total_ratings"
              . $base_sql
              . $group_having .
              " ORDER BY c.created_at DESC
                LIMIT ? OFFSET ?";

$search_stmt = mysqli_prepare($conn, $search_sql);

$final_params = $params;
$final_types = $types . "ii";
$final_params[] = $limit;
$final_params[] = $offset;

mysqli_stmt_bind_param($search_stmt, $final_types, ...$final_params);
mysqli_stmt_execute($search_stmt);
$result = mysqli_stmt_get_result($search_stmt);

include 'includes/header.php';
?>

<div class="search-page">
    <h2 class="search-page-title">Search Cars</h2>

    <div class="search-form-box">
        <form method="GET" class="search-form-grid">
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>">
            </div>

            <div>
                <label for="date_from">Date From</label>
                <input type="date" name="date_from" id="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
            </div>

            <div>
                <label for="date_to">Date To</label>
                <input type="date" name="date_to" id="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
            </div>

            <div>
                <label for="creator">Creator Username</label>
                <input type="text" name="creator" id="creator" value="<?php echo htmlspecialchars($creator); ?>">
            </div>

            <div>
                <label for="min_rating">Minimum Rating</label>
                <select name="min_rating" id="min_rating">
                    <option value="">Any</option>
                    <option value="1" <?php if ($min_rating === '1') echo 'selected'; ?>>1+</option>
                    <option value="2" <?php if ($min_rating === '2') echo 'selected'; ?>>2+</option>
                    <option value="3" <?php if ($min_rating === '3') echo 'selected'; ?>>3+</option>
                    <option value="4" <?php if ($min_rating === '4') echo 'selected'; ?>>4+</option>
                    <option value="5" <?php if ($min_rating === '5') echo 'selected'; ?>>5</option>
                </select>
            </div>

            <div class="search-form-actions">
                <button type="submit">Search</button>
                <a href="search.php" class="search-reset-btn">Reset</a>
            </div>
        </form>
    </div>

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
                            <p><strong>Creator:</strong> <?php echo htmlspecialchars($car['username']); ?></p>
                        </div>

                        <p class="car-card-rating">
                            <strong>Rating:</strong>
                            <?php
                            if ($car['total_ratings'] > 0) {
                                echo number_format($car['avg_rating'], 1) . " / 5";
                                echo " (" . (int)$car['total_ratings'] . " ratings)";
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
                <?php
                $query_params = $_GET;
                if ($page > 1):
                    $query_params['page'] = $page - 1;
                ?>
                    <a href="search.php?<?php echo htmlspecialchars(http_build_query($query_params)); ?>" class="pagination-link">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php $query_params['page'] = $i; ?>
                    <a href="search.php?<?php echo htmlspecialchars(http_build_query($query_params)); ?>" class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages):
                    $query_params['page'] = $page + 1;
                ?>
                    <a href="search.php?<?php echo htmlspecialchars(http_build_query($query_params)); ?>" class="pagination-link">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="search-empty-box">
            <p>No matching cars found.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>