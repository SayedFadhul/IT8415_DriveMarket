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

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $short_description = trim($_POST['short_description']);
    $full_description = trim($_POST['full_description']);
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $car_year = (int) $_POST['car_year'];
    $price = (float) $_POST['price'];
    $image = trim($_POST['image']);
    $status = $_POST['status'];

    if (
        $title !== "" &&
        $short_description !== "" &&
        $full_description !== "" &&
        $brand !== "" &&
        $model !== "" &&
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
            $image,
            $status,
            $car_id,
            $_SESSION['user_id']
        );

        if (mysqli_stmt_execute($update_stmt)) {
            $message = "Car listing updated successfully.";

            $refresh_sql = "SELECT * FROM dbProj_cars WHERE car_id = ? AND creator_id = ?";
            $refresh_stmt = mysqli_prepare($conn, $refresh_sql);
            mysqli_stmt_bind_param($refresh_stmt, "ii", $car_id, $_SESSION['user_id']);
            mysqli_stmt_execute($refresh_stmt);
            $refresh_result = mysqli_stmt_get_result($refresh_stmt);
            $car = mysqli_fetch_assoc($refresh_result);
        } else {
            $message = "Error updating car listing.";
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}

include '../includes/header.php';
?>

<h2>Edit Car Listing</h2>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($car['title']); ?>" required><br><br>

    <label>Short Description:</label><br>
    <input type="text" name="short_description" value="<?php echo htmlspecialchars($car['short_description']); ?>" required><br><br>

    <label>Full Description:</label><br>
    <textarea name="full_description" rows="5" cols="60" required><?php echo htmlspecialchars($car['full_description']); ?></textarea><br><br>

    <label>Brand:</label><br>
    <input type="text" name="brand" value="<?php echo htmlspecialchars($car['brand']); ?>" required><br><br>

    <label>Model:</label><br>
    <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required><br><br>

    <label>Year:</label><br>
    <input type="number" name="car_year" value="<?php echo htmlspecialchars($car['car_year']); ?>" required><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($car['price']); ?>" required><br><br>

    <label>Image URL:</label><br>
    <input type="url" name="image" value="<?php echo htmlspecialchars($car['image']); ?>"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="draft" <?php if ($car['status'] === 'draft') echo 'selected'; ?>>Draft</option>
        <option value="published" <?php if ($car['status'] === 'published') echo 'selected'; ?>>Published</option>
    </select><br><br>

    <button type="submit">Update Car</button>
</form>

<p><?php echo htmlspecialchars($message); ?></p>

<p><a href="my_cars.php">Back to My Cars</a></p>

<?php include '../includes/footer.php'; ?>