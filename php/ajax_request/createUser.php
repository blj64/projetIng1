<?php
/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 31/05/2023 01:04:45 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file createUser.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Wed 31 May 2023 - 01:04:45
 *
 *  @brief 
 *      create a user in the database
 *
 */

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo "Error: wrong request method";
    exit(1);
}

if (!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['number']) || !isset($_POST['password']))
{
    echo "Error: missing parameters";
    exit(1);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db())
    connect_db();

if (session_status() == PHP_SESSION_NONE)
    session_start();

if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id']))
{
    echo "Error: you are not log in !";
    exit(1);
}

if (!roleUser($_SESSION['user']['id'], ADMIN))
{
    echo "Error: you are not allowed to do this";
    exit(1);
}

try {
    $id = createUser($_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['number'], $_POST['email']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit(1);
}

echo "Success: user created with id :" . $id; 