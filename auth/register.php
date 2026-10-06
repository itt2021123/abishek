<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {

        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "Username or email is already registered.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($insert->execute([$username, $email, $hashed_password])) {
                $success = "Registration successful! You can now <a href='login.php' class='alert-link'>login here</a>.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Digital Recipe Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <a href="../index.php" class="text-decoration-none text-danger fs-3 fw-bold">
                        <i class="bi bi-book-half"></i> RecipeRealm
                    </a>
                </div>
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <h3 class="fw-bold mb-3 text-center">Create Chef Account</h3>
                    <p class="text-muted text-center small mb-4">Join our culinary community to share your favorite dishes.</p>

                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2 small" role="alert"><?= $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success py-2 small" role="alert"><?= $success; ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="POST" class="needs-validation-js" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-semibold">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Choose a username">
                            <div class="invalid-feedback">Please enter a username.</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="name@domain.com">
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-semibold">Password (min 6 characters)</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" required placeholder="••••••••">
                            <div class="invalid-feedback">Password must be at least 6 characters.</div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">Create Account</button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">Already have an account? <a href="login.php" class="text-danger fw-semibold">Log in</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
