-- Path: bdd/init_data.sql
-- Date: 2020-04-28 15:00:00

USE IAPau;

INSERT INTO `User` VALUES (null, "Nicolas", "Durand", "123456", "0606060606", "exemple@cy-tech.fr");
INSERT INTO `User` VALUES (null, "Matt", "Coste", "123456", "0606060606", "exemple2@cy-tech.fr");
INSERT INTO `User` VALUES (null, "admin", "admin", "123456", "0606060606", "admin@cy-tech.fr");
INSERT INTO `User` VALUES (null, "Lilan", "gestionnaire", "123456", "0606060606", "gestion@cy-tech.fr");
INSERT INTO `User` VALUES (null, "Lucas", "Fernandes", "123456", "0606060606", "exemple3@cy-tech.fr");

INSERT INTO `Admin` VALUES (3);

INSERT INTO `Manager` VALUES (4, "Cy-Tech", "2020-04-28", "2020-05-28");

INSERT INTO `DataChallenge` VALUES (null, "DataChallenge1", "2020-04-28", "2020-05-28", "image1");

INSERT INTO `Group` VALUES (null, "Group1", 1, 1);

INSERT INTO `Student` VALUES (1, 1, "L1", "CY Tech", "Pau");
INSERT INTO `Student` VALUES (2, 1, "L2", "CY Tech", "Cergy");
INSERT INTO `Student` VALUES (5, 1, "L3", "EISTI", "Pau");

INSERT INTO `Gerer` VALUES (4, 1);

INSERT INTO `Message` (`idSender`, `idReceiver`, `messageContent`) VALUES (3, 4, "Hello World!");
