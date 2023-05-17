<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IAPau                                              :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 17/05/2023 10:23:51 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file inscription.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Wed 17 May 2023 - 10:23:51
 *
 *  @brief 
 *      sign up user in the database
 *      check if the email is already used => user already exists
 *
 */

/* *************************************************************************** */
/*                                    INCLUDE                                  */

require_once("bdd.php");

/* *************************************************************************** */
/*                                    FUNCTIONS                                */


/* *************************************************************************** */
/*                                    MAIN                                     */

/* Start session if needed */
if( session_status() != PHP_SESSION_ACTIVE )
    session_start();

/* connect to the database if needed */
if ( !is_connected_db() )
    try {
        connect_db();
    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

/* check if the user exists and is unique */
try {
    $exist = ExistUserByEmail($_POST['email']);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

/* if the user exists, redirect to the login page */
if ($exist) {
    header("Location: /pages/login.php?error=EMAIL_ALREADY_USED");
    exit();
}

/* if the user doesn't exist, create it */
try {
    /* create the user 
     *  =============================================
     * 
     * C'EST ICI QU'IL FAUDRA MODIFER LE POST EN FONCTION DU FORMULAIRE
     * 
     *  =============================================
     */
    $result = CreateUser($_POST['firstname'], $_POST['lastname'], $_POST['password'], $_POST['number'], $_POST['email']);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

/* redirect to a page */
/* A MODIFER */
header('Location: /pages/login.php?success=USER_CREATED');
exit();
?>