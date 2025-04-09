<?php
// Include configuration
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - <?php echo $site_name; ?></title>
    
    <!-- External stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .error-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: var(--dark-blue);
            opacity: 0.2;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="error-container">
        <div class="container text-center">
            <div class="error-code">404</div>
            <h1 class="mb-4 text-dark-blue">Page Not Found</h1>
            <p class="mb-5">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            <a href="index.php" class="btn btn-dark-blue rounded-pill px-4 py-2">
                <i class="bi bi-house-door me-2"></i> Back to Home
            </a>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
