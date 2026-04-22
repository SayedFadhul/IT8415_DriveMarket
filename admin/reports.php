<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();

$from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
$to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
$selected_creator = isset($_GET['creator']) ? trim($_GET['creator']) : '';

$popular_result = null;
$popular_message = '';
$creator_cars_result = null;
$creator_message = '';

$creator_sql = "SELECT user_id, username
                FROM dbProj_users
                WHERE role = 'creator'
                ORDER BY username ASC";
$creator_result = mysqli_query($conn, $creator_sql);

if (isset($_GET['popular_report'])) {
    if ($from_date !== '' && $to_date !== '') {
        $popular_sql = "SELECT c.title, u.username,
                               COALESCE(AVG(r.rating_value), 0) AS avg_rating,
                               COUNT(r.rating_id) AS rating_count
                        FROM dbProj_cars c
                        JOIN dbProj_users u ON c.creator_id = u.user_id
                        LEFT JOIN dbProj_ratings r ON c.car_id = r.car_id
                        WHERE c.status = 'published'
                          AND DATE(c.created_at) BETWEEN ? AND ?
                        GROUP BY c.car_id, c.title, u.username
                        ORDER BY avg_rating DESC, rating_count DESC";

        $popular_stmt = mysqli_prepare($conn, $popular_sql);
        mysqli_stmt_bind_param($popular_stmt, "ss", $from_date, $to_date);
        mysqli_stmt_execute($popular_stmt);
        $popular_result = mysqli_stmt_get_result($popular_stmt);
    } else {
        $popular_message = "Please select both dates.";
    }
}

if (isset($_GET['creator_report'])) {
    if ($selected_creator !== '') {
        $creator_cars_sql = "CALL sp_GetCarsByCreator(?)";
        $creator_cars_stmt = mysqli_prepare($conn, $creator_cars_sql);
        mysqli_stmt_bind_param($creator_cars_stmt, "i", $selected_creator);
        mysqli_stmt_execute($creator_cars_stmt);
        $creator_cars_result = mysqli_stmt_get_result($creator_cars_stmt);
    } else {
        $creator_message = "Please select a creator.";
    }
}

include '../includes/header.php';
?>

<div class="admin-manage-page">
    <div class="form-hero admin-hero">
        <span class="dashboard-badge">Admin Panel</span>
        <h2>Reports</h2>
        <p>Generate car performance insights by date range and review listings created by each creator.</p>
    </div>

    <div class="reports-grid">
        <div class="report-box">
            <h3>Most Popular Cars</h3>
            <p class="report-subtext">Generate the most popular published cars within a selected date range.</p>

            <form method="GET" class="report-form-grid">
                <div class="form-field">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" id="from_date" value="<?php echo htmlspecialchars($from_date); ?>">
                </div>

                <div class="form-field">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" id="to_date" value="<?php echo htmlspecialchars($to_date); ?>">
                </div>

                <div class="form-field report-form-action">
                    <button type="submit" name="popular_report" class="form-main-btn">Generate</button>
                </div>
            </form>

            <?php if ($popular_message !== ''): ?>
                <div class="auth-message error" style="margin-top: 16px;">
                    <?php echo htmlspecialchars($popular_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($popular_result): ?>
                <div class="report-results-box">
                    <h3>Popular Cars Results</h3>

                    <?php if (mysqli_num_rows($popular_result) > 0): ?>
                        <div class="report-table-wrap">
                            <table>
                                <tr>
                                    <th>Car Title</th>
                                    <th>Creator</th>
                                    <th>Average Rating</th>
                                    <th>Rating Count</th>
                                </tr>

                                <?php while ($row = mysqli_fetch_assoc($popular_result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td><?php echo number_format($row['avg_rating'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($row['rating_count']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="empty-text">No cars found for this date range.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="report-box">
            <h3>Cars by Creator</h3>
            <p class="report-subtext">Select a creator to view all car listings they have added.</p>

            <form method="GET" class="report-form-grid">
                <div class="form-field form-field-full">
                    <label for="creator">Creator Username</label>
                    <select name="creator" id="creator">
                        <option value="">Select Creator</option>
                        <?php if ($creator_result && mysqli_num_rows($creator_result) > 0): ?>
                            <?php while ($creator = mysqli_fetch_assoc($creator_result)): ?>
                                <option value="<?php echo $creator['user_id']; ?>" <?php if ($selected_creator == $creator['user_id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($creator['username']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-field report-form-action">
                    <button type="submit" name="creator_report" class="form-main-btn">Generate</button>
                </div>
            </form>

            <?php if ($creator_message !== ''): ?>
                <div class="auth-message error" style="margin-top: 16px;">
                    <?php echo htmlspecialchars($creator_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($creator_cars_result): ?>
                <div class="report-results-box">
                    <h3>Creator Cars Results</h3>

                    <?php if (mysqli_num_rows($creator_cars_result) > 0): ?>
                        <div class="report-cards-list">
                            <?php while ($car = mysqli_fetch_assoc($creator_cars_result)): ?>
                                <div class="report-car-card">
                                    <p><strong>Title:</strong> <?php echo htmlspecialchars($car['title']); ?></p>
                                    <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                                    <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                                    <p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
                                    <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
                                    <p><strong>Status:</strong> <?php echo htmlspecialchars($car['status']); ?></p>
                                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($car['created_at']); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="empty-text">No cars found for this creator.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<p style="margin-top: 20px;">
    <a href="admin_dashboard.php" class="back-link">Return to Admin Dashboard</a>
</p>
<?php include '../includes/footer.php'; ?>