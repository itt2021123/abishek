<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';


$stmt = $pdo->query("SELECT r.*, u.username FROM recipes r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
$recipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Recipe Book - Home</title>

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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#recipes-section">Browse Recipes</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if (isLoggedIn()): ?>
                        <a href="dashboard.php" class="btn btn-outline-light btn-sm"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        <a href="auth/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout (<?= htmlspecialchars($_SESSION['username']); ?>)</a>
                    <?php else: ?>
                        <a href="auth/login.php" class="btn btn-outline-light btn-sm"><i class="bi bi-person"></i> Login</a>
                        <a href="auth/register.php" class="btn btn-danger btn-sm"><i class="bi bi-person-plus"></i> Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main>
    
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1400&q=80" class="d-block w-100" alt="Culinary Delights">
                    <div class="carousel-caption">
                        <h2 class="display-6 fw-bold text-white">Discover & Share Homemade Recipes</h2>
                        <p class="lead text-light">Join a passionate community of amateur chefs and culinary artists.</p>
                        <a href="#recipes-section" class="btn btn-danger btn-lg mt-2">Explore Cookbook</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1400&q=80" class="d-block w-100" alt="Fresh Ingredients">
                    <div class="carousel-caption">
                        <h2 class="display-6 fw-bold text-white">Cook with Wholesome Ingredients</h2>
                        <p class="lead text-light">Create balanced breakfasts, hearty dinners, and delightful desserts.</p>
                        <a href="auth/register.php" class="btn btn-danger btn-lg mt-2">Start Sharing Today</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1400&q=80" class="d-block w-100" alt="Chef Passion">
                    <div class="carousel-caption">
                        <h2 class="display-6 fw-bold text-white">Your Personal Digital Kitchen</h2>
                        <p class="lead text-light">Manage, update, and organize your favorite recipes in one place.</p>
                        <a href="contact.php" class="btn btn-outline-light btn-lg mt-2">Get In Touch</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>


        <section id="recipes-section" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Community Recipes</h2>
                    <p class="text-muted">Search by keyword or filter recipes dynamically with JavaScript</p>
                </div>

         
                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" id="recipeSearch" class="form-control" placeholder="Search recipe title...">
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="btn-group flex-wrap" role="group">
                            <button type="button" class="btn btn-dark active filter-btn" data-category="all">All</button>
                            <button type="button" class="btn btn-outline-dark filter-btn" data-category="Breakfast">Breakfast</button>
                            <button type="button" class="btn btn-outline-dark filter-btn" data-category="Dinner">Dinner</button>
                            <button type="button" class="btn btn-outline-dark filter-btn" data-category="Dessert">Dessert</button>
                        </div>
                    </div>
                </div>

           
                <div class="row g-4" id="recipeGrid">
                    <?php if (empty($recipes)): ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No recipes found. Be the first to share one!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recipes as $r): ?>
                            <div class="col-md-6 col-lg-4 recipe-item" data-title="<?= htmlspecialchars($r['title']); ?>" data-category="<?= htmlspecialchars($r['category']); ?>">
                                <div class="card h-100 shadow-sm recipe-card">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge badge-category"><?= htmlspecialchars($r['category']); ?></span>
                                            <small class="text-muted"><i class="bi bi-person"></i> <?= htmlspecialchars($r['username']); ?></small>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($r['title']); ?></h5>
                                        <h6 class="text-secondary mt-2 mb-1"><i class="bi bi-basket"></i> Ingredients:</h6>
                                        <p class="card-text small text-muted"><?= nl2br(htmlspecialchars($r['ingredients'])); ?></p>
                                        
                                        <h6 class="text-secondary mt-2 mb-1"><i class="bi bi-card-checklist"></i> Instructions:</h6>
                                        <p class="card-text small text-dark flex-grow-1"><?= nl2br(htmlspecialchars($r['instructions'])); ?></p>
                                        
                                        <div class="mt-3 pt-2 border-top text-muted small">
                                            <i class="bi bi-clock"></i> Shared on <?= date('M d, Y', strtotime($r['created_at'])); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>


    <footer class="py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1 fw-bold text-white">ICT 1209 - Web Technologies Mini Project</p>
            <small class="text-secondary">&copy; <?= date('Y'); ?> Digital Recipe Book Web Application. Faculty of Technology, RUSL.</small>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/main.js"></script>
</body>
</html>
