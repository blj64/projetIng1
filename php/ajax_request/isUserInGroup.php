<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   Project name                                       :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 17:33:51 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file isUserInGroup.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 17:33:51
 *
 *  @brief 
 *
 *
 */


if (session_status() == PHP_SESSION_NONE) 
    session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db())
{
    try {
        connect_db();
    } catch (Exception $e) {
        echo "Erreur lors de la connexion à la base de donnée";
        exit(1);
    }
}

if (!isset($_POST['login']) )
{
    echo "Erreur lors de la récupération des données";
    exit(1);
}

$user = getUserByEmail($_POST['login']);

if(!isset($user))
{
    echo "Error: User do not existe";
    exit(0);
}

if(!roleUser($user['id'], STUDENT))
{
    echo "Error: User is not a student";
    exit(1);
}

$group = getGroupByStudentId($user['id']);
if(!isset($group))
{
    echo "Error: User already in a group";
    exit(0);
}

echo "Success:".$_SESSION['user']['group'];