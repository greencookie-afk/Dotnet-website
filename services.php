<?php
// Include header
include 'header.php';
?>

    <!-- Services Hero Section -->
    <section class="bg-dark-blue py-5 text-center text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-4">Our Services</h1>
                    <p class="lead mb-4 text-white">We offer a comprehensive range of solutions to help your business grow in the digital landscape.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-dark-blue">What We Offer</h2>
                        <p class="text-muted">Crafting digital solutions that drive growth and efficiency</p>
                    </div>
                </div>
            </div>
            
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
                        'icon' => 'bi-code-square',
                        'details' => 'Our custom application development service provides tailored solutions that address your specific business challenges. We work closely with you to understand your requirements and deliver applications that streamline your operations and enhance productivity.'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Automation Workflows',
                        'description' => 'Streamline your business processes with intelligent automation.',
                        'icon' => 'bi-gear',
                        'details' => 'Automate repetitive tasks and streamline your business processes with our cutting-edge automation solutions. Our team will identify opportunities for automation in your workflow and implement efficient solutions that save time and reduce errors.'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Database Solutions',
                        'description' => 'Efficient data management systems tailored to your requirements.',
                        'icon' => 'bi-database',
                        'details' => 'Our database solutions provide robust and scalable data management systems that ensure data integrity, security, and accessibility. We design and implement database architectures that optimize performance and support your business growth.'
                    ]
                ];
                
                $services = $default_services;
            }
            
            // Display detailed service sections
            foreach ($services as $service) {
            ?>
            <!-- <?php echo $service['title']; ?> Details -->
            <section class="py-5 <?php echo $service['id'] % 2 == 0 ? 'bg-light' : ''; ?>" id="service-<?php echo $service['id']; ?>">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 <?php echo $service['id'] % 2 == 0 ? 'order-lg-2' : ''; ?> mb-4 mb-lg-0 text-center-mobile">
                            <h2 class="fw-bold mb-4 text-dark-blue"><?php echo $service['title']; ?></h2>
                            <p class="mb-4"><?php echo $service['details']; ?></p>
                            
                            <div class="mb-4">
                                <h5><i class="bi bi-check-circle-fill text-dark-blue me-2"></i> Key Benefits</h5>
                                <ul class="list-unstyled ps-4">
                                    <li class="mb-2"><i class="bi bi-arrow-right text-dark-blue me-2"></i> Increased efficiency and productivity</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right text-dark-blue me-2"></i> Reduced operational costs</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right text-dark-blue me-2"></i> Improved data accuracy and reliability</li>
                                </ul>
                            </div>
                            
                            <a href="contact.php" class="btn btn-dark-blue rounded-pill px-4 py-2 mt-3">Request a Quote</a>
                        </div>
                        <div class="col-lg-6 <?php echo $service['id'] % 2 == 0 ? 'order-lg-1' : ''; ?>">
                            <div class="text-center">
                                <div class="service-icon-large bg-light p-4 rounded-circle d-inline-block mb-3">
                                    <i class="bi <?php echo $service['icon']; ?> fs-1 text-dark-blue"></i>
                                </div>
                                <img src="./assets/service-<?php echo $service['id']; ?>.svg" alt="<?php echo $service['title']; ?>" class="img-fluid rounded shadow-sm" onerror="this.src='./assets/svg-image.svg'">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            }
            ?>
        </div>
    </section>

<?php
// Include footer
include 'footer.php';
?>
