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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    if (isset($_POST['comment_text'])) {
        $comment_text = trim($_POST['comment_text']);

        if ($comment_text !== "") {
            $insert_sql = "INSERT INTO dbProj_comments (car_id, user_id, comment_text) VALUES (?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "iis", $car_id, $_SESSION['user_id'], $comment_text);
            mysqli_stmt_execute($insert_stmt);
        }
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
            } else {
                $insert_rating_sql = "INSERT INTO dbProj_ratings (car_id, user_id, rating_value) VALUES (?, ?, ?)";
                $insert_rating_stmt = mysqli_prepare($conn, $insert_rating_sql);
                mysqli_stmt_bind_param($insert_rating_stmt, "iii", $car_id, $_SESSION['user_id'], $rating_value);
                mysqli_stmt_execute($insert_rating_stmt);
            }
        }
    }

    header("Location: car_details.php?id=" . $car_id);
    exit();
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

include 'includes/header.php';
?>

<h2><?php echo htmlspecialchars($car['title']); ?></h2>

<?php if (!empty($car['image'])): ?>
    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" style="width:400px; height:auto; border-radius:8px; margin-bottom:15px;">
<?php endif; ?>

<p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
<p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
<p><strong>Year:</strong> <?php echo htmlspecialchars($car['car_year']); ?></p>
<p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>

<hr>

<p><?php echo nl2br(htmlspecialchars($car['full_description'])); ?></p>

<hr>

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
    <form method="POST">
        <label for="rating_value"><strong>Rate this car:</strong></label>
        <select name="rating_value" id="rating_value" required>
            <option value="">Select</option>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
        <button type="submit">Submit Rating</button>
    </form>
<?php else: ?>
    <p>You must <a href="login.php">log in</a> to rate this car.</p>
<?php endif; ?>

<hr>

<h3>Comments</h3>

<?php if (mysqli_num_rows($comments_result) > 0): ?>
    <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:6px;">
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
    <form method="POST">
        <textarea name="comment_text" rows="4" cols="50" required></textarea><br><br>
        <button type="submit">Post Comment</button>
    </form>
<?php else: ?>
    <p>You must <a href="login.php">log in</a> to add a comment.</p>
<?php endif; ?>

<br>
<a href="cars.php">← Back to Cars</a>

<?php include 'includes/footer.php'; ?>