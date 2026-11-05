<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$events = $view->getVariable("events");
$currentUser = $view->getVariable("currentuser");
$featuredEvent = !empty($events) ? $events[0] : null;
$restEvents    = count($events) > 1 ? array_slice($events, 1) : [];
?>

<div class="main-content">
    <div class="header-action">
        <h2><?= t("Available Events") ?></h2>
        <?php if ($currentUser): ?>
            <a href="index.php?controller=events&amp;action=add" class="btn btn-primary">+ <?= t("Create Event") ?></a>
        <?php endif; ?>
    </div>

    <?php if ($featuredEvent): ?>
    <!-- Evento destacado -->
    <article class="event-featured">
        <div class="event-img-wrapper">
            <img
                src="img/<?= htmlspecialchars($featuredEvent->getImage()) ?>"
                alt="<?= htmlspecialchars($featuredEvent->getTitle()) ?>"
                class="event-img"
                onerror="this.src='img/default_event.jpg'"
            >
        </div>
        <div class="event-card-body">
            <span class="event-tag">⭐ <?= t("Featured Event") ?></span>
            <h3>
                <a href="index.php?controller=events&amp;action=view&amp;id=<?= $featuredEvent->getId() ?>">
                    <?= htmlspecialchars($featuredEvent->getTitle()) ?>
                </a>
            </h3>
            <div class="event-meta">
                <span>📅 <?= htmlspecialchars($featuredEvent->getDate()) ?></span>
                <span>📍 <?= htmlspecialchars($featuredEvent->getLocation()) ?></span>
            </div>
            <p class="event-description">
                <?= htmlspecialchars(substr($featuredEvent->getDescription(), 0, 200)) ?>...
            </p>
            <div class="event-author">
                <span class="event-author-avatar"><?= strtoupper(substr($featuredEvent->getAuthor()->getUsername(), 0, 1)) ?></span>
                <?= t("Organized by") ?> <strong><?= htmlspecialchars($featuredEvent->getAuthor()->getUsername()) ?></strong>
            </div>
            <a href="index.php?controller=events&amp;action=view&amp;id=<?= $featuredEvent->getId() ?>" class="btn btn-primary">
                <?= t("View Details") ?> →
            </a>
        </div>
    </article>
    <?php endif; ?>

    <?php if (!empty($restEvents)): ?>
    <!-- Resto de eventos -->
    <div class="events-grid">
        <?php foreach ($restEvents as $event): ?>
            <article class="event-card">
                <div class="event-img-wrapper">
                    <img
                        src="img/<?= htmlspecialchars($event->getImage()) ?>"
                        alt="<?= htmlspecialchars($event->getTitle()) ?>"
                        class="event-img"
                        onerror="this.src='img/default_event.jpg'"
                    >
                    <span class="event-date-badge">📅 <?= htmlspecialchars($event->getDate()) ?></span>
                </div>
                <div class="event-card-body">
                    <span class="event-tag">📌 <?= t("Event") ?></span>
                    <h3>
                        <a href="index.php?controller=events&amp;action=view&amp;id=<?= $event->getId() ?>">
                            <?= htmlspecialchars($event->getTitle()) ?>
                        </a>
                    </h3>
                    <div class="event-meta">
                        <span>📍 <?= htmlspecialchars($event->getLocation()) ?></span>
                    </div>
                    <p class="event-description">
                        <?= htmlspecialchars(substr($event->getDescription(), 0, 110)) ?>...
                    </p>
                    <div class="event-author">
                        <span class="event-author-avatar"><?= strtoupper(substr($event->getAuthor()->getUsername(), 0, 1)) ?></span>
                        <?= htmlspecialchars($event->getAuthor()->getUsername()) ?>
                    </div>
                    <a href="index.php?controller=events&amp;action=view&amp;id=<?= $event->getId() ?>" class="btn btn-primary">
                        <?= t("View Details") ?> →
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($events)): ?>
        <div class="alert alert-info"><?= t("No events available yet.") ?></div>
    <?php endif; ?>
</div>
