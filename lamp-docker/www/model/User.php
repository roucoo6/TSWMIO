<?php
class User {
    private ?int $id;
    private string $username;
    private string $password;
    private string $email;

    public function __construct(?int $id = null, string $username = "", string $password = "", string $email = "") {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getUsername(): string { return $this->username; }
    public function setUsername(string $username): void { $this->username = $username; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function checkIsValidForRegister(): void {
        $errors = array();
        if (strlen(trim($this->username)) < 3) {
            $errors["username"] = "El nombre de usuario debe tener al menos 3 caracteres";
        }
        if (strlen($this->password) < 5) {
            $errors["password"] = "La contraseña debe tener al menos 5 caracteres";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "El correo electrónico introducido no es válido";
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors, "El usuario no es válido");
        }
    }
}
