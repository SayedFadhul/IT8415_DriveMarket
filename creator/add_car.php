<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('creator');

$conn = getConnection();
$message = '';
$message_type = '';
$image_value = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year_raw = trim($_POST['car_year'] ?? '');
    $price_raw = trim($_POST['price'] ?? '');
    $image_url = trim($_POST['image'] ?? '');
    $status = $_POST['status'] ?? 'draft';

    $car_year = (int) $year_raw;
    $price = (float) $price_raw;

    if (
        mb_strlen($title) > 120 ||
        mb_strlen($short_description) > 180 ||
        mb_strlen($full_description) > 2000 ||
        mb_strlen($brand) > 60 ||
        mb_strlen($model) > 60 ||
        mb_strlen($image_url) > 255
    ) {
        $message = "One or more fields are too long.";
        $message_type = 'error';
    } elseif ($image_url !== '' && filter_var($image_url, FILTER_VALIDATE_URL) === false) {
        $message = "Please enter a valid image URL.";
        $message_type = 'error';
    } elseif (!preg_match('/^\d{4}$/', $year_raw) || $car_year < 1900 || $car_year > 2099) {
        $message = "Year must be exactly 4 digits between 1900 and 2099.";
        $message_type = 'error';
    } elseif (!is_numeric($price_raw) || $price <= 0 || $price > 999999.99) {
        $message = "Price must be a valid amount between 0.01 and 999999.99.";
        $message_type = 'error';
    } elseif (
        $title === '' ||
        $short_description === '' ||
        $full_description === '' ||
        $brand === '' ||
        $model === ''
    ) {
        $message = "Please fill in all fields correctly.";
        $message_type = 'error';
    } elseif (!in_array($status, ['draft', 'published'])) {
        $message = "Invalid status selected.";
        $message_type = 'error';
    }

    $image_value = $image_url;
    $final_image = $image_url;

    if ($message === '' && isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
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
                $image_value = $final_image;
            } else {
                if ($image_url === '') {
                    $message = "Image upload failed. Please use an Image URL instead.";
                    $message_type = 'error';
                }
            }
        }
    }

    if ($message === '') {
        $sql = "INSERT INTO dbProj_cars
                (creator_id, title, short_description, full_description, brand, model, car_year, price, image, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "isssssidss",
            $_SESSION['user_id'],
            $title,
            $short_description,
            $full_description,
            $brand,
            $model,
            $car_year,
            $price,
            $final_image,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Car listing added successfully.";
            $message_type = 'success';
            $image_value = '';
        } else {
            $message = "Error adding car listing.";
            $message_type = 'error';
        }
    }
}

include '../includes/header.php';
?>

<div class="form-page">
    <div class="form-hero creator-hero">
        <span class="dashboard-badge">Creator Panel</span>
        <h2>Add Car Listing</h2>
        <p>Create a new car listing using an image URL or upload your own image file.</p>
    </div>

    <div class="form-card">
        <?php if ($message !== ''): ?>
            <div class="auth-message <?php echo $message_type === 'success' ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="car-form-grid carValidationForm" novalidate>
            <div class="form-field">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" maxlength="120" required>
            </div>

            <div class="form-field">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" maxlength="60" required>
            </div>

            <div class="form-field">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" maxlength="60" required>
            </div>

            <div class="form-field">
                <label for="car_year">Year</label>
                <input type="number" name="car_year" id="car_year" min="1900" max="2099" required>
            </div>

            <div class="form-field">
                <label for="price">Price</label>
                <input type="number" step="0.01" min="0.01" max="999999.99" name="price" id="price" required>
            </div>

            <div class="form-field">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <div class="form-field form-field-full">
                <label for="short_description">Short Description</label>
                <input type="text" name="short_description" id="short_description" maxlength="180" required>
            </div>

            <div class="form-field form-field-full">
                <label for="full_description">Full Description</label>
                <textarea name="full_description" id="full_description" rows="6" maxlength="2000" required></textarea>
            </div>

            <div class="form-field form-field-full">
                <label for="image">Image URL</label>
                <input type="url" name="image" id="image" maxlength="255" placeholder="https://example.com/car.jpg" value="<?php echo htmlspecialchars($image_value); ?>">
            </div>

            <div class="form-field form-field-full">
                <label for="image_file">Or Upload Image</label>
                <input type="file" name="image_file" id="image_file" accept=".jpg,.jpeg,.png,.webp">
            </div>

            <div class="form-field form-field-full">
                <button type="submit" class="form-main-btn">Add Car</button>
            </div>
        </form>
    </div>
</div>

<p style="margin-top: 20px;">
    <a href="creator_dashboard.php" class="back-link">Return to Creator Dashboard</a>
</p>

<?php include '../includes/footer.php'; ?>