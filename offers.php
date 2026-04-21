<?php
require_once 'includes/auth.php';
require_once 'config/db.php';

requireLogin();

$conn = getConnection();
$message = '';
$message_type = '';

$selected_car_id = isset($_GET['car_id']) ? (int) $_GET['car_id'] : 0;
$offer_amount_value = '';
$offer_message_value = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selected_car_id = isset($_POST['car_id']) ? (int) $_POST['car_id'] : 0;
    $offer_amount_value = isset($_POST['offer_amount']) ? trim($_POST['offer_amount']) : '';
    $offer_message_value = isset($_POST['message']) ? trim($_POST['message']) : '';
    $offer_amount = (float) $offer_amount_value;

    if ($selected_car_id <= 0 || $offer_amount <= 0) {
        $message = "Please select a car and enter a valid offer amount.";
        $message_type = 'error';
    } else {
        $check_sql = "SELECT car_id, creator_id FROM dbProj_cars WHERE car_id = ? AND status = 'published'";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "i", $selected_car_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        $car_data = mysqli_fetch_assoc($check_result);

        if (!$car_data) {
            $message = "Selected car was not found.";
            $message_type = 'error';
        } elseif ((int)$car_data['creator_id'] === (int)$_SESSION['user_id']) {
            $message = "You cannot make an offer on your own car.";
            $message_type = 'error';
        } else {
            $insert_sql = "INSERT INTO dbProj_offers (car_id, user_id, offer_amount, message) VALUES (?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "iids", $selected_car_id, $_SESSION['user_id'], $offer_amount, $offer_message_value);

            if (mysqli_stmt_execute($insert_stmt)) {
                $message = "Offer submitted successfully.";
                $message_type = 'success';
                $offer_amount_value = '';
                $offer_message_value = '';
            } else {
                $message = "Error submitting offer.";
                $message_type = 'error';
            }
        }
    }
}

$cars_sql = "SELECT c.car_id, c.title, c.brand, c.model, c.price, u.username
             FROM dbProj_cars c
             JOIN dbProj_users u ON c.creator_id = u.user_id
             WHERE c.status = 'published'
             ORDER BY c.created_at DESC";
$cars_result = mysqli_query($conn, $cars_sql);

$my_offers_sql = "SELECT o.offer_amount, o.message, o.created_at,
                         c.title, c.brand, c.model, c.price,
                         u.username AS creator_name
                  FROM dbProj_offers o
                  JOIN dbProj_cars c ON o.car_id = c.car_id
                  JOIN dbProj_users u ON c.creator_id = u.user_id
                  WHERE o.user_id = ?
                  ORDER BY o.created_at DESC";
$my_offers_stmt = mysqli_prepare($conn, $my_offers_sql);
mysqli_stmt_bind_param($my_offers_stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($my_offers_stmt);
$my_offers_result = mysqli_stmt_get_result($my_offers_stmt);

include 'includes/header.php';
?>

<div class="form-page">
    <div class="form-hero">
        <span class="dashboard-badge">User Panel</span>
        <h2>Offers</h2>
        <p>Submit an offer on a published car and track all your submitted offers in one place.</p>
    </div>

    <?php if ($selected_car_id > 0): ?>
        <?php
        $selected_car_sql = "SELECT title, brand, model, price FROM dbProj_cars WHERE car_id = ?";
        $selected_car_stmt = mysqli_prepare($conn, $selected_car_sql);
        mysqli_stmt_bind_param($selected_car_stmt, "i", $selected_car_id);
        mysqli_stmt_execute($selected_car_stmt);
        $selected_car_result = mysqli_stmt_get_result($selected_car_stmt);
        $selected_car = mysqli_fetch_assoc($selected_car_result);
        ?>
        <?php if ($selected_car): ?>
            <div class="selected-car-box">
                <strong>Selected Car:</strong>
                <?php echo htmlspecialchars($selected_car['title'] . ' - ' . $selected_car['brand'] . ' ' . $selected_car['model'] . ' (BHD ' . $selected_car['price'] . ')'); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="form-card">
        <?php if ($message !== ''): ?>
            <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h3 class="section-title-small">Make an Offer</h3>

        <form method="POST" class="car-form-grid">
            <div class="form-field form-field-full">
                <label for="car_id">Select Car</label>
                <select name="car_id" id="car_id" required>
                    <option value="">Select Car</option>
                    <?php if ($cars_result && mysqli_num_rows($cars_result) > 0): ?>
                        <?php while ($car = mysqli_fetch_assoc($cars_result)): ?>
                            <option value="<?php echo $car['car_id']; ?>" <?php if ($selected_car_id == $car['car_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($car['title'] . ' - ' . $car['brand'] . ' ' . $car['model'] . ' (BHD ' . $car['price'] . ')'); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-field">
                <label for="offer_amount">Offer Amount (BHD)</label>
                <input type="number" step="0.01" min="0.01" name="offer_amount" id="offer_amount" value="<?php echo htmlspecialchars($offer_amount_value); ?>" required>
            </div>

            <div class="form-field form-field-full">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="4"><?php echo htmlspecialchars($offer_message_value); ?></textarea>
            </div>

            <div class="form-field form-field-full">
                <button type="submit" class="form-main-btn">Submit Offer</button>
            </div>
        </form>
    </div>

    <div class="form-card">
        <h3 class="section-title-small">My Offers</h3>

        <?php if ($my_offers_result && mysqli_num_rows($my_offers_result) > 0): ?>
            <div class="activity-grid">
                <?php while ($offer = mysqli_fetch_assoc($my_offers_result)): ?>
                    <div class="activity-item offer-card">
                        <p><strong>Car:</strong> <?php echo htmlspecialchars($offer['title']); ?></p>
                        <p><strong>Brand / Model:</strong> <?php echo htmlspecialchars($offer['brand'] . ' ' . $offer['model']); ?></p>
                        <p><strong>Listed Price:</strong> BHD <?php echo htmlspecialchars($offer['price']); ?></p>
                        <p><strong>Your Offer:</strong> <span class="badge-value">BHD <?php echo htmlspecialchars($offer['offer_amount']); ?></span></p>
                        <p><strong>Creator:</strong> <?php echo htmlspecialchars($offer['creator_name']); ?></p>
                        <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($offer['message'])); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($offer['created_at']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="empty-text">You have not submitted any offers yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>