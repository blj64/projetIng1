<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 23:23:04 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file modifProfil.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 23:23:04
 *
 *  @brief 
 *      This file is used to modify the user's profile.
 *
 */

require ('bdd.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!is_connected_db())
{
    try {
        connect_db();
    } catch (Exception $e) {
        echo $e;
    }
}


try {
    alterUser_db($_SESSION['user']['id'], $_POST['firstname'], $_POST['lastname'], null ,$_POST['number'], $_POST['email']);
    if($_POST['email'] != "")
        $_SESSION['user']['login'] = $_POST['email'];   
} catch (Exception $e) {
    echo $e;
}

if (roleUser($_SESSION['user']['id'], STUDENT))
{
    try {
        alterStudent_db($_SESSION['user']['id'], null, null, $_POST['lvStudy'], $_POST['school'], $_POST['city']);
    } catch (Exception $e) {
        echo $e;
    }
}
else if (roleUser($_SESSION['user']['id'], MANAGER))
{
    try {
        alterManager_db($_SESSION['user']['id'], $_POST['company'], null, null);
    } catch (Exception $e) {
        echo $e;
    }
}

header("Location: /pages/profil.php");
