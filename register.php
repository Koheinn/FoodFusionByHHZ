<?php
session_start();
require_once 'include/dbconfig.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE Email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error = 'Email already registered';
        } else {
            // Insert new user
            try {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (FirstName, LastName, Email, PasswordHash) VALUES (?, ?, ?, ?)');
                $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
                $success = 'Registration successful! You can now login.';
                // Redirect to login page after 2 seconds
                header('refresh:2;url=login.php');
            } catch (PDOException $e) {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #28a745;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container">
        <div class="register-container">
            <h2 class="form-title">Join FoodFusion Community</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="form-text">Password must be at least 8 characters long.</div>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>

                <div class="text-center mt-3">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </form>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>