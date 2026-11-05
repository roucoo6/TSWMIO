<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$user = $view->getVariable("user");
$errors = $view->getVariable("errors");
?>

<div class="form-container main-content">
    <h2><?= t("Register User") ?></h2>

    <form action="index.php?controller=users&amp;action=register" method="POST" class="form">
        <div class="form-group">
            <label for="username"><?= t("Username") ?>:</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user->getUsername()) ?>" required>
            <?php if (isset($errors["username"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["username"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email"><?= t("Email") ?>:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
            <?php if (isset($errors["email"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["email"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password"><?= t("Password") ?>:</label>
            <input type="password" id="password" name="password" class="form-control" required>
            <?php if (isset($errors["password"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["password"]) ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary"><?= t("Register") ?></button>
    </form>

    <p class="form-footer">
        <?= t("Already have an account?") ?> <a href="index.php?controller=users&amp;action=login"><?= t("Log in here") ?></a>.
    </p>
</div>
