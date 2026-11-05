<?php
class Event {
    private ?int $id;
    private int $userId;
    private string $title;
    private string $description;
    private string $date;
    private string $location;
    private string $image;
    private ?User $author;
    private array $activities;

    public function __construct(?int $id = null, int $userId = 0, string $title = "", string $description = "", string $date = "", string $location = "", string $image = "default_event.jpg", ?User $author = null, array $activities = []) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->location = $location;
        $this->image = $image;
        $this->author = $author;
        $this->activities = $activities;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $userId): void { $this->userId = $userId; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): void { $this->title = $title; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getDate(): string { return $this->date; }
    public function setDate(string $date): void { $this->date = $date; }

    public function getLocation(): string { return $this->location; }
    public function setLocation(string $location): void { $this->location = $location; }

    public function getImage(): string { return $this->image; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getAuthor(): ?User { return $this->author; }
    public function setAuthor(?User $author): void { $this->author = $author; }

    public function getActivities(): array { return $this->activities; }
    public function setActivities(array $activities): void { $this->activities = $activities; }

    public function checkIsValidForCreate(): void {
        $errors = array();
        if (empty(trim($this->title))) {
            $errors["title"] = "El título del evento no puede estar vacío";
        }
        if (empty(trim($this->description))) {
            $errors["description"] = "La descripción no puede estar vacía";
        }
        if (empty(trim($this->date))) {
            $errors["date"] = "La fecha no puede estar vacía";
        }
        if (empty(trim($this->location))) {
            $errors["location"] = "La ubicación no puede estar vacía";
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors, "El evento no es válido");
        }
    }
}
