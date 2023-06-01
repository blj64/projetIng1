<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 00:04:33 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file currentUser.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 00:04:33
 *
 *  @brief 
 *
 *
 */

if($_SERVER['REQUEST_METHOD'] !== 'GET')
    exit();

if(session_status() == PHP_SESSION_NONE)
    session_start();

require_once('../bdd.php');

if (!is_connected_db())
    connect_db();

if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])){
    echo "error : missing user";
    exit();
}

echo "Success :" . $_SESSION['user']['id'];

if(roleUser($_SESSION['user']['id'], ADMIN))
{
    echo ":ADMIN";
    exit();
}
else if (roleUser($_SESSION['user']['id'], MANAGER))
{
    echo ":MANAGER";
    exit();
}
else if (roleUser($_SESSION['user']['id'], STUDENT))
{
    echo ":STUDENT";
    exit();
}
else
    echo ":USER";
    