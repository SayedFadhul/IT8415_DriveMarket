<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();
$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'], $_POST['role'])) {
    $user_id = (int) $_POST['user_id'];
    $role = $_POST['role'];

    if (in_array($role, ['viewer', 'creator', 'admin'])) {
        $update_sql = "UPDATE dbProj_users SET role = ? WHERE user_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $role, $user_id);

        if (mysqli_stmt_execute($update_stmt)) {
            $message = "User role updated successfully.";
            $message_type = 'success';
        } else {
            $message = "Error updating user role.";
            $message_type = 'error';
        }
    } else {
        $message = "Invalid role selected.";
        $message_type = 'error';
    }
}

$sql = "SELECT user_id, username, email, role, created_at FROM dbProj_users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include '../includes/header.php';
?>

<div class="admin-manage-page">
    <div class="form-hero admin-hero">
        <span class="dashboard-badge">Admin Panel</span>
        <h2>Manage Users</h2>
        <p>Review all users, monitor their current roles, and update access levels when needed.</p>
    </div>

    <?php if ($message !== ''): ?>
        <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="admin-users-grid">
            <?php while ($user = mysqli_fetch_assoc($result)): ?>
                <div class="admin-user-card">
                    <div class="admin-user-top">
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <span class="user-role-badge <?php echo htmlspecialchars($user['role']); ?>">
                            <?php echo htmlspecialchars(ucfirst($user['role'])); ?>
                        </span>
                    </div>

                    <div class="admin-user-meta">
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['user_id']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Created At:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
                    </div>

                    <form method="POST" class="admin-user-form">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                        <label for="role_<?php echo $user['user_id']; ?>">Change Role</label>
                        <select name="role" id="role_<?php echo $user['user_id']; ?>">
                            <option value="viewer" <?php if ($user['role'] === 'viewer') echo 'selected'; ?>>Viewer</option>
                            <option value="creator" <?php if ($user['role'] === 'creator') echo 'selected'; ?>>Creator</option>
                            <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                        </select>

                        <button type="submit" class="form-main-btn">Update Role</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state-box">
            <h3>No users found</h3>
            <p>There are currently no users in the system.</p>
        </div>
    <?php endif; ?>
</div>
<p style="margin-top: 20px;">
    <a href="admin_dashboard.php" class="back-link">Return to Admin Dashboard</a>
</p>
<?php include '../includes/footer.php'; ?>