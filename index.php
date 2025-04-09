<?php
// Include header
include 'header.php';
?>

    <section class="bg-main hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 order-2 order-lg-1 mb-5 mb-lg-0 text-center-mobile">
                    <h1 class="text-capitalize mb-3">Go From Concept To Reality</h1>
                    <p class="mb-4">Bring your digital products to life quickly with no-code and
                        low-code solutions</p>
                    <a href="#" class="btn btn-dark-blue rounded-pill px-4 py-2">Get Inspired</a>
                </div>
                <div class="col-12 col-lg-6 order-1 order-lg-2">
                    <div class="text-center">
                        <img src="./assets/hero-section.svg" alt="hero image" class="img-fluid" width="70%">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- service section -->
    <section class="services-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark-blue">Our Services</h2>
                <p class="text-muted">We offer a range of digital solutions to help your business grow</p>
            </div>
            <div class="row g-4">
                <?php
                // Get services from database
                $services = getServices();
                
                // If no services in database yet, show default services
                if (empty($services)) {
                    $default_services = [
                        [
                            'id' => 1,
                            'title' => 'Custom Applications',
                            'description' => 'Tailor-made solutions designed specifically for your business needs.',
                            'icon' => 'bi-code-square'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Automation Workflows',
                            'description' => 'Streamline your business processes with intelligent automation.',
                            'icon' => 'bi-gear'
                        ],
                        [
                            'id' => 3,
                            'title' => 'Database Solutions',
                            'description' => 'Efficient data management systems tailored to your requirements.',
                            'icon' => 'bi-database'
                        ]
                    ];
                    
                    $services = $default_services;
                }
                
                // Display services
                foreach ($services as $service) {
                ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi <?php echo $service['icon']; ?> fs-2 text-dark-blue"></i>
                            </div>
                            <h3 class="fs-4 fw-bold text-dark-blue"><?php echo $service['title']; ?></h3>
                            <p class="text-muted"><?php echo $service['description']; ?></p>
                            <a href="services.php#service-<?php echo $service['id']; ?>" class="btn btn-outline-dark-blue rounded-pill mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-img-container text-center text-lg-start">
                        <img src="./assets/svg-image.svg" alt="About Us" class="img-fluid rounded" width="80%">
                    </div>
                </div>
                <div class="col-lg-6 text-center-mobile">
                    <h2 class="fw-bold mb-4 text-dark-blue">About <?php echo $site_name; ?></h2>
                    <p class="mb-4 text-muted">We are a team of dedicated professionals who specialize in creating digital solutions that help businesses thrive in the modern world. With our no-code and low-code approaches, we make technology accessible to everyone.</p>
                    <p class="text-muted">Our mission is to simplify the digital transformation journey for businesses of all sizes, enabling them to innovate faster and grow smarter.</p>
                    <a href="services.php" class="btn btn-dark-blue rounded-pill px-4 py-2 mt-4">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section py-5 bg-dark-blue text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
                    <p class="mb-5 text-white">Contact us today to discuss how we can help bring your digital vision to life.</p>
                    <a href="contact.php" class="btn btn-light btn-lg rounded-pill px-5 py-3 text-dark-blue">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

<?php
// Include footer
include 'footer.php';
?>
