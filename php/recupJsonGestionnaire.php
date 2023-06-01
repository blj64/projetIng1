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

$id = $_POST["0"];
try {
    $students = getStudentsGroup($id);
    foreach ($students as $student){
        if($student["leader"] === true){
            $idLeader = $student["id"];
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}


try {
    $result = existJsonFromStudent($idLeader);
    echo($result[0]["json"]);
} catch (Exception $e){
    echo $e->getMessage();
    exit();
}
