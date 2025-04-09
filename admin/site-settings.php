<?php
// Include configuration
require_once '../config.php';

// Check if logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Process form submission
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['settings_submit'])) {
    $site_name = sanitize($_POST['site_name']);
    $site_description = sanitize($_POST['site_description']);
    $contact_email = sanitize($_POST['contact_email']);
    $contact_phone = sanitize($_POST['contact_phone']);
    $contact_address = sanitize($_POST['contact_address']);

    // Update settings
    $settings = [
        'site_name' => $site_name,
        'site_description' => $site_description,
        'contact_email' => $contact_email,
        'contact_phone' => $contact_phone,
        'contact_address' => $contact_address
    ];

    $success = true;

    foreach ($settings as $name => $value) {
        $query = "UPDATE site_settings SET setting_value = '$value' WHERE setting_name = '$name'";
        if (!mysqli_query($conn, $query)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        $message = "Settings updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error updating settings: " . mysqli_error($conn);
        $message_type = "danger";
    }
}

// Get current settings
$query = "SELECT * FROM site_settings";
$result = mysqli_query($conn, $query);
$settings = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['setting_name']] = $row['setting_value'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - <?php echo $site_name; ?></title>

    <!-- External stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <a href="../index.php" class="text-decoration-none">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="me-2">
                                    <i class="bi bi-code-slash fs-4 text-dark-blue"></i>
                                </div>
                                <span class="fw-bold fs-4 text-dark-blue"><?php echo $site_name; ?></span>
                            </div>
                        </a>
                    </div>

                    <div class="sidebar-heading">
                        Main
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="sidebar-link" href="dashboard.php">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sidebar-link" href="manage-services.php">
                                <i class="bi bi-gear me-2"></i>
                                Manage Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sidebar-link" href="messages.php">
                                <i class="bi bi-envelope me-2"></i>
                                Messages
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-heading mt-4">
                        Settings
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="sidebar-link active" href="site-settings.php">
                                <i class="bi bi-sliders me-2"></i>
                                Site Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sidebar-link" href="profile.php">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sidebar-link" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Site Settings</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="../index.php" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i> View Website
                            </a>
                        </div>
                    </div>
                </div>

                <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">General Settings</h5>
                            </div>
                            <div class="card-body">
                                <form action="site-settings.php" method="POST">
                                    <input type="hidden" name="settings_submit" value="1">

                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Site Name</label>
                                        <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo isset($settings['site_name']) ? htmlspecialchars($settings['site_name']) : ''; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="site_description" class="form-label">Site Description</label>
                                        <textarea class="form-control" id="site_description" name="site_description" rows="2" required><?php echo isset($settings['site_description']) ? htmlspecialchars($settings['site_description']) : ''; ?></textarea>
                                    </div>

                                    <hr class="my-4">

                                    <h5 class="mb-3">Contact Information</h5>

                                    <div class="mb-3">
                                        <label for="contact_email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo isset($settings['contact_email']) ? htmlspecialchars($settings['contact_email']) : ''; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="contact_phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo isset($settings['contact_phone']) ? htmlspecialchars($settings['contact_phone']) : ''; ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="contact_address" class="form-label">Address</label>
                                        <textarea class="form-control" id="contact_address" name="contact_address" rows="2" required><?php echo isset($settings['contact_address']) ? htmlspecialchars($settings['contact_address']) : ''; ?></textarea>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark-blue">Save Settings</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
