<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - Your Culinary Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('media/title_food_image.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
        .join-popup, .recipe-popup, .signup-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 90%;
        }
        .recipe-popup img {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .carousel-caption h5, .carousel-caption p {
            color: white;
            background-color: black;
            width: fit-content;
            padding: 4px;
            border-radius: 5px;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #28a745; 
            border-radius: 50%; 
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4">Welcome to FoodFusion</h1>
            <p class="lead">Join our community of food enthusiasts and discover the joy of cooking</p>
            <button class="btn btn-success btn-lg" onclick="showJoinPopup()">Join Us Today</button>
        </div>
    </section>

    <!-- Cooking Events Carousel -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Upcoming Cooking Events</h2>
        <div id="eventsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#eventsCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#eventsCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#eventsCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="media/cooking_event_carousel1.jpg" class="d-block w-100" alt="Cooking Event 1">
                    <div class="carousel-caption">
                        <h5>Master Chef Workshop</h5>
                        <p>Learn from the best in the industry</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="media/cooking_event_carousel2.jpg" class="d-block w-100" alt="Cooking Event 2">
                    <div class="carousel-caption">
                        <h5>Baking Masterclass</h5>
                        <p>Perfect your pastry skills</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="media/cooking_event_carousel3.jpg" class="d-block w-100" alt="Cooking Event 3">
                    <div class="carousel-caption">
                        <h5>International Cuisine Festival</h5>
                        <p>Explore flavors from around the world</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Featured Recipes -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Featured Recipes</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="media/featured_recipes1.jpg" class="card-img-top" alt="Recipe 1">
                    <div class="card-body">
                        <h5 class="card-title">Potsticker Salad</h5>
                        <p class="card-text">Elevate your greens with crispy, pan-seared dumplings tossed in a zesty sesame dressing.</p>
                        <button onclick="showRecipePopup('Potsticker Salad', 'media/featured_recipes1.jpg', 'A delightful fusion dish that combines crispy pan-seared dumplings with fresh, crisp vegetables. The salad is dressed in a zesty sesame-ginger vinaigrette, creating a perfect balance of textures and Asian-inspired flavors. This innovative dish transforms traditional potstickers into a refreshing meal that\'s both satisfying and light.')" class="btn btn-success">View Recipe</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="media/featured_recipes2.jpg" class="card-img-top" alt="Recipe 2">
                    <div class="card-body">
                        <h5 class="card-title">Pappardelle Pasta</h5>
                        <p class="card-text">Savor the rich flavors of wide, silky noodles paired with a hearty ragu or creamy sauce.</p>
                        <button onclick="showRecipePopup('Pappardelle Pasta', 'media/featured_recipes2.jpg', 'Luxurious wide ribbons of pasta paired with a rich, slow-cooked ragu sauce. Our pappardelle features handmade pasta tossed in a hearty sauce made with premium ingredients. The broad, flat noodles are perfect for catching every bit of the savory sauce, creating a truly authentic Italian dining experience.')" class="btn btn-success">View Recipe</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="media/featured_recipes3.jpeg" class="card-img-top" alt="Recipe 3">
                    <div class="card-body">
                        <h5 class="card-title">Tofu Stir-fry</h5>
                        <p class="card-text">Whip up a quick, flavorful dish with crispy tofu, vibrant veggies, and a savory soy-ginger glaze.</p>
                        <button onclick="showRecipePopup('Tofu Stir-fry', 'media/featured_recipes3.jpeg', 'A vibrant and healthy stir-fry that transforms simple tofu into a flavor-packed meal. Crispy cubes of tofu are combined with colorful seasonal vegetables and tossed in our signature soy-ginger sauce. This quick and easy dish proves that plant-based cooking can be both nutritious and incredibly delicious.')" class="btn btn-success">View Recipe</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Culinary Trends -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Latest Culinary Trends</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="media/culinary_trend1.jpg" class="card-img-top" alt="Trend 1">
                    <div class="card-body">
                        <h5 class="card-title">Plant-Based Cooking</h5>
                        <p class="card-text">Discover delicious vegetarian and vegan recipes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="media/culinary_trend2.jpg" class="card-img-top" alt="Trend 2">
                    <div class="card-body">
                        <h5 class="card-title">Fusion Cuisine</h5>
                        <p class="card-text">Blend different culinary traditions for unique flavors.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="media/culinary_trend3.jpg" class="card-img-top" alt="Trend 3">
                    <div class="card-body">
                        <h5 class="card-title">Sustainable Cooking</h5>
                        <p class="card-text">Learn about eco-friendly cooking practices.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recipe Popup -->
    <div class="recipe-popup" id="recipePopup">
        <h3 class="text-center mb-4" id="recipeTitle"></h3>
        <img id="recipeImage" class="img-fluid mb-4 rounded" alt="Recipe Image">
        <p class="lead" id="recipeDescription"></p>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" onclick="hideRecipePopup()" aria-label="Close"></button>
    </div>

    <!-- Join Us Popup -->
    <div class="popup-overlay" id="popupOverlay"></div>
    <div class="signup-popup" id="signupPopup">
        <h3 class="text-center mb-4">Sign Up Now to explore our culinary platform</h3>
        <div class="text-center">
            <a href="register.php" class="btn btn-success btn-lg">Go to SignUp Page</a>
        </div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" onclick="hideSignupPopup()" aria-label="Close"></button>
    </div>
    <div class="join-popup" id="joinPopup">
        <h3 class="text-center mb-4">Join FoodFusion Community</h3>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="popupFirstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="popupFirstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="popupLastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="popupLastName" name="lastName" required>
            </div>
            <div class="mb-3">
                <label for="popupEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="popupEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="popupPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="popupPassword" name="password" required>
                <div class="form-text">Password must be at least 8 characters long.</div>
            </div>
            <div class="mb-3">
                <label for="popupConfirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="popupConfirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" onclick="hideJoinPopup()" aria-label="Close"></button>
        </form>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showSignupPopup() {
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('signupPopup').style.display = 'block';
        }

        function hideSignupPopup() {
            document.getElementById('popupOverlay').style.display = 'none';
            document.getElementById('signupPopup').style.display = 'none';
        }

        function showJoinPopup() {
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('joinPopup').style.display = 'block';
        }

        function hideJoinPopup() {
            document.getElementById('popupOverlay').style.display = 'none';
            document.getElementById('joinPopup').style.display = 'none';
        }

        function showRecipePopup(title, image, description) {
            document.getElementById('recipeTitle').textContent = title;
            document.getElementById('recipeImage').src = image;
            document.getElementById('recipeDescription').textContent = description;
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('recipePopup').style.display = 'block';
        }

        function hideRecipePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
            document.getElementById('recipePopup').style.display = 'none';
        }

        // Show popup when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Only show popup for non-logged in users
            <?php if (!isset($_SESSION['user_id'])): ?>
                showSignupPopup();
            <?php endif; ?>
        });
    </script>
</body>
</html>