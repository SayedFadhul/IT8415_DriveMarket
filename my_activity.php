<?php
require_once 'includes/auth.php';
require_once 'config/db.php';

requireLogin();

$conn = getConnection();
$user_id = $_SESSION['user_id'];
$limit = 5;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_comment_id'])) {
        $delete_id = (int) $_POST['delete_comment_id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM dbProj_comments WHERE comment_id = ? AND user_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $delete_id, $user_id);
        mysqli_stmt_execute($stmt);
    }

    if (isset($_POST['delete_rating_id'])) {
        $delete_id = (int) $_POST['delete_rating_id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM dbProj_ratings WHERE rating_id = ? AND user_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $delete_id, $user_id);
        mysqli_stmt_execute($stmt);
    }

    if (isset($_POST['delete_offer_id'])) {
        $delete_id = (int) $_POST['delete_offer_id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM dbProj_offers WHERE offer_id = ? AND user_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $delete_id, $user_id);
        mysqli_stmt_execute($stmt);
    }

    if (isset($_POST['delete_appointment_id'])) {
        $delete_id = (int) $_POST['delete_appointment_id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM dbProj_appointments WHERE appointment_id = ? AND user_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $delete_id, $user_id);
        mysqli_stmt_execute($stmt);
    }

    $query_string = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
    header("Location: my_activity.php" . $query_string);
    exit();
}

$comments_page = isset($_GET['comments_page']) && (int) $_GET['comments_page'] > 0 ? (int) $_GET['comments_page'] : 1;
$ratings_page = isset($_GET['ratings_page']) && (int) $_GET['ratings_page'] > 0 ? (int) $_GET['ratings_page'] : 1;
$offers_page = isset($_GET['offers_page']) && (int) $_GET['offers_page'] > 0 ? (int) $_GET['offers_page'] : 1;
$appointments_page = isset($_GET['appointments_page']) && (int) $_GET['appointments_page'] > 0 ? (int) $_GET['appointments_page'] : 1;

$comments_count_sql = "SELECT COUNT(*) AS total FROM dbProj_comments WHERE user_id = ?";
$comments_count_stmt = mysqli_prepare($conn, $comments_count_sql);
mysqli_stmt_bind_param($comments_count_stmt, "i", $user_id);
mysqli_stmt_execute($comments_count_stmt);
$comments_count_result = mysqli_stmt_get_result($comments_count_stmt);
$comments_total = (int) mysqli_fetch_assoc($comments_count_result)['total'];
$comments_total_pages = max(1, (int) ceil($comments_total / $limit));
if ($comments_page > $comments_total_pages) {
    $comments_page = $comments_total_pages;
}
$comments_offset = ($comments_page - 1) * $limit;

$comments_sql = "SELECT c.comment_id, c.comment_text, c.created_at, car.title
                 FROM dbProj_comments c
                 JOIN dbProj_cars car ON c.car_id = car.car_id
                 WHERE c.user_id = ?
                 ORDER BY c.created_at DESC
                 LIMIT ? OFFSET ?";
$comments_stmt = mysqli_prepare($conn, $comments_sql);
mysqli_stmt_bind_param($comments_stmt, "iii", $user_id, $limit, $comments_offset);
mysqli_stmt_execute($comments_stmt);
$comments_result = mysqli_stmt_get_result($comments_stmt);

$ratings_count_sql = "SELECT COUNT(*) AS total FROM dbProj_ratings WHERE user_id = ?";
$ratings_count_stmt = mysqli_prepare($conn, $ratings_count_sql);
mysqli_stmt_bind_param($ratings_count_stmt, "i", $user_id);
mysqli_stmt_execute($ratings_count_stmt);
$ratings_count_result = mysqli_stmt_get_result($ratings_count_stmt);
$ratings_total = (int) mysqli_fetch_assoc($ratings_count_result)['total'];
$ratings_total_pages = max(1, (int) ceil($ratings_total / $limit));
if ($ratings_page > $ratings_total_pages) {
    $ratings_page = $ratings_total_pages;
}
$ratings_offset = ($ratings_page - 1) * $limit;

$ratings_sql = "SELECT r.rating_id, r.rating_value, r.created_at, car.title
                FROM dbProj_ratings r
                JOIN dbProj_cars car ON r.car_id = car.car_id
                WHERE r.user_id = ?
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";
$ratings_stmt = mysqli_prepare($conn, $ratings_sql);
mysqli_stmt_bind_param($ratings_stmt, "iii", $user_id, $limit, $ratings_offset);
mysqli_stmt_execute($ratings_stmt);
$ratings_result = mysqli_stmt_get_result($ratings_stmt);

$offers_count_sql = "SELECT COUNT(*) AS total FROM dbProj_offers WHERE user_id = ?";
$offers_count_stmt = mysqli_prepare($conn, $offers_count_sql);
mysqli_stmt_bind_param($offers_count_stmt, "i", $user_id);
mysqli_stmt_execute($offers_count_stmt);
$offers_count_result = mysqli_stmt_get_result($offers_count_stmt);
$offers_total = (int) mysqli_fetch_assoc($offers_count_result)['total'];
$offers_total_pages = max(1, (int) ceil($offers_total / $limit));
if ($offers_page > $offers_total_pages) {
    $offers_page = $offers_total_pages;
}
$offers_offset = ($offers_page - 1) * $limit;

$offers_sql = "SELECT o.offer_id, o.offer_amount, o.message, o.created_at, car.title
               FROM dbProj_offers o
               JOIN dbProj_cars car ON o.car_id = car.car_id
               WHERE o.user_id = ?
               ORDER BY o.created_at DESC
               LIMIT ? OFFSET ?";
$offers_stmt = mysqli_prepare($conn, $offers_sql);
mysqli_stmt_bind_param($offers_stmt, "iii", $user_id, $limit, $offers_offset);
mysqli_stmt_execute($offers_stmt);
$offers_result = mysqli_stmt_get_result($offers_stmt);

$appointments_count_sql = "SELECT COUNT(*) AS total FROM dbProj_appointments WHERE user_id = ?";
$appointments_count_stmt = mysqli_prepare($conn, $appointments_count_sql);
mysqli_stmt_bind_param($appointments_count_stmt, "i", $user_id);
mysqli_stmt_execute($appointments_count_stmt);
$appointments_count_result = mysqli_stmt_get_result($appointments_count_stmt);
$appointments_total = (int) mysqli_fetch_assoc($appointments_count_result)['total'];
$appointments_total_pages = max(1, (int) ceil($appointments_total / $limit));
if ($appointments_page > $appointments_total_pages) {
    $appointments_page = $appointments_total_pages;
}
$appointments_offset = ($appointments_page - 1) * $limit;

$appointments_sql = "SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.notes, a.created_at, car.title
                     FROM dbProj_appointments a
                     JOIN dbProj_cars car ON a.car_id = car.car_id
                     WHERE a.user_id = ?
                     ORDER BY a.appointment_date DESC, a.appointment_time DESC
                     LIMIT ? OFFSET ?";
$appointments_stmt = mysqli_prepare($conn, $appointments_sql);
mysqli_stmt_bind_param($appointments_stmt, "iii", $user_id, $limit, $appointments_offset);
mysqli_stmt_execute($appointments_stmt);
$appointments_result = mysqli_stmt_get_result($appointments_stmt);

include 'includes/header.php';
?>

<div class="activity-page">
    <h2 class="activity-title">My Activity</h2>

    <div class="activity-grid">
        <div class="activity-section">
            <h3>My Comments</h3>
            <?php if ($comments_result && mysqli_num_rows($comments_result) > 0): ?>
                <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                    <div class="activity-item">
                        <p><strong>Car:</strong> <?php echo htmlspecialchars($comment['title']); ?></p>
                        <p><strong>Comment:</strong> <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($comment['created_at']); ?></p>

                        <form method="POST" class="inline-action-form" style="margin-top: 12px;">
                            <input type="hidden" name="delete_comment_id" value="<?php echo $comment['comment_id']; ?>">
                            <button type="submit" class="danger-btn" onclick="return confirm('Delete this comment?');">Remove</button>
                        </form>
                    </div>
                <?php endwhile; ?>

                <?php if ($comments_total_pages > 1): ?>
                    <div class="pagination-box">
                        <?php for ($i = 1; $i <= $comments_total_pages; $i++): ?>
                            <a href="my_activity.php?comments_page=<?php echo $i; ?>&ratings_page=<?php echo $ratings_page; ?>&offers_page=<?php echo $offers_page; ?>&appointments_page=<?php echo $appointments_page; ?>" class="pagination-link <?php echo $i === $comments_page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="empty-text">No comments yet.</p>
            <?php endif; ?>
        </div>

        <div class="activity-section">
            <h3>My Ratings</h3>
            <?php if ($ratings_result && mysqli_num_rows($ratings_result) > 0): ?>
                <?php while ($rating = mysqli_fetch_assoc($ratings_result)): ?>
                    <div class="activity-item">
                        <p><strong>Car:</strong> <?php echo htmlspecialchars($rating['title']); ?></p>
                        <p><strong>Rating:</strong> <span class="badge-value"><?php echo htmlspecialchars($rating['rating_value']); ?> / 5</span></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($rating['created_at']); ?></p>

                        <form method="POST" class="inline-action-form" style="margin-top: 12px;">
                            <input type="hidden" name="delete_rating_id" value="<?php echo $rating['rating_id']; ?>">
                            <button type="submit" class="danger-btn" onclick="return confirm('Delete this rating?');">Remove</button>
                        </form>
                    </div>
                <?php endwhile; ?>

                <?php if ($ratings_total_pages > 1): ?>
                    <div class="pagination-box">
                        <?php for ($i = 1; $i <= $ratings_total_pages; $i++): ?>
                            <a href="my_activity.php?comments_page=<?php echo $comments_page; ?>&ratings_page=<?php echo $i; ?>&offers_page=<?php echo $offers_page; ?>&appointments_page=<?php echo $appointments_page; ?>" class="pagination-link <?php echo $i === $ratings_page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="empty-text">No ratings yet.</p>
            <?php endif; ?>
        </div>

        <div class="activity-section">
            <h3>My Offers</h3>
            <?php if ($offers_result && mysqli_num_rows($offers_result) > 0): ?>
                <?php while ($offer = mysqli_fetch_assoc($offers_result)): ?>
                    <div class="activity-item">
                        <p><strong>Car:</strong> <?php echo htmlspecialchars($offer['title']); ?></p>
                        <p><strong>Offer Amount:</strong> <span class="badge-value">BHD <?php echo htmlspecialchars($offer['offer_amount']); ?></span></p>
                        <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($offer['message'])); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($offer['created_at']); ?></p>

                        <form method="POST" class="inline-action-form" style="margin-top: 12px;">
                            <input type="hidden" name="delete_offer_id" value="<?php echo $offer['offer_id']; ?>">
                            <button type="submit" class="danger-btn" onclick="return confirm('Delete this offer?');">Remove</button>
                        </form>
                    </div>
                <?php endwhile; ?>

                <?php if ($offers_total_pages > 1): ?>
                    <div class="pagination-box">
                        <?php for ($i = 1; $i <= $offers_total_pages; $i++): ?>
                            <a href="my_activity.php?comments_page=<?php echo $comments_page; ?>&ratings_page=<?php echo $ratings_page; ?>&offers_page=<?php echo $i; ?>&appointments_page=<?php echo $appointments_page; ?>" class="pagination-link <?php echo $i === $offers_page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="empty-text">No offers yet.</p>
            <?php endif; ?>
        </div>

        <div class="activity-section">
            <h3>My Test Drive Appointments</h3>
            <?php if ($appointments_result && mysqli_num_rows($appointments_result) > 0): ?>
                <?php while ($appointment = mysqli_fetch_assoc($appointments_result)): ?>
                    <div class="activity-item">
                        <p><strong>Car:</strong> <?php echo htmlspecialchars($appointment['title']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($appointment['appointment_date']); ?></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
                        <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($appointment['notes'])); ?></p>
                        <p><strong>Booked On:</strong> <?php echo htmlspecialchars($appointment['created_at']); ?></p>

                        <form method="POST" class="inline-action-form" style="margin-top: 12px;">
                            <input type="hidden" name="delete_appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                            <button type="submit" class="danger-btn" onclick="return confirm('Delete this appointment?');">Remove</button>
                        </form>
                    </div>
                <?php endwhile; ?>

                <?php if ($appointments_total_pages > 1): ?>
                    <div class="pagination-box">
                        <?php for ($i = 1; $i <= $appointments_total_pages; $i++): ?>
                            <a href="my_activity.php?comments_page=<?php echo $comments_page; ?>&ratings_page=<?php echo $ratings_page; ?>&offers_page=<?php echo $offers_page; ?>&appointments_page=<?php echo $i; ?>" class="pagination-link <?php echo $i === $appointments_page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="empty-text">No test drive appointments yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>