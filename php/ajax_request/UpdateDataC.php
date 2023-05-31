<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 31/05/2023 17:47:56 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file UpdateDataC.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Wed 31 May 2023 - 17:47:56
 *
 *  @brief 
 *      Update a dataC from the database
 *
 */

if ($_SERVER['REQUEST_METHOD'] != 'POST')
    exit(0);

if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db())
    connect_db();

$_POST = json_decode($_POST['data'], true);

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id']) || !isset($_POST['idDataC']) || (!roleUser($_SESSION['user']['id'], ADMIN) && !roleUser($_SESSION['user']['id'], MANAGER)))
{
    echo "error : not connected or bad rights";
    exit(0);
}

try {
    $request = "UPDATE DataChallenge SET name = '".$_POST['name']."', description = '".$_POST['description']."', startDate = '".$_POST['startDate']."', endDate = '".$_POST['endDate']."' WHERE `idDataC` = ".$_POST['idDataC'];
    request_db(DB_ALTER, $request);
} catch (Exception $e) {
    echo "error : " . $e->getMessage();
}

$sub = getSubjectsByIdChallenge($_POST['idDataC']);
$count = 0;
foreach($sub as $key => $subject)
{
    try {
        $request = "UPDATE Subject SET name = '".$_POST['subjects'][$count]['name']."', description = '".$_POST['subjects'][$count]['description']."' WHERE idSubject = ".$subject['idSubject'];
        request_db(DB_ALTER, $request);
        $count++;
    } catch (Exception $e) {
        echo "error : " . $e->getMessage();
    }
}

echo "Success";