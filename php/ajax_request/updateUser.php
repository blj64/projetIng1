<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 28/05/2023 17:02:29 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file updateUser.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Sun 28 May 2023 - 17:02:29
 *
 *  @brief 
 *
 *
 */

if (!isset($_POST['id']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['role']) || !isset($_POST['number']) || !isset($_POST['firstName']) )
{
    echo "Error: missing parameters";
    exit(1);
}

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo "Error: wrong request method";
    exit(1);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db())
    connect_db();

if (session_status() == PHP_SESSION_NONE)
    session_start();

try {
    alterUser_db($_POST['id'], $_POST['firstName'], $_POST['lastName'], null , $_POST['number'], $_POST['email']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit(1);
}

if(roleUser($_SESSION['user']['id'], STUDENT))
    try {
        alterStudent_db($_POST['id'], null, $_POST['lvStudy'], $_POST['school'] , $_POST['city']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit(1);
    }
else if(roleUser($_SESSION['user']['id'], MANAGER))
{
    try {
        alterManager_db($_POST['id'], $_POST['company'], $_POST['startDate'], $_POST['endDate']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit(1);
    }
}

echo "Success: user updated";