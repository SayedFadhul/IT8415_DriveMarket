<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('admin');

$conn = getConnection();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'], $_POST['role'])) {
    $user_id = (int) $_POST['user_id'];
    $role = $_POST['role'];

    if (in_array($role, ['viewer', 'creator', 'admin'])) {
        $update_sql = "UPDATE dbProj_users SET role = ? WHERE user_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $role, $user_id);

        if (mysqli_stmt_execute($update_stmt)) {
            $message = "User role updated successfully.";
        } else {
            $message = "Error updating user role.";
        }
    } else {
        $message = "Invalid role selected.";
    }
}

$sql = "SELECT user_id, username, email, role, created_at FROM dbProj_users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include '../includes/header.php';
?>

<h2>Manage Users</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($user = mysqli_fetch_assoc($result)): ?>
        <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px;">
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['user_id']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Current Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>

            <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                <label for="role_<?php echo $user['user_id']; ?>">Change Role:</label>
                <select name="role" id="role_<?php echo $user['user_id']; ?>">
                    <option value="viewer" <?php if ($user['role'] === 'viewer') echo 'selected'; ?>>Viewer</option>
                    <option value="creator" <?php if ($user['role'] === 'creator') echo 'selected'; ?>>Creator</option>
                    <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                </select>

                <button type="submit">Update Role</button>
            </form>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>