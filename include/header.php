<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">FoodFusion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <span class="text-light mx-2">|</span>
                        <a class="nav-link <?php echo $current_page === 'about_us.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user_id']) ? 'about_us.php' : 'login.php'; ?>">About Us</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <span class="text-light mx-2">|</span>
                        <a class="nav-link <?php echo $current_page === 'recipe_collection.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user_id']) ? 'recipe_collection.php' : 'login.php'; ?>">Recipe Collection</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <span class="text-light mx-2">|</span>
                        <a class="nav-link <?php echo $current_page === 'community_cookbook.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user_id']) ? 'community_cookbook.php' : 'login.php'; ?>">Community Cookbook</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <span class="text-light mx-2">|</span>
                        <a class="nav-link <?php echo $current_page === 'contact_us.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user_id']) ? 'contact_us.php' : 'login.php'; ?>">Contact Us</a>
                    </li>
                    <li class="nav-item dropdown d-flex align-items-center">
                        <span class="text-light mx-2">|</span>
                        <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Resources</a>
                        <ul class="dropdown-menu" aria-labelledby="resourcesDropdown">
                            <li><a class="dropdown-item <?php echo $current_page === 'culinary_resources.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user_id']) ? 'culinary_resources.php' : 'login.php'; ?>">Culinary Resources</a></li>
                            <li><a class="dropdown-item <?php echo $current_page === 'educational_resources.php' ? 'active' : ''; ?>" href="<?php echo isset($_SESSION['user_id']) ? 'educational_resources.php' : 'login.php'; ?>">Educational Resources</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-item nav-link text-light" href="profile.php">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</a>
                        <a class="nav-link" href="logout.php">Logout</a>
                    <?php else: ?>
                        <a class="nav-link <?php echo $current_page === 'login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
                        <a class="nav-link <?php echo $current_page === 'register.php' ? 'active' : ''; ?>" href="register.php">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Social Media Links -->
<div class="social-links position-fixed top-50 start-0 translate-middle-y" style="z-index: 1000;">
    <div class="d-flex flex-column gap-3 ms-3">
        <a href="https://www.facebook.com" class="text-success fs-4" title="Facebook" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://www.twitter.com" class="text-success fs-4" title="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://www.instagram.com" class="text-success fs-4" title="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://www.pinterest.com" class="text-success fs-4" title="Pinterest" target="_blank"><i class="fab fa-pinterest"></i></a>
    </div>
</div>

<!-- Font Awesome for social media icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">