# projetIng1
Plateforme d'administration pour data challenge et analyse de code dans le cadre d'un projet de fin d'année


Afin de démarrer le serveur PHP, vous devez exécuter la commande suivante (lorsque vous êtes dans le répertoire du projet) sur un premier terminal :

```bash
php -S localhost:8080 -t .
```

Puis cette commande (ou alors accéder à cet url sur votre navigateur) sur un second terminal : 
```bash
xdg-open http://localhost:8080/pages/index.php
```

Et enfin cette commande toujours sur le second terminal : 
```bash
java -classpath java/json-20140107.jar:java CodeAnalyse
```

Ainsi, vous allez démarrer le serveur PHP, puis ouvrir le bon URL ensuite démarrer le serveur Java.