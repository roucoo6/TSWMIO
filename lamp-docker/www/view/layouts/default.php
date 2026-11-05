<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$currentUser = $view->getVariable("currentuser");
$flashMessage = $view->popFlash();
?>
<!DOCTYPE html>
<html lang="<?= i18n("currentlang") ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Gestión de Eventos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="container nav-container">
            <a href="index.php?controller=events&amp;action=index" class="brand-logo">EventHub</a>
            <nav class="nav-links">
                <a href="index.php?controller=events&amp;action=index"><?= t("Available Events") ?></a>
                
                <?php if ($currentUser): ?>
                    <span class="user-welcome"><?= htmlspecialchars($currentUser) ?></span>
                    <a href="index.php?controller=users&amp;action=logout" class="btn btn-nav"><?= t("Logout") ?></a>
                <?php else: ?>
                    <a href="index.php?controller=users&amp;action=login" class="btn btn-nav"><?= t("Log In") ?></a>
                    <a href="index.php?controller=users&amp;action=register" class="btn btn-nav-primary"><?= t("Register") ?></a>
                <?php endif; ?>

                <div class="lang-selector">
                    <a href="index.php?controller=language&amp;action=change&amp;lang=es">ES</a> | 
                    <a href="index.php?controller=language&amp;action=change&amp;lang=en">EN</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($flashMessage)): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($flashMessage) ?>
            </div>
        <?php endif; ?>

        <?= $view->getFragment("css") ?>
        <?= $view->getFragment("javascript") ?>
        <?= $view->getFragment("content") ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 EventHub - Tecnologías y Servicios Web (4º Grado en Ingeniería Informática).</p>
        </div>
    </footer>
</body>
</html>
