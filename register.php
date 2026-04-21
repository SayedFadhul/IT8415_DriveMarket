<?php
require_once 'config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = getConnection();
$error = '';
$success = '';

$username = '';
$email = '';
$role = 'viewer';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = trim($_POST['role'] ?? 'viewer');

    if ($username === '' || $email === '' || $password === '' || $confirm_password === '' || $role === '') {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif (!in_array($role, ['viewer', 'creator'])) {
        $error = "Invalid role selected.";
    } else {
        $check_sql = "SELECT user_id FROM dbProj_users WHERE email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "This email is already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_sql = "INSERT INTO dbProj_users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "ssss", $username, $email, $hashed_password, $role);

            if (mysqli_stmt_execute($insert_stmt)) {
                $success = "Registration successful. You can now log in.";
                $username = '';
                $email = '';
                $role = 'viewer';
            } else {
                $error = "Error creating account.";
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-card-top">
            <h2>Create Account</h2>
            <p>Join DriveMarket to browse, rate, make offers, and book test drives.</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="auth-message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success !== ''): ?>
            <div class="auth-message success"><?php echo htmlspecialchars($success); ?></div>
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
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="viewer" <?php if ($role === 'viewer') echo 'selected'; ?>>Viewer</option>
                    <option value="creator" <?php if ($role === 'creator') echo 'selected'; ?>>Creator</option>
                </select>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="auth-field">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" class="auth-btn">Register</button>
        </form>

        <p class="auth-switch">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>