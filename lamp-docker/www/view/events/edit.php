<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$event = $view->getVariable("event");
$errors = $view->getVariable("errors");
?>

<div class="form-container main-content">
    <h2><?= t("Edit Event") ?></h2>

    <form action="index.php?controller=events&amp;action=edit" method="POST" class="form">
        <input type="hidden" name="id" value="<?= $event->getId() ?>">

        <div class="form-group">
            <label for="title"><?= t("Title") ?>:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($event->getTitle()) ?>" required>
            <?php if (isset($errors["title"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["title"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="date"><?= t("Date") ?>:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?= htmlspecialchars($event->getDate()) ?>" required>
            <?php if (isset($errors["date"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["date"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="location"><?= t("Location") ?>:</label>
            <input type="text" id="location" name="location" class="form-control" value="<?= htmlspecialchars($event->getLocation()) ?>" required>
            <?php if (isset($errors["location"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["location"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="description"><?= t("Description") ?>:</label>
            <textarea id="description" name="description" class="form-control" rows="5" required><?= htmlspecialchars($event->getDescription()) ?></textarea>
            <?php if (isset($errors["description"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["description"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="image"><?= t("Image Filename") ?>:</label>
            <input type="text" id="image" name="image" class="form-control" value="<?= htmlspecialchars($event->getImage()) ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= t("Save Changes") ?></button>
            <a href="index.php?controller=events&amp;action=view&amp;id=<?= $event->getId() ?>" class="btn btn-secondary"><?= t("Cancel") ?></a>
        </div>
    </form>
</div>
