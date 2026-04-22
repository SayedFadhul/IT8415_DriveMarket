<?php
require_once 'config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
    die("Car not found.");
}

$conn = getConnection();
$car_id = (int) $_GET['id'];
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    if (isset($_POST['comment_text'])) {
        $comment_text = trim($_POST['comment_text'] ?? '');

        if (mb_strlen($comment_text) > 500) {
            $message = "Comment is too long.";
        } elseif ($comment_text === '') {
            $message = "Comment cannot be empty.";
        } else {
            $insert_sql = "INSERT INTO dbProj_comments (car_id, user_id, comment_text) VALUES (?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "iis", $car_id, $_SESSION['user_id'], $comment_text);
            mysqli_stmt_execute($insert_stmt);
            $message = "Comment added successfully.";
        }

        header("Location: car_details.php?id=" . $car_id . "&msg=" . urlencode($message));
        exit();
    }

    if (isset($_POST['rating_value'])) {
        $rating_value = (int) $_POST['rating_value'];

        if ($rating_value >= 1 && $rating_value <= 5) {
            $check_sql = "SELECT rating_id FROM dbProj_ratings WHERE car_id = ? AND user_id = ?";
            $check_stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($check_stmt, "ii", $car_id, $_SESSION['user_id']);
            mysqli_stmt_execute($check_stmt);
            $check_result = mysqli_stmt_get_result($check_stmt);

            if (mysqli_num_rows($check_result) > 0) {
                $update_sql = "UPDATE dbProj_ratings SET rating_value = ? WHERE car_id = ? AND user_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "iii", $rating_value, $car_id, $_SESSION['user_id']);
                mysqli_stmt_execute($update_stmt);
                $message = "Rating updated successfully.";
            } else {
                $insert_rating_sql = "INSERT INTO dbProj_ratings (car_id, user_id, rating_value) VALUES (?, ?, ?)";
                $insert_rating_stmt = mysqli_prepare($conn, $insert_rating_sql);
                mysqli_stmt_bind_param($insert_rating_stmt, "iii", $rating_value, $car_id, $_SESSION['user_id']);
                mysqli_stmt_execute($insert_rating_stmt);
                $message = "Rating submitted successfully.";
            }

            header("Location: car_details.php?id=" . $car_id . "&msg=" . urlencode($message));
            exit();
        } else {
            $message = "Please select a valid rating.";
            header("Location: car_details.php?id=" . $car_id . "&msg=" . urlencode($message));
            exit();
        }
    }
}

if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
}

$sql = "SELECT * FROM dbProj_cars WHERE car_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $car_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$car = mysqli_fetch_assoc($result);

if (!$car) {
    die("Car not found.");
}

$comments_sql = "SELECT c.comment_text, c.created_at, u.username
                 FROM dbProj_comments c
                 JOIN dbProj_users u ON c.user_id = u.user_id
                 WHERE c.car_id = ?
                 ORDER BY c.created_at DESC";
$comments_stmt = mysqli_prepare($conn, $comments_sql);
mysqli_stmt_bind_param($comments_stmt, "i", $car_id);
mysqli_stmt_execute($comments_stmt);
$comments_result = mysqli_stmt_get_result($comments_stmt);

$rating_avg_sql = "SELECT AVG(rating_value) AS avg_rating, COUNT(*) AS total_ratings
                   FROM dbProj_ratings
                   WHERE car_id = ?";
$rating_avg_stmt = mysqli_prepare($conn, $rating_avg_sql);
mysqli_stmt_bind_param($rating_avg_stmt, "i", $car_id);
mysqli_stmt_execute($rating_avg_stmt);
$rating_avg_result = mysqli_stmt_get_result($rating_avg_stmt);
$rating_data = mysqli_fetch_assoc($rating_avg_result);

$user_rating = null;
if (isset($_SESSION['user_id'])) {
    $user_rating_sql = "SELECT rating_value FROM dbProj_ratings WHERE car_id = ? AND user_id = ?";
    $user_rating_stmt = mysqli_prepare($conn, $user_rating_sql);
    mysqli_stmt_bind_param($user_rating_stmt, "ii", $car_id, $_SESSION['user_id']);
    mysqli_stmt_execute($user_rating_stmt);
    $user_rating_result = mysqli_stmt_get_result($user_rating_stmt);
    $user_rating_data = mysqli_fetch_assoc($user_rating_result);
    if ($user_rating_data) {
        $user_rating = (int) $user_rating_data['rating_value'];
    }
}

include 'includes/header.php';
?>

<div class="car-details-page">
    <div class="car-details-card">
        <div class="car-details-top">
            <div class="car-details-image-wrap">
                <?php if (!empty($car['image'])): ?>
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" class="car-details-image">
                <?php else: ?>
                    <div class="car-details-image car-details-placeholder">No Image</div>
                <?php endif; ?>
            </div>

            <div class="car-details-info">
                <h2 class="car-details-title"><?php echo htmlspecialchars($car['title']); ?></h2>

                <?php if ($message !== ''): ?>
                    <p class="car-details-message"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>

                <div class="car-meta-grid">
                    <div class="car-meta-item"><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></div>
                    <div class="car-meta-item"><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></div>
                    <div class="car-meta-item"><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></div>
                    <div class="car-meta-item"><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></div>
                </div>

                <div class="rating-summary-box">
                    <h3>Rating</h3>
                    <p>
                        <strong>Average Rating:</strong>
                        <?php
                        if ($rating_data['total_ratings'] > 0) {
                            echo number_format($rating_data['avg_rating'], 1) . " / 5";
                            echo " (" . (int) $rating_data['total_ratings'] . " ratings)";
                        } else {
                            echo "No ratings yet.";
                        }
                        ?>
                    </p>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form method="POST" class="car-details-rating-form">
                            <p><strong>Rate this car:</strong></p>

                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating_value" value="5" <?php if ($user_rating === 5) echo 'checked'; ?> required>
                                <label for="star5" title="5 stars">&#9733;</label>

                                <input type="radio" id="star4" name="rating_value" value="4" <?php if ($user_rating === 4) echo 'checked'; ?>>
                                <label for="star4" title="4 stars">&#9733;</label>

                                <input type="radio" id="star3" name="rating_value" value="3" <?php if ($user_rating === 3) echo 'checked'; ?>>
                                <label for="star3" title="3 stars">&#9733;</label>

                                <input type="radio" id="star2" name="rating_value" value="2" <?php if ($user_rating === 2) echo 'checked'; ?>>
                                <label for="star2" title="2 stars">&#9733;</label>

                                <input type="radio" id="star1" name="rating_value" value="1" <?php if ($user_rating === 1) echo 'checked'; ?>>
                                <label for="star1" title="1 star">&#9733;</label>
                            </div>

                            <button type="submit">Submit Rating</button>
                        </form>
                    <?php else: ?>
                        <p>You must <a href="login.php">log in</a> to rate this car.</p>
                    <?php endif; ?>
                </div>

                <div class="car-actions-box">
                    <h3>Actions</h3>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <p>You must <a href="login.php">log in</a> to make an offer or book a test drive.</p>
                    <?php elseif ((int) $car['creator_id'] === (int) $_SESSION['user_id']): ?>
                        <p>You cannot make an offer or book a test drive for your own car.</p>
                    <?php else: ?>
                        <a href="offers.php?car_id=<?php echo $car['car_id']; ?>" class="action-btn">Make Offer</a>
                        <a href="appointments.php?car_id=<?php echo $car['car_id']; ?>" class="action-btn">Book Test Drive</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="car-description-box">
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($car['full_description'])); ?></p>
        </div>

        <div class="car-comments-box">
            <h3>Comments</h3>

            <?php if (mysqli_num_rows($comments_result) > 0): ?>
                <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                    <div class="comment-card">
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong></p>
                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                        <small><?php echo htmlspecialchars($comment['created_at']); ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <h3>Add Comment</h3>
                <form method="POST" class="car-comment-form">
                    <textarea name="comment_text" rows="4" maxlength="500" required placeholder="Write your comment here..."></textarea>
                    <button type="submit">Post Comment</button>
                </form>
            <?php else: ?>
                <p>You must <a href="login.php">log in</a> to add a comment.</p>
            <?php endif; ?>
        </div>

        <a href="cars.php" class="back-link">Back to Cars</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>