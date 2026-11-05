<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$event = $view->getVariable("event");
$currentUser = $view->getVariable("currentuser");
?>

<div class="main-content">
    <article class="event-detail">

        <!-- Hero con imagen -->
        <div class="event-hero">
            <img
                src="img/<?= htmlspecialchars($event->getImage()) ?>"
                alt="<?= htmlspecialchars($event->getTitle()) ?>"
                class="event-hero-img"
                onerror="this.src='img/default_event.jpg'"
            >
            <div class="event-hero-overlay"></div>
            <div class="event-hero-content">
                <h2><?= htmlspecialchars($event->getTitle()) ?></h2>
                <div class="event-meta-pills">
                    <span class="meta-pill">📅 <?= htmlspecialchars($event->getDate()) ?></span>
                    <span class="meta-pill">📍 <?= htmlspecialchars($event->getLocation()) ?></span>
                    <span class="meta-pill">👤 <?= htmlspecialchars($event->getAuthor()->getUsername()) ?></span>
                </div>
            </div>
        </div>

        <!-- Acciones (editar/borrar) -->
        <?php if ($currentUser && $event->getAuthor() && $currentUser === $event->getAuthor()->getUsername()): ?>
        <div class="event-actions">
            <a href="index.php?controller=events&action=edit&id=<?= $event->getId() ?>" class="btn btn-warning"><?= t("Edit Event") ?></a>

            <form action="index.php?controller=events&action=delete" method="POST" style="display:inline;" onsubmit="return confirm('<?= t("Are you sure you want to delete this event?") ?>');">
                <input type="hidden" name="id" value="<?= $event->getId() ?>">
                <button type="submit" class="btn btn-danger"><?= t("Delete Event") ?></button>
            </form>

            <a href="index.php?controller=events&amp;action=index" class="btn btn-secondary" style="margin-left:auto;">← <?= t("Available Events") ?></a>
        </div>
        <?php else: ?>
        <div class="event-actions">
            <a href="index.php?controller=events&amp;action=index" class="btn btn-secondary">← <?= t("Available Events") ?></a>
        </div>
        <?php endif; ?>

        <!-- Descripción -->
        <div class="event-body-content">
            <div class="event-text">
                <h3><?= t("Description") ?></h3>
                <p><?= nl2br(htmlspecialchars($event->getDescription())) ?></p>
            </div>
        </div>

        <hr class="separator">

        <!-- Actividades -->
        <section class="activities-section">
            <div class="header-action">
                <h3><?= t("Associated Activities") ?></h3>
                <?php if ($currentUser && $currentUser === $event->getAuthor()->getUsername()): ?>
                    <a href="index.php?controller=activities&amp;action=add&amp;event_id=<?= $event->getId() ?>" class="btn btn-sm btn-primary">+ <?= t("Add Activity") ?></a>
                <?php endif; ?>
            </div>

            <?php if (count($event->getActivities()) > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= t("Schedule") ?></th>
                            <th><?= t("Activity") ?></th>
                            <th><?= t("Speaker") ?></th>
                            <th><?= t("Actions") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($event->getActivities() as $act): ?>
                            <tr>
                                <td><?= htmlspecialchars($act->getStartTime()) ?> - <?= htmlspecialchars($act->getEndTime()) ?></td>
                                <td>
                                    <a href="index.php?controller=activities&amp;action=view&amp;id=<?= $act->getId() ?>">
                                        <strong><?= htmlspecialchars($act->getTitle()) ?></strong>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($act->getSpeaker() ?? '-') ?></td>
                                <td>
                                    <a href="index.php?controller=activities&amp;action=view&amp;id=<?= $act->getId() ?>" class="btn btn-sm btn-info"><?= t("View") ?></a>
                                   <?php if ($currentUser && $event->getAuthor() && $currentUser === $event->getAuthor()->getUsername()): ?>
                                        <a href="index.php?controller=activities&action=edit&id=<?= $act->getId() ?>" class="btn btn-sm btn-warning"><?= t("Edit") ?></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted"><?= t("No activities scheduled for this event yet.") ?></p>
            <?php endif; ?>
        </section>
    </article>
</div>
