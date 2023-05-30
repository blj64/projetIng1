<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 30/05/2023 10:39:05 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file createChallenge.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Tue 30 May 2023 - 10:39:05
 *
 *  @brief 
 *
 *
 */

 if ($_SERVER['REQUEST_METHOD'] != 'POST')
 {
     echo "Error: wrong request method";
     exit(1);
 }

 
if (session_start() == PHP_SESSION_NONE)
    session_start();

require '../bdd.php';

var_dump($_POST);
exit(0);

if (!roleUSer($_SESSION['user']['id'], ADMIN))
    header('/pages/index.php?error=You are not admin');

if (!is_connected_db())
    connect_db();

/* faire fonction move_uploaded_file pour l'image */

/* add the dataC */
try {
    $idDataC = createDataC($_POST['name'], $_POST['startDate'],$_POST['endDate'], $_POST['image'], $_POST['description']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit(1);
}


/* add all the subject */
/*
foreach ($_POST['subject'] as $subject) {
    try {
        createSubject($idDataC, $subject);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit(1);
    }
}
*/