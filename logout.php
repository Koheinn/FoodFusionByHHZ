<?php
if (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] === 'true') {
    session_start();
    // Clear all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                </div>
                <div class="modal-body">
                    Do you really want to log out?
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" name="confirm_logout" value="true">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the modal automatically when the page loads
        window.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            myModal.show();
        });
    </script>
</body>
</html>