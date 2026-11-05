<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$activity = $view->getVariable("activity");
$event = $view->getVariable("event");
$currentUser = $view->getVariable("currentuser");
?>

<div class="main-content">
    <article class="activity-detail card">
        <header class="activity-header">
            <h2><?= htmlspecialchars($activity->getTitle()) ?></h2>
            <p class="activity-meta">
                <strong><?= t("Event") ?>:</strong> 
                <a href="index.php?controller=events&amp;action=view&amp;id=<?= $event->getId() ?>">
                    <?= htmlspecialchars($event->getTitle()) ?>
                </a><br>
                <strong><?= t("Schedule") ?>:</strong> <?= htmlspecialchars($activity->getStartTime()) ?> - <?= htmlspecialchars($activity->getEndTime()) ?><br>
                <strong><?= t("Speaker") ?>:</strong> <?= htmlspecialchars($activity->getSpeaker() ?? t("Not specified")) ?>
            </p>
        </header>

        <div class="activity-body">
            <h3><?= t("Description") ?></h3>
            <p><?= nl2br(htmlspecialchars($activity->getDescription())) ?></p>
        </div>

        <div class="activity-actions">
            <a href="index.php?controller=events&amp;action=view&amp;id=<?= $event->getId() ?>" class="btn btn-secondary"><?= t("Back to Event") ?></a>
            
            <?php if ($currentUser && $currentUser === $event->getAuthor()->getUsername()): ?>
                <a href="index.php?controller=activities&amp;action=edit&amp;id=<?= $activity->getId() ?>" class="btn btn-warning"><?= t("Edit Activity") ?></a>
                
                <form action="index.php?controller=activities&amp;action=delete" method="POST" style="display:inline;" onsubmit="return confirm('<?= t("Are you sure you want to delete this activity?") ?>');">
                    <input type="hidden" name="id" value="<?= $activity->getId() ?>">
                    <button type="submit" class="btn btn-danger"><?= t("Delete Activity") ?></button>
                </form>
            <?php endif; ?>
        </div>
    </article>
</div>
