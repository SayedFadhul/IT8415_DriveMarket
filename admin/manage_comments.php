<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();
$message = '';
$message_type = '';
$limit = 12;
$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_comment_id'])) {
    $delete_comment_id = (int) $_POST['delete_comment_id'];

    $delete_sql = "DELETE FROM dbProj_comments WHERE comment_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "i", $delete_comment_id);

    if (mysqli_stmt_execute($delete_stmt)) {
        $message = "Comment removed successfully.";
        $message_type = 'success';
    } else {
        $message = "Error removing comment.";
        $message_type = 'error';
    }

    header("Location: manage_comments.php?page=" . $page);
    exit();
}

$count_sql = "SELECT COUNT(*) AS total FROM dbProj_comments";
$count_result = mysqli_query($conn, $count_sql);
$total_records = (int) mysqli_fetch_assoc($count_result)['total'];
$total_pages = max(1, (int) ceil($total_records / $limit));

if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT c.comment_id, c.comment_text, c.created_at, u.username, car.title
        FROM dbProj_comments c
        JOIN dbProj_users u ON c.user_id = u.user_id
        JOIN dbProj_cars car ON c.car_id = car.car_id
        ORDER BY c.created_at DESC
        LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include '../includes/header.php';
?>

<div class="admin-manage-page">
    <div class="form-hero admin-hero">
        <span class="dashboard-badge">Admin Panel</span>
        <h2>Manage Comments</h2>
        <p>Review user comments across car listings and remove inappropriate content when necessary.</p>
    </div>

    <?php if ($message !== ''): ?>
        <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="admin-comments-list">
            <?php while ($comment = mysqli_fetch_assoc($result)): ?>
                <div class="admin-comment-card">
                    <div class="admin-comment-top">
                        <div>
                            <h3><?php echo htmlspecialchars($comment['username']); ?></h3>
                            <p class="admin-comment-car">On: <?php echo htmlspecialchars($comment['title']); ?></p>
                        </div>
                        <span class="admin-comment-date"><?php echo htmlspecialchars($comment['created_at']); ?></span>
                    </div>

                    <div class="admin-comment-body">
                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                    </div>

                    <form method="POST" class="inline-action-form" style="margin-top: 14px;">
                        <input type="hidden" name="delete_comment_id" value="<?php echo $comment['comment_id']; ?>">
                        <button type="submit" class="danger-btn" onclick="return confirm('Are you sure you want to delete this comment?');">Delete Comment</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination-box">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="manage_comments.php?page=<?php echo $i; ?>" class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state-box">
            <h3>No comments found</h3>
            <p>There are currently no comments in the system.</p>
        </div>
    <?php endif; ?>

    <p style="margin-top: 20px;">
        <a href="admin_dashboard.php" class="back-link">Return to Admin Dashboard</a>
    </p>
</div>

<?php include '../includes/footer.php'; ?>