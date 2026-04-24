<?php
require_once 'config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = getConnection();

$cars_count = 0;
$creators_count = 0;
$offers_count = 0;

$cars_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM dbProj_cars WHERE status = 'published'");
if ($cars_result) {
    $cars_count = (int) mysqli_fetch_assoc($cars_result)['total'];
}

$creators_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM dbProj_users WHERE role = 'creator'");
if ($creators_result) {
    $creators_count = (int) mysqli_fetch_assoc($creators_result)['total'];
}

$offers_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM dbProj_offers");
if ($offers_result) {
    $offers_count = (int) mysqli_fetch_assoc($offers_result)['total'];
}

$featured_sql = "SELECT c.car_id, c.title, c.brand, c.model, c.price, c.short_description, c.image
                 FROM dbProj_cars c
                 WHERE c.status = 'published'
                 ORDER BY c.created_at DESC
                 LIMIT 3";
$featured_result = mysqli_query($conn, $featured_sql);

include 'includes/header.php';
?>

<div class="home-page">
    <section class="home-hero">
        <div class="home-hero-content">
            <span class="hero-badge">Drive Smarter. Choose Better.</span>
            <h1>Find Your Next Car with Confidence</h1>
            <p>
                DriveMarket helps you explore car listings, compare options, make offers,
                and book test drives in one clean platform.
            </p>

            <div class="hero-actions">
                <a href="cars.php" class="hero-btn primary">Browse Cars</a>
                <a href="search.php" class="hero-btn secondary">Advanced Search</a>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <p class="hero-user-note">
                    You are logged in as:
                    <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>
                </p>
            <?php endif; ?>
        </div>

        <div class="home-hero-panel">
            <div class="hero-panel-card">
                <h3>Why DriveMarket?</h3>
                <ul>
                    <li>Browse published cars easily</li>
                    <li>Search by title, creator, date, and rating</li>
                    <li>Make offers directly to listings</li>
                    <li>Book realistic test drive appointments</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="home-stats">
        <div class="stat-card">
            <h3><?php echo $cars_count; ?></h3>
            <p>Published Cars</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $creators_count; ?></h3>
            <p>Active Creators</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $offers_count; ?></h3>
            <p>Total Offers</p>
        </div>
    </section>

    <section class="home-actions-grid">
        <a href="cars.php" class="home-action-card">
            <h3>Explore Cars</h3>
            <p>View the latest published listings with prices, details, and ratings.</p>
        </a>

        <a href="search.php" class="home-action-card">
            <h3>Search Smart</h3>
            <p>Use filters to search by title, creator, date range, and rating.</p>
        </a>

        <a href="offers.php" class="home-action-card">
            <h3>Make Offers</h3>
            <p>Submit price offers on cars you’re interested in.</p>
        </a>

        <a href="appointments.php" class="home-action-card">
            <h3>Book Test Drives</h3>
            <p>Reserve a date and time to test drive your selected car.</p>
        </a>
    </section>

    <?php if ($featured_result && mysqli_num_rows($featured_result) > 0): ?>
        <section class="home-featured">
            <div class="section-heading">
                <h2>Featured Listings</h2>
                <a href="cars.php">View All</a>
            </div>

            <div class="cars-grid">
                <?php while ($car = mysqli_fetch_assoc($featured_result)): ?>
                    <div class="car-card">
                        <?php if (!empty($car['image'])): ?>
                            <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image" class="car-card-image">
                        <?php else: ?>
                            <div class="car-card-image car-card-placeholder">No Image</div>
                        <?php endif; ?>

                        <div class="car-card-body">
                            <h3 class="car-card-title"><?php echo htmlspecialchars($car['title']); ?></h3>
                            <div class="car-card-meta">
                                <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                                <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                                <p><strong>Price:</strong> BHD <?php echo htmlspecialchars($car['price']); ?></p>
                            </div>

                            <p class="car-card-description">
                                <?php echo htmlspecialchars($car['short_description']); ?>
                            </p>

                            <a href="car_details.php?id=<?php echo $car['car_id']; ?>" class="car-card-link">View More</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="home-role-panel">
        <div class="section-heading">
            <h2>Quick Access</h2>
        </div>

        <div class="home-role-grid">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="home-role-card">
                    <h3>Login</h3>
                    <p>Access your account to interact with cars, offers, and appointments.</p>
                </a>
                <a href="register.php" class="home-role-card">
                    <h3>Create Account</h3>
                    <p>Join DriveMarket and start browsing, rating, and booking.</p>
                </a>
            <?php else: ?>
                <a href="my_activity.php" class="home-role-card">
                    <h3>My Activity</h3>
                    <p>Track your comments, ratings, offers, and test drive bookings.</p>
                </a>

                <?php if ($_SESSION['role'] === 'creator'): ?>
                    <a href="creator/creator_dashboard.php" class="home-role-card">
                        <h3>Creator Dashboard</h3>
                        <p>Manage your listings, publish cars, and review your content.</p>
                    </a>
                <?php endif; ?>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="admin/admin_dashboard.php" class="home-role-card">
                        <h3>Admin Dashboard</h3>
                        <p>Manage users, content, comments, and reports from one place.</p>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>