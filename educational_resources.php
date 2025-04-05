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
    <title>Educational Resources - FoodFusion</title>
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
        .educational-content .educational-heading {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2c3e50;
        }
        .educational-resource-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            overflow: hidden;
        }
        .educational-resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .educational-card-cover-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .educational-resource-icon {
            font-size: 2.5rem;
            color: #28a745;
            margin-bottom: 15px;
        }
        .educational-resource-section {
            padding: 40px 0;
            background-color: #f8f9fa;
        }
        .educational-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .educational-video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }
        .educational-video-container iframe {
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
        <img src="media/educational_resources_title.jpg" alt="Educational Resources Banner" class="w-100 banner-image">
        <div class="banner-overlay">
            <h1 class="text-center educational-heading text-white">Educational Resources</h1>
            <p class="text-center text-white">Explore our comprehensive collection of renewable energy educational materials</p>
        </div>
    </div>
    <div class="container educational-content">

        <!-- Downloadable Resources Section -->
        <section class="resource-section mb-5">
            <h2 class="text-center mb-4 educational-heading">Downloadable Resources</h2>
            <p class="text-center mb-4">Access detailed guides and materials about renewable energy topics</p>
            <div class="row g-4">
                <?php
                $resources_dir = 'resources/Educational/resources/';
                $resources = glob($resources_dir . '*');
                
                foreach ($resources as $resource) {
                    if (!file_exists($resource)) {
                        continue;
                    }
                    $filename = basename($resource);
                    $title = ucwords(str_replace(['_', '-', '.pdf'], ' ', $filename));
                    ?>
                    <div class="col-md-4">
                        <div class="card educational-resource-card shadow-sm">
                            <div class="text-center py-4">
                                <i class="fas fa-file-pdf educational-resource-icon"></i>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="educational-card-title"><?php echo htmlspecialchars($title); ?></h5>
                                <a href="download.php?file=<?php echo urlencode($resource); ?>" class="btn btn-success">
                                    <i class="fas fa-download me-2"></i>Download Resource
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>

        <!-- Infographics Section -->
        <section class="educational-resource-section mb-5">
            <h2 class="text-center mb-4">Infographics</h2>
            <p class="text-center mb-4">Visual guides explaining renewable energy concepts</p>
            <div class="row g-4">
                <?php
                $infographics_dir = 'resources/Educational/infographics/';
                $infographics = glob($infographics_dir . '*.{jpg,jpeg,png,pdf}', GLOB_BRACE);
                
                foreach ($infographics as $infographic) {
                    if (is_file($infographic)) {
                        $filename = basename($infographic);
                        $title = ucwords(str_replace(['_', '-', '.jpg', '.jpeg', '.png', '.pdf'], ' ', $filename));
                        $file_extension = strtolower(pathinfo($infographic, PATHINFO_EXTENSION));
                        ?>
                        <div class="col-md-6">
                            <div class="card educational-resource-card shadow-sm">
                                <div class="card-body">
                                    <h5 class="educational-card-title text-center mb-3"><?php echo htmlspecialchars($title); ?></h5>
                                    <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png'])): ?>
                                        <img src="<?php echo htmlspecialchars($infographic); ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($title); ?>">
                                    <?php else: ?>
                                        <div class="text-center">
                                            <i class="fas fa-file-image educational-resource-icon"></i>
                                            <a href="download.php?file=<?php echo urlencode($infographic); ?>" class="btn btn-success" download>
                                                <i class="fas fa-download me-2"></i>Download Infographic
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

        <!-- Educational Videos Section -->
        <section class="educational-resource-section">
            <h2 class="text-center mb-4">Educational Videos</h2>
            <p class="text-center mb-4">Watch and learn about renewable energy technologies and applications</p>
            <div class="row g-4">
                <?php
                $videos_dir = 'resources/Educational/videos/';
                $videos = glob($videos_dir . '*.{mp4,webm}', GLOB_BRACE);
                
                foreach ($videos as $video) {
                    $filename = basename($video);
                    $title = ucwords(str_replace(['_', '-', '.mp4', '.webm'], ' ', $filename));
                    ?>
                    <div class="col-md-6">
                        <div class="card educational-resource-card shadow-sm">
                            <div class="card-body">
                                <h5 class="educational-card-title text-center mb-3"><?php echo htmlspecialchars($title); ?></h5>
                                <div class="educational-video-container">
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