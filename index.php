<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start(); // Start the session at the very beginning of the page
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI FINas - Data-Driven Insights</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link to the external stylesheet -->
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-custom-primary text-custom-primary d-flex flex-column min-vh-100">

    <!-- Header -->
    <header class="bg-custom-secondary shadow sticky-top z-50">
       <nav class="navbar navbar-expand-md container">
        <a class="finas-navbar-brand text-custom-primary" href="../index.php">
           <a class="finas-navbar-brand text-custom-primary" href="<?php echo $base_url; ?>/index.php">
    <img src="images/logo.png" alt="logo" class="logo logo-responsive" style="max-height:50px;">
</a>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-item-link" href="index.php">Home</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-item-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <?php echo htmlspecialchars($_SESSION['email']); ?>
                        </a>
                        <ul class="dropdown-menu bg-custom-secondary border-custom-primary">
                            
                            <li><a class="dropdown-item text-custom-primary bg-custom-secondary hover-custom-primary" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-item-link" href="login_signup/login_signup.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    </header>

    <!-- Hero Section -->
    <main class="container text-center py-5 flex-grow-1">
        <h1 class="display-4 fw-bold text-custom-primary">Simulate. Analyze. Succeed.</h1>
        <p class="lead text-custom-secondary mx-auto mb-5" style="max-width: 600px;">
            Explore financial possibilities with a powerful, AI-driven sandbox that gives you the data you need to make the right moves.
        </p>

        <!-- The call-to-action is a prominent box -->
        <div class="position-relative mx-auto mb-5" style="max-width: 700px;">
            <div class="bg-custom-secondary p-4 rounded-3 shadow-lg card-border-primary">
                <h2 class="h4 fw-bold text-custom-primary">Start Your Data-Powered Simulation</h2>
                <p class="text-custom-secondary mb-4">
                    Gain predictive insights and visualize your financial future. Click below to enter the sandbox.
                </p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="simulation/sim1_view.php" class="btn btn-custom-primary rounded-pill py-2 px-5">
                        Open the AI FINas Sandbox
                    </a>
                <?php else: ?>
                    <a href="login_signup/login_signup.php" class="btn btn-custom-primary rounded-pill py-2 px-5">
                        Open the AI FINas Sandbox
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Key Metrics Section -->
    <section class="bg-custom-secondary py-5">
        <div class="container text-center">
            <h2 class="h3 fw-bold text-custom-primary mb-4">What is Finas AI?</h2>
            
            <div class="row g-4">
                <!-- fact 1 -->
               
                <div class="col-md-4">
                    <div class="p-3 hover-lift">
                        <h3 class="h5 fw-bold text-custom-primary mb-2">AI financial sandbox</h3>
                        <p class="text-custom-secondary">lorem ipsum blah blah blah lorem ipsum blah blah blah</p>
                    </div>
                </div>
                <!-- Metric 2 -->
                <div class="col-md-4">
                    <div class="p-3 hover-lift">
                        
                        <h3 class="h5 fw-bold text-custom-primary mb-2">made for Filipinos</h3>
                        <p class="text-custom-secondary">lorem ipsum blah blah blah lorem ipsum blah blah blah</p>
                    </div>
                </div>
                <!-- Metric 3 -->
                <div class="col-md-4">
                    <div class="p-3 hover-lift">
                      
                        <h3 class="h5 fw-bold text-custom-primary mb-2"></h3>
                        <p class="text-custom-secondary">lorem ipsum blah blah blah lorem ipsum blah blah blah</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-custom-footer text-center py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 MySite. All rights reserved.</p>
            <div class="d-flex justify-content-center mt-2">
                <a href="#" class="text-custom-secondary text-decoration-none mx-2">Privacy Policy</a>
                <a href="#" class="text-custom-secondary text-decoration-none mx-2">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-custom-secondary text-custom-primary">
                <div class="modal-header border-custom-primary">
                    <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                    <button type="button" class="btn-close btn-close-custom-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notificationModalBody">
                    <!-- Notification message will be injected here -->
                </div>
                <div class="modal-footer border-custom-primary">
                    <button type="button" class="btn btn-custom-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
    <?php
    if (isset($_SESSION['notification'])) {
        $notification_message = htmlspecialchars($_SESSION['notification'], ENT_QUOTES);
        unset($_SESSION['notification']);
        echo "
            document.addEventListener('DOMContentLoaded', function() {
                const modalElement = document.getElementById('notificationModal');
                const modalBody = document.getElementById('notificationModalBody');
                modalBody.textContent = '{$notification_message}';
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        ";
    }
    ?>
    </script>
</body>
</html>
