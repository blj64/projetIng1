<?php

require_once("bdd.php");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /pages/myGroup.php#Rendu?error=method");
    exit();
}

/* Start session if needed */
if ( session_status() != PHP_SESSION_ACTIVE )
    session_start();

/* connect to the database if needed */
if ( !is_connected_db() )
    try {
        connect_db();
    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

$id = $_SESSION["user"]["id"];
try {
    $student = getStudentByIdUser($id);

} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$json = $_POST[0];

try {
    updateStudentJson($student["0"]["idUser"], $json);
} catch (Exception $e){
    echo $e->getMessage();
    exit();
}
