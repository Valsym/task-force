DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` integer PRIMARY KEY,
  `title` varchar(255),
  `desc` varchar(255),
  `category` varchar(255),
  `location_id` integer,
  `budget` float,
  `deadline` DATE,
  `file` varchar(255),
  `status` tinyint,
  `author_id` integer,
  `performer_id` integer,
  `response_id` integer,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(255)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` integer PRIMARY KEY,
  `username` varchar(255)  NOT NULL UNIQUE,
  `role` varchar(255),
  `email` varchar(255) NOT NULL UNIQUE,
  `pass` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `birthday` DATE,
  `phone` varchar(255),
  `telegram` varchar(255),
  `city` varchar(255),
  `avatar` varchar(255),
  `category` varchar(255) NOT NULL,
  `rating` tinyint DEFAULT 0,
  `reviews` varchar(255),
  `status` tinyint,
  `cancels` integer
);

DROP TABLE IF EXISTS `responses`;
CREATE TABLE `responses` (
  `id` integer PRIMARY KEY,
  `task_id` integer,
  `performer_id` integer,
  `price` float,
  `body` text COMMENT 'Content of the post',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `tasks` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`);
