<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('creator');

if (!isset($_GET['id'])) {
    die("Car not found.");
}

$conn = getConnection();
$car_id = (int) $_GET['id'];

$sql = "SELECT * FROM dbProj_cars WHERE car_id = ? AND creator_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $car_id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$car = mysqli_fetch_assoc($result);

if (!$car) {
    die("Car not found or access denied.");
}

if ($car['status'] === 'removed') {
    include '../includes/header.php';
    ?>
    <div class="form-page">
        <div class="form-hero creator-hero">
            <span class="dashboard-badge">Creator Panel</span>
            <h2>Edit Car Listing</h2>
            <p>This listing was removed by admin and cannot be edited.</p>
        </div>

        <div class="form-card">
            <div class="auth-message error">
                This car listing has been removed by admin. You cannot edit or republish it.
            </div>

            <p style="margin-top: 18px;">
                <a href="my_cars.php" class="back-link">Back to My Cars</a>
            </p>
        </div>
    </div>
    <?php
    include '../includes/footer.php';
    exit();
}

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $car_year = (int) ($_POST['car_year'] ?? 0);
    $price = (float) ($_POST['price'] ?? 0);
    $image_url = trim($_POST['image'] ?? '');
    $status = $_POST['status'] ?? 'draft';

    $final_image = $image_url !== '' ? $image_url : $car['image'];

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $upload_dir = realpath(__DIR__ . '/../assets/uploads');
        if ($upload_dir === false) {
            $upload_dir = __DIR__ . '/../assets/uploads';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
        }

        $file_tmp = $_FILES['image_file']['tmp_name'];
        $file_name = basename($_FILES['image_file']['name']);
        $file_size = $_FILES['image_file']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($file_ext, $allowed)) {
            $message = "Only JPG, JPEG, PNG, and WEBP files are allowed.";
            $message_type = 'error';
        } elseif ($file_size > 5 * 1024 * 1024) {
            $message = "Image file must be less than 5MB.";
            $message_type = 'error';
        } else {
            $new_file_name = 'car_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
            $target_path = rtrim($upload_dir, '/\\') . DIRECTORY_SEPARATOR . $new_file_name;

            if (move_uploaded_file($file_tmp, $target_path)) {
                $final_image = '/~u202301830/DriveMarket/assets/uploads/' . $new_file_name;
            } else {
                if ($image_url === '' && $car['image'] === '') {
                    $message = "Image upload failed. Please use an Image URL instead.";
                    $message_type = 'error';
                }
            }
        }
    }

    if ($message === '') {
        if (
                $title !== '' &&
                $short_description !== '' &&
                $full_description !== '' &&
                $brand !== '' &&
                $model !== '' &&
                $car_year > 0 &&
                $price > 0 &&
                in_array($status, ['draft', 'published'])
        ) {
            $update_sql = "UPDATE dbProj_cars
                           SET title = ?, short_description = ?, full_description = ?, brand = ?, model = ?, car_year = ?, price = ?, image = ?, status = ?
                           WHERE car_id = ? AND creator_id = ?";

            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param(
                    $update_stmt,
                    "sssssidssii",
                    $title,
                    $short_description,
                    $full_description,
                    $brand,
                    $model,
                    $car_year,
                    $price,
                    $final_image,
                    $status,
                    $car_id,
                    $_SESSION['user_id']
            );

            if (mysqli_stmt_execute($update_stmt)) {
                $message = "Car listing updated successfully.";
                $message_type = 'success';

                $refresh_sql = "SELECT * FROM dbProj_cars WHERE car_id = ? AND creator_id = ?";
                $refresh_stmt = mysqli_prepare($conn, $refresh_sql);
                mysqli_stmt_bind_param($refresh_stmt, "ii", $car_id, $_SESSION['user_id']);
                mysqli_stmt_execute($refresh_stmt);
                $refresh_result = mysqli_stmt_get_result($refresh_stmt);
                $car = mysqli_fetch_assoc($refresh_result);
            } else {
                $message = "Error updating car listing.";
                $message_type = 'error';
            }
        } else {
            $message = "Please fill in all fields correctly.";
            $message_type = 'error';
        }
    }
}

include '../includes/header.php';
?>

<div class="form-page">
    <div class="form-hero creator-hero">
        <span class="dashboard-badge">Creator Panel</span>
        <h2>Edit Car Listing</h2>
        <p>Update your listing details, change the image, and control publishing status.</p>
    </div>

    <div class="form-card">
        <?php if ($message !== ''): ?>
            <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="car-form-grid">
            <div class="form-field">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($car['title']); ?>" required>
            </div>

            <div class="form-field">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" value="<?php echo htmlspecialchars($car['brand']); ?>" required>
            </div>

            <div class="form-field">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
            </div>

            <div class="form-field">
                <label for="car_year">Year</label>
                <input type="number" name="car_year" id="car_year" min="1900" max="2099" value="<?php echo htmlspecialchars($car['car_year']); ?>" required>
            </div>

            <div class="form-field">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($car['price']); ?>" required>
            </div>

            <div class="form-field">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="draft" <?php if ($car['status'] === 'draft') echo 'selected'; ?>>Draft</option>
                    <option value="published" <?php if ($car['status'] === 'published') echo 'selected'; ?>>Published</option>
                </select>
            </div>

            <div class="form-field form-field-full">
                <label for="short_description">Short Description</label>
                <input type="text" name="short_description" id="short_description" value="<?php echo htmlspecialchars($car['short_description']); ?>" required>
            </div>

            <div class="form-field form-field-full">
                <label for="full_description">Full Description</label>
                <textarea name="full_description" id="full_description" rows="6" required><?php echo htmlspecialchars($car['full_description']); ?></textarea>
            </div>

            <div class="form-field form-field-full">
                <label for="image">Image URL</label>
                <input type="url" name="image" id="image" value="<?php echo htmlspecialchars($car['image']); ?>" placeholder="https://example.com/car.jpg">
            </div>

            <div class="form-field form-field-full">
                <label for="image_file">Or Upload New Image</label>
                <input type="file" name="image_file" id="image_file" accept=".jpg,.jpeg,.png,.webp">
            </div>

            <?php if (!empty($car['image'])): ?>
                <div class="form-field form-field-full">
                    <label>Current Image</label>
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Current Car Image" class="edit-car-preview-image">
                </div>
            <?php endif; ?>

            <div class="form-field form-field-full">
                <button type="submit" class="form-main-btn">Update Car</button>
            </div>
        </form>

        <p style="margin-top: 18px;">
            <a href="my_cars.php" class="back-link">Back to My Cars</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>