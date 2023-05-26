-- Path: bdd/init.sql
-- Date: 2020-04-28 14:00:00
DROP DATABASE IF EXISTS IAPau;
CREATE DATABASE IAPau;
USE IAPau;

CREATE TABLE `DataChallenge` (
    `idDataC` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `startDate` DATE NOT NULL,
    `endDate` DATE NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idDataC`)
);

CREATE TABLE `User` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `firstName` VARCHAR(20) NOT NULL,
    `lastName` VARCHAR(31) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `number` VARCHAR(11) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `Group` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `idDataC` INT UNSIGNED NOT NULL,
    `idLeader` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`idDataC`) REFERENCES `DataChallenge`(`idDataC`) ON DELETE CASCADE,
    FOREIGN KEY (`idLeader`) REFERENCES `User`(`id`)
);

CREATE TABLE `Admin` (
    `idUser` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`idUser`),
    FOREIGN KEY (`idUser`) REFERENCES `User`(`id`) ON DELETE CASCADE
);

CREATE TABLE `Student` (
    `idUser` INT UNSIGNED NOT NULL,
    `idGroup` INT UNSIGNED NOT NULL,
    `lvStudy` VARCHAR(2) NOT NULL,
    `school` VARCHAR(255) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idUser`),
    FOREIGN KEY (`idUser`) REFERENCES `User`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`idGroup`) REFERENCES `Group`(`id`)
);

CREATE TABLE `Manager` (
    `idUser` INT UNSIGNED NOT NULL,
    `company` VARCHAR(255) NOT NULL,
    `startDate` DATE,
    `endDate` DATE,
    PRIMARY KEY (`idUser`),
    FOREIGN KEY (`idUser`) REFERENCES `User`(`id`) ON DELETE CASCADE
);

CREATE TABLE `Handle` (
    `idUser` INT UNSIGNED NOT NULL,
    `idDataC` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`idUser`, `idDataC`),
    FOREIGN KEY (`idUser`) REFERENCES `User`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`idDataC`) REFERENCES `DataChallenge`(`idDataC`) ON DELETE CASCADE
);

CREATE TABLE `Message` (
    `idMessage` INT NOT NULL AUTO_INCREMENT,
    `idSender` INT UNSIGNED NOT NULL,
    `idReceiver` INT UNSIGNED NOT NULL,
    `messageContent` TEXT NOT NULL,
    `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`idMessage`),
    FOREIGN KEY (`idSender`) REFERENCES `User`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`idReceiver`) REFERENCES `User`(`id`) ON DELETE CASCADE
);

CREATE TABLE `Quiz` (
    `idQuiz` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `idDataC` INT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `startDate` DATE NOT NULL,
    `endDate` DATE NOT NULL,
    PRIMARY KEY (`idQuiz`),
    FOREIGN KEY (`idDataC`) REFERENCES `DataChallenge`(`idDataC`) ON DELETE CASCADE
);

CREATE TABLE `Resource` (
    `idResource` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `idDataC` INT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `path` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idResource`),
    FOREIGN KEY (`idDataC`) REFERENCES DataChallenge(`idDataC`) ON DELETE CASCADE
)