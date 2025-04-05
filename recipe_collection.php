<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Recipe data array
$recipes = [
    [
        'id' => 1,
        'title' => 'Spicy Thai Curry',
        'cuisine' => 'Asian',
        'dietary' => 'Vegetarian',
        'difficulty' => 'Medium',
        'image' => 'media/recipe1.jpg',
        'description' => 'A fragrant and spicy Thai curry with coconut milk and fresh vegetables.'
    ],
    [
        'id' => 2,
        'title' => 'Classic Italian Pasta',
        'cuisine' => 'Italian',
        'dietary' => 'Vegetarian',
        'difficulty' => 'Easy',
        'image' => 'media/recipe2.jpg',
        'description' => 'Traditional Italian pasta with homemade tomato sauce and fresh herbs.'
    ],
    [
        'id' => 3,
        'title' => 'Grilled Salmon',
        'cuisine' => 'American',
        'dietary' => 'Pescatarian',
        'difficulty' => 'Medium',
        'image' => 'media/recipe3.jpg',
        'description' => 'Fresh salmon fillet grilled to perfection with lemon and herbs.'
    ],
    [
        'id' => 4,
        'title' => 'Vegetable Sushi Roll',
        'cuisine' => 'Japanese',
        'dietary' => 'Vegan',
        'difficulty' => 'Hard',
        'image' => 'media/recipe4.jpg',
        'description' => 'Colorful sushi rolls filled with fresh vegetables and avocado.'
    ],
    [
        'id' => 5,
        'title' => 'Mexican Tacos',
        'cuisine' => 'Mexican',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Easy',
        'image' => 'media/recipe5.jpg',
        'description' => 'Authentic Mexican tacos with seasoned meat and fresh toppings.'
    ],
    [
        'id' => 6,
        'title' => 'Mediterranean Salad',
        'cuisine' => 'Mediterranean',
        'dietary' => 'Vegetarian',
        'difficulty' => 'Easy',
        'image' => 'media/recipe6.jpg',
        'description' => 'Fresh Mediterranean salad with feta cheese and olives.'
    ],
    [
        'id' => 7,
        'title' => 'Indian Butter Chicken',
        'cuisine' => 'Indian',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Medium',
        'image' => 'media/recipe7.jpg',
        'description' => 'Creamy and rich Indian butter chicken with aromatic spices.'
    ],
    [
        'id' => 8,
        'title' => 'French Ratatouille',
        'cuisine' => 'French',
        'dietary' => 'Vegan',
        'difficulty' => 'Medium',
        'image' => 'media/recipe8.jpg',
        'description' => 'Classic French vegetable stew with Provençal herbs.'
    ],
    [
        'id' => 9,
        'title' => 'Chinese Dim Sum',
        'cuisine' => 'Chinese',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Hard',
        'image' => 'media/recipe9.jpg',
        'description' => 'Assorted Chinese dumplings with various fillings.'
    ],
    [
        'id' => 10,
        'title' => 'Greek Moussaka',
        'cuisine' => 'Greek',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Hard',
        'image' => 'media/recipe10.jpg',
        'description' => 'Traditional Greek layered dish with eggplant and meat.'
    ],
    [
        'id' => 11,
        'title' => 'Vietnamese Pho',
        'cuisine' => 'Vietnamese',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Medium',
        'image' => 'media/recipe11.jpg',
        'description' => 'Aromatic Vietnamese noodle soup with herbs and meat.'
    ],
    [
        'id' => 12,
        'title' => 'Korean Bibimbap',
        'cuisine' => 'Korean',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Medium',
        'image' => 'media/recipe12.jpg',
        'description' => 'Colorful Korean rice bowl with vegetables and meat.'
    ],
    [
        'id' => 13,
        'title' => 'Spanish Paella',
        'cuisine' => 'Spanish',
        'dietary' => 'Non-Vegetarian',
        'difficulty' => 'Hard',
        'image' => 'media/recipe13.jpg',
        'description' => 'Traditional Spanish rice dish with seafood and saffron.'
    ]
];

// Add cooking tips to all recipes
foreach ($recipes as &$recipe) {
    if (!isset($recipe['cooking_tips'])) {
        switch($recipe['difficulty']) {
            case 'Easy':
                $recipe['cooking_tips'] = 'Take your time with prep work and follow the recipe closely. Don\'t forget to taste as you go!';
                break;
            case 'Medium':
                $recipe['cooking_tips'] = 'Pay attention to cooking temperatures and timing. Consider prepping ingredients before starting to cook.';
                break;
            case 'Hard':
                $recipe['cooking_tips'] = 'Read the entire recipe before starting. Use proper techniques and don\'t rush the cooking process.';
                break;
        }
    }
}

// Get unique values for filters
$cuisines = array_unique(array_column($recipes, 'cuisine'));
$dietaryTypes = array_unique(array_column($recipes, 'dietary'));
$difficultyLevels = array_unique(array_column($recipes, 'difficulty'));

// Apply filters if set
$filteredRecipes = $recipes;
if (isset($_GET['cuisine']) && $_GET['cuisine'] !== '') {
    $filteredRecipes = array_filter($filteredRecipes, function($recipe) {
        return $recipe['cuisine'] === $_GET['cuisine'];
    });
    // Reindex the array after filtering
    $filteredRecipes = array_values($filteredRecipes);
}
if (isset($_GET['dietary']) && $_GET['dietary'] !== '') {
    $filteredRecipes = array_filter($filteredRecipes, function($recipe) {
        return $recipe['dietary'] === $_GET['dietary'];
    });
    // Reindex the array after filtering
    $filteredRecipes = array_values($filteredRecipes);
}
if (isset($_GET['difficulty']) && $_GET['difficulty'] !== '') {
    $filteredRecipes = array_filter($filteredRecipes, function($recipe) {
        return $recipe['difficulty'] === $_GET['difficulty'];
    });
    // Reindex the array after filtering
    $filteredRecipes = array_values($filteredRecipes);
}

// Pagination
$recipesPerPage = 6;
$totalRecipes = count($filteredRecipes);
$totalPages = ceil($totalRecipes / $recipesPerPage);
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$startIndex = ($currentPage - 1) * $recipesPerPage;
$paginatedRecipes = array_slice($filteredRecipes, $startIndex, $recipesPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Collection - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .collection-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            letter-spacing: 1px;
        }
        .recipe-card {
            transition: transform 0.3s ease;
            height: 100%;
        }
        .recipe-card:hover {
            transform: translateY(-5px);
        }
        .recipe-image {
            height: 200px;
            object-fit: cover;
        }
        .difficulty-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .recipe-modal .modal-body img {
            max-height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<?php include 'include/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-center align-items-center mb-5">
        <img src="media/chef.png" alt="Chef Icon" style="width: 80px; height: 80px; margin-right: 15px;">
        <h1 class="collection-title mb-0">Recipe Collection</h1>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form class="row g-3" method="GET">
                <div class="col-md-3">
                    <select class="form-select" name="cuisine" onchange="this.form.submit()">
                        <option value="">All Cuisines</option>
                        <?php foreach($cuisines as $cuisine): ?>
                            <option value="<?php echo $cuisine; ?>" <?php echo (isset($_GET['cuisine']) && $_GET['cuisine'] === $cuisine) ? 'selected' : ''; ?>>
                                <?php echo $cuisine; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="dietary" onchange="this.form.submit()">
                        <option value="">All Dietary Types</option>
                        <?php foreach($dietaryTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($_GET['dietary']) && $_GET['dietary'] === $type) ? 'selected' : ''; ?>>
                                <?php echo $type; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="difficulty" onchange="this.form.submit()">
                        <option value="">All Difficulty Levels</option>
                        <?php foreach($difficultyLevels as $level): ?>
                            <option value="<?php echo $level; ?>" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] === $level) ? 'selected' : ''; ?>>
                                <?php echo $level; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <a href="recipe_collection.php" class="btn btn-outline-secondary w-100">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Recipe Cards -->
    <div class="row g-4">
        <?php foreach($paginatedRecipes as $recipe): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card recipe-card h-100">
                    <img src="<?php echo $recipe['image']; ?>" class="card-img-top recipe-image" alt="<?php echo $recipe['title']; ?>">
                    <div class="difficulty-badge">
                        <span class="badge bg-<?php 
                            echo $recipe['difficulty'] === 'Easy' ? 'success' : 
                                ($recipe['difficulty'] === 'Medium' ? 'primary' : 'danger');
                        ?>">
                            <?php echo $recipe['difficulty']; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-globe-americas me-2"></i><?php echo $recipe['cuisine']; ?>
                                <span class="mx-2">|</span>
                                <i class="fas fa-leaf me-2"></i><?php echo $recipe['dietary']; ?>
                            </small>
                        </p>
                        <p class="card-text"><?php echo $recipe['description']; ?></p>
                        <button class="btn btn-success w-100" onclick="showRecipeDetails(<?php echo htmlspecialchars(json_encode($recipe)); ?>)">
                            View Recipe
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Recipe pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link text-success" href="?page=<?php echo $currentPage - 1; ?><?php echo isset($_GET['cuisine']) ? '&cuisine=' . $_GET['cuisine'] : ''; ?><?php echo isset($_GET['dietary']) ? '&dietary=' . $_GET['dietary'] : ''; ?><?php echo isset($_GET['difficulty']) ? '&difficulty=' . $_GET['difficulty'] : ''; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i === $currentPage ? 'active bg-success' : ''; ?>">
                        <a class="page-link <?php echo $i === $currentPage ? 'bg-success border-success' : 'text-success'; ?>" href="?page=<?php echo $i; ?><?php echo isset($_GET['cuisine']) ? '&cuisine=' . $_GET['cuisine'] : ''; ?><?php echo isset($_GET['dietary']) ? '&dietary=' . $_GET['dietary'] : ''; ?><?php echo isset($_GET['difficulty']) ? '&difficulty=' . $_GET['difficulty'] : ''; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link text-success" href="?page=<?php echo $currentPage + 1; ?><?php echo isset($_GET['cuisine']) ? '&cuisine=' . $_GET['cuisine'] : ''; ?><?php echo isset($_GET['dietary']) ? '&dietary=' . $_GET['dietary'] : ''; ?><?php echo isset($_GET['difficulty']) ? '&difficulty=' . $_GET['difficulty'] : ''; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Recipe Modal -->
<div class="modal fade recipe-modal" id="recipeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img class="w-100 mb-4 rounded" alt="Recipe Image">
                <div class="recipe-details"></div>
            </div>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showRecipeDetails(recipe) {
    const modal = new bootstrap.Modal(document.getElementById('recipeModal'));
    document.querySelector('#recipeModal .modal-title').textContent = recipe.title;
    document.querySelector('#recipeModal img').src = recipe.image;
    document.querySelector('#recipeModal img').alt = recipe.title;
    
    const details = `
        <div class="mb-3">
            <h6>Cuisine Type:</h6>
            <p>${recipe.cuisine}</p>
        </div>
        <div class="mb-3">
            <h6>Cooking Tips:</h6>
            <p class="text-muted fst-italic">${recipe.cooking_tips}</p>
        </div>
        <div class="mb-3">
            <h6>Dietary Type:</h6>
            <p>${recipe.dietary}</p>
        </div>
        <div class="mb-3">
            <h6>Difficulty Level:</h6>
            <p>${recipe.difficulty}</p>
        </div>
        <div>
            <h6>Description:</h6>
            <p>${recipe.description}</p>
        </div>
    `;
    
    document.querySelector('#recipeModal .recipe-details').innerHTML = details;
    modal.show();
}
</script>

</body>
</html>