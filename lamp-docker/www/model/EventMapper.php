<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Event.php");
require_once(__DIR__."/../model/User.php");

class EventMapper {
    private PDO $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function findAll(): array {
        $stmt = $this->db->query(
            "SELECT e.*, u.username FROM events e INNER JOIN users u ON e.user_id = u.id ORDER BY e.date ASC"
        );
        $eventsWithUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = array();
        foreach ($eventsWithUsers as $row) {
            $author = new User($row["user_id"], $row["username"]);
            $events[] = new Event(
                $row["id"],
                $row["user_id"],
                $row["title"],
                $row["description"],
                $row["date"],
                $row["location"],
                $row["image"],
                $author
            );
        }
        return $events;
    }

    public function findById(int $eventId): ?Event {
        $stmt = $this->db->prepare(
            "SELECT e.*, u.username FROM events e INNER JOIN users u ON e.user_id = u.id WHERE e.id = ?"
        );
        $stmt->execute(array($eventId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            $author = new User($row["user_id"], $row["username"]);
            return new Event(
                $row["id"],
                $row["user_id"],
                $row["title"],
                $row["description"],
                $row["date"],
                $row["location"],
                $row["image"],
                $author
            );
        }
        return null;
    }

    public function save(Event $event): int {
        $stmt = $this->db->prepare(
            "INSERT INTO events(user_id, title, description, date, location, image) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute(array(
            $event->getUserId(),
            $event->getTitle(),
            $event->getDescription(),
            $event->getDate(),
            $event->getLocation(),
            $event->getImage()
        ));
        return $this->db->lastInsertId();
    }

    public function update(Event $event): void {
        $stmt = $this->db->prepare(
            "UPDATE events SET title = ?, description = ?, date = ?, location = ?, image = ? WHERE id = ?"
        );
        $stmt->execute(array(
            $event->getTitle(),
            $event->getDescription(),
            $event->getDate(),
            $event->getLocation(),
            $event->getImage(),
            $event->getId()
        ));
    }

    public function delete(Event $event): void {
        $stmt = $this->db->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute(array($event->getId()));
    }
}
