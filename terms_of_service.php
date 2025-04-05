<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .terms-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .terms-section {
            margin-bottom: 30px;
        }
        .terms-section h2 {
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container terms-container">
        <h1 class="text-center mb-5">Terms of Service</h1>
        
        <div class="terms-section">
            <h2>Acceptance of Terms</h2>
            <p>By accessing and using FoodFusion, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using this site.</p>
        </div>

        <div class="terms-section">
            <h2>User Accounts</h2>
            <p>To access certain features of the site, you must create an account. You are responsible for:</p>
            <ul>
                <li>Maintaining the confidentiality of your account</li>
                <li>All activities that occur under your account</li>
                <li>Providing accurate and current information</li>
                <li>Notifying us of any unauthorized use</li>
            </ul>
        </div>

        <div class="terms-section">
            <h2>Content Guidelines</h2>
            <p>When submitting recipes and comments, you agree to follow these guidelines:</p>
            <ul>
                <li>Content must be original or properly credited</li>
                <li>No inappropriate, offensive, or harmful content</li>
                <li>No spam or commercial advertising</li>
                <li>No copyright infringement</li>
            </ul>
        </div>

        <div class="terms-section">
            <h2>Intellectual Property</h2>
            <p>All content on FoodFusion, including text, graphics, logos, and recipes, is protected by copyright and other intellectual property laws. Users retain ownership of their submitted content but grant FoodFusion a license to use, display, and distribute it.</p>
        </div>

        <div class="terms-section">
            <h2>Limitation of Liability</h2>
            <p>FoodFusion is provided "as is" without any warranties. We are not responsible for:</p>
            <ul>
                <li>Accuracy of user-submitted content</li>
                <li>Any harm resulting from using the site</li>
                <li>Technical issues or service interruptions</li>
                <li>Third-party links or content</li>
            </ul>
        </div>

        <div class="terms-section">
            <h2>Modifications</h2>
            <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting to the site. Your continued use of FoodFusion constitutes acceptance of the modified terms.</p>
        </div>

        <div class="terms-section">
            <h2>Termination</h2>
            <p>We may terminate or suspend your account and access to FoodFusion at our discretion, without prior notice, for conduct that we believe violates these terms or is harmful to other users or us.</p>
        </div>

        <div class="terms-section">
            <h2>Contact Information</h2>
            <p>For questions about these terms, please contact us at terms@foodfusion.com</p>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>