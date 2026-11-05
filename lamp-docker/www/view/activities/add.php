<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$activity = $view->getVariable("activity");
$event = $view->getVariable("event");
$errors = $view->getVariable("errors");
?>

<div class="form-container main-content">
    <h2><?= t("Add Activity to") ?>: <?= htmlspecialchars($event->getTitle()) ?></h2>

    <form action="index.php?controller=activities&amp;action=add" method="POST" class="form">
        <input type="hidden" name="event_id" value="<?= $event->getId() ?>">

        <div class="form-group">
            <label for="title"><?= t("Title") ?>:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($activity->getTitle()) ?>" required>
            <?php if (isset($errors["title"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["title"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="start_time"><?= t("Start Time") ?>:</label>
            <input type="time" id="start_time" name="start_time" class="form-control" value="<?= htmlspecialchars($activity->getStartTime()) ?>" required>
            <?php if (isset($errors["startTime"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["startTime"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="end_time"><?= t("End Time") ?>:</label>
            <input type="time" id="end_time" name="end_time" class="form-control" value="<?= htmlspecialchars($activity->getEndTime()) ?>" required>
            <?php if (isset($errors["endTime"])): ?>
                <span class="error-text"><?= htmlspecialchars($errors["endTime"]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="speaker"><?= t("Speaker / Presenter") ?>:</label>
            <input type="text" id="speaker" name="speaker" class="form-control" value="<?= htmlspecialchars($activity->getSpeaker() ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="description"><?= t("Description") ?>:</label>
            <textarea id="description" name="description" class="form-control" rows="4"><?= htmlspecialchars($activity->getDescription()) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?= t("Add Activity") ?></button>
        <a href="index.php?controller=events&amp;action=view&amp;id=<?= $event->getId() ?>" class="btn btn-secondary"><?= t("Cancel") ?></a>
    </form>
</div>
