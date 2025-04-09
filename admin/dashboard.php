<?php
// Include configuration
require_once '../config.php';

// Check if logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Get stats
$query_messages = "SELECT COUNT(*) as total FROM contact_messages";
$result_messages = mysqli_query($conn, $query_messages);
$total_messages = 0;
if ($result_messages) {
    $row = mysqli_fetch_assoc($result_messages);
    $total_messages = $row['total'];
}

$query_services = "SELECT COUNT(*) as total FROM services";
$result_services = mysqli_query($conn, $query_services);
$total_services = 0;
if ($result_services) {
    $row = mysqli_fetch_assoc($result_services);
    $total_services = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo $site_name; ?></title>

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
                            <a class="sidebar-link active" href="dashboard.php">
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
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="../index.php" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i> View Website
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Total Messages</h6>
                                        <h2 class="fw-bold"><?php echo $total_messages; ?></h2>
                                    </div>
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-envelope fs-3 text-dark-blue"></i>
                                    </div>
                                </div>
                                <a href="messages.php" class="btn btn-sm btn-dark-blue mt-3">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Total Services</h6>
                                        <h2 class="fw-bold"><?php echo $total_services; ?></h2>
                                    </div>
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-gear fs-3 text-dark-blue"></i>
                                    </div>
                                </div>
                                <a href="manage-services.php" class="btn btn-sm btn-dark-blue mt-3">Manage</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Quick Actions</h6>
                                        <h2 class="fw-bold">Settings</h2>
                                    </div>
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-sliders fs-3 text-dark-blue"></i>
                                    </div>
                                </div>
                                <a href="site-settings.php" class="btn btn-sm btn-dark-blue mt-3">Configure</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card stat-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Account</h6>
                                        <h2 class="fw-bold">Profile</h2>
                                    </div>
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-person fs-3 text-dark-blue"></i>
                                    </div>
                                </div>
                                <a href="profile.php" class="btn btn-sm btn-dark-blue mt-3">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Recent Messages</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    echo '<div class="table-responsive">';
                                    echo '<table class="table table-hover">';
                                    echo '<thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th>Status</th></tr></thead>';
                                    echo '<tbody>';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                        echo '<td>' . substr(htmlspecialchars($row['message']), 0, 50) . '...</td>';
                                        echo '<td>' . date('M d, Y', strtotime($row['created_at'])) . '</td>';
                                        echo '<td>' . ($row['is_read'] ? '<span class="badge bg-success">Read</span>' : '<span class="badge bg-warning text-dark">Unread</span>') . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';
                                } else {
                                    echo '<p class="text-center">No messages yet.</p>';
                                }
                                ?>

                                <div class="text-end mt-3">
                                    <a href="messages.php" class="btn btn-sm btn-dark-blue">View All Messages</a>
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
