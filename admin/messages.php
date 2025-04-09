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

// Mark as read
if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $id = (int)$_GET['mark_read'];
    $query = "UPDATE contact_messages SET is_read = 1 WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $message = "Message marked as read.";
        $message_type = "success";
    } else {
        $message = "Error updating message: " . mysqli_error($conn);
        $message_type = "danger";
    }
}

// Delete message
if (isset($_POST['delete_message'])) {
    $id = (int)$_POST['delete_id'];

    $query = "DELETE FROM contact_messages WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $message = "Message deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error deleting message: " . mysqli_error($conn);
        $message_type = "danger";
    }
}

// Get message details
$view_message = null;
if (isset($_GET['view']) && is_numeric($_GET['view'])) {
    $id = (int)$_GET['view'];
    $query = "SELECT * FROM contact_messages WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $view_message = mysqli_fetch_assoc($result);

        // Mark as read if not already
        if (!$view_message['is_read']) {
            $update_query = "UPDATE contact_messages SET is_read = 1 WHERE id = $id";
            mysqli_query($conn, $update_query);
            $view_message['is_read'] = 1;
        }
    }
}

// Get all messages
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$messages = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - <?php echo $site_name; ?></title>

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
                            <a class="sidebar-link active" href="messages.php">
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
                    <h1 class="h2">Messages</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="../contact.php" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i> View Contact Page
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
                    <?php if ($view_message): ?>
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Message Details</h5>
                                <a href="messages.php" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back to All Messages
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">From:</h6>
                                    <p class="fs-5"><?php echo htmlspecialchars($view_message['name']); ?> &lt;<?php echo htmlspecialchars($view_message['email']); ?>&gt;</p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Date:</h6>
                                    <p><?php echo date('F d, Y \a\t h:i A', strtotime($view_message['created_at'])); ?></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Message:</h6>
                                    <div class="p-3 bg-light rounded">
                                        <?php echo nl2br(htmlspecialchars($view_message['message'])); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="mailto:<?php echo htmlspecialchars($view_message['email']); ?>" class="btn btn-dark-blue">
                                        <i class="bi bi-reply me-1"></i> Reply via Email
                                    </a>

                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $view_message['id']; ?>">
                                        <i class="bi bi-trash me-1"></i> Delete Message
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $view_message['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $view_message['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $view_message['id']; ?>">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this message from <?php echo htmlspecialchars($view_message['name']); ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="messages.php" method="POST">
                                                        <input type="hidden" name="delete_message" value="1">
                                                        <input type="hidden" name="delete_id" value="<?php echo $view_message['id']; ?>">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">All Messages</h5>
                            </div>
                            <div class="card-body">
                                <?php if (count($messages) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message Preview</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($messages as $msg): ?>
                                            <tr class="message-row <?php echo $msg['is_read'] ? '' : 'unread'; ?>" onclick="window.location='messages.php?view=<?php echo $msg['id']; ?>'">
                                                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                                <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                                <td><?php echo substr(htmlspecialchars($msg['message']), 0, 50) . '...'; ?></td>
                                                <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                                                <td>
                                                    <?php if ($msg['is_read']): ?>
                                                    <span class="badge bg-success">Read</span>
                                                    <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Unread</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="messages.php?view=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <?php if (!$msg['is_read']): ?>
                                                    <a href="messages.php?mark_read=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-success me-1">
                                                        <i class="bi bi-check-lg"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $msg['id']; ?>" onclick="event.stopPropagation();">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $msg['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $msg['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $msg['id']; ?>">Confirm Delete</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this message from <?php echo htmlspecialchars($msg['name']); ?>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="messages.php" method="POST">
                                                                        <input type="hidden" name="delete_message" value="1">
                                                                        <input type="hidden" name="delete_id" value="<?php echo $msg['id']; ?>">
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
                                <p class="text-center">No messages found.</p>
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
