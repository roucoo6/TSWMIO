<?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/User.php");

class UserMapper {
    private PDO $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function save(User $user): int {
        $stmt = $this->db->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)");
        $stmt->execute(array($user->getUsername(), $user->getPassword(), $user->getEmail()));
        return $this->db->lastInsertId();
    }

    public function usernameExists(string $username): bool {
        $stmt = $this->db->prepare("SELECT count(id) FROM users WHERE username = ?");
        $stmt->execute(array($username));
        return $stmt->fetchColumn() > 0;
    }

    public function isValidUser(string $username, string $password): bool {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute(array($username));
        $hashedPassword = $stmt->fetchColumn();

        if ($hashedPassword !== false) {
            return password_verify($password, $hashedPassword);
        }
        return false;
    }

    public function findByUsername(string $username): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute(array($username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            return new User($row["id"], $row["username"], $row["password"], $row["email"]);
        }
        return null;
    }
}
