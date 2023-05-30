<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 28/05/2023 17:15:23 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file deleteUser.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Sun 28 May 2023 - 17:15:23
 *
 *  @brief 
 *
 *
 */

if (!isset($_POST['id']))
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
    deleteUser($_POST['id']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit(1);
}

echo "Success: user deleted";