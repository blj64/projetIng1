---
documentclass: article
graphics: true
title: Projet Ingénieur
subtitle: Peio LOUBIERE
titlegraphic: images/cytech
institute: CY Tech
date: 2022 -- 2023
author:

- Nicolas DURAND
- Lucas FERNANDES
- Jérémi LIOGER--BUN
- Lilian MICHEL-DANSAC
- Matt COSTE
toc: true
toc-title: Table des matières
lof: true
header-includes: |
  \usepackage{caption}
  \usepackage{subcaption}
  \usepackage{ dsfont }
  \usepackage{ amssymb }
  \usepackage{ tipa }
  \usepackage{ stmaryrd }

---

# I. Introduction 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dans le cadre de notre première année du cycle ingénieur, il nous est proposé la réalisation d'un projet pour mettre en pratique nos connaissances.
Ce projet consiste en la réalisation d'une application pour IA Pau permettant la création et l'administration de data challenges.

&nbsp;&nbsp;&nbsp;&nbsp; Le dépôt git se trouve au lien suivant : [https://github.com/blj64/projetIng1.git](https://github.com/blj64/projetIng1.git)


# II. Notre organisation

&nbsp;&nbsp;&nbsp; Afin de réaliser ce projet, nous avons dû travailler en équipe. Ce défi peut effrayer, mais avec un peu d'organisation et de travail, nous sommes arrivés à un résultat plutôt convaincant. 

&nbsp;&nbsp;&nbsp;&nbsp; Le premier jour, nous avons tous déclarer nos preferences au niveau du code. Lilian et Nicolas souhaitaient travailler sur le Backend, Matt sur l'analyseur de code et l'API Java, Jérémi s'occuperait de la messagerie et Lucas du Frontend. Nous avons ensuite réalisé un mld pour la base de donnée et un diagramme afin de structurer le site.  
&nbsp;&nbsp;&nbsp;&nbsp; Après s'être concerté pour le visuel du site et l'architecture de nos dossiers, nous avons commencé à travailler chacun dans nos parties respectives. 
Pour maintenir un rythme de travail élevé, nous utilisions github pour regrouper toutes nos avancées. Suite à ça, Nicolas a laissé Lilian finir les fonctions utiles à la base de donnée pour lier le back et le front. 
Une semaine avant la date de rendu, nous avons fait une réunion pour déterminer les fonctionnalités qu'il fallait finir à tout prix.


# III. Stockage des données

&nbsp;&nbsp;&nbsp;&nbsp; L'utilisation d'une base de données dans le contexte de ce projet est évident pour pouvoir stocker diverses informations comme celles concernant les utilisateurs ou les data chalenges.
Ainsi, nous avons réalisé un modèle conceptuel de données (MCD) pour réaliser ensuite la structure de la base de données.

## &nbsp;&nbsp;&nbsp; 1. Le Modèle conceptuel de données

![MCD](images/CDM_db.jpeg){height=40%}

&nbsp;&nbsp;&nbsp; Un utilisateur peut être soit un administrateur, un gestionnaire ou un étudiant (un participant).
Un ensemble d'utilisateurs quelconques peut recevoir un message donné et un utilisateur peut aussi envoyer un message. Nous pouvons considérer qu'un étudiant puisse envoyer un message à un administrateur sous des conditions particulières (requête pour résoudre un bug, etc) qui peuvent être gérées lors du développement de l'application.
Un même groupe peut participer à plusieurs data challenge en même temps d'où la cardinalité dans le MCD.

&nbsp;&nbsp;&nbsp;&nbsp; Cependant, tous les data challenges ont des sujets différents, des resources différentes et s'ils contiennent un quiz, un quiz différent les uns des autres. D'où la cardinalité (1, 1) du côté de la table DataChallenge.
Enfin, nous considérons qu'un gestionnaire gère le data challenge complet (nous aurions pu définir des gestionnaires qui gèrent seulement un ou des sujets d'un data challenge).

## &nbsp;&nbsp;&nbsp; 2. La base de données

&nbsp;&nbsp;&nbsp; Nous avons choisi d'utiliser la base de données mySQL pour stocker les informations nécessaires.

&nbsp;&nbsp;&nbsp;&nbsp; Nous avons pris parti d'inclure l'identifiant des data challenge en tant que clé étrangère dans les tables Quiz et Resource puisqu'elles sont uniques à chaque data challenge ainsi qu'à la table Group parce que le cas d'un même groupe qui participe à plusieurs data challenges en même temps reste un cas très particulier.

Ci-dessous une visualisation de la base de données utilisée :

![Base de données IAPau](images/db.png){height=40%}

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a. Gestion de la connexion à la base de données

&nbsp;&nbsp;&nbsp;&nbsp; Plusieurs fonctions php pour gérer la connexion à la base de données sont présentes dans le fichier bdd.php. 


- connect_db($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME)

- is_connected_db()

- disconnect_db()

&nbsp;&nbsp;&nbsp;&nbsp; Ces fonctions servent respectivement dans le cas général à se connecter à la base de données, vérifier si nous sommes connecté et enfin se déconnecter.


### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b. Récupération des données de la base de données

&nbsp;&nbsp;&nbsp;&nbsp; Pour simplifier l'aspect front et la création des diverses pages nécessaires, plusieurs fonctions ont été codées pour accéder aux informations stocker dans la base de données.
Ces fonctions dans bdd.php sont identifiables par un "get" au début du nom de la fonction. De plus, une fonction request_db($dbRequestType, $request = null) permet dans le cas général d'envoyer une requête à la base de données.

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; c. Modification des données de la base de données

&nbsp;&nbsp;&nbsp;&nbsp; De même, de multiples fonctions ont été codées pour modifier les informations stockées dans la base de données toujours dans le but de simplifier l'aspect front de l'application.
Ces fonctions dans bdd.php sont identifiables par un "alter" au début du nom de la fonction. Il existe par exemple une fonction pour modifier les informations d'un user ou data challenge.

# IV. Les fonctionnalités implémentées

&nbsp;&nbsp;&nbsp;&nbsp; Les fonctionnalités qui ont pu être implémentées dans l'application sont présentées dans cette partie.

## &nbsp;&nbsp;&nbsp; 1. Compte utilisateur

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a. Inscription et connexion

![Inscription](images/users/signUp.png){height=40%}

&nbsp;&nbsp;&nbsp; Le menu d'inscription pour un utilisateur de type élève. Les gestionnaires sont quant à eux à ajouter manuellement par un administrateur (voir : [2. Administration des utilisateurs](#adminUsers)).

![Connexion](images/users/signIn.png){height=40%}

&nbsp;&nbsp;&nbsp; Tous les utilisateurs peuvent se connecter depuis ce menu. Une redirection vers la page de connexion depuis la page d'inscription et inversement est implémentée.

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b. Profil

&nbsp;&nbsp;&nbsp; Tous les types d'utilisateur ont accès à leur propre profil avec la possibilité de modifier certaines informations de base comme l'adresse e-mail, le mot de passe, le nom, etc.

![Profil pour tous les utilisateurs (1)](images/profil_1.png){height=40%}

![Profil pour tous les utilisateurs (2)](images/profil_2.png){height=40%}

## &nbsp;&nbsp;&nbsp; 2. Administration des utilisateurs {#adminUsers}

![Gestion et création d'un utilisateur](images/users/h_users.png){height=40%}

&nbsp;&nbsp;&nbsp; L'accès à ce menu est réservé aux administrateurs. La gestion de tous les utilisateurs et la possibilité d'en créer un nouveau (menu côté droit) sont possibles.

![Modification des informations d'un utilisateur](images/users/changeUser.png){height=30%}

&nbsp;&nbsp;&nbsp; La modification des informations d'un utilisateur, le supprimer ainsi que la possibilité de créer un gestionnaire à partir d'un utilisateur. À noter qu'un administrateur peut tout de même être supprimé depuis cette interface.

## &nbsp;&nbsp;&nbsp; 3. Administration des data challenges

![Création d'un data event](images/dataC/createDataC.png){height=40%}

&nbsp;&nbsp;&nbsp; Le menu de création d'un data challenge avec ses informations de base. L'ajout de sujets est possible dans la limite de 3 sujets avec chacun son nom et sa description. La création et la suppression (depuis le menu Data Challenges) peut seulement être effectuées par un administrateur.

## &nbsp;&nbsp;&nbsp; 4. Gestion des data challenges

![Liste des data events](images/dataC/listDataC.png){height=40%}

&nbsp;&nbsp;&nbsp; La liste de tous les data events sont visibles dans le menu Data Challenges. 

![Modification des informations d'un data event](images/dataC/alterDataC.png){height=40%}

![Mon data challenge modifiable](images/gestionnaire/myDataCModif.png){height=40%}

![Les autres data challenges non modifiables](images/gestionnaire/otherDataCNModif.png){height=40%}


&nbsp;&nbsp;&nbsp; Cette page permet à un gestionnaire de visualiser toutes les équipes pour un data challenge donné.
De plus, si nécessaire, il peut aussi envoyer un quiz (data battle) aux équipes et voir leurs membres.

![Liste des équipes et envoyer quiz](images/dataC/dataCGroupsQuiz.png){height=40%}

![Liste des équipes avec rendu](images/dataC/dataCGroupsQuiz2.png){height=40%}

![Détails équipe](images/dataC/detailGroup.png){height=40%}

![Rendu de l'équipe](images/dataC/renduGroup.png){height=40%}


### &nbsp;&nbsp;&nbsp; b. Partie administrateur

&nbsp;&nbsp;&nbsp; L'administrateur peut voir tous les data challenges, les modifier ainsi que les supprimer. Il peut en créer vu ici [3. Administration des data challenges](#adminData).

![Tous les data challenges visibles et modifiables](images/admin/allDataC.png){height=40%}


## &nbsp;&nbsp;&nbsp; 5. La messagerie

&nbsp;&nbsp;&nbsp; La liste de toutes les personnes avec qui l'utilisateur a une conversation est affiché en colonne dans la partie gauche. Il est possible d'afficher la conversation en cours avec eux en cliquant dessus. La liste s'actualise automatiquement. Les messages sont stockés dans la base de données dans la table message. Chaque message possède un id, l'id de celui qui envoi le message, celui qui le reçoit, le message, sa date et son heure qui sont générées automatiquement ainsi qu'une variable équivalente à un type boolean qui prend 0 ou 1 en fonction de si le message a été lu ou non.

![Messagerie vue par le gestionnaire](images/gestionnaire/messagerie.png){height:40%}

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a. Contacter un nouvel utilisateur
&nbsp;&nbsp;&nbsp; Le button *nouveau message* sert à contacter un nouvel utilisateur. Il inclut dans la zone où les messages apparaissent normalement un input ou l'utilisateur sélectionne la personne qu'il souhaite contacter. À partir de la saisie de l'utilisateur, le serveur est censé proposer les noms des personnes contactable en créant une datalist dynamique, mais cette fonctionnalité ne marche pas très bien.
Ensuite, il suffit juste de rédiger le message et de l'envoyer pour finaliser la création d'un échange avec une nouvelle personne.

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b. Contacter les utilisateurs
&nbsp;&nbsp;&nbsp; Comme dit précédemment, pour parler avec une personne deja contacter, il suffit de sélectionner l'utilisateur dans la liste à gauche. La liste de tous les messages va donc s'afficher dans leurs ordres d'envoi. Ils sont également séparés en deux parties, à gauche ceux reçus et à droite ceux envoyer. 
La messagerie est instantané, chaque seconde une fonction va rechercher les messages qui n'ont pas été vu. Cette méthode est efficace, mais bien trop énergivore et peu adaptable dans le cas d'un vrai site. Nous avons en revanche trouvé une méthode plus efficace : HTTP Long Polling. L'utilisateur envoi une requête au serveur et tant que le serveur ne détecte pas de changement, il ne renvoie pas de requête la où dans notre solution initiale, il la renvoie immédiatement et ainsi de suite toutes les secondes. Par soucis de temps, nous n'avons pas adapté la methode HTTP Long Polling.

## &nbsp;&nbsp;&nbsp; 6. Gestion des groupes

![Menu de l'équipe](images/group/membersGroup.png){height=40%}

&nbsp;&nbsp;&nbsp; Le menu principal pour un groupe. Mon équipe correspond à l'équipe de l'utilisateur pour un data event (la couronne indique le capitaine, le nom en gras est le nom de l'utilisateur).

![La messagerie](images/group/messagesGroup.png){height=40%}

&nbsp;&nbsp;&nbsp; La messagerie est accessible sur cette même page bien que pas totalement implémentée (voir : [V. Problèmes rencontrés](#issues))

![Modification paramètres groupe](images/group/parametersGroup.png){height=40%}

&nbsp;&nbsp;&nbsp; Le menu unique au capitaine qui peut ajouter de nouveaux membres et changer le capitaine de l'équipe


![Rendu d'un fichier python et visualisation résultats](images/group/pythonGroup.png){height=40%}

## &nbsp;&nbsp;&nbsp; 7. L'API en Java

&nbsp;&nbsp;&nbsp; Dans cette partie, il nous était demandé de réaliser un analyseur de code source Python en Java, pour ensuite créer un web service REST sous forme d'API en Java.
Ainsi, nous allons expliquer comment nous nous sommes débrouillés pour répondre à cette demande en détaillant les étapes.


### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; a. La classe *CodeAnalyse*

&nbsp;&nbsp;&nbsp; Nous avons tout d'abord créé une classe ***CodeAnalyse*** qui avait comme seuls attributs :


- *path* de type **String** correspondant au chemin vers le fichier Python
- *file* de type **File** correspondant au fichier Python
- *br* de type **BufferedReader** permettant de lire le fichier à partir d'un flux de symboles
- *nb_lignes* de type **int** correspondant au nombre de lignes du fichier
- *text[][]* de type **String**, un tableau de tableaux de **String** qui permet d'accéder au texte complet ligne par ligne et mot par mot au sein de chaque ligne


&nbsp;&nbsp;&nbsp; Puis, nous avons créé deux constructeurs de classe, l'un à partir d'un fichier Python de type **File** et l'autre à partir d'un chemin vers un fichier Python de type **String**.
Voilà un des constructeurs :

```java
    public CodeAnalyse(File fileInsert) throws IOException {
        file = fileInsert;
        path = fileInsert.getPath();
        br = new BufferedReader(new FileReader(file));
        taille_texte();
        text = new String[nb_lignes][];
        splitTab();
    }
```
&nbsp;&nbsp;&nbsp; *splitTab()* permet d'initialiser l'attribut *text[][]* en séparant le texte du flux de l'attribut *br*. *taille_texte()* permet d'initialiser l'attribut *nb_lignes* au nombre de lignes du texte à partir de l'attribut *br*.


&nbsp;&nbsp;&nbsp; Il n'y a aucune vérification de l'extension du fichier au sein de la classe parce que la vérification est gérée du côté web lorsque l'utilisateur s'occupera d'upload son fichier.
Nous n'avons qu'un seul getter qui est *getNb_lignes()* puisqu'il est le seul utile pour un utilisateur.


&nbsp;&nbsp;&nbsp; Suite à cela, nous avons créé plusieurs méthodes au sein de notre classe, certaines privées qui ne sont pas utiles pour l'utilisateur et d'autres publiques car essentielles pour ce dernier.
Voici notre diagramme de classes que nous avions à ce moment-là :

![Diagramme de classes temporaire](images/java_uml_1.png){height=50%}

&nbsp;&nbsp;&nbsp; Nous avons essayé de rendre le nom des méthodes le plus clair possible cependant, si vous souhaitez avoir plus d'informations sur chacune d'elles,
elles sont toutes commentées et vous pouvez vous rendre sur la [***Javadoc***](./java/CodeAnalyseJavaDoc/allclasses.html) (le lien fonctionne si vous lisez le rapport depuis le repertoire du projet, sinon il faudra s'y rendre manuellement).



&nbsp;&nbsp;&nbsp; Voilà un exemple de fonctionnement de notre classe (cette partie provient du **main** qui est une partie commentée pour laisser place à la gestion du serveur) :


```java 
    /* Création de l'instance de ma classe à partir du fichier 
    nommé "test.py" */
    CodeAnalyse code = new CodeAnalyse("src/test.py"); 
            
            
    /* Première fonction permettant de générer le JSON avec 
    toutes les data nécessaires */
    code.create_JSON_data();
    
    
    /* Deuxième fonction permettant de prendre un mot et d'obtenir 
    le nombre d'itérations de celui-ci */
    int iteration_mot_def = code.iteration_mot("def");
    
    
    
    /* Démonstration de toutes les fonctions de la classe et les 
    différents affichages */
    
    /* Affichage des noms de fonctions */
    System.out.print("Tableau des noms de fonctions : ");
    code.afficher_iteration_fonction(true);
    
    /* Affichage des tailles de fonctions */
    System.out.print("Tableau des tailles de fonctions : ");
    code.afficher_iteration_fonction(false);
    
    /* Affichage de la taille maximale */
    System.out.println("Taille maximale : " + code.max_ligne_fonction());
    
    /* Affichage de la taille minimale */
    System.out.println("Taille minimale : " + code.min_ligne_fonction());
    
    /* Affichage de la moyenne */
    System.out.println("Taille moyenne : " + code.moyenne_ligne_fonction());
    
    /* Affichage du nombre de commentaires */
    System.out.println("Nombre de commentaires : " + code.nombre_ligne_commentaires());
    
    /* Affichage du nombre de lignes totales */
    System.out.println("Nombre de lignes totales : " + code.getNb_lignes());
    
    /* Affichage du nombre de lignes de code */
    int taille_code = code.getNb_lignes() - code.nombre_ligne_commentaires();
    System.out.println("Nombre de lignes de code : " + taille_code);
```


Voilà l'affichage correspondant :

```shell
    Tableau des noms de fonctions : [fRepartition ; test ; test ; graphique ; __str__ ; 
    variance ; esperance ; __init__ ; test ; f_inv2 ; f_inv ; S_n]
    Tableau des tailles de fonctions : [7 ; 2 ; 2 ; 4 ; 2 ; 1 ; 2 ; 4 ; 24 ; 2 ; 2 ; 5]
    Taille maximale : 24
    Taille minimale : 1
    Taille moyenne : 4
    Nombre de commentaires : 17
    Nombre de lignes totales : 116
    Nombre de lignes de code : 99
```

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b. Partie serveur de la classe Java



&nbsp;&nbsp;&nbsp; Après s'être occupé de la classe *CodeAnalyse* avec toutes les fonctionnalités de base pour analyser le code, nous nous sommes occupés de
l'implémentation de la partie serveur.
Ainsi, nous avons ajouté les attributs suivants :


- *SERVEUR* de type **String** qui représente l'url de base du service
- *PORT* de type **int** qui représente le port du serveur
- *URL* de type **String** qui représente l'url de base du service
- *LOGGER* de type **Logger** qui permet de gérer les messages émis durant l'exécution du serveur


&nbsp;&nbsp;&nbsp; Le *main*, qui servait à faire la démonstration de la classe et de son fonctionnement, sert désormais de boucle principale permettant au serveur de démarrer et de fonctionner jusqu'à l'arrêt du fonctionnement de la classe.
Nous avons dû nous occuper également des différentes méthodes permettant de gérer les requêtes (POST, GET qui proviennent du serveur web), de les traiter et d'envoyer une réponse.
Pour la méthode POST, nous récupérons un fichier Python provenant d'un form HTML et nous lui appliquons la méthode permettant de générer une chaîne de caractères en format JSON et nous envoyons à la page web cette dernière.
Pour la méthode GET, nous ne la gérons pas puisque nous ne faisons aucune requête GET au sein de notre site web.

Voici donc le diagramme de classes final que nous avons :

![Diagramme de classes final](images/java_uml_2.png){height=50%}


&nbsp;&nbsp;&nbsp; Pour finir, il y a un *README* dans le dossier *java* contenant les instructions à réaliser pour lancer le serveur Java.
Vous pouvez retrouver ces mêmes instructions dans le README global avec les instructions pour lancer le serveur PHP.

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; c. Visualisation des résultats

&nbsp;&nbsp;&nbsp; Pour visualiser les résultats sur notre site, nous utilisons une librairie nommée ChartJS ce qui nous permet de créer des graphiques
visuellement beaux et dynamiques à partir d'un JSON.
Voilà à quoi ressemble la visualisation des résultats d'un fichier Python (le fichier *test.py* présent dans le dossier *java*) :

![Visualisation des résultats 1](images/graph_result_1.png){height=80%}

![Visualisation des résultats 2](images/graph_result_2.png){height=80%}

![Visualisation des résultats 3](images/graph_result_3.png){height=80%}

## &nbsp;&nbsp;&nbsp; 8. Autre

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. Choix du CSS

&nbsp;&nbsp;&nbsp; Pour la page d'accueil, nous avons choisi de rester proche du style de la page du site IA Pau ainsi que pour les pages d'inscription et de connexion.
Cependant, les pages d'accueil en tant qu'utilisateurs (admin, gestionnaire et student) connectés changent radicalement du style original. Souvent des zones à bordures arrondies où nous retrouvons les fonctionnalités principales, dans un fond de nature. Nous pouvons retrouver parfois le background du site IA Pau et son header qui reste le même quand il est utilisé.

&nbsp;&nbsp;&nbsp;&nbsp; Au niveau des animations, nous pouvons retrouver des pop ups comme dans le header, ou des changements de couleurs et de tailles pour les cartes dans le menu de l'accueil, les liens vers les réseaux sociaux ou certains boutons et lien.

![Header et underheader](images/header.png){height=80%}

![Cartes](images/card.png){height=80%}

&nbsp;&nbsp;&nbsp;&nbsp; Nous avons choisi de rester sobres dans les pages pour faciliter l'utilisation à l'utilisateur. Le header et underheader changent en fonction de l'utilisateur, ainsi que l'accueil quand nous sommes connecté.

# V. Problèmes rencontrés {#issues}

&nbsp;&nbsp;&nbsp;&nbsp; Lors de ce projet, nous avons fait face à plusieurs problèmes. Nous avons réussi an résoudre une bonne partie d'entre eux, mais certain d'entre ont persisté.

### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. La messagerie

&nbsp;&nbsp;&nbsp;&nbsp; Il y a eu plusieurs problèmes rencontrés dans la conception de la messagerie : 


- Les nouveaux messages s'envoient avec une requête AJAX mais lorsque l'utilisateur appuyait sur la touche "entre" lorsque le form était envoyé et réactualise la page. Pour résoudre ce problème, nous avons forcé l'action de touche entre pour qu'elle simule l'appui du bouton envoyer.
- Comme dit précédemment lorsque nous désirons contacter un nouvel utilisateur, il faut saisir son nom dans un input et des noms sont proposés en fonctions de ce que l'utilisateur saisit. Pour une raison inconnue cela ne marche pas. Pourtant, si nous saisissons manuellement la datalist, la suggestion marche bien.



# VI. Bilan du projet

&nbsp;&nbsp;&nbsp; Pendant ces trois semaines, nous avons travaillé en équipe sur un sujet des plus intéressants, qui a été un véritable défi pour nous en tant qu'étudiants. C'était la première fois que nous étions assignés à un groupe pour un projet, et malgré les difficultés rencontrées, nous avons fait preuve de patience et d'organisation pour mettre en place la plupart des fonctionnalités demandées. Nous avons réussi à développer la base de données, la gestion des data battles et challenges, les différentes parties utilisateur ainsi que le design.En conclusion, ce projet nous a non seulement permis de développer nos compétences techniques, mais il nous a également appris l'importance de la collaboration en équipe et de l'adaptabilité face aux défis. Nous sommes fiers du travail accompli et nous sommes confiants dans notre capacité à relever de futurs projets ambitieux.


