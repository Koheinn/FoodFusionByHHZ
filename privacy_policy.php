<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .policy-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .policy-section {
            margin-bottom: 30px;
        }
        .policy-section h2 {
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container policy-container">
        <h1 class="text-center mb-5">Privacy Policy</h1>
        
        <div class="policy-section">
            <h2>Information We Collect</h2>
            <p>We collect information that you provide directly to us, including:</p>
            <ul>
                <li>Name and contact information when you create an account</li>
                <li>Profile information and preferences</li>
                <li>Recipe submissions and comments</li>
                <li>Communications with us</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Provide and maintain our services</li>
                <li>Process your recipe submissions</li>
                <li>Send you updates and notifications</li>
                <li>Improve our website and services</li>
                <li>Respond to your comments and questions</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>Information Sharing</h2>
            <p>We do not sell or rent your personal information to third parties. We may share your information:</p>
            <ul>
                <li>With your consent</li>
                <li>To comply with legal obligations</li>
                <li>To protect our rights and safety</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>Data Security</h2>
            <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.</p>
        </div>

        <div class="policy-section">
            <h2>Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access your personal information</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your information</li>
                <li>Opt-out of marketing communications</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>Updates to This Policy</h2>
            <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>
        </div>

        <div class="policy-section">
            <h2>Contact Us</h2>
            <p>If you have any questions about this privacy policy, please contact us at privacy@foodfusion.com</p>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>