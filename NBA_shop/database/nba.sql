/* This is the query you have to past in PHP myAdmin in the SQL part, nba is the name of the database i have created */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NULL,
   PRIMARY KEY (`id`));


DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `url` VARCHAR(500) NOT NULL,
    `description` VARCHAR(255) NOT NULL, 
      PRIMARY KEY (`id`));

INSERT INTO `users` (`username`, `password`) VALUES ('admin', 'password');