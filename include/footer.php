<footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row justify-content-between align-items-start">
            <div class="col-md-5">
                <h4 class="text-success mb-4">About FoodFusion</h4>
                <p class="lead">Discover the joy of cooking with our community of food enthusiasts. Share recipes, learn techniques, and explore culinary creativity.</p>
            </div>
            <div class="col-md-5">
                <h4 class="text-success mb-4">Quick Links</h4>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled footer-links">
                            <li class="mb-2"><a href="privacy_policy.php" class="text-light text-decoration-none hover-success">Privacy Policy</a></li>
                            <li class="mb-2"><a href="terms_of_service.php" class="text-light text-decoration-none hover-success">Terms of Service</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled footer-links">
                            <li class="mb-2"><a href="cookie_policy.php" class="text-light text-decoration-none hover-success">Cookie Policy</a></li>
                            <li class="mb-2"><a href="contact_us.php" class="text-light text-decoration-none hover-success">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4 border-success">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2025 FoodFusion. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<style>
.hover-success:hover {
    color: #28a745 !important;
    transition: color 0.3s ease;
}
.footer-links li a {
    position: relative;
    padding-left: 15px;
}
.footer-links li a:before {
    content: '→';
    position: absolute;
    left: 0;
    color: #28a745;
}
</style>

<!-- Cookie Consent -->
<div class="cookie-consent position-fixed bottom-0 start-0 w-100 bg-dark text-light p-3" style="z-index: 1000; display: none;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="mb-0">We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.</p>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <button class="btn btn-success me-2" onclick="acceptCookies()">Accept</button>
                <button class="btn btn-outline-light" onclick="declineCookies()">Decline</button>
            </div>
        </div>
    </div>
</div>

<script>
function showCookieConsent() {
    if (!localStorage.getItem('cookieConsent')) {
        document.querySelector('.cookie-consent').style.display = 'block';
    }
}

function acceptCookies() {
    localStorage.setItem('cookieConsent', 'accepted');
    document.querySelector('.cookie-consent').style.display = 'none';
}

function declineCookies() {
    localStorage.setItem('cookieConsent', 'declined');
    document.querySelector('.cookie-consent').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', showCookieConsent);
</script>