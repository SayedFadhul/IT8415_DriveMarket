<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_comment_id'])) {
    $delete_comment_id = (int) $_POST['delete_comment_id'];

    $delete_sql = "DELETE FROM dbProj_comments WHERE comment_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "i", $delete_comment_id);

    if (mysqli_stmt_execute($delete_stmt)) {
        $message = "Comment removed successfully.";
    } else {
        $message = "Error removing comment.";
    }
}

$sql = "SELECT c.comment_id, c.comment_text, c.created_at, u.username, car.title
        FROM dbProj_comments c
        JOIN dbProj_users u ON c.user_id = u.user_id
        JOIN dbProj_cars car ON c.car_id = car.car_id
        ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $sql);

include '../includes/header.php';
?>

<h2>Manage Comments</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($comment = mysqli_fetch_assoc($result)): ?>
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px;">
            <p><strong>User:</strong> <?php echo htmlspecialchars($comment['username']); ?></p>
            <p><strong>Car:</strong> <?php echo htmlspecialchars($comment['title']); ?></p>
            <p><strong>Comment:</strong> <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($comment['created_at']); ?></p>

            <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="delete_comment_id" value="<?php echo $comment['comment_id']; ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this comment?');">Delete Comment</button>
            </form>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No comments found.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>