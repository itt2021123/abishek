<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name'] ?? '');
    $email   = sanitize($_POST['email'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please provide a valid email address.";
    } else {

        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $message])) {
            $success = "Thank you, {$name}! Your message has been sent successfully.";
        } else {
            $error = "An error occurred while transmitting your message. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Digital Recipe Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-book-half text-danger"></i> RecipeRealm
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#recipes-section">Browse Recipes</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if (isLoggedIn()): ?>
                        <a href="dashboard.php" class="btn btn-outline-light btn-sm"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        <a href="auth/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    <?php else: ?>
                        <a href="auth/login.php" class="btn btn-outline-light btn-sm"><i class="bi bi-person"></i> Login</a>
                        <a href="auth/register.php" class="btn btn-danger btn-sm"><i class="bi bi-person-plus"></i> Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">
                    <div class="card border-0 shadow rounded-4 p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Contact Our Culinary Team</h2>
                            <p class="text-muted">Have a query, suggestion, or partnership idea? Reach out to us below.</p>
                        </div>

                        <?php if ($success): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div><?= $success; ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                <div><?= $error; ?></div>
                            </div>
                        <?php endif; ?>

                    
                        <form action="contact.php" method="POST" class="needs-validation-js" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Your Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Chef Mario">
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="mario@example.com">
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold">Your Message or Feedback</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Share your thoughts..."></textarea>
                                <div class="invalid-feedback">Please provide a message.</div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                                <i class="bi bi-send-fill me-1"></i> Send Query
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1 fw-bold text-white">ICT 1209 - Web Technologies Mini Project</p>
            <small class="text-secondary">&copy; <?= date('Y'); ?> Digital Recipe Book Web Application.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
