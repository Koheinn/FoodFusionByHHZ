<?php
session_start();
require_once 'include/dbconfig.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contactmessages (UserID, Name, Email, Subject, Message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $name, $email, $subject, $message]);
            $success = 'Your message has been sent successfully! We will get back to you soon.';
            
            // Clear form data after successful submission
            $name = $email = $subject = $message = '';
        } catch (PDOException $e) {
            $error = 'An error occurred while sending your message. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FoodFusion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .contact-page-body {
            background: url('media/background_contactus.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        .contact-page-section {
            padding: 60px 0;
            position: relative;
            min-height: auto;
            display: flex;
            align-items: center
        }
        .contact-page-section::before {
            display: none;
        }
        .contact-page-container {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px;
            background: rgba(0, 100, 80, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2)
        }
        .contact-page-info {
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            height: auto;
        }
        .contact-page-info i {
            color: #ffffff;
            font-size: 24px;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }
        .contact-page-info p {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .contact-page-info h3 {
            color: #ffffff;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 24px;
        }
        .contact-page-form {
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            height: auto;
            margin-bottom: 0;
        }
        .contact-page-label {
            color: #ffffff;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .contact-page-input {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 15px 20px;
            font-size: 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            height: auto;
            width: 100%
        }
        .contact-page-input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: #ffffff;
        }
        .contact-page-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        textarea.contact-page-input {
            min-height: 120px;
            resize: vertical;
        }
        .contact-page-btn {
            background: #ffffff;
            color: #006450;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .contact-page-btn:hover {
            background: #006450;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .contact-page-map {
            position: relative;
            height: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            min-height: 500px;
        }
        .contact-page-title {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 40px;
            font-size: 36px;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .contact-page-alert {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #ffffff;
            backdrop-filter: blur(10px);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }
    </style>
</head>
<body class="contact-page-body">

<?php include 'include/header.php'; ?>

<div class="container-fluid contact-page-section">
    <div class="container contact-page-container">
        <h1 class="contact-page-title"><i class="fas fa-paper-plane"></i> Contact Us Here</h1>
        
        <?php if ($error): ?>
            <div class="contact-page-alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="contact-page-alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="row g-4 align-items-stretch">
            <div class="col-md-6">
                <div class="contact-page-info">
                    <h3>Get in Touch</h3>
                    <p><i class="fas fa-map-marker-alt"></i> FoodFusion Office, Yangon, Myanmar</p>
                    <p><i class="fas fa-phone"></i> +95 123 456 789</p>
                    <p><i class="fas fa-envelope"></i> info@foodfusion.com</p>
                </div>

                <div class="contact-page-form">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="contact-page-label">Name *</label>
                            <input type="text" class="contact-page-input" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required placeholder="Enter your full name">
                            <div class="invalid-feedback" style="color: #fff; font-size: 12px; margin-top: -15px; margin-bottom: 10px;">
                                Please enter your name
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="contact-page-label">Email *</label>
                            <input type="email" class="contact-page-input" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required placeholder="Enter your email address">
                            <div class="invalid-feedback" style="color: #fff; font-size: 12px; margin-top: -15px; margin-bottom: 10px;">
                                Please enter a valid email address
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="contact-page-label">Subject</label>
                            <input type="text" class="contact-page-input" id="subject" name="subject" value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>" placeholder="What is your message about?">
                        </div>

                        <div class="mb-3">
                            <label for="message" class="contact-page-label">Message *</label>
                            <textarea class="contact-page-input" id="message" name="message" rows="5" required placeholder="Type your message here..."><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                            <div class="invalid-feedback" style="color: #fff; font-size: 12px; margin-top: -15px; margin-bottom: 10px;">
                                Please enter your message
                            </div>
                        </div>

                        <button type="submit" class="contact-page-btn">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="contact-page-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1666.2145057423468!2d96.1557503393502!3d16.820153600874924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c193e941f2e067%3A0x5e54c9aa66f073eb!2sKBTC%20University-%20School%20of%20IT!5e0!3m2!1smy!2smm!4v1743425861026!5m2!1smy!2smm" width="100%" height="100%" style="border:0; min-height: 450px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Form validation
document.querySelector('.needs-validation').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    this.classList.add('was-validated');
});
</script>
</body>
</html>