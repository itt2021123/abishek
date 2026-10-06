<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Recipe Book</title>
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
                    <h3 class="fw-bold mb-3 text-center">Chef Login</h3>
                    <p class="text-muted text-center small mb-4">Enter your credentials to access your dashboard.</p>

                    <?php if (isset($_GET['error']) && $_GET['error'] === 'unauthorized'): ?>
                        <div class="alert alert-warning py-2 small" role="alert">Please sign in to access your dashboard.</div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2 small" role="alert"><?= $error; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST" class="needs-validation-js" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-semibold">Username or Email</label>
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Your username or email">
                            <div class="invalid-feedback">Please enter your username or email.</div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">Sign In</button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">Don't have an account? <a href="register.php" class="text-danger fw-semibold">Sign up</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
