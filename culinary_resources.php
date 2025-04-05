<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'include/dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinary Resources - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .banner-container {
            position: relative;
            overflow: hidden;
            max-height: 400px;
        }
        .banner-image {
            object-fit: cover;
            height: 400px;
        }
        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
        }
        .culinary-content .culinary-heading {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2c3e50;
        }
        .culinary-resource-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            overflow: hidden;
        }
        .culinary-resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .culinary-card-cover-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .culinary-resource-icon {
            font-size: 2.5rem;
            color: #28a745;
            margin-bottom: 15px;
        }
        .culinary-resource-section {
            padding: 40px 0;
            background-color: #f8f9fa;
        }
        .culinary-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .culinary-video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }
        .culinary-video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="banner-container mb-5">
        <img src="media/culinary_resources_title.png" alt="Culinary Resources Banner" class="w-100 banner-image">
        <div class="banner-overlay">
            <h1 class="text-center culinary-heading text-white">Culinary Resources</h1>
            <p class="text-center text-white">Discover a world of culinary knowledge with our comprehensive collection of cooking resources</p>
        </div>
    </div>
    <div class="container culinary-content">

        <!-- Recipe Cards Section -->
        <section class="resource-section mb-5">
            <h2 class="text-center mb-4 culinary-heading">Recipe Cards</h2>
            <p class="text-center mb-4">Step-by-step guides to create delicious dishes with confidence</p>
            <div class="row g-4">
                <?php
                $recipe_cards_dir = 'resources/Culinary/recipe cards/';
                $recipe_cards = glob($recipe_cards_dir . '*');
                
                foreach ($recipe_cards as $card) {
                    if (!file_exists($card)) {
                        continue;
                    }
                    $filename = basename($card);
                    $title = ucwords(str_replace(['_', '-', '.pdf', '.jpg', '.png'], ' ', $filename));
                    $file_extension = strtolower(pathinfo($card, PATHINFO_EXTENSION));
                    ?>
                    <div class="col-md-4">
                        <div class="card culinary-resource-card shadow-sm">
                            <?php
                            $cover_dir = 'resources/Culinary/recipe card covers/';
                            $cover_files = glob($cover_dir . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                            $found_cover = false;
                            
                            foreach ($cover_files as $cover) {
                                // Convert both filenames to lowercase and remove extensions for comparison
                                $card_name = strtolower(pathinfo($filename, PATHINFO_FILENAME));
                                $cover_name = strtolower(pathinfo(basename($cover), PATHINFO_FILENAME));
                                
                                // Check if the cover name contains the card name or vice versa
                                if (strpos($cover_name, $card_name) !== false || strpos($card_name, $cover_name) !== false) {
                                    echo '<img src="' . htmlspecialchars($cover) . '" class="culinary-card-cover-img" alt="' . htmlspecialchars($title) . '">';
                                    $found_cover = true;
                                    break;
                                }
                            }
                            
                            if (!$found_cover) {
                                echo '<div class="text-center py-4"><i class="fas fa-image culinary-resource-icon"></i></div>';
                            }
                            ?>
                            <div class="card-body text-center">
                                <h5 class="culinary-card-title"><?php echo htmlspecialchars($title); ?></h5>
                                <a href="download.php?file=<?php echo urlencode($card); ?>" class="btn btn-success">
                                    <i class="fas fa-download me-2"></i>Download Recipe
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>

        <!-- Cooking Tutorials Section -->
        <section class="culinary-resource-section mb-5">
            <h2 class="text-center mb-4">Cooking Tutorials</h2>
            <p class="text-center mb-4">Master essential cooking techniques with our detailed tutorials</p>
            <div class="row g-4">
                <?php
                $tutorials_dir = 'resources/Culinary/cooking tutorials/';
                $tutorials = glob($tutorials_dir . '*');
                
                foreach ($tutorials as $tutorial) {
                    if (is_file($tutorial)) {
                        $filename = basename($tutorial);
                        $title = ucwords(str_replace(['_', '-', '.mp4', '.pdf'], ' ', $filename));
                        ?>
                        <div class="col-md-6">
                            <div class="card culinary-resource-card shadow-sm">
                                <div class="card-body">
                                    <h5 class="culinary-card-title text-center mb-3"><?php echo htmlspecialchars($title); ?></h5>
                                    <?php if (strpos($tutorial, '.mp4') !== false): ?>
                                        <div class="culinary-video-container mb-3">
                                            <video controls class="w-100">
                                                <source src="<?php echo htmlspecialchars($tutorial); ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <i class="fas fa-file-alt culinary-resource-icon"></i>
                                            <a href="<?php echo htmlspecialchars($tutorial); ?>" class="btn btn-success" download>
                                                <i class="fas fa-download me-2"></i>Download Tutorial
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </section>

        <!-- Instructional Videos Section -->
        <section class="culinary-resource-section">
            <h2 class="text-center mb-4">Instructional Videos</h2>
            <p class="text-center mb-4">Watch and learn professional cooking tips and kitchen hacks</p>
            <div class="row g-4">
                <?php
                $videos_dir = 'resources/Culinary/instructional videos/';
                $videos = glob($videos_dir . '*.{mp4,webm}', GLOB_BRACE);
                
                foreach ($videos as $video) {
                    $filename = basename($video);
                    $title = ucwords(str_replace(['_', '-', '.mp4', '.webm'], ' ', $filename));
                    ?>
                    <div class="col-md-6">
                        <div class="card culinary-resource-card shadow-sm">
                            <div class="card-body">
                                <h5 class="culinary-card-title text-center mb-3"><?php echo htmlspecialchars($title); ?></h5>
                                <div class="culinary-video-container">
                                    <video controls class="w-100">
                                        <source src="<?php echo htmlspecialchars($video); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>