<?php
// Include functions
require_once 'functions.php';

// Process contact form if submitted
$form_result = null;
if (basename($_SERVER['PHP_SELF']) === 'contact.php') {
    $form_result = processContactForm();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getPageTitle(); ?> - <?php echo $site_name; ?></title>

    <!-- external stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --dark-blue: #0d2e4d;
            --light-blue: #1e5b94;
        }
        
        .bg-dark-blue {
            background-color: var(--dark-blue);
        }

        .text-dark-blue {
            color: var(--dark-blue);
        }

        .bg-light-blue {
            background-color: var(--light-blue);
        }

        .text-light-blue {
            color: var(--light-blue);
        }

        .btn-dark-blue {
            background-color: var(--dark-blue);
            color: white;
        }

        .btn-dark-blue:hover {
            background-color: var(--light-blue);
            color: white;
        }
        
        .btn-outline-dark-blue {
            color: var(--dark-blue);
            border-color: var(--dark-blue);
        }

        .btn-outline-dark-blue:hover {
            background-color: var(--dark-blue);
            color: white;
        }
        
        .navbar-toggler {
            border: none;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 768px) {
            .text-center-mobile {
                text-align: center !important;
            }
            h1, h2, h3, h4, h5, p {
                text-align: center;
            }
            .btn {
                display: block;
                margin: 1rem auto;
            }
            ul {
                padding-left: 0;
                list-style-position: inside;
            }
            .navbar {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            .dropdown-menu {
                border: none;
                background-color: transparent;
                padding-left: 1.5rem;
            }
            .dropdown-item {
                color: rgba(255, 255, 255, 0.7);
            }
            .dropdown-item:hover, .dropdown-item:focus {
                color: #fff;
                background-color: transparent;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark-blue py-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="logo-container d-flex align-items-center">
                    <div class="logo-icon me-2">
                        <i class="bi bi-code-slash text-white"></i>
                    </div>
                    <span class="fw-bold fs-4 text-white"><?php echo $site_name; ?></span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo isCurrentPage('index.php') ? 'active' : ''; ?> text-white" href="index.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isCurrentPage('services.php') ? 'active' : ''; ?> text-white" href="services.php">Services</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-light rounded-pill px-3 py-2 text-dark-blue" href="contact.php">Contact Us</a>
                    </li>
                    <?php if (isLoggedIn()): ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light rounded-pill px-3 py-2" href="admin/dashboard.php">Admin</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
