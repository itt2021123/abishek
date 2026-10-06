<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';


requireLogin();

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';


if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $del_stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ? AND user_id = ?");
    $del_stmt->execute([$delete_id, $user_id]);
    header("Location: dashboard.php?msg=deleted");
    exit();
}


if (isset($_GET['delete_msg'])) {
    $delete_id = (int)$_GET['delete_msg'];
    $del_stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $del_stmt->execute([$delete_id]);
    header("Location: dashboard.php?msg=msg_deleted");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title        = sanitize($_POST['title'] ?? '');
    $category     = sanitize($_POST['category'] ?? 'Dessert');
    $ingredients  = sanitize($_POST['ingredients'] ?? '');
    $instructions = sanitize($_POST['instructions'] ?? '');

    if (empty($title) || empty($ingredients) || empty($instructions)) {
        $error = "Please fill in all recipe fields.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO recipes (user_id, title, category, ingredients, instructions) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $title, $category, $ingredients, $instructions])) {
            $success = "Recipe added successfully!";
        } else {
            $error = "Failed to add recipe. Please try again.";
        }
    }
}


$stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$my_recipes = $stmt->fetchAll();


$stmt_msg = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt_msg->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Dashboard - Digital Recipe Book</title>
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
            <div class="d-flex align-items-center gap-2 ms-auto">
                <a href="index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-house"></i> Public View</a>
                <a href="auth/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="fw-bold mb-0">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
                    <p class="text-muted">Manage your custom recipes or submit a new culinary creation.</p>
                </div>
            </div>

            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-1"></i> Recipe successfully removed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'msg_deleted'): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-1"></i> Message successfully removed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i> <?= $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i> <?= $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
           
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-3 p-4">
                        <h4 class="fw-bold mb-3"><i class="bi bi-plus-circle text-danger me-2"></i>Post New Recipe</h4>
                        
                        <form action="dashboard.php" method="POST" class="needs-validation-js" novalidate>
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">Recipe Title</label>
                                <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., Homemade Lemon Meringue Pie">
                                <div class="invalid-feedback">Title is required.</div>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Dinner">Dinner</option>
                                    <option value="Dessert" selected>Dessert</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="ingredients" class="form-label fw-semibold">Ingredients</label>
                                <textarea class="form-control" id="ingredients" name="ingredients" rows="4" required placeholder="1 cup sugar, 2 eggs..."></textarea>
                                <div class="invalid-feedback">Ingredients are required.</div>
                            </div>

                            <div class="mb-3">
                                <label for="instructions" class="form-label fw-semibold">Cooking Instructions</label>
                                <textarea class="form-control" id="instructions" name="instructions" rows="4" required placeholder="1. Preheat oven... 2. Mix ingredients..."></textarea>
                                <div class="invalid-feedback">Instructions are required.</div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Publish Recipe
                            </button>
                        </form>
                    </div>
                </div>

           
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-3 p-4">
                        <h4 class="fw-bold mb-3"><i class="bi bi-journals text-primary me-2"></i>My Published Recipes (<?= count($my_recipes); ?>)</h4>
                        
                        <?php if (empty($my_recipes)): ?>
                            <div class="alert alert-light text-center py-4 border">
                                <i class="bi bi-inbox fs-2 text-muted"></i>
                                <p class="mb-0 mt-2 text-muted">You haven't added any recipes yet. Use the form on the left to start cooking!</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($my_recipes as $recipe): ?>
                                            <tr>
                                                <td class="fw-semibold"><?= htmlspecialchars($recipe['title']); ?></td>
                                                <td><span class="badge bg-secondary"><?= htmlspecialchars($recipe['category']); ?></span></td>
                                                <td class="small text-muted"><?= date('M d, Y', strtotime($recipe['created_at'])); ?></td>
                                                <td class="text-end">
                                                    <a href="dashboard.php?delete=<?= $recipe['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this recipe?');">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

    
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 p-4">
                        <h4 class="fw-bold mb-3"><i class="bi bi-envelope-paper text-success me-2"></i>Contact Form Messages (<?= count($messages); ?>)</h4>
                        
                        <?php if (empty($messages)): ?>
                            <div class="alert alert-light text-center py-4 border">
                                <i class="bi bi-inbox fs-2 text-muted"></i>
                                <p class="mb-0 mt-2 text-muted">No messages received yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($messages as $msg): ?>
                                            <tr>
                                                <td class="fw-semibold"><?= htmlspecialchars($msg['name']); ?></td>
                                                <td><a href="mailto:<?= htmlspecialchars($msg['email']); ?>" class="text-decoration-none"><?= htmlspecialchars($msg['email']); ?></a></td>
                                                <td><?= nl2br(htmlspecialchars($msg['message'])); ?></td>
                                                <td class="small text-muted"><?= date('M d, Y h:i A', strtotime($msg['created_at'])); ?></td>
                                                <td class="text-end">
                                                    <a href="dashboard.php?delete_msg=<?= $msg['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this message?');">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-4 mt-auto">
        <div class="container text-center">
            <small class="text-secondary">&copy; <?= date('Y'); ?> Digital Recipe Book Web Application.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
