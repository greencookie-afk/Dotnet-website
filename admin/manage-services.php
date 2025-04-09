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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add or update service
    if (isset($_POST['service_submit'])) {
        $title = sanitize($_POST['title']);
        $description = sanitize($_POST['description']);
        $icon = sanitize($_POST['icon']);
        $details = sanitize($_POST['details']);
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($id > 0) {
            // Update existing service
            $query = "UPDATE services SET
                      title = '$title',
                      description = '$description',
                      icon = '$icon',
                      details = '$details',
                      updated_at = NOW()
                      WHERE id = $id";

            if (mysqli_query($conn, $query)) {
                $message = "Service updated successfully!";
                $message_type = "success";
            } else {
                $message = "Error updating service: " . mysqli_error($conn);
                $message_type = "danger";
            }
        } else {
            // Add new service
            $query = "INSERT INTO services (title, description, icon, details)
                      VALUES ('$title', '$description', '$icon', '$details')";

            if (mysqli_query($conn, $query)) {
                $message = "Service added successfully!";
                $message_type = "success";
            } else {
                $message = "Error adding service: " . mysqli_error($conn);
                $message_type = "danger";
            }
        }
    }

    // Delete service
    if (isset($_POST['delete_service'])) {
        $id = (int)$_POST['delete_id'];

        $query = "DELETE FROM services WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            $message = "Service deleted successfully!";
            $message_type = "success";
        } else {
            $message = "Error deleting service: " . mysqli_error($conn);
            $message_type = "danger";
        }
    }
}

// Get service for editing
$edit_service = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $query = "SELECT * FROM services WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $edit_service = mysqli_fetch_assoc($result);
    }
}

// Get all services
$query = "SELECT * FROM services ORDER BY id ASC";
$result = mysqli_query($conn, $query);
$services = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - <?php echo $site_name; ?></title>

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
                            <a class="sidebar-link active" href="manage-services.php">
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
                    <h1 class="h2">Manage Services</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="../services.php" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i> View Services Page
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
                    <div class="col-md-5 mb-4">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><?php echo $edit_service ? 'Edit Service' : 'Add New Service'; ?></h5>
                            </div>
                            <div class="card-body">
                                <form action="manage-services.php" method="POST">
                                    <input type="hidden" name="service_submit" value="1">
                                    <?php if ($edit_service): ?>
                                    <input type="hidden" name="id" value="<?php echo $edit_service['id']; ?>">
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $edit_service ? htmlspecialchars($edit_service['title']) : ''; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Short Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="2" required><?php echo $edit_service ? htmlspecialchars($edit_service['description']) : ''; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icon Class</label>
                                        <div class="input-group">
                                            <span class="input-group-text">bi-</span>
                                            <input type="text" class="form-control" id="icon" name="icon" value="<?php echo $edit_service ? str_replace('bi-', '', htmlspecialchars($edit_service['icon'])) : ''; ?>" required>
                                        </div>
                                        <div class="form-text">Enter Bootstrap icon name (without 'bi-' prefix)</div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="details" class="form-label">Detailed Description</label>
                                        <textarea class="form-control" id="details" name="details" rows="5" required><?php echo $edit_service ? htmlspecialchars($edit_service['details']) : ''; ?></textarea>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark-blue"><?php echo $edit_service ? 'Update Service' : 'Add Service'; ?></button>
                                    </div>

                                    <?php if ($edit_service): ?>
                                    <div class="mt-3 text-center">
                                        <a href="manage-services.php" class="text-decoration-none">Cancel and add new</a>
                                    </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">All Services</h5>
                            </div>
                            <div class="card-body">
                                <?php if (count($services) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Icon</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($services as $service): ?>
                                            <tr>
                                                <td><?php echo $service['id']; ?></td>
                                                <td><?php echo htmlspecialchars($service['title']); ?></td>
                                                <td><i class="bi <?php echo htmlspecialchars($service['icon']); ?>"></i></td>
                                                <td>
                                                    <a href="manage-services.php?edit=<?php echo $service['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $service['id']; ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $service['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $service['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $service['id']; ?>">Confirm Delete</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the service "<?php echo htmlspecialchars($service['title']); ?>"?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="manage-services.php" method="POST">
                                                                        <input type="hidden" name="delete_service" value="1">
                                                                        <input type="hidden" name="delete_id" value="<?php echo $service['id']; ?>">
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <p class="text-center">No services found. Add your first service using the form.</p>
                                <?php endif; ?>
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
