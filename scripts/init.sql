CREATE DATABASE `smallProj`; 
USE `smallProj`;
-- Create database that will hold user credentials--
CREATE TABLE `creds` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- Create database that will hold each user's contact list--
CREATE TABLE `contacts` (
  `user_id` int(255) NOT NULL,
  `contact_id` int(255) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL, 
  `phone` varchar(50) NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `creds` VALUES (1,'johnnyboy','ilovemydog');
