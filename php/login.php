<?php
/* check if the method is POST */
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /pages/signIn.php?error=method");
    exit();
}


/* do the stuff */
require "./bdd.php";
$login = $_POST['login'];
$pwd = $_POST['password'];

if (SESSION_STATUS() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['old']['login'] = $_POST['login'];
$_SESSION['error'] = array();
$errEmpty = "Please complete this field.";

/* Case of empty fields */
if (empty($login)) {
    $_SESSION['error']['login'] = $errEmpty;
}
if (empty($pwd)) {
    $_SESSION['error']['pwd'] = $errEmpty;
}

/* if a field is empty, the user is redirected to the login page */
if (isset($_SESSION['error']['login']) || isset($_SESSION['error']['pwd'])) {
    header("Location: /pages/signIn.php?error=empty_fields");
    exit();
}

/* Case of completed fields */
/* Verification of the database connection */
if (!is_connected_db()) {
    try {
        connect_db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    } catch (Exception $e) {
        header("Location: /pages/signIn.php?error=connect_db line 32 : " . $e->getMessage());
        exit();
    }
}

/* Verify if the user is registered */
/* if the user is not registered, he is redirected to the login page */
if (!existUserByEmail($login)) {
    $_SESSION['error']['login'] = "The login is incorrect.";
    header("Location: /pages/signIn.php?error=UserDoNotExist");
    exit();
}

/* get the user */
try {
    $result = request_db(DB_RETRIEVE, "SELECT * FROM `User` WHERE `email` = '$login'");
} catch (Exception $e) {
    header("Location: /pages/signIn.php?error=request_db line 49 : " . $e->getMessage());
    exit();
}

/* Case there is no User w/ that email */
if (!isset($result[0])) {
    $_SESSION['error']['login'] = "The login is incorrect";
    header("Location: /pages/signIn.php?error=IncorrectLogin");
    exit();
}

/* Check the issue of several users with the same registered email */
try {
    isUnique($result);
} catch (Exception $e) {
    echo $e->getMessage();
    header("Location: /pages/signIn.php?error=isUnique line 64 : " . $e->getMessage());
    exit();
}

/* Case the password is incorrect */
if (!password_verify("$pwd", $result[0]["password"])) {
    $_SESSION['error']['pwd'] = "The password is incorrect";
    header("Location: /pages/signIn.php?error=IncorrectPassword");
    exit();
}

unset($_SESSION['user']);
$_SESSION['user']["id"] = $result[0]["id"];
$_SESSION['user']["login"] = $result[0]["email"];

/* check if the user is a student and has a group */
/* check if the user has a group */
if (roleUser($result[0]['id'], STUDENT))  {
    /* get the student intels */
    
    $request =
    "SELECT `idGroup` FROM `In` WHERE `idUser` = " . $result[0]["id"];
    
    try {
        $student = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        header("Location: /pages/signIn.php?error=request_db line 86 : " . $e->getMessage());
        exit();
    }
    $_SESSION['user']["group"] = $student[0]["idGroup"];
}

unset($_SESSION['old']);
unset($_SESSION['error']);

header("Location: /pages/accueil.php");
