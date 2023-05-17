-- Path: bdd/init.sql
-- Date: 2020-04-28 14:00:00
DROP DATABASE IF EXISTS IAPau;
CREATE DATABASE IAPau;
USE IAPau;

CREATE TABLE DataChallenge (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    startD DATE NOT NULL,
    endD DATE NOT NULL,
    img VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Users (
    id INT NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(20) NOT NULL,
    lastName VARCHAR(31) NOT NULL,
    pwd VARCHAR(60) NOT NULL,
    tel VARCHAR(11) NOT NULL,
    email VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Team (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    idDataC INT NOT NULL,
    idLeader INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (idDataC) REFERENCES DataChallenge(id),
    FOREIGN KEY (idLeader) REFERENCES Users(id)
);

CREATE TABLE Admin (
    idUser INT NOT NULL,
    PRIMARY KEY (idUser),
    FOREIGN KEY (idUser) REFERENCES Users(id)
);

CREATE TABLE Student (
    idUser INT NOT NULL,
    idTeam INT NOT NULL,
    PRIMARY KEY (idUser),
    FOREIGN KEY (idUser) REFERENCES Users(id),
    FOREIGN KEY (idTeam) REFERENCES Team(id)
);

CREATE TABLE Gestionnaire (
    idUser INT NOT NULL,
    company VARCHAR(255) NOT NULL,
    startDate date,
    endDate date,
    PRIMARY KEY (idUser),
    FOREIGN KEY (idUser) REFERENCES Users(id)
);

CREATE TABLE Gerer (
    idUser INT NOT NULL,
    idDataC INT NOT NULL,
    PRIMARY KEY (idUser, idDataC),
    FOREIGN KEY (idUser) REFERENCES Users(id),
    FOREIGN KEY (idDataC) REFERENCES DataChallenge(id)
);

