<header class="bg-custom-secondary shadow sticky-top z-50">
    <nav class="navbar navbar-expand-md container">
        <!-- Brand -->
        <a class="finas-navbar-brand text-custom-primary" href="<?php echo $base_url; ?>/index.php">
            <img src="https://i.postimg.cc/BbmbtzLs/logo.png" alt="logo" class="logo logo-responsive" style="max-height:50px;">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-item-link" href="../index.php">Home</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-item-link dropdown-toggle" href="#" id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['email']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-custom-secondary border-custom-primary" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item text-custom-primary bg-custom-secondary hover-custom-primary"
                                   href="../logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-item-link" href="login_signup/login_signup.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>

