<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
require_once 'include/dbconfig.php';

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $commentText = trim($_POST['comment_text']);
    $recipeId = $_POST['recipe_id'];
    $userId = $_SESSION['user_id'];

    if (!empty($commentText)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO comments (RecipeID, UserID, CommentText) VALUES (?, ?, ?)");
            $stmt->execute([$recipeId, $userId, $commentText]);
            header("Location: " . $_SERVER['PHP_SELF'] . "#recipe_" . $recipeId);
            exit();
        } catch (Exception $e) {
            $error = "An error occurred while posting the comment.";
        }
    }
}

// Handle recipe submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_recipe'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $cuisineType = trim($_POST['cuisine_type']);
    $dietaryPreferences = trim($_POST['dietary_preferences']);
    $difficulty = $_POST['difficulty'];
    $cookingTips = trim($_POST['cooking_tips']);
    $ingredients = $_POST['ingredients'];
    $quantities = $_POST['quantities'];
    $userId = $_SESSION['user_id'];
    $imageURL = '';

    // Validate required fields
    if (empty($title) || empty($description)) {
        $error = "Title and description are required.";
    } else {
        // Handle image upload
        if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileExtension = strtolower(pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                $error = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                $fileName = uniqid('recipe_') . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['recipe_image']['tmp_name'], $uploadPath)) {
                    $imageURL = $uploadPath;
                } else {
                    $error = "Failed to upload image.";
                }
            }
        }

        if (!isset($error)) {
            try {
                // Begin transaction
                $pdo->beginTransaction();

                // Insert recipe
                $stmt = $pdo->prepare("INSERT INTO recipes (UserID, Title, Description, CuisineType, DietaryPreferences, Difficulty, ImageURL, CookingTips) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$userId, $title, $description, $cuisineType, $dietaryPreferences, $difficulty, $imageURL, $cookingTips]);
                $recipeId = $pdo->lastInsertId();

                // Insert ingredients
                $stmt = $pdo->prepare("INSERT INTO recipeingredients (RecipeID, IngredientName, Quantity) VALUES (?, ?, ?)");
                for ($i = 0; $i < count($ingredients); $i++) {
                    if (!empty($ingredients[$i]) && !empty($quantities[$i])) {
                        $stmt->execute([$recipeId, $ingredients[$i], $quantities[$i]]);
                    }
                }

                // Commit transaction
                $pdo->commit();
                $success = "Recipe submitted successfully!";
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "An error occurred while saving the recipe.";
            }
        }
    }
}

// Fetch all recipes with user information
$stmt = $pdo->query("SELECT r.*, u.FirstName, u.LastName FROM recipes r JOIN users u ON r.UserID = u.UserID GROUP BY r.RecipeID ORDER BY r.CreatedAt DESC");
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch ingredients and comments for each recipe
foreach ($recipes as $key => $recipe) {
    // Fetch ingredients
    $stmt = $pdo->prepare("SELECT * FROM recipeingredients WHERE RecipeID = ?");
    $stmt->execute([$recipe['RecipeID']]);
    $recipes[$key]['ingredients'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch comments
    $stmt = $pdo->prepare("SELECT c.*, u.FirstName, u.LastName FROM comments c JOIN users u ON c.UserID = u.UserID WHERE c.RecipeID = ? ORDER BY c.CreatedAt");
    $stmt->execute([$recipe['RecipeID']]);
    $recipes[$key]['comments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Cookbook - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .recipe-image {
            max-height: 300px;
            object-fit: cover;
        }
        .ingredient-row {
            margin-bottom: 10px;
        }
        .remove-ingredient {
            cursor: pointer;
        }
        .comment-section {
            max-height: 300px;
            overflow-y: auto;
        }
        .recipe-description {
            position: relative;
            max-height: 4.5em;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .recipe-description.expanded {
            max-height: none;
        }
        .see-more {
            color: #198754;
            cursor: pointer;
            font-weight: 500;
        }
        .see-more:hover {
            text-decoration: underline;
        }
        .cookbook-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2c3e50;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .cookbook-title img {
            width: 60px;
            height: auto;
        }
        .cookbook-subtitle {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>

<?php include 'include/header.php'; ?>

<div class="container my-5">
    <h1 class="cookbook-title">
        <img src="media/notebook.png" alt="Cookbook Icon">
        Community Cookbook
    </h1>
    <p class="text-center cookbook-subtitle mb-5">A collaborative space where food enthusiasts share their favorite recipes, cooking tips, and culinary experiences with the FoodFusion community</p>

    <!-- Recipe Submission Form -->
    <div class="card mb-5">
        <div class="card-header bg-success text-white">
            <h3 class="card-title mb-0">Share Your Recipe</h3>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Recipe Title*</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="cuisine_type" class="form-label">Cuisine Type</label>
                        <input type="text" class="form-control" id="cuisine_type" name="cuisine_type">
                    </div>
                    <div class="col-md-4">
                        <label for="dietary_preferences" class="form-label">Dietary Preferences</label>
                        <input type="text" class="form-control" id="dietary_preferences" name="dietary_preferences">
                    </div>
                    <div class="col-md-4">
                        <label for="difficulty" class="form-label">Difficulty Level</label>
                        <select class="form-select" id="difficulty" name="difficulty">
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <div id="ingredients-container">
                        <div class="ingredient-row row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ingredients[]" placeholder="Ingredient name">
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="quantities[]" placeholder="Quantity">
                            </div>
                            <div class="col-md-1">
                                <i class="fas fa-times text-danger remove-ingredient"></i>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-ingredient">
                        <i class="fas fa-plus"></i> Add Ingredient
                    </button>
                </div>

                <div class="mb-3">
                    <label for="cooking_tips" class="form-label">Cooking Tips</label>
                    <textarea class="form-control" id="cooking_tips" name="cooking_tips" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="recipe_image" class="form-label">Recipe Image</label>
                    <input type="file" class="form-control" id="recipe_image" name="recipe_image" accept="image/*">
                </div>

                <button type="submit" name="submit_recipe" class="btn btn-success">
                    <i class="fas fa-share"></i> Share Recipe
                </button>
            </form>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search recipes by title...">
                </div>
                <div class="col-md-2">
                    <select id="cuisineFilter" class="form-select">
                        <option value="">All Cuisines</option>
                        <?php
                        $cuisines = $pdo->query("SELECT DISTINCT CuisineType FROM recipes WHERE CuisineType IS NOT NULL AND CuisineType != '' ORDER BY CuisineType")->fetchAll(PDO::FETCH_COLUMN);
                        foreach ($cuisines as $cuisine): ?>
                            <option value="<?php echo htmlspecialchars($cuisine); ?>"><?php echo htmlspecialchars($cuisine); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="dietaryFilter" class="form-select">
                        <option value="">All Dietary Types</option>
                        <?php
                        $dietaryTypes = $pdo->query("SELECT DISTINCT DietaryPreferences FROM recipes WHERE DietaryPreferences IS NOT NULL AND DietaryPreferences != '' ORDER BY DietaryPreferences")->fetchAll(PDO::FETCH_COLUMN);
                        foreach ($dietaryTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="difficultyFilter" class="form-select">
                        <option value="">All Difficulties</option>
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Shared Recipes -->
    <h2 class="mb-4">Community Recipes</h2>
    <?php foreach ($recipes as $recipe): ?>
        <div class="card mb-4" id="recipe_<?php echo $recipe['RecipeID']; ?>">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><?php echo htmlspecialchars($recipe['Title']); ?></h3>
                    <small class="text-muted">
                        Shared by <?php echo htmlspecialchars($recipe['FirstName'] . ' ' . $recipe['LastName']); ?>
                        on <?php echo date('M d, Y', strtotime($recipe['CreatedAt'])); ?>
                    </small>
                </div>
            </div>
            <?php if ($recipe['ImageURL']): ?>
                <img src="<?php echo htmlspecialchars($recipe['ImageURL']); ?>" class="card-img-top recipe-image" alt="<?php echo htmlspecialchars($recipe['Title']); ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="mb-3">
                    <h5>Description</h5>
                    <div class="recipe-description">
                        <p><?php echo nl2br(htmlspecialchars($recipe['Description'])); ?></p>
                    </div>
                    <span class="see-more">See More...</span>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <h5>Cuisine Type</h5>
                        <p><?php echo htmlspecialchars($recipe['CuisineType']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5>Dietary Preferences</h5>
                        <p><?php echo htmlspecialchars($recipe['DietaryPreferences']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5>Difficulty Level</h5>
                        <p><?php echo htmlspecialchars($recipe['Difficulty']); ?></p>
                    </div>
                </div>

                <div class="mb-3">
                    <h5>Ingredients</h5>
                    <ul class="list-unstyled">
                        <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                            <li>
                                <?php echo htmlspecialchars($ingredient['IngredientName']); ?> - 
                                <?php echo htmlspecialchars($ingredient['Quantity']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if ($recipe['CookingTips']): ?>
                    <div class="mb-3">
                        <h5>Cooking Tips</h5>
                        <p class="fst-italic"><?php echo nl2br(htmlspecialchars($recipe['CookingTips'])); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Comments Section -->
                <div class="mt-4">
                    <h5>Comments</h5>
                    <div class="comment-section">
                        <?php foreach ($recipe['comments'] as $comment): ?>
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <p class="mb-1"><?php echo nl2br(htmlspecialchars($comment['CommentText'])); ?></p>
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($comment['FirstName'] . ' ' . $comment['LastName']); ?> - 
                                        <?php echo date('M d, Y g:i A', strtotime($comment['CreatedAt'])); ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <form method="POST" class="mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="comment_text" placeholder="Add a comment..." required>
                            <input type="hidden" name="recipe_id" value="<?php echo $recipe['RecipeID']; ?>">
                            <button type="submit" name="submit_comment" class="btn btn-outline-success">
                                <i class="fas fa-comment"></i> Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search and filter functionality
    const searchInput = document.getElementById('searchInput');
    const cuisineFilter = document.getElementById('cuisineFilter');
    const dietaryFilter = document.getElementById('dietaryFilter');
    const difficultyFilter = document.getElementById('difficultyFilter');
    const recipeCards = document.querySelectorAll('.card[id^="recipe_"]');

    function filterRecipes() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCuisine = cuisineFilter.value.toLowerCase();
        const selectedDietary = dietaryFilter.value.toLowerCase();
        const selectedDifficulty = difficultyFilter.value.toLowerCase();

        recipeCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('.card-body p').textContent.toLowerCase();
            const cuisine = card.querySelector('.col-md-4:nth-child(1) p').textContent.toLowerCase();
            const dietary = card.querySelector('.col-md-4:nth-child(2) p').textContent.toLowerCase();
            const difficulty = card.querySelector('.col-md-4:nth-child(3) p').textContent.toLowerCase();

            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesCuisine = !selectedCuisine || cuisine.includes(selectedCuisine);
            const matchesDietary = !selectedDietary || dietary.includes(selectedDietary);
            const matchesDifficulty = !selectedDifficulty || difficulty.includes(selectedDifficulty);

            card.style.display = 
                matchesSearch && matchesCuisine && matchesDietary && matchesDifficulty ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRecipes);
    cuisineFilter.addEventListener('change', filterRecipes);
    dietaryFilter.addEventListener('change', filterRecipes);
    difficultyFilter.addEventListener('change', filterRecipes);

    // Add ingredient row
    document.getElementById('add-ingredient').addEventListener('click', function() {
        const container = document.getElementById('ingredients-container');
        const newRow = document.createElement('div');
        newRow.className = 'ingredient-row row';
        newRow.innerHTML = `
            <div class="col-md-6">
                <input type="text" class="form-control" name="ingredients[]" placeholder="Ingredient name">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="quantities[]" placeholder="Quantity">
            </div>
            <div class="col-md-1">
                <i class="fas fa-times text-danger remove-ingredient"></i>
            </div>
        `;
        container.appendChild(newRow);
    });

    // Remove ingredient row
    document.getElementById('ingredients-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-ingredient')) {
            const row = e.target.closest('.ingredient-row');
            if (document.getElementsByClassName('ingredient-row').length > 1) {
                row.remove();
            }
        }
    });

    // Handle See More functionality
    document.querySelectorAll('.see-more').forEach(button => {
        button.addEventListener('click', function() {
            const description = this.previousElementSibling;
            const isExpanded = description.classList.contains('expanded');
            
            description.classList.toggle('expanded');
            this.textContent = isExpanded ? 'See More...' : 'See Less';
        });
    });

    // Add ingredient row
    document.getElementById('add-ingredient').addEventListener('click', function() {
        const container = document.getElementById('ingredients-container');
        const newRow = document.createElement('div');
        newRow.className = 'ingredient-row row';
        newRow.innerHTML = `
            <div class="col-md-6">
                <input type="text" class="form-control" name="ingredients[]" placeholder="Ingredient name">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="quantities[]" placeholder="Quantity">
            </div>
            <div class="col-md-1">
                <i class="fas fa-times text-danger remove-ingredient"></i>
            </div>
        `;
        container.appendChild(newRow);
    });

    // Remove ingredient row
    document.getElementById('ingredients-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-ingredient')) {
            const row = e.target.closest('.ingredient-row');
            if (document.getElementsByClassName('ingredient-row').length > 1) {
                row.remove();
            }
        }
    });
});
</script>

</body>
</html>