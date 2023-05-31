<?php
/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 31/05/2023 16:00:16 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file deleteDataC.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Wed 31 May 2023 - 16:00:16
 *
 *  @brief 
 *      Delete a dataC from the database
 *
 */

if ($_SERVER['REQUEST_METHOD'] != 'POST')
    exit(0);

if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db())
    connect_db();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id']) || !isset($_POST['idDataC']) || !roleUser($_SESSION['user']['id'], ADMIN))
{
    echo "error : not connected or bad rights";
    exit(0);
}

try {
    $request = "DELETE FROM DataChallenge WHERE idDataC = ".$_POST['idDataC'].";";
    request_db(DB_ALTER, $request);
    echo "Success";
} catch (Exception $e) {
    echo "error : " . $e->getMessage();
}