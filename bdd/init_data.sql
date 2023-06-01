-- Path: bdd/init_data.sql
-- Date: 2020-04-28 15:00:00

USE IAPau;

INSERT INTO `User` VALUES (null, "Nicolas", "Durand", "$2y$10$h/FgDUL6GlkY40Lne.hMROY98l13NqJVCL64hIHPWgqNOmEOJtQXO", "0606060606", "durandnico@cy-tech.fr"); /* Mot de passe : Azerty1! */
INSERT INTO `User` VALUES (null, "Matt", "Coste", "$2y$10$0nd2hf4zQ1AnAQy4dGaQ6eRJhr6Hy8Dh/8f4xlpICdsXS4DL74Dk2", "0606060606", "Costematt@cy-tech.fr"); /* Mot de passe : azerty */
INSERT INTO `User` VALUES (null, "admin", "admin", "$2y$10$GqbX4WeZ9fG7wteXNSu1mOY6paNQms3xecowH8e1olfsrwA7RQvnG", "0606060606", "admin@cy-tech.fr"); /* Mot de passe : admin */
INSERT INTO `User` VALUES (null, "Lilian", "manager", "$2y$10$TEd6iw1twrpx0RWXLex2JebCbZJf6sB/zJBc7efjoqZXoiNA6LLbC", "0606060606", "manager@cy-tech.fr"); /* Mot de passe : manager */
INSERT INTO `User` VALUES (null, "Lucas", "Fernandes", "$2y$10$0nd2hf4zQ1AnAQy4dGaQ6eRJhr6Hy8Dh/8f4xlpICdsXS4DL74Dk2", "0606060606", "fernandes@cy-tech.fr"); /* Mot de passe : azerty */
INSERT INTO `User` VALUES (null, "Celian", "Pallard", "$2y$10$h/FgDUL6GlkY40Lne.hMROY98l13NqJVCL64hIHPWgqNOmEOJtQXO", "0102030405", "bgdu64@cy-tech.fr"); /* Mot de passe : Azerty1! User simple */ 

INSERT INTO `Admin` VALUES (3);

INSERT INTO `Manager` VALUES (4, "Cy-Tech", "2020-04-28", "2020-05-28");

INSERT INTO `DataChallenge` VALUES (null, "Data Challenge avril 2024", "2024-04-28", "2024-05-28", "/asset/uploaded/1dc-decembre-2022-archive-site-web.jpg", "Les 3 sujets ont été apportés par : Boavizta, une association de référence sur l’impact environnemental de l’IA; Green AI, un laboratoire de l’université de Pau qui développe des algorithmes basse consommation ayant un impact sur le réchauffement climatique; et les PtitsBots, une entreprise qui développe et commercialise des chatbots citoyens pour les collectivités, avec toutes les considérations éthiques que cela implique.");
INSERT INTO `DataChallenge` VALUES (null, "Data Battle avril 2024", "2024-04-28", "2024-05-31", "/asset/uploaded/0introduction-projet-tatami.jpg", "Le projet de correspondance entre des offres d’emplois et des candidatures soumis par l’entreprise TATAMI a été étudié pendant un mois par différentes équipes d’étudiants de la région Nouvelle Aquitaine.
Un prix d’un montant de 6 000 € a été réparti entre les 3 finalistes");
INSERT INTO `Student` VALUES (1, "L1", "CY Tech", "Pau", NULL);
INSERT INTO `Student` VALUES (2, "L2", "CY Tech", "Cergy", NULL);
INSERT INTO `Student` VALUES (5, "L3", "EISTI", "Pau", NULL);

INSERT INTO `Subject` VALUES (null, 1, "Boavizta", "Identifier un modèle NLP présentant le moins d’impact environnemental
Problématique et objectifs : L’objectif est de construire un modèle de NLP avec le coût environnemental le plus bas possible. Le projet concerne la tâche de classification de sentiment, c’est à dire de classer des phrases selon que les sentiments décrits sont positifs ou négatifs. Cette tâche a l’avantage d’être relativement connue, et porte sur de nombreuses applications de la vie réelle. Il est demandé d’explorer l’état de l’art et trouver des modèles qui offrent des compromis précision/impact plus intéressants que les modèles classiquement utilisés. Tout modèle de NLP peut être testé (TF-IDF, embedding based classifier, LSTM, BERT), ainsi que les modèles préentraînés (exclusion des modèles déjà entraînés pour la classification de sentiments).
Descriptif du jeu de données fourni : Les données se composent d’un sous-ensemble de 30000 critiques de films extraites du site IMDb. Un second corpus wikitext est fourni pour apprendre son propre modèle de langage ou plongement lexical. L’usage de ce second corpus est optionnel.");

INSERT INTO `Subject` VALUES (null, 1, "Green AI", "Optimisation d’une application de sensibilisation à l’environnement
Problématique et objectifs : l’équipe GreenAI UPPA développe depuis plusieurs mois une application de sensibilisation à l’environnement sur https://la-derniere-bibliotheque.org/. L’objectif du challenge est d’améliorer le modèle de NLP utilisé par l’application pour ajouter de la pertinence au moteur de recherche et proposer automatiquement des tags lors de l’ajout de contenus.
Concernant le moteur de recherche, Il s’agit d’une part d’améliorer la pertinence des résultats, étant donné la requête saisie par l’utilisateur, mais également d’optimiser et de renseigner l’énergie consommée lors de la requête.
Concernant la proposition de tags lors d’une nouvelle saisie, il s’agit d’entraîner des classifieurs à partir des différents modèles de NLP sur les données de l’applications.
Descriptif du jeu de données fourni : mise à disposition d’un dépôt github contenant le code open-source du projet en ligne la-derniere-bibliotheque.org, des fichiers relatifs à l’évaluation du moteur de recherche (un fichier contenant 20 requêtes et contenu associé à chaque requête, un script python pour évaluer le top5, top3, et top1 de l’algorithme de recherche), les tweets utilisés pour entraîner le modèle fasttext actuellement en production.");

INSERT INTO `Subject` VALUES (null, 1, "PtitsBots", " Anonymisation des données personnelles
Problématique et objectifs : l’objectif est donc d’anonymiser les messages des utilisateurs; la version idéale devrait fonctionner en 2 étapes : identifer automatiquement les mots ou groupes de mots qui sont des informations à caractère personnel ou sensible dans les messages envoyés aux chatbots, puis anonymiser ces messages en cachant ces mots ou groupes de mots. En fonction des contraintes techniques rencontrées, il est possible d’imaginer une première version où les 2 étapes seraient : identifier automatiquement les messages comprenant des informations à caractère personnel ou sensible, puis les supprimer. Cette version n’est pas optimale, puisque l’objectif est de garder tous les messages non compris afin d’alimenter le chatbot lors du processus ”Entraînement”.
Descriptif du jeu de données fourni : 2 sets de données fournies : les messages des habitants de la ville de Clichy et les messages des collaborateurs travaillant à la Gendarmerie Nationale. Tous ces messages ont été labellisés (identification des messages qui possèdent des informations personnelles, et au sein
de ces messages, tag des mots qui posent problème). Un fichier .xlsx contenant les éléments suivants est fourni : un ID, une query (la question posée par l’utilisateur), un drapeau indiquant si la question détient des éléments sensibles ou non; un autre .xlsx contenant uniquement les phrases contenant des éléments sensibles (en gras) est également disponible.");

INSERT INTO `Subject` VALUES (null, 2, "TATAMI", "L’entreprise TATAMI développe une plateforme appelée VivaJob qui permet de matcher des entreprises qui recherchent des compétences et des personnes à la recherche d’un emploi, ceci quel soit le type de contrat (CDI, CDD, intérim, stage).
Le projet consiste à rechercher la meilleure technologie de correspondance entre des offres d’emplois et des contenus de CVs.
Un jeu de données a été constitué, à partir d’une source de données réelles issues d’un partenaire de l’entreprise spécialiste du recrutement et de l’intérim : ces données ont été anonymisées et structurées (extraction data intéressante) avec l’aide des experts d’IA PAU.
L’objectif est d’utiliser les technologies de l’intelligence artificielle afin de trouver des critères supplémentaires de correspondances offres – candidatures, d’affiner la lecture des détails invisibles des candidats et de corriger les biais éventuels inhérents au recrutement.");

INSERT INTO `Group` VALUES (null, "Group1", 1, 1);

INSERT INTO `In` VALUES (1, 1);

INSERT INTO `In` VALUES (2, 1);

INSERT INTO `In` VALUES (5, 1);

INSERT INTO `Handle` VALUES (4, 1);

INSERT INTO `Message` (`idSender`, `idReceiver`, `messageContent`) VALUES (3, 4, "Hello World!");

INSERT INTO `Quiz` VALUES (null, 1, "quiz", "2023-05-24", "2023-09-03");

INSERT INTO `Quiz` VALUES (null, 1, "notAvailable", "2023-05-20", "2023-05-23");

INSERT INTO `Resource` VALUES (null, 1, "test", "resource/Sujet_Projet_ING1_GI_2023.pdf");