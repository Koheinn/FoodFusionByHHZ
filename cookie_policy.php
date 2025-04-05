<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Policy - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cookie-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .cookie-section {
            margin-bottom: 30px;
        }
        .cookie-section h2 {
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container cookie-container">
        <h1 class="text-center mb-5">Cookie Policy</h1>
        
        <div class="cookie-section">
            <h2>What Are Cookies</h2>
            <p>Cookies are small text files that are placed on your computer or mobile device when you visit our website. They are widely used to make websites work more efficiently and provide a better user experience.</p>
        </div>

        <div class="cookie-section">
            <h2>How We Use Cookies</h2>
            <p>We use cookies for the following purposes:</p>
            <ul>
                <li>Essential cookies: Required for the website to function properly</li>
                <li>Authentication cookies: Remember your login status</li>
                <li>Preference cookies: Remember your website preferences</li>
                <li>Analytics cookies: Help us understand how visitors use our site</li>
            </ul>
        </div>

        <div class="cookie-section">
            <h2>Types of Cookies We Use</h2>
            <ul>
                <li><strong>Session Cookies:</strong> Temporary cookies that expire when you close your browser</li>
                <li><strong>Persistent Cookies:</strong> Remain on your device until they expire or you delete them</li>
                <li><strong>First-party Cookies:</strong> Set by our website</li>
                <li><strong>Third-party Cookies:</strong> Set by our partners and service providers</li>
            </ul>
        </div>

        <div class="cookie-section">
            <h2>Managing Cookies</h2>
            <p>You can control and manage cookies in various ways:</p>
            <ul>
                <li>Browser settings: Configure your browser to accept, reject, or notify you about cookies</li>
                <li>Delete cookies: Clear your browser's cookie storage</li>
                <li>Opt-out: Use browser privacy modes or third-party tools</li>
            </ul>
            <p>Please note that disabling cookies may affect the functionality of our website.</p>
        </div>

        <div class="cookie-section">
            <h2>Updates to This Policy</h2>
            <p>We may update this cookie policy from time to time. Any changes will be posted on this page with an updated revision date.</p>
        </div>

        <div class="cookie-section">
            <h2>Contact Us</h2>
            <p>If you have any questions about our cookie policy, please contact us at privacy@foodfusion.com</p>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>