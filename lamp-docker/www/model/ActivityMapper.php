<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Activity.php");

class ActivityMapper {
    private PDO $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function findByEventId(int $eventId): array {
        $stmt = $this->db->prepare("SELECT * FROM activities WHERE event_id = ? ORDER BY start_time ASC");
        $stmt->execute(array($eventId));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $activities = array();
        foreach ($rows as $row) {
            $activities[] = new Activity(
                $row["id"],
                $row["event_id"],
                $row["title"],
                $row["description"],
                $row["start_time"],
                $row["end_time"],
                $row["speaker"]
            );
        }
        return $activities;
    }

    public function findById(int $activityId): ?Activity {
        $stmt = $this->db->prepare("SELECT * FROM activities WHERE id = ?");
        $stmt->execute(array($activityId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            return new Activity(
                $row["id"],
                $row["event_id"],
                $row["title"],
                $row["description"],
                $row["start_time"],
                $row["end_time"],
                $row["speaker"]
            );
        }
        return null;
    }

    public function save(Activity $activity): int {
        $stmt = $this->db->prepare(
            "INSERT INTO activities(event_id, title, description, start_time, end_time, speaker) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute(array(
            $activity->getEventId(),
            $activity->getTitle(),
            $activity->getDescription(),
            $activity->getStartTime(),
            $activity->getEndTime(),
            $activity->getSpeaker()
        ));
        return $this->db->lastInsertId();
    }

    public function update(Activity $activity): void {
        $stmt = $this->db->prepare(
            "UPDATE activities SET title = ?, description = ?, start_time = ?, end_time = ?, speaker = ? WHERE id = ?"
        );
        $stmt->execute(array(
            $activity->getTitle(),
            $activity->getDescription(),
            $activity->getStartTime(),
            $activity->getEndTime(),
            $activity->getSpeaker(),
            $activity->getId()
        ));
    }

    public function delete(Activity $activity): void {
        $stmt = $this->db->prepare("DELETE FROM activities WHERE id = ?");
        $stmt->execute(array($activity->getId()));
    }
}
