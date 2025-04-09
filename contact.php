<?php
// Include header
include 'header.php';
?>

    <!-- Contact Hero Section -->
    <section class="bg-dark-blue py-5 text-center text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-4">Contact Us</h1>
                    <p class="lead mb-4 text-white">We'd love to hear from you. Get in touch with our team.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php if (isset($form_result) && $form_result): ?>
                    <div class="alert alert-<?php echo $form_result['status'] === 'success' ? 'success' : 'danger'; ?> mb-4">
                        <?php echo $form_result['message']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center mb-4 text-dark-blue">Send Us a Message</h2>
                            
                            <form action="contact.php" method="POST">
                                <input type="hidden" name="contact_submit" value="1">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-dark-blue rounded-pill px-5 py-3">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-md-8">
                    <h2 class="fw-bold text-dark-blue">Get in Touch</h2>
                    <p class="text-muted">We're here to answer any questions you may have</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="contact-icon mb-3">
                                <i class="bi bi-envelope-fill fs-2 text-dark-blue"></i>
                            </div>
                            <h3 class="fs-4 fw-bold text-dark-blue">Email Us</h3>
                            <p class="text-muted mb-2">For general inquiries:</p>
                            <p class="mb-0"><a href="mailto:info@dotnet.com" class="text-dark-blue">info@dotnet.com</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="contact-icon mb-3">
                                <i class="bi bi-telephone-fill fs-2 text-dark-blue"></i>
                            </div>
                            <h3 class="fs-4 fw-bold text-dark-blue">Call Us</h3>
                            <p class="text-muted mb-2">Monday to Friday, 9am-5pm:</p>
                            <p class="mb-0"><a href="tel:+11234567890" class="text-dark-blue">(123) 456-7890</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="contact-icon mb-3">
                                <i class="bi bi-geo-alt-fill fs-2 text-dark-blue"></i>
                            </div>
                            <h3 class="fs-4 fw-bold text-dark-blue">Visit Us</h3>
                            <p class="text-muted mb-2">Our office location:</p>
                            <p class="mb-0">123 Tech Street, Digital City</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
// Include footer
include 'footer.php';
?>
