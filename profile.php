<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'include/dbconfig.php';

$error = '';
$success = '';
$userId = $_SESSION['user_id'];

// Fetch user data
try {
    $stmt = $pdo->prepare('SELECT FirstName, LastName, Email FROM users WHERE UserID = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    $error = 'Error fetching user data';
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate input
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All password fields are required';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New passwords do not match';
    } elseif (strlen($newPassword) < 8) {
        $error = 'New password must be at least 8 characters long';
    } else {
        // Verify current password
        $stmt = $pdo->prepare('SELECT PasswordHash FROM users WHERE UserID = ?');
        $stmt->execute([$userId]);
        $userData = $stmt->fetch();

        if (password_verify($currentPassword, $userData['PasswordHash'])) {
            // Update password
            try {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE users SET PasswordHash = ? WHERE UserID = ?');
                $stmt->execute([$hashedPassword, $userId]);
                $success = 'Password updated successfully';
            } catch (PDOException $e) {
                $error = 'Error updating password';
            }
        } else {
            $error = 'Current password is incorrect';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #28a745;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #28a745;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container">
        <div class="profile-container">
            <h2 class="section-title">My Profile</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <div class="user-info">
                <h3 class="mb-4">Account Information</h3>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Name:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($user['Email']); ?></div>
                </div>
            </div>

            <div class="password-change-section">
                <h3 class="mb-4">Change Password</h3>
                <form method="POST" action="profile.php">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" name="change_password" class="btn btn-success">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>