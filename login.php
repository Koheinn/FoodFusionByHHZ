<?php
session_start();
require_once 'include/dbconfig.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE Email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Check if user is locked out
            if ($user['LockoutTime'] !== null && new DateTime($user['LockoutTime']) > new DateTime()) {
                $lockoutTime = new DateTime($user['LockoutTime']);
                $now = new DateTime();
                $timeLeft = $now->diff($lockoutTime);
                $error = 'Account is locked. Please try again in ' . $timeLeft->i . ' minutes and ' . $timeLeft->s . ' seconds.';
            } else {
                if (password_verify($password, $user['PasswordHash'])) {
                    // Successful login
                    $_SESSION['user_id'] = $user['UserID'];
                    $_SESSION['user_name'] = $user['FirstName'];
                    
                    // Reset failed attempts
                    $stmt = $pdo->prepare('UPDATE users SET FailedLoginAttempts = 0, LockoutTime = NULL WHERE UserID = ?');
                    $stmt->execute([$user['UserID']]);
                    
                    header('Location: index.php');
                    exit();
                } else {
                    // Failed login attempt
                    $failedAttempts = $user['FailedLoginAttempts'] + 1;
                    
                    if ($failedAttempts >= 3) {
                        // Lock the account for 3 minutes
                        $lockoutTime = new DateTime();
                        $lockoutTime->add(new DateInterval('PT3M'));
                        
                        $stmt = $pdo->prepare('UPDATE users SET FailedLoginAttempts = ?, LockoutTime = ? WHERE UserID = ?');
                        $stmt->execute([$failedAttempts, $lockoutTime->format('Y-m-d H:i:s'), $user['UserID']]);
                        
                        $error = 'Too many failed attempts. Account locked for 3 minutes.';
                    } else {
                        $stmt = $pdo->prepare('UPDATE users SET FailedLoginAttempts = ? WHERE UserID = ?');
                        $stmt->execute([$failedAttempts, $user['UserID']]);
                        $error = 'Invalid password. ' . (3 - $failedAttempts) . ' attempts remaining.';
                    }
                }
            }
        } else {
            $error = 'No account found with this email';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
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
        <div class="login-container">
            <h2 class="form-title">Welcome Back!</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Login</button>

                <div class="text-center mt-3">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </form>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>