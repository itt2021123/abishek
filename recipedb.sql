-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.42 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for recipe_book
CREATE DATABASE IF NOT EXISTS `recipe_book` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `recipe_book`;

-- Dumping structure for table recipe_book.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table recipe_book.messages: ~0 rows (approximately)
DELETE FROM `messages`;

-- Dumping structure for table recipe_book.recipes
CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'Dessert',
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table recipe_book.recipes: ~4 rows (approximately)
DELETE FROM `recipes`;
INSERT INTO `recipes` (`id`, `user_id`, `title`, `category`, `ingredients`, `instructions`, `created_at`) VALUES
	(1, 1, 'Classic Creamy Carbonara', 'Dinner', 'Spaghetti, 2 Fresh Eggs, Pecorino Cheese, Guanciale/Bacon, Crushed Black Pepper', '1. Boil pasta al dente.\n2. Crisp bacon in skillet.\n3. Whisk eggs and cheese.\n4. Combine hot pasta with egg mixture off heat.', '2026-10-06 06:34:08'),
	(2, 1, 'Avocado Sourdough Toast', 'Breakfast', '2 Slices Sourdough Bread, 1 Ripe Avocado, Chili Flakes, Olive Oil, Sea Salt', '1. Toast sourdough until crisp.\n2. Mash avocado with salt and olive oil.\n3. Spread over toast and sprinkle chili flakes.', '2026-10-06 06:34:08'),
	(3, 1, 'Berry Blast Smoothie Bowl', 'Breakfast', 'Frozen Mixed Berries, 1 Banana, Greek Yogurt, Honey, Chia Seeds, Granola', '1. Blend frozen berries, banana, and yogurt.\n2. Pour into bowl.\n3. Top with granola and chia seeds.', '2026-10-06 06:34:08'),
	(4, 1, 'Spicy Arrabbiata Penne', 'Dinner', 'Penne Pasta, Canned Crushed Tomatoes, 3 Garlic Cloves, Red Chili Flakes, Fresh Basil', '1. Sauté garlic and red chili flakes in olive oil.\n2. Simmer tomatoes for 15 mins.\n3. Toss penne in sauce and garnish with basil.', '2026-10-06 06:34:08');

-- Dumping structure for table recipe_book.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table recipe_book.users: ~1 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
	(1, 'demo_chef', 'chef@example.com', '$2y$10$4n9x5r4QcK8zEw/ZkE53GOWpS0aD1P8c7mP2tM7K8yC3fJ6u8T5aW', '2026-10-06 06:34:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
