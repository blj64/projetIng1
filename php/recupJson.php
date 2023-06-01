<?php

require_once("bdd.php");


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
    $result = existJsonFromStudent($student["0"]["idUser"]);
    echo($result[0]["json"]);
} catch (Exception $e){
    echo $e->getMessage();
    exit();
}
