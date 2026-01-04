<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-envelope me-3"></i>Contact Us
            </h1>
            <p class="lead text-muted">We'd love to hear from you. Get in touch with us today!</p>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <!-- Contact Info Cards -->
        <div class="col-md-6 col-lg-3">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h5>Address</h5>
                <p>123 Coffee Street<br>Downtown, City 12345<br>Country</p>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h5>Phone</h5>
                <p><a href="tel:+15551234567" class="text-decoration-none">(555) 123-4567</a></p>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h5>Email</h5>
                <p><a href="mailto:info@coffeeshop.com" class="text-decoration-none">info@coffeeshop.com</a></p>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h5>Hours</h5>
                <p>
                    <small>Mon-Fri: 7:00 AM - 8:00 PM<br>
                    Sat: 8:00 AM - 9:00 PM<br>
                    Sun: 8:00 AM - 7:00 PM</small>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-map me-2"></i>Our Location</h5>
                </div>
                <div class="card-body p-0">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.1234567890!2d-74.0060!3d40.7128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQyJzQ2LjAiTiA3NMKwMDAnMjEuNiJX!5e0!3m2!1sen!2sus!4v1234567890" 
                            width="100%" height="400" style="border:0; border-radius: 0 0 12px 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Info -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Get in Touch</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        Have questions or feedback? We're here to help! Feel free to reach out to us through any of the contact methods above. 
                        We typically respond to emails within 24 hours.
                    </p>
                    <p class="mb-0">
                        For urgent matters, please call us directly during business hours. We look forward to hearing from you!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .contact-icon {
        font-size: 2.5rem;
        color: #8B4513;
        margin-bottom: 1rem;
    }
    
    .contact-card h5 {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }
    
    .contact-card p {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .contact-card a {
        color: #8B4513;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .contact-card a:hover {
        color: #D2691E;
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
