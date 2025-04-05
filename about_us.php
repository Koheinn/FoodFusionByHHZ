<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('media/about_us_title_image.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .team-member-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 4px solid #28a745;
        }
        .value-card {
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 15px 0;
            background-color: #f8f9fa;
            transition: transform 0.3s ease;
        }
        .value-card:hover {
            transform: translateX(10px);
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4">Our Story</h1>
            <p class="lead">Bringing people together through the love of food</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Our Mission</h2>
                <p class="lead mb-4">
                    At FoodFusion, we believe that cooking is more than just preparing meals - it's about creating connections, 
                    sharing traditions, and exploring cultures through the universal language of food. Our platform brings together 
                    food enthusiasts from all walks of life to learn, share, and grow together.
                </p>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Our Values</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="value-card">
                    <h4>Community First</h4>
                    <p>We foster a supportive environment where food lovers can connect, share, and inspire each other.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <h4>Culinary Excellence</h4>
                    <p>We promote high-quality recipes, techniques, and cooking education to help you master the kitchen.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <h4>Sustainable Cooking</h4>
                    <p>We encourage eco-friendly cooking practices and responsible ingredient sourcing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Meet Our Team</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <img src="media/team_member1.jpg" alt="Executive Chef" class="team-member-img">
                <h4>Sarah Chen</h4>
                <p class="text-success">Executive Chef</p>
                <p>A master of fusion cuisine with 15 years of culinary experience in top restaurants worldwide.</p>
            </div>
            <div class="col-md-4 mb-4">
                <img src="media/team_member2.jpg" alt="Culinary Director" class="team-member-img">
                <h4>Marcus Rodriguez</h4>
                <p class="text-success">Culinary Director</p>
                <p>Former Michelin-starred chef turned educator, passionate about sharing culinary knowledge.</p>
            </div>
            <div class="col-md-4 mb-4">
                <img src="media/team_member3.jpg" alt="Community Manager" class="team-member-img">
                <h4>Emily Thompson</h4>
                <p class="text-success">Community Manager</p>
                <p>Food blogger and community builder who brings our members together through shared passion.</p>
            </div>
            <div class="col-md-6 mb-4">
                <img src="media/team_member4.jpg" alt="Sustainability Expert" class="team-member-img">
                <h4>David Park</h4>
                <p class="text-success">Sustainability Expert</p>
                <p>Environmental specialist focusing on sustainable cooking practices and food waste reduction.</p>
            </div>
            <div class="col-md-6 mb-4">
                <img src="media/team_member5.jpg" alt="Content Creator" class="team-member-img">
                <h4>Lisa Martinez</h4>
                <p class="text-success">Content Creator</p>
                <p>Award-winning food photographer and recipe developer bringing dishes to life.</p>
            </div>
        </div>
    </section>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>