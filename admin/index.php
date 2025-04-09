<?php
// Include configuration
require_once '../config.php';

// Check if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

// Process login form
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    // Validate credentials
    $query = "SELECT * FROM admin_users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password (in a real app, use password_verify)
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];

            // Update last login
            $update_query = "UPDATE admin_users SET last_login = NOW() WHERE id = " . $user['id'];
            mysqli_query($conn, $update_query);

            // Redirect to dashboard
            redirect('dashboard.php');
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo $site_name; ?></title>

    <!-- External stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center mb-4">
            <a href="../index.php" class="text-decoration-none">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="me-2">
                        <i class="bi bi-code-slash fs-3 text-dark-blue"></i>
                    </div>
                    <span class="fw-bold fs-3 text-dark-blue"><?php echo $site_name; ?></span>
                </div>
            </a>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 text-dark-blue">Admin Login</h2>

                <?php if ($error): ?>
                <div class="alert alert-danger mb-4">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <form action="index.php" method="POST">
                    <input type="hidden" name="login_submit" value="1">

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark-blue py-2">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="../index.php" class="text-dark-blue">← Back to Website</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
