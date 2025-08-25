<!DOCTYPE html>
<html lang="en">
<head>
  <?php session_start(); ?>
  <meta charset="UTF-8">
  <title>Login & Signup</title>
  <link rel="stylesheet" href="style_login_signup.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ===== Internal CSS for Special Alert Box ===== */
    .bg-custom-secondary {
      background-color: #F7F7F7;
    }
    .bg-custom-primary {
      background-image: linear-gradient(135deg, #F7F7F7 0%, #E9E9E9 100%);
    }
    .text-custom-primary {
      color: #C81D11;
    }
    .text-custom-secondary {
      color: #7A7A7A;
    }
    .btn-custom-primary {
      background-color: #C81D11;
      color: #F7F7F7;
      font-weight: 700;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
      background-color: #700f09;
      color: #F7F7F7;
      opacity: 0.9;
      transform: scale(1.05);
    }
    .card-border-primary {
      border: 2px solid #C81D11;
    }
    .border-custom-primary {
      border-color: #C81D11 !important;
    }
    .btn-close-custom-primary {
      filter: invert(0) grayscale(100%) brightness(50%);
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="title-text">
      <div class="title login">Login Form</div>
      <div class="title signup">Sign up Form</div>
    </div>
    <div class="form-container">
      <div class="slide-controls">
        <input type="radio" name="slide" id="login" checked>
        <input type="radio" name="slide" id="signup">
        <label for="login" class="slide login">Login</label>
        <label for="signup" class="slide signup">Sign up</label>
        <div class="slider-tab"></div>
      </div>
      <div class="form-inner">

        <!-- Login form -->
        <form action="login.php" method="POST" class="login" novalidate>
          <div class="field">
            <input type="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="field">
            <input type="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="pass-link"><a href="#">Forgot password?</a></div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Login">
          </div>
          <div class="signup-link">Not a member? <a href="#">Signup now</a></div>
        </form>

        <!-- Signup form -->
        <form action="signup.php" method="POST" class="signup" novalidate>
  <div class="field">
    <input type="text" name="email" placeholder="Email Address" id="signupEmail" required>
  </div>
  <div class="field">
    <input type="password" name="password" placeholder="Password" id="signupPassword" required>
  </div>
  <div class="field">
    <input type="password" name="confirm_password" placeholder="Confirm password" id="signupConfirmPassword" required>
  </div>
  <div class="field btn">
    <div class="btn-layer"></div>
    <input type="submit" value="Signup">
  </div>
</form>


      </div>
    </div>
  </div>

  <!-- Notification Modal (special alert box) -->
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

  <!-- JS -->
  <script src="script_login_signup.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
