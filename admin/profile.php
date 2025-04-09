<?php
// Include configuration
require_once '../config.php';

// Check if logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Get admin user data
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin_users WHERE id = $admin_id";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Process form submission
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update profile
    if (isset($_POST['profile_submit'])) {
        $username = sanitize($_POST['username']);
        $email = sanitize($_POST['email']);

        // Check if username already exists
        $check_query = "SELECT id FROM admin_users WHERE username = '$username' AND id != $admin_id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $message = "Username already exists. Please choose another one.";
            $message_type = "danger";
        } else {
            $query = "UPDATE admin_users SET username = '$username', email = '$email' WHERE id = $admin_id";

            if (mysqli_query($conn, $query)) {
                $_SESSION['admin_username'] = $username;
                $message = "Profile updated successfully!";
                $message_type = "success";

                // Refresh admin data
                $result = mysqli_query($conn, "SELECT * FROM admin_users WHERE id = $admin_id");
                $admin = mysqli_fetch_assoc($result);
            } else {
                $message = "Error updating profile: " . mysqli_error($conn);
                $message_type = "danger";
            }
        }
    }

    // Change password
    if (isset($_POST['password_submit'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Verify current password
        if (password_verify($current_password, $admin['password'])) {
            // Check if new passwords match
            if ($new_password === $confirm_password) {
                // Hash new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $query = "UPDATE admin_users SET password = '$hashed_password' WHERE id = $admin_id";

                if (mysqli_query($conn, $query)) {
                    $message = "Password changed successfully!";
                    $message_type = "success";
                } else {
                    $message = "Error changing password: " . mysqli_error($conn);
                    $message_type = "danger";
                }
            } else {
                $message = "New passwords do not match.";
                $message_type = "danger";
            }
        } else {
            $message = "Current password is incorrect.";
            $message_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo $site_name; ?></title>

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
                            <a class="sidebar-link" href="site-settings.php">
                                <i class="bi bi-sliders me-2"></i>
                                Site Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sidebar-link active" href="profile.php">
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
                    <h1 class="h2">Profile</h1>
                </div>

                <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Edit Profile</h5>
                            </div>
                            <div class="card-body">
                                <form action="profile.php" method="POST">
                                    <input type="hidden" name="profile_submit" value="1">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark-blue">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Change Password</h5>
                            </div>
                            <div class="card-body">
                                <form action="profile.php" method="POST">
                                    <input type="hidden" name="password_submit" value="1">

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark-blue">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Account Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Last Login</h6>
                                    <p><?php echo $admin['last_login'] ? date('F d, Y \a\t h:i A', strtotime($admin['last_login'])) : 'Never'; ?></p>
                                </div>

                                <div class="mb-0">
                                    <h6 class="text-muted mb-1">Account Created</h6>
                                    <p class="mb-0"><?php echo date('F d, Y', strtotime($admin['created_at'])); ?></p>
                                </div>
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
