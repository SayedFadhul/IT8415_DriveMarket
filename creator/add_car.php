<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

requireRole('creator');

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = getConnection();

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
                $image,
                $status
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Car listing added successfully.";
        } else {
            $message = "Error adding car listing.";
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}

include '../includes/header.php';
?>

<h2>Add Car Listing</h2>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Short Description:</label><br>
    <input type="text" name="short_description" required><br><br>

    <label>Full Description:</label><br>
    <textarea name="full_description" rows="5" cols="60" required></textarea><br><br>

    <label>Brand:</label><br>
    <input type="text" name="brand" required><br><br>

    <label>Model:</label><br>
    <input type="text" name="model" required><br><br>

    <label>Year:</label><br>
    <input type="number" name="car_year" required><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Image URL:</label><br>
    <input type="url" name="image" placeholder="https://example.com/car.jpg"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="draft">Draft</option>
        <option value="published">Published</option>
    </select><br><br>

    <button type="submit">Add Car</button>
</form>

<p><?php echo htmlspecialchars($message); ?></p>

<?php include '../includes/footer.php'; ?>