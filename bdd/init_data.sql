-- Path: bdd/init_data.sql
-- Date: 2020-04-28 15:00:00

USE IAPau;

INSERT INTO `User` VALUES (null, "Nicolas", "Durand", "$2y$10$zq6xyV8q0PWp9plNdQpewuZGIXCj8KJlyYYVk7wIu32ws0Lhjm1yK", "0606060606", "durandnico@cy-tech.fr"); /* Mot de passe : Azerty1! */
INSERT INTO `User` VALUES (null, "Matt", "Coste", "$2y$10$0nd2hf4zQ1AnAQy4dGaQ6eRJhr6Hy8Dh/8f4xlpICdsXS4DL74Dk2", "0606060606", "Costematt@cy-tech.fr"); /* Mot de passe : azerty */
INSERT INTO `User` VALUES (null, "admin", "admin", "$2y$10$GqbX4WeZ9fG7wteXNSu1mOY6paNQms3xecowH8e1olfsrwA7RQvnG", "0606060606", "admin@cy-tech.fr"); /* Mot de passe : admin */
INSERT INTO `User` VALUES (null, "Lilan", "manager", "$2y$10$QJAKD69.horLpTlHGU64Oemt6NeG8L2qODpZtkRL63kkKbB1H65Ge", "0606060606", "manager@cy-tech.fr"); /* Mot de passe : manager */
INSERT INTO `User` VALUES (null, "Lucas", "Fernandes", "$2y$10$0nd2hf4zQ1AnAQy4dGaQ6eRJhr6Hy8Dh/8f4xlpICdsXS4DL74Dk2", "0606060606", "fernandes@cy-tech.fr"); /* Mot de passe : azerty */
INSERT INTO `User` VALUES (null, "Celian", "Pallard", "$2y$10$zq6xyV8q0PWp9plNdQpewuZGIXCj8KJlyYYVk7wIu32ws0Lhjm1yK", "0102030405", "bgdu64@cy-tech.fr"); /* Mot de passe : Azerty1! User simple */ 

INSERT INTO `Admin` VALUES (3);

INSERT INTO `Manager` VALUES (4, "Cy-Tech", "2020-04-28", "2020-05-28");

INSERT INTO `DataChallenge` VALUES (null, "DataChallenge1", "2020-04-28", "2020-05-28", "image1", "Data challenge description");

INSERT INTO `Subject` VALUES (null, 1, "Subject 1", "Subject description");

INSERT INTO `Group` VALUES (null, "Group1", 1, 1);

INSERT INTO `Student` VALUES (1, 1, "L1", "CY Tech", "Pau");
INSERT INTO `Student` VALUES (2, 1, "L2", "CY Tech", "Cergy");
INSERT INTO `Student` VALUES (5, 1, "L3", "EISTI", "Pau");

INSERT INTO `Handle` VALUES (4, 1);

INSERT INTO `Message` (`idSender`, `idReceiver`, `messageContent`) VALUES (3, 4, "Hello World!");

INSERT INTO `Quiz` VALUES (null, 1, "quiz", "2023-05-24", "2023-09-03");

INSERT INTO `Quiz` VALUES (null, 1, "notAvailable", "2023-05-20", "2023-05-23");

INSERT INTO `Resource` VALUES (null, 1, "test", "resource/Sujet_Projet_ING1_GI_2023.pdf");