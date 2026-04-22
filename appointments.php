<?php
require_once 'includes/auth.php';
require_once 'config/db.php';

requireLogin();
date_default_timezone_set('Asia/Bahrain');

$conn = getConnection();
$message = '';
$message_type = '';

$selected_car_id = isset($_GET['car_id']) ? (int) $_GET['car_id'] : 0;
$appointment_date_value = '';
$appointment_time_value = '';
$notes_value = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selected_car_id = isset($_POST['car_id']) ? (int) $_POST['car_id'] : 0;
    $appointment_date_value = isset($_POST['appointment_date']) ? trim($_POST['appointment_date']) : '';
    $appointment_time_value = isset($_POST['appointment_time']) ? trim($_POST['appointment_time']) : '';
    $notes_value = isset($_POST['notes']) ? trim($_POST['notes']) : '';

    $today = date('Y-m-d');
    $current_time = date('H:i');

    if (mb_strlen($notes_value) > 500) {
        $message = "Notes are too long.";
        $message_type = 'error';
    } elseif ($selected_car_id <= 0 || $appointment_date_value === '' || $appointment_time_value === '') {
        $message = "Please select a car, date, and time.";
        $message_type = 'error';
    } elseif ($appointment_date_value < $today) {
        $message = "Appointment date cannot be in the past.";
        $message_type = 'error';
    } elseif ($appointment_date_value === $today && $appointment_time_value <= $current_time) {
        $message = "Appointment time cannot be in the past.";
        $message_type = 'error';
    } else {
        $check_car_sql = "SELECT car_id, creator_id FROM dbProj_cars WHERE car_id = ? AND status = 'published'";
        $check_car_stmt = mysqli_prepare($conn, $check_car_sql);
        mysqli_stmt_bind_param($check_car_stmt, "i", $selected_car_id);
        mysqli_stmt_execute($check_car_stmt);
        $check_car_result = mysqli_stmt_get_result($check_car_stmt);
        $car_data = mysqli_fetch_assoc($check_car_result);

        if (!$car_data) {
            $message = "Selected car was not found.";
            $message_type = 'error';
        } elseif ((int) $car_data['creator_id'] === (int) $_SESSION['user_id']) {
            $message = "You cannot book a test drive for your own car.";
            $message_type = 'error';
        } else {
            $slot_sql = "SELECT appointment_id
                         FROM dbProj_appointments
                         WHERE car_id = ? AND appointment_date = ? AND appointment_time = ?";
            $slot_stmt = mysqli_prepare($conn, $slot_sql);
            mysqli_stmt_bind_param($slot_stmt, "iss", $selected_car_id, $appointment_date_value, $appointment_time_value);
            mysqli_stmt_execute($slot_stmt);
            $slot_result = mysqli_stmt_get_result($slot_stmt);

            if (mysqli_num_rows($slot_result) > 0) {
                $message = "This test drive slot is already booked. Please choose another time.";
                $message_type = 'error';
            } else {
                $duplicate_sql = "SELECT appointment_id
                                  FROM dbProj_appointments
                                  WHERE car_id = ? AND user_id = ?";
                $duplicate_stmt = mysqli_prepare($conn, $duplicate_sql);
                mysqli_stmt_bind_param($duplicate_stmt, "ii", $selected_car_id, $_SESSION['user_id']);
                mysqli_stmt_execute($duplicate_stmt);
                $duplicate_result = mysqli_stmt_get_result($duplicate_stmt);

                if (mysqli_num_rows($duplicate_result) > 0) {
                    $message = "You have already booked a test drive for this car.";
                    $message_type = 'error';
                } else {
                    $insert_sql = "INSERT INTO dbProj_appointments (car_id, user_id, appointment_date, appointment_time, notes)
                                   VALUES (?, ?, ?, ?, ?)";
                    $insert_stmt = mysqli_prepare($conn, $insert_sql);
                    mysqli_stmt_bind_param($insert_stmt, "iisss", $selected_car_id, $_SESSION['user_id'], $appointment_date_value, $appointment_time_value, $notes_value);

                    try {
                        if (mysqli_stmt_execute($insert_stmt)) {
                            $message = "Test drive booked successfully.";
                            $message_type = 'success';
                            $appointment_date_value = '';
                            $appointment_time_value = '';
                            $notes_value = '';
                        } else {
                            $message = "Error booking the test drive.";
                            $message_type = 'error';
                        }
                    } catch (Throwable $e) {
                        $error_text = $e->getMessage();

                        if (stripos($error_text, 'already booked') !== false) {
                            $message = "This test drive slot is already booked. Please choose another time.";
                        } elseif (stripos($error_text, 'already booked a test drive for this car') !== false) {
                            $message = "You have already booked a test drive for this car.";
                        } else {
                            $message = "Error booking the test drive.";
                        }
                        $message_type = 'error';
                    }
                }
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

$my_appointments_sql = "SELECT a.appointment_date, a.appointment_time, a.notes, a.created_at,
                               c.title, c.brand, c.model, c.price,
                               u.username AS creator_name
                        FROM dbProj_appointments a
                        JOIN dbProj_cars c ON a.car_id = c.car_id
                        JOIN dbProj_users u ON c.creator_id = u.user_id
                        WHERE a.user_id = ?
                        ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$my_appointments_stmt = mysqli_prepare($conn, $my_appointments_sql);
mysqli_stmt_bind_param($my_appointments_stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($my_appointments_stmt);
$my_appointments_result = mysqli_stmt_get_result($my_appointments_stmt);

include 'includes/header.php';
?>

<div class="form-page">
    <div class="form-hero">
        <span class="dashboard-badge">User Panel</span>
        <h2>Test Drive Appointments</h2>
        <p>Book a realistic test drive slot for a published car and review all your scheduled appointments.</p>
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

        <h3 class="section-title-small">Book a Test Drive</h3>

        <form method="POST" class="car-form-grid" id="appointmentForm" novalidate>
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
                <label for="appointment_date">Appointment Date</label>
                <input type="date" name="appointment_date" id="appointment_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($appointment_date_value); ?>" required>
            </div>

            <div class="form-field">
                <label for="appointment_time">Appointment Time</label>
                <input type="time" name="appointment_time" id="appointment_time" value="<?php echo htmlspecialchars($appointment_time_value); ?>" required>
            </div>

            <div class="form-field form-field-full">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="4" maxlength="500"><?php echo htmlspecialchars($notes_value); ?></textarea>
            </div>

            <div class="form-field form-field-full">
                <button type="submit" class="form-main-btn">Book Test Drive</button>
            </div>
        </form>
    </div>

    <div class="form-card">
        <h3 class="section-title-small">My Test Drive Appointments</h3>

        <?php if ($my_appointments_result && mysqli_num_rows($my_appointments_result) > 0): ?>
            <div class="activity-grid">
                <?php while ($appointment = mysqli_fetch_assoc($my_appointments_result)): ?>
                    <div class="activity-item offer-card">
                        <p><strong>Car:</strong> <?php echo htmlspecialchars($appointment['title']); ?></p>
                        <p><strong>Brand / Model:</strong> <?php echo htmlspecialchars($appointment['brand'] . ' ' . $appointment['model']); ?></p>
                        <p><strong>Listed Price:</strong> BHD <?php echo htmlspecialchars($appointment['price']); ?></p>
                        <p><strong>Creator:</strong> <?php echo htmlspecialchars($appointment['creator_name']); ?></p>
                        <p><strong>Date:</strong> <span class="badge-value"><?php echo htmlspecialchars($appointment['appointment_date']); ?></span></p>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
                        <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($appointment['notes'])); ?></p>
                        <p><strong>Booked On:</strong> <?php echo htmlspecialchars($appointment['created_at']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="empty-text">You have not booked any test drives yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>