-- Database creation and initial data for EventHub

CREATE DATABASE IF NOT EXISTS `mvcblog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mvcblog`;

DROP TABLE IF EXISTS `activities`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `date` DATE NOT NULL,
  `location` VARCHAR(150) NOT NULL,
  `image` VARCHAR(255) DEFAULT 'default_event.jpg',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `activities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `speaker` VARCHAR(100) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial test data (Password for both users: 'password123')
INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe11eQ3M3w3q5vG/4O9R4jB6F.N6iM1gK', 'admin@eventhub.es'),
(2, 'dev_user', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe11eQ3M3w3q5vG/4O9R4jB6F.N6iM1gK', 'dev@eventhub.es');

INSERT INTO `events` (`id`, `user_id`, `title`, `description`, `date`, `location`, `image`) VALUES
(1, 1, 'Conferencia de Ciberseguridad 2026', 'Evento anual sobre las últimas tendencias en seguridad informática, hacking ético y protección de datos.', '2026-11-15', 'Auditorio Principal de Informática', 'ciberseguridad.jpg'),
(2, 1, 'Hackathon Desarrollo Web MVC', 'Jornada intensiva de programación creando aplicaciones web robustas con arquitectura MVC en PHP.', '2026-12-01', 'Laboratorio L3', 'desarrolloweb.jpg');

INSERT INTO `activities` (`id`, `event_id`, `title`, `description`, `start_time`, `end_time`, `speaker`) VALUES
(1, 1, 'Ponencia: Seguridad en Entornos LAMP', 'Análisis de vulnerabilidades comunes y endurecimiento de servidores Apache y MySQL.', '10:00:00', '11:30:00', 'Dra. María Gómez'),
(2, 1, 'Taller: Hacking Ético en Aplicaciones Web', 'Demostración práctica de prevención de ataques XSS y SQL Injection.', '12:00:00', '14:00:00', 'Ing. Carlos Ruiz'),
(3, 2, 'Sesión 1: Diseño de DAOs y Mappers', 'Patrones de diseño de persistencia de datos aplicados a aplicaciones PHP sin frameworks.', '09:00:00', '11:00:00', 'Prof. Alejandro López');
