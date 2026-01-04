<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-info-circle me-3"></i>About <?php echo SITE_NAME; ?>
            </h1>
            <p class="lead text-muted">Crafting exceptional coffee experiences since day one</p>
        </div>
    </div>
    
    <!-- Our Story -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-book me-2"></i>Our Story</h4>
                </div>
                <div class="card-body">
                    <p class="lead">
                        Welcome to <?php echo SITE_NAME; ?>, your favorite destination for premium coffee and delicious treats.
                    </p>
                    <p>
                        Founded with a passion for quality and customer satisfaction, we've been serving our community with 
                        exceptional beverages and food since day one. What started as a small dream has grown into a beloved 
                        local institution where coffee lovers gather to enjoy their favorite drinks and treats.
                    </p>
                    <p>
                        Every cup we serve is crafted with care, using only the finest ingredients and the most skilled baristas. 
                        We believe that great coffee is more than just a beverage—it's an experience, a moment of connection, 
                        and a small luxury in your daily routine.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Mission -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-target me-2"></i>Our Mission</h4>
                </div>
                <div class="card-body">
                    <p class="lead">
                        To provide the finest coffee experience in a warm, welcoming environment.
                    </p>
                    <p>
                        We believe in using only the highest quality ingredients and treating every customer like family. 
                        Our mission is to create a space where people can relax, connect, and enjoy exceptional coffee and food. 
                        We're committed to sustainability, fair trade practices, and supporting our local community.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Values -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-heart me-2"></i>Our Values</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="value-item">
                                <h5 class="text-primary mb-2">
                                    <i class="fas fa-star me-2"></i>Quality
                                </h5>
                                <p class="text-muted">We never compromise on the quality of our products. Every bean is carefully selected and roasted to perfection.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="value-item">
                                <h5 class="text-primary mb-2">
                                    <i class="fas fa-handshake me-2"></i>Service
                                </h5>
                                <p class="text-muted">Exceptional customer service is our priority. We treat every customer with respect and care.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="value-item">
                                <h5 class="text-primary mb-2">
                                    <i class="fas fa-users me-2"></i>Community
                                </h5>
                                <p class="text-muted">We're committed to being part of your daily routine and supporting our local community.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="value-item">
                                <h5 class="text-primary mb-2">
                                    <i class="fas fa-leaf me-2"></i>Sustainability
                                </h5>
                                <p class="text-muted">We care about the environment and our suppliers, practicing sustainable and ethical business.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .value-item {
        padding: 1.5rem;
        background: #f9f9f9;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .value-item:hover {
        background: #f0f0f0;
        transform: translateY(-3px);
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
