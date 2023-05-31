import java.io.*;
import java.util.Objects;
import java.util.Stack;

import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;

import java.io.IOException;
import java.io.OutputStream;
import java.net.InetSocketAddress;
import java.util.concurrent.Executors;
import java.util.concurrent.ThreadPoolExecutor;
import java.util.logging.Logger;
import java.io.BufferedReader;

import com.sun.net.httpserver.HttpServer;
import org.json.*;


public class CodeAnalyse {
    /**
     * permet de gérer les messages émis durant l'exécution du serveur
     */
    private static final Logger LOGGER = Logger.getLogger(CodeAnalyse.class.getName());
    /**
     * url de base du service
     */
    private static final String SERVEUR = "localhost";
    /**
     * port serveur
     */
    private static final int PORT = 8081;
    /**
     * url de base du service
     */
    private static final String URL = "/endpoint";

    /**
     * String correspondant au chemin vers le fichier Python
     */
    private final String path;
    /**
     * File correspondant au fichier Python
     */
    private final File file;
    /**
     * BufferedReader permettant de lire le fichier
     */
    private BufferedReader br;
    /**
     * Entier correspondant au nombre de lignes du fichier
     */
    private int nb_lignes;
    /**
     * Tableau de tableaux de String correspondant au texte complet pour pouvoir accéder à chaque ligne et à chaque mot de chaque ligne
     */
    private final String[][] text;


    /**
     * Constructeur de la classe
     *
     * @param fileInsert : Objet de type File permettant à l'utilisateur d'instancier sa classe à partir de son fichier
     * @throws IOException Exception due à la gestion de fichier(s)
     */
    public CodeAnalyse(File fileInsert) throws IOException {
        file = fileInsert;
        path = fileInsert.getPath();
        br = new BufferedReader(new FileReader(file));
        taille_texte();
        text = new String[nb_lignes][];
        splitTab();
    }

    /**
     * Constructeur de la classe
     *
     * @param pathname : Objet de type String permettant à l'utilisateur d'instancier sa classe à partir du chemin de son fichier
     * @throws IOException Exception due à la gestion de fichier(s)
     */
    public CodeAnalyse(String pathname) throws IOException {
        file = new File(pathname);
        path = pathname;
        br = new BufferedReader(new FileReader(file));
        taille_texte();
        text = new String[nb_lignes][];
        splitTab();
    }

    /**
     * Fonction permettant d'accéder à l'attribut nb_lignes
     *
     * @return le nombre de lignes
     */
    public int getNb_lignes() {
        return nb_lignes;
    }

    /**
     * Procédure permettant de séparer le texte mots par mots au sein d'un tableau de String de 2 dimensions
     *
     * @throws IOException Exception due à la gestion de fichier(s)
     */
    private void splitTab() throws IOException {
        resetBufferedReader();
        String st;
        int indice = 0;

        /* On parcourt toutes les lignes du texte du BufferedReader */
        while ((st = br.readLine()) != null) {
            text[indice] = new String[st.length()]; // On crée des sous tableaux de tailles différentes correspondantes à la taille de chaque ligne
            text[indice] = st.split(" "); // On coupe la ligne mots par mots
            indice++;
        }
        br.close();
    }

    /**
     * Procédure permettant de réinitialiser le BufferedReader permettant de revenir au début du texte (opération utile à la procédure splitTab())
     *
     * @throws FileNotFoundException Exception due à l'absence d'un fichier
     */
    private void resetBufferedReader() throws FileNotFoundException {
        br = new BufferedReader(new FileReader(file));
    }

    /**
     * Procédure permettant d'avoir la taille totale du texte, en comptant les lignes de code, les commentaires, etc.
     *
     * @throws IOException Exception due à la gestion de fichier(s)
     */
    private void taille_texte() throws IOException {
        nb_lignes = 0;
        /* On parcourt toutes les lignes du texte */
        while ((br.readLine()) != null) {
            nb_lignes++; // On compte le nombre de lignes du document
        }
        br.close();
    }

    /**
     * Fonction permettant de savoir si une ligne, dont l'indice est passé en paramètre, est vide ou non
     *
     * @param i : entier représentant l'indice de la ligne
     * @return vrai ou faux selon si la ligne est vide ou non
     */
    private boolean ligne_vide(int i) {
        boolean vide = true;

        /* On parcourt toute la ligne mot par mot et on vérifie si la ligne est vide*/
        for (int j = 0; j < text[i].length; j++) {
            if (!Objects.equals(text[i][j], "")) { // Si tous les mots sont des caractères vides : "", alors la ligne est vide
                vide = false; // On met à faux si un caractère/mot diffère du caractère vide : ""
            }
        }
        return vide;
    }

    /**
     * Fonction permettant d'obtenir à la position du mot "def" au sein d'une ligne donnée.
     * La fonction étant en privée, elle n'est appelée seulement lorsque nous savons que la ligne contient le mot "def" donc il n'y a pas besoin de vérification
     *
     * @param i       : entier représentant l'indice de la ligne
     * @param element : String représentant le mot à trouver dans la ligne
     * @return un entier representation la position du mot au sein de la ligne
     */
    private int pos_element(int i, String element) {
        int pos = 0;
        boolean trouve = false;

        for (int j = 0; j < text[i].length; j++) {
            if (!trouve && Objects.equals(text[i][j], element)) {
                pos = j;
                trouve = true;
            }
        }
        return pos;
    }

    /**
     * Fonction permettant d'avoir un tableau contenant la taille de chaque fonction non commentée
     *
     * @return un tableau d'entier représentant la taille de toutes les fonctions présent au sein du code (non commenté)
     */
    public int[] iteration_fonction() {
        /* On récupère le nombre de fois où le mot "def", correspondant aux fonctions en Python, est présent dans le code */
        int nb = iteration_mot("def");
        Integer compteur = 0; // Création d'un compteur pour chaque fonction
        Stack<Integer> pile_fonction = new Stack<>(); // Création d'une pile d'entier
        int[] liste_fonction = new int[nb]; // Création du tableau d'entier de nb éléments, représentant le nombre de fois où "def" est dans le code
        int j;
        int pos_def;
        /* On parcourt toutes les lignes */
        for (int i = 0; i < text.length; i++) {

            /* Si la ligne n'est pas un commentaire, on continue*/
            if (!commentaire_non_diese(i) && !commentaire_diese(i)) {

                /* Si la ligne contient le mot "def" alors on continue */
                if (contient_element(i, "def")) {
                    pos_def = pos_element(i, "def"); // On récupère la position de "def" au sein de la ligne
                    j = i + 1; // On prend la ligne suivante
                    compteur++; // On incrémente le compteur

                    /* Tant que la position de "def" existe dans la ligne j et que le mot est égal au caractère vide "" alors on va à la ligne suivante */
                    while (pos_def <= text[j].length && Objects.equals(text[j][pos_def], "")) {
                        j++;
                    }

                    /* On parcourt toutes les lignes de i+1 à j et on regarde si les lignes ne sont pas vides. Si c'est le cas, on incrémente le compteur */
                    for (int k = i + 1; k < j; k++) {
                        if (!ligne_vide(k)) {
                            compteur++;
                        }
                    }
                    pile_fonction.push(compteur); // On empile la pile avec la valeur du compteur
                    compteur = 0; // On remet à 0 le compteur pour la prochaine fonction
                }
            }
        }



        /* On stock toutes les valeurs de la pile au sein d'un tableau */
        int i = 0;
        while (!pile_fonction.empty()) {
            liste_fonction[i] = pile_fonction.peek();
            pile_fonction.pop();
            i++;
        }
        return liste_fonction; // On retourne le tableau d'entier
    }

    /**
     * Fonction permettant d'avoir la taille de la plus grande fonction du code source
     *
     * @return un entier représentant la taille de la fonction la plus grande
     */
    public int max_ligne_fonction() {
        /* On récupère la liste des fonctions et on retourne le plus grand élément */
        int[] liste_fonction = iteration_fonction();
        int max = 0;
        for (int i = 0; i < liste_fonction.length; i++) {
            if (max < liste_fonction[i]) {
                max = liste_fonction[i];
            }
        }
        return max;
    }

    /**
     * Fonction permettant d'avoir la taille de la plus petite fonction du code source
     *
     * @return un entier représentant la taille de la fonction la plus petite
     */
    public int min_ligne_fonction() {
        /* On récupère la liste des fonctions et on retourne le plus petit élément */
        int[] liste_fonction = iteration_fonction();
        int min = liste_fonction[0];
        for (int i = 1; i < liste_fonction.length; i++) {
            if (min > liste_fonction[i]) {
                min = liste_fonction[i];
            }
        }
        return min;
    }

    /**
     * Fonction permettant d'avoir la moyenne des tailles des fonctions du code source
     *
     * @return un entier représentant la moyenne de toutes les tailles
     */
    public int moyenne_ligne_fonction() {
        /* On récupère la liste des fonctions et on retourne la moyenne des éléments */
        int[] liste_fonction = iteration_fonction();
        int moyenne = 0;
        for (int i = 0; i < liste_fonction.length; i++) {
            moyenne = moyenne + liste_fonction[i];
        }
        return moyenne / liste_fonction.length;
    }

    /**
     * Procédure permettant d'afficher le tableau contenant les tailles des fonctions
     */
    public void afficher_iteration_fonction(boolean nom) {
        if (nom) {
            String[] liste_fonction = iteration_fonction2();
            String res = "[";
            for (int i = 0; i < liste_fonction.length - 1; i++) {
                res = res + liste_fonction[i] + " ; ";
            }
            res = res + liste_fonction[liste_fonction.length - 1] + "]";
            System.out.println(res);
        } else {
            int[] liste_fonction = iteration_fonction();
            String res = "[";
            for (int i = 0; i < liste_fonction.length - 1; i++) {
                res = res + liste_fonction[i] + " ; ";
            }
            res = res + liste_fonction[liste_fonction.length - 1] + "]";
            System.out.println(res);
        }

    }

    /**
     * Fonction permettant d'avoir le nombre d'apparitions d'un mot dans tout le texte
     *
     * @param mot : String correspondant au mot cherché
     * @return un entier représentant le nombre de d'apparition du mot
     */
    public int iteration_mot(String mot) {
        int compteur = 0;
        /* On parcourt toutes les lignes */
        for (int i = 0; i < text.length; i++) {
            /* Si la ligne n'est pas un commentaire, on va parcourir chaque mot de chaque ligne et compter le nombre de
            fois que le mot passé en paramètre de la fonction est présent au sein du code */
            if (!commentaire_non_diese(i) && !commentaire_diese(i)) {
                for (int j = 0; j < text[i].length; j++) {
                    if (Objects.equals(text[i][j], mot)) {
                        compteur++;
                    }

                }
            }
        }
        return compteur;
    }

    /**
     * Fonction permettant de savoir si une ligne est un commentaire généré par le caractère "#"
     *
     * @param i : Entier correspondant à l'index de la ligne
     * @return vrai ou faux si la ligne est un commentaire ou non
     */
    private boolean commentaire_diese(int i) {
        /* On prend le premier élément non vide de la ligne et on retourne vrai si le caractère est un '#' et faux sinon */
        String s = decomposition_premier_elt(i);
        return s.equals("#");
    }

    /**
     * Fonction permettant de savoir si une ligne est un commentaire généré par le caractère ' " ' ou ' """ '
     *
     * @param i : Entier correspondant à l'index de la ligne
     * @return vrai ou faux si la ligne est un commentaire ou non
     */
    private boolean commentaire_non_diese(int i) {
        /* On prend le premier élément non vide de la ligne et on retourne vrai si le caractère est un '"' et faux sinon */
        String s = decomposition_premier_elt(i);
        return s.equals("\"");
    }

    /**
     * Fonction permettant de savoir si une ligne précise contient ou non un élément
     *
     * @param i       : entier représentant la position de la ligne dans le texte
     * @param element : String représentant le mot ou le caractère à chercher dans la phrase
     * @return vrai ou faux selon si l'élément se trouve dans la phrase
     */
    private boolean contient_element(int i, String element) {
        boolean contient = false;

        /* On parcourt toute la ligne afin de trouver l'élément passé en paramètre et retourne vrai s'il est dedans, sinon retourne faux */
        for (int j = 0; j < text[i].length; j++) {
            if (Objects.equals(text[i][j], element)) {
                contient = true;
            }
        }
        return contient;
    }

    /**
     * Fonction permettant d'avoir la position du premier élément d'une ligne
     *
     * @param i : entier représentant la position de la ligne dans le texte
     * @return la position du premier élément d'une ligne
     */
    private int position_premier_elt(int i) {
        int res = -1;

        /* On parcourt toutes la ligne et dès qu'on trouve un caractère/mot non vide, on retourne sa position au sein de la ligne */
        for (int j = 0; j < text[i].length; j++) {
            if (!Objects.equals(text[i][j], "")) {
                if (res == -1) {
                    res = j;
                }
            }
        }
        return res;
    }

    /**
     * Fonction permettant d'avoir le nombre de lignes commentées
     *
     * @return le nombre de lignes commentées
     */
    public int nombre_ligne_commentaires() {
        int compteur = 0;

        /* On parcourt toutes les lignes et on compte le nombre de lignes commentées */
        for (int i = 0; i < text.length; i++) {
            if (commentaire_diese(i) || commentaire_non_diese(i)) {
                compteur++;
            }
        }
        return compteur;
    }

    /**
     * Fonction permettant de décomposer le premier élément non vide d'une ligne caractères par caractères
     *
     * @param i : entier représentant la position de la ligne dans le texte
     * @return le premier caractère de la ligne
     */
    private String decomposition_premier_elt(int i) {
        int pos = position_premier_elt(i); // On récupère la position du premier élément

        /* Si la position est différente de -1, cas où la ligne est vide, alors on split le premier mot caractère par caractère et on retourne le premier caractère */
        if (pos != -1) {
            String[] res = text[i][pos].split("");
            return res[0];
        } else {
            return "";
        }
    }

    /**
     * Fonction permettant de décomposer le nom de la fonction situé à la position j de la ligne i
     *
     * @param i : entier représentant la position de la ligne dans le texte
     * @param j : entier représentant la position du mot dans la ligne
     * @return le nom de la fonction
     */
    private String decomposition_nom_fonction(int i, int j) {
        String[] nom = text[i][j].split("");
        int compteur = 0;

        while (!nom[compteur].equals("(")) {
            compteur++;
        }

        String res = "";

        for (int k = 0; k < compteur; k++) {
            res = res + nom[k];
        }

        return res;
    }

    /**
     * Procédure permettant de générer le JSON contenant toutes les data nécessaires
     */
    public void create_JSON_data() {

        /* Récupération de toutes les valeurs nécessaires */
        int taille_max = max_ligne_fonction();
        int taille_min = min_ligne_fonction();
        int taille_moy = moyenne_ligne_fonction();
        int nb_lignes = getNb_lignes();
        int taille_code = getNb_lignes() - nombre_ligne_commentaires();
        int taille_com = nombre_ligne_commentaires();
        int[] fonction = iteration_fonction();
        String[] nom_fonction = iteration_fonction2();


        /* Création de l'objet JSON et insérer les valeurs au sein de celui-ci */
        JSONObject json = new JSONObject();
        json.put("nb_lignes_tot", nb_lignes);
        json.put("nb_lignes_com", taille_com);
        json.put("nb_lignes_code", taille_code);

        JSONArray array = new JSONArray();
        JSONObject item = new JSONObject();
        item.put("nb_fonctions", fonction.length);
        item.put("taille_max", taille_max);
        item.put("taille_min", taille_min);
        item.put("taille_moy", taille_moy);

        JSONObject item2 = new JSONObject();
        String concat;
        for (int i = 0; i < fonction.length; i++) {
            if (item2.has(nom_fonction[i])) {
                concat = nom_fonction[i] + "" + i;
                item2.put(concat, fonction[i]);
            } else {
                item2.put(nom_fonction[i], fonction[i]);
            }
        }
        array.put(item2);
        item.put("tailles_fonctions", array);
        json.put("fonctions", item);


        /* Création du JSON en fonction du path inscrit et gestion de l'erreur si le path est incorrect */
        String path = "./src/data.json";
        try (PrintWriter out = new PrintWriter(new FileWriter(path))) {
            out.write(json.toString());
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * Fonction permettant de générer une chaîne de caractère en format JSON contenant toutes les data nécessaires
     */
    public String create_JSON_data2() {

        /* Récupération de toutes les valeurs nécessaires */
        int taille_max = max_ligne_fonction();
        int taille_min = min_ligne_fonction();
        int taille_moy = moyenne_ligne_fonction();
        int nb_lignes = getNb_lignes();
        int taille_code = getNb_lignes() - nombre_ligne_commentaires();
        int taille_com = nombre_ligne_commentaires();
        int[] fonction = iteration_fonction();
        String[] nom_fonction = iteration_fonction2();


        /* Création de l'objet JSON et insérer les valeurs au sein de celui-ci */
        JSONObject json = new JSONObject();
        json.put("nb_lignes_tot", nb_lignes);
        json.put("nb_lignes_com", taille_com);
        json.put("nb_lignes_code", taille_code);

        JSONArray array = new JSONArray();
        JSONObject item = new JSONObject();
        item.put("nb_fonctions", fonction.length);
        item.put("taille_max", taille_max);
        item.put("taille_min", taille_min);
        item.put("taille_moy", taille_moy);

        JSONObject item2 = new JSONObject();
        String concat;
        for (int i = 0; i < fonction.length; i++) {
            if (item2.has(nom_fonction[i])) {
                concat = nom_fonction[i] + "" + i;
                item2.put(concat, fonction[i]);
            } else {
                item2.put(nom_fonction[i], fonction[i]);
            }
        }
        array.put(item2);
        item.put("tailles_fonctions", array);
        json.put("fonctions", item);


        return json.toString();
    }


    /**
     * Fonction permettant d'avoir un tableau contenant le nom de chaque fonction non commentée
     *
     * @return un tableau de String représentant le nom des fonctions présentes au sein du code (non commenté)
     */
    public String[] iteration_fonction2() {
        /* On récupère le nombre de fois où le mot "def", correspondant aux fonctions en Python, est présent dans le code */
        int nb = iteration_mot("def");
        String nom_fonction;
        Stack<String> pile_fonction = new Stack<String>(); // Création d'une pile d'entier
        String[] liste_nom_fonction = new String[nb]; // Création du tableau d'entier de nb éléments, représentant le nombre de fois où "def" est dans le code
        int pos_def;
        /* On parcourt toutes les lignes */
        for (int i = 0; i < text.length; i++) {

            /* Si la ligne n'est pas un commentaire, on continue*/
            if (!commentaire_non_diese(i) && !commentaire_diese(i)) {

                /* Si la ligne contient le mot "def" alors on continue */
                if (contient_element(i, "def")) {
                    pos_def = pos_element(i, "def"); // On récupère la position de "def" au sein de la ligne
                    nom_fonction = decomposition_nom_fonction(i, pos_def + 1); // On récupère le nom de la fonction

                    pile_fonction.push(nom_fonction); // On empile la pile avec le nom de la fonction
                }
            }
        }

        /* On stock toutes les valeurs de la pile au sein d'un tableau */
        int i = 0;
        while (!pile_fonction.empty()) {
            liste_nom_fonction[i] = pile_fonction.peek();
            pile_fonction.pop();
            i++;
        }
        return liste_nom_fonction; // On retourne le tableau de String des noms des fonctions
    }


    /**
     * Main permettant de lancer le serveur Java permettant la communication entre la partie web et la partie Java
     *
     * @param args : Tableau de String correspondant aux arguments
     */
    public static void main(String[] args) throws IOException {
        /* La partie commentée est un exemple permettant de montrer comment fonctionne la classe en général */

//        CodeAnalyse code = new CodeAnalyse("src/test.py"); // Création de l'instance de ma classe à partir du fichier nommé "test.py"
//
//        /* Première fonction permettant de générer le JSON avec toutes les data nécessaires */
//
//        code.create_JSON_data();
//
//
//
//        /* Deuxième fonction permettant de prendre un mot et d'obtenir le nombre d'itérations de celui-ci */
//
//        int iteration_mot_def = code.iteration_mot("def");
//
//
//
//        /* Démonstration de toutes les fonctions de la classe et les différents affichages */
//
//        System.out.print("Tableau des noms de fonctions : ");
//        code.afficher_iteration_fonction(true); // Affichage des noms de fonctions
//        System.out.print("Tableau des tailles de fonctions : ");
//        code.afficher_iteration_fonction(false); // Affichage des tailles de fonctions
//        System.out.println("Taille maximale : " + code.max_ligne_fonction()); // Affichage de la taille max
//        System.out.println("Taille minimale : " + code.min_ligne_fonction()); // Affichage de la taille min
//        System.out.println("Taille moyenne : " + code.moyenne_ligne_fonction()); // Affichage de la moyenne
//        System.out.println("Nombre de commentaires : " + code.nombre_ligne_commentaires()); // Affichage du nombre de commentaires
//        System.out.println("Nombre de lignes totales : " + code.getNb_lignes()); // Affichage du nombre de lignes totales
//        int taille_code = code.getNb_lignes() - code.nombre_ligne_commentaires();
//        System.out.println("Nombre de lignes de code : " + taille_code); // Affichage du nombre de lignes de code

        HttpServer server = null;
        try {
            server = HttpServer.create(new InetSocketAddress(SERVEUR, PORT), 0);

            server.createContext(URL, new MyHttpHandler());
            ThreadPoolExecutor threadPoolExecutor = (ThreadPoolExecutor) Executors.newFixedThreadPool(10);
            server.setExecutor(threadPoolExecutor);
            server.start();
            LOGGER.info(" Server started on port " + PORT);

        } catch (IOException e) {
            e.printStackTrace();
        }


    }

    public static class MyHttpHandler implements HttpHandler {
        /**
         * Fonction permettant de gérer une requête GET
         *
         * @param httpExchange permet d'encapsuler une requête HTTP reçue et une réponse à générer en un seul échange
         * @return la première valeur de l'url
         */
        private String handleGetRequest(HttpExchange httpExchange) {
            return httpExchange.getRequestURI()
                    .toString()
                    .split("\\?")[1]
                    .split("=")[1];
        }

        /**
         * Procédure permettant de générer une réponse vers une page HTML
         *
         * @param httpExchange      permet d'encapsuler une requête HTTP reçue et une réponse à générer en un seul échange
         * @param requestParamValue représente la valeur à envoyer comme réponse
         * @throws IOException Exception due à la gestion de fichier(s)
         */
        private void handleResponse(HttpExchange httpExchange, String requestParamValue) throws IOException {
            LOGGER.info("J'envoi");
            OutputStream outputStream = httpExchange.getResponseBody();
            httpExchange.getResponseHeaders().add("Access-Control-Allow-Origin", "*");
            httpExchange.getResponseHeaders().add("Access-Control-Allow-Methods", "POST");
            httpExchange.getResponseHeaders().add("Access-Control-Allow-Headers", "Content-Type");
            httpExchange.sendResponseHeaders(200, requestParamValue.length());
            outputStream.write(requestParamValue.getBytes());
            outputStream.flush();
            outputStream.close();
        }

        /**
         * Procédure permettant de gérer la requête HTTP
         *
         * @param httpExchange permet d'encapsuler une requête HTTP reçue et une réponse à générer en un seul échange
         * @throws IOException Exception due à la gestion de fichier(s)
         */
        @Override
        public void handle(HttpExchange httpExchange) throws IOException {
            LOGGER.info("Je reçois");
            String requestParamValue = null;
            if ("GET".equals(httpExchange.getRequestMethod())) {
                LOGGER.info("GET REQUEST");
                requestParamValue = handleGetRequest(httpExchange);
            } else if ("POST".equals(httpExchange.getRequestMethod())) {
                LOGGER.info("POST REQUEST");
                requestParamValue = handlePostRequest(httpExchange);
            }
            handleResponse(httpExchange, requestParamValue);

        }

        /**
         * Fonction permettant de gérer une requête POST
         *
         * @param httpExchange permet d'encapsuler une requête HTTP reçue et une réponse à générer en un seul échange
         * @return une chaîne de caractères en format JSON qui correspond aux data du fichier Python reçu
         */
        private String handlePostRequest(HttpExchange httpExchange) throws IOException {

            // Récupérer l'InputStream du fichier envoyé
            InputStream requestBody = httpExchange.getRequestBody();

            // Créer un fichier temporaire
            File file = File.createTempFile("file", ".txt");

            // Copier le contenu de l'InputStream vers le fichier temporaire
            try (OutputStream outputStream = new FileOutputStream(file)) {
                byte[] buffer = new byte[4096]; // Taille du tampon de lecture
                int bytesRead;
                while ((bytesRead = requestBody.read(buffer)) != -1) {
                    outputStream.write(buffer, 0, bytesRead);
                }
            }

            CodeAnalyse test = new CodeAnalyse(file);

            return test.create_JSON_data2();


        }
    }

}
