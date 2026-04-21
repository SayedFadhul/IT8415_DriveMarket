<?php
require_once 'config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = getConnection();
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_input = trim($_POST['login_input'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login_input === '' || $password === '') {
        $error = "Please enter your username or email and password.";
    } else {
        $sql = "SELECT user_id, username, email, password, role 
            FROM dbProj_users 
            WHERE email = ? OR username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $login_input, $login_input);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/admin_dashboard.php");
            } elseif ($user['role'] === 'creator') {
                header("Location: creator/creator_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid username/email or password.";
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-card-top">
            <h2>Welcome Back</h2>
            <p>Log in to continue exploring cars, offers, and test drives.</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="auth-message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="auth-field">
                <label for="login_input">Username or Email</label>
                <input type="text" name="login_input" id="login_input" required>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="auth-btn">Login</button>
        </form>

        <p class="auth-switch">
            Don’t have an account?
            <a href="register.php">Register here</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>