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

 
if (session_start() != PHP_SESSION_ACTIVE)
    session_start();

require '../bdd.php';

// fonction pour upload l'image dans le dossier asset
$data = json_decode($_POST['data'], true);

if (!is_connected_db())
    connect_db();

if (!roleUSer($_SESSION['user']['id'], ADMIN))
    header('/pages/index.php?error=You are not admin');


/* faire fonction move_uploaded_file pour l'image */

/* add the dataC */
try {
    $idDataC = createDataC($data['titre'], $data['startDate'],$data['endDate'], $data['image'], $data['description']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit(1);
}


/* add all the subject */
foreach ($data['subjects'] as $subject) {
    try {
        createSubject($idDataC, $subject['name'], $subject['description']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit(1);
    }
}

echo "Success: JE SUIS UN HOMME HEUREUX";