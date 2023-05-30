<p style="text-align: center; font-size: 40px">Compte rendu projet ING1 : IA Pau</p>

[//]: # "1. ## [ppppppages implémentées](#pppppagesImp) indiqué les fonctionnalités implémentées dans le grand 3"

[//]: # "Administration des data challenges --> la partie gérée par un admin comme la création / suppression (voir sujet)"

[//]: # "Gestion des data challenges --> la partie gérée par un gestionnaire"

[//]: # "3. 4. 1. La messagerie entre utilisateurs (cas général ou seulement entre membres du groupe  --> par rapport à ce qui est implémenté)"

# Sommaire

1. ## [Introduction](#introduction)
2. ## [Stockage des données](#donnees) 
    1. ## [Le Modèle conceptuel de données](#mcd)
    2. ## [La Base de données](#bdd)
        1. ## [Gestion de la connexion à la base de données](#bddCon)
        2. ## [Récupération des données de la base de données](#bddRecup)
        3. ## [Modification des données de la base de données](#bddModif)
3. ## [Les fonctionnalités implémentées](#impFonct)
    1. ## [Administration des utilisateurs](#gestionUtil)
    2. ## [Administration des data challenges](#adminDataC)
    3. ## [Gestion des data challenges](#gestionDataC)
    4. ## [La messagerie](#gestionMsg)
        1. ## [La messagerie entre utilisateurs](#msgUtil)
        2. ## [La messagerie pour un gestionnaire](#msgG)
    5. ## [Gestion des groupes](#gestionG)
    6. ## [Analyse de code source](#analCode)
        1. ## [Analyseur de code](#analyseurCode)
        2. ## [Visualisation des résultats](#visuRes)
4. ## [Les fonctionnalités qui restent à implémenter](#nonImpFonct)
 
## Introduction <a name="introduction"></a>
        Dans le cadre de notre première année du cycle ingénieur, il nous est proposé la réalisation d'un projet pour mettre en pratique nos connaissances. 
    Ce projet consiste en la réalisation d'une application pour IA Pau permettant la création et l'administration de data challenges.

## Stockage des données <a name="donnees"></a>
        L'utilisation d'une base de données dans le contexte de ce projet est évident pour pouvoir stocker diverses informations comme celles concernant les utilisateurs ou les data chalenges.
    Ainsi, nous avons réalisé un modèle conceptuel de données (MCD) pour réaliser ensuite la structure de la base de données. 

### Le Modèle conceptuel de données <a name="mcd"></a>
        Vous pouvez trouver le MCD ci-dessous.
    Un utilisateur peut être soit un administrateur, un gestionnaire ou un étudiant (un participant).
    Un ensemble d'utilisateurs quelconques peut recevoir un message donné et un utilisateur peut aussi envoyer un message. On peut considérer qu'un étudiant puisse envoyer un message à un administrateur sous des conditions particulières (requête pour résoudre un bug, etc) qui peuvent être gérées lors du développement de l'application.
    Un même groupe peut participer à plusieurs data challenge en même temps d'où la cardinalité dans le MCD.

[//]: # "Espace à gérer selon le texte ci-dessous pour correctement placer l'image du MCD"

    Par contre tous les data challenges ont des sujets différents, des resources différentes et s'ils contiennent un quiz, un quiz différent les uns des autres. D'où la cardinalité (1, 1) du côté de la table DataChallenge.
    Enfin, on considère qu'un gestionnaire gère le data challenge complet (on aurait pu définir des gestionnaires qui gèrent seulement un ou des sujets d'un data challenge).

![MCD](MCD_db.jpeg)

### La base de données <a name="bdd"></a>
        Nous avons choisi d'utiliser la base de données mySQL pour stocker les informations nécessaires.
[//]: # "Revoir ce passage ou voir comment le formuler / reformuler."
    Nous avons pris parti d'inclure l'identifiant des data challenge en tant que clé étrangère dans les tables Quiz et Resource puisqu'elles sont uniques à chaque data challenge ainsi qu'à la table Group puique le cas d'un même groupe qui participe à plusieurs data challenges en même temps reste un cas très particulier.
    

### Gestion de la connexion à la base de données <a name="bddCon"></a>
        Plusieurs fonctions php pour gérer la connexion à la base de données sont présentes dans le fichier bdd.php.
    On a : 
[//]: # "à lister"

### Récupération des données de la base de données <a name="bddRecup"></a>
Another paragraphe

### Modification des données de la base de données <a name="bddModif"></a>
Another paragraphe




## Les fonctionnalités implémentées <a name="impFonct"></a>
The second paragraph



## Les fonctionnalités qui restent à implémenter <a name="nonImpFonct"></a>
Another paragraph
