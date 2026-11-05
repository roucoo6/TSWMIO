<?php
class Activity {
    private ?int $id;
    private int $eventId;
    private string $title;
    private string $description;
    private string $startTime;
    private string $endTime;
    private ?string $speaker;

    public function __construct(?int $id = null, int $eventId = 0, string $title = "", string $description = "", string $startTime = "", string $endTime = "", ?string $speaker = null) {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->speaker = $speaker;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getEventId(): int { return $this->eventId; }
    public function setEventId(int $eventId): void { $this->eventId = $eventId; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): void { $this->title = $title; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getStartTime(): string { return $this->startTime; }
    public function setStartTime(string $startTime): void { $this->startTime = $startTime; }

    public function getEndTime(): string { return $this->endTime; }
    public function setEndTime(string $endTime): void { $this->endTime = $endTime; }

    public function getSpeaker(): ?string { return $this->speaker; }
    public function setSpeaker(?string $speaker): void { $this->speaker = $speaker; }

    public function checkIsValidForCreate(): void {
        $errors = array();
        if (empty(trim($this->title))) {
            $errors["title"] = "El título de la actividad es obligatorio";
        }
        if (empty(trim($this->startTime))) {
            $errors["startTime"] = "La hora de inicio es obligatoria";
        }
        if (empty(trim($this->endTime))) {
            $errors["endTime"] = "La hora de fin es obligatoria";
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors, "La actividad no es válida");
        }
    }
}
