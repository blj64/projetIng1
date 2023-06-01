<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 18:20:54 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file changeLeader.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 18:20:54
 *
 *  @brief 
 *
 *
 */


if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db()) {
    try {
        connect_db();
    } catch (Exception $e) {
        echo "Erreur lors de la connexion à la base de donnée";
        exit(1);
    }
}

if(!isset($_POST))
{
    echo "Error: recup data";
    exit(0);
}

$idGroup = $_POST['idGroup'];
$idnew = $_POST['idLeader'];

$request = "UPDATE `Group` SET `idLeader` = '$idnew' WHERE `id` = '$idGroup'";

try {
    request_db(DB_ALTER, $request);
} catch (Exception $e){
    echo "Error:" . $e->getMessage();
}

echo "Success: Leader Change";