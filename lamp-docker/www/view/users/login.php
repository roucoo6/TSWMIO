<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
?>

<div class="form-container main-content">
    <h2><?= t("Log In") ?></h2>

    <?php if (isset($errors["general"])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($errors["general"]) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?controller=users&amp;action=login" method="POST" class="form">
        <div class="form-group">
            <label for="username"><?= t("Username") ?>:</label>
            <input type="text" id="username" name="username" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label for="password"><?= t("Password") ?>:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary"><?= t("Log In") ?></button>
    </form>

    <p class="form-footer">
        <?= t("Don't have an account?") ?> <a href="index.php?controller=users&amp;action=register"><?= t("Register here") ?></a>.
    </p>
</div>
