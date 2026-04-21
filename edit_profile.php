<?php
require_once 'includes/auth.php';
require_once 'config/db.php';

requireLogin();

$conn = getConnection();
$message = '';
$message_type = '';

$user_id = $_SESSION['user_id'];

$sql = "SELECT user_id, username, email, password, role FROM dbProj_users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found.");
}

$username = $user['username'];
$email = $user['email'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_username = trim($_POST['username'] ?? '');
    $new_email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    if ($new_username === '' || $new_email === '' || $current_password === '') {
        $message = "Please fill in username, email, and current password.";
        $message_type = 'error';
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $message_type = 'error';
    } elseif (!password_verify($current_password, $user['password'])) {
        $message = "Current password is incorrect.";
        $message_type = 'error';
    } else {
        $email_check_sql = "SELECT user_id FROM dbProj_users WHERE email = ? AND user_id != ?";
        $email_check_stmt = mysqli_prepare($conn, $email_check_sql);
        mysqli_stmt_bind_param($email_check_stmt, "si", $new_email, $user_id);
        mysqli_stmt_execute($email_check_stmt);
        $email_check_result = mysqli_stmt_get_result($email_check_stmt);

        if (mysqli_num_rows($email_check_result) > 0) {
            $message = "That email is already used by another account.";
            $message_type = 'error';
        } else {
            $final_password = $user['password'];

            if ($new_password !== '' || $confirm_new_password !== '') {
                if ($new_password !== $confirm_new_password) {
                    $message = "New passwords do not match.";
                    $message_type = 'error';
                } elseif (strlen($new_password) < 6) {
                    $message = "New password must be at least 6 characters.";
                    $message_type = 'error';
                } else {
                    $final_password = password_hash($new_password, PASSWORD_DEFAULT);
                }
            }

            if ($message === '') {
                $update_sql = "UPDATE dbProj_users SET username = ?, email = ?, password = ? WHERE user_id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "sssi", $new_username, $new_email, $final_password, $user_id);

                if (mysqli_stmt_execute($update_stmt)) {
                    $_SESSION['username'] = $new_username;

                    $username = $new_username;
                    $email = $new_email;

                    $message = "Profile updated successfully.";
                    $message_type = 'success';

                    $refresh_sql = "SELECT user_id, username, email, password, role FROM dbProj_users WHERE user_id = ?";
                    $refresh_stmt = mysqli_prepare($conn, $refresh_sql);
                    mysqli_stmt_bind_param($refresh_stmt, "i", $user_id);
                    mysqli_stmt_execute($refresh_stmt);
                    $refresh_result = mysqli_stmt_get_result($refresh_stmt);
                    $user = mysqli_fetch_assoc($refresh_result);
                } else {
                    $message = "Error updating profile.";
                    $message_type = 'error';
                }
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card profile-card">
        <div class="auth-card-top">
            <h2>Edit Profile</h2>
            <p>Update your username, email, and password securely.</p>
        </div>

        <?php if ($message !== ''): ?>
            <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="auth-field">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="auth-field">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>

            <div class="auth-field">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" placeholder="Leave blank to keep current password">
            </div>

            <div class="auth-field">
                <label for="confirm_new_password">Confirm New Password</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Leave blank to keep current password">
            </div>

            <button type="submit" class="auth-btn">Save Changes</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>