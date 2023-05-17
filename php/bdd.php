<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IAPAU                                              :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 16/05/2023 15:00:15 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/*! 
 *  \file bdd.php
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Tue 16 May 2023 - 15:00:15
 *
 *  \brief 
 *      This file contains the database connection and the functions to interact with it.
 *
 */

/* **************************************************************************** */
/*                          DEFINE                                             */

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "IAPAU");
    
/* **************************************************************************** */
/*                          GLOBAL VARIABLES                                    */
static $bdd;

/* **************************************************************************** */
/*                          FUNCTIONS                                           */

/** 
 *  fn function connect_db($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Tue 16 May 2023 - 15:01:37
 *  @brief connect to a database
 *  @param $host   : the host of the database
 *  @param $user   : the user of the database
 *  @param $pass   : the password of the database
 *  @param $db     : the name of the database
 *  @return true if the connection is successful, false otherwise
 *  @remarks if no parameters are given, the function will use the default values of DEFINE
 */
function connect_db($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME) : bool {
    global $bdd;

    $bdd = mysqli_connect($host, $user, $pass, $db);

    if (mysqli_connect_errno()) 
        throw new Exception("Échec de la connexion : " . mysqli_connect_error());
    
    return (true);
}

/* -------------------------------------------------------------------------- */

/**
 *  fn function is_connected_db()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Tue 16 May 2023 - 15:06:18
 *  @brief check if the database is connected
 *  @param [global] $bdd   : the database connection
 *  @return true if the database is connected, false otherwise
 *  @remarks if no parameters are given, the function will use the global variable $bdd
 */
function is_connected_db() : bool{
    global $bdd;
    return (isset($bdd) && $bdd != NULL);
}

/* -------------------------------------------------------------------------- */

/**
 *  *fn function disconnect_db()
 *  *author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  *version 0.1
 *  *date Tue 16 May 2023 - 15:05:34
 *  @brief disconnect from the database
 *  @param [global] $bdd   : the database connection
 *  @return true if the disconnection is successful
 *  @remarks neeed to call connect_db() before
 */
function disconnect_db() : bool {
    global $bdd;

    if ( !is_connected_db() )
        throw new mysqli_sql_exception("bdd not connected.");

    mysqli_close($bdd);

    if (is_connected_db())
        throw new mysqli_sql_exception("bdd not disconnected.");
    
    return (true);
}

/* -------------------------------------------------------------------------- */
/*
 *
 *  *fn function request_db($request)
 *  *author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  *version 0.1
 *  *date Tue 16 May 2023 - 15:58:42
 * */
/**
 *  brief send a request to the database
 *  @param $request   : the request to send
 *  @return array w/ the result of the request
 *  @remarks throw an exception if the request is not valid
 */
function request_db($request = NULL) : array {
    global $bdd;

    if ( !is_connected_db() )
        throw new mysqli_sql_exception("bdd not connected.");

    if ( !isset($request) )
        throw new mysqli_sql_exception("request not set.");

    $queryR = mysqli_query($bdd, $request);

    if ( !$queryR )
        throw new mysqli_sql_exception("request not valid.");

    $result = array();
    while ($row = mysqli_fetch_assoc($queryR))
        $result[] = $row;
    
    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function GetAllUsers()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 09:48:15
*/
/**
 *  brief get all users from the database 
 *  @param none
 *  @return array w/ all users
 *  @remarks throw an exception if the request is not valid
 */
function GetAllUsers() : array {
    $request = "SELECT * FROM users";
    try {
        $result = request_db($request);
    } catch (Exception $e) {
        throw new Exception("Error GetAllUsers : " . $e->getMessage());
    }
    
    /* return an array of users */
    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getUserByEmail($email)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 09:51:43
*/
/**
 *  brief get a user from the database by his email
 *  @param $email   : the email of the user
 *  @return array w/ the data of the user
 *  @remarks throw an exception if the request is not valid
 */
function getUserByEmail($email) : array {
    $request ="SELECT * FROM users WHERE email = '$email'";
    
    try {
        $result = request_db($request);
    } catch (Exception $e) {
        throw new Exception("Error GetUsersByEmail : " . $e->getMessage());
    }

    /* check if the user exists and is unique */
    $count = count($result);
    if ($count == 0)
        throw new Exception("Error GetUsersByEmail : no user found.");

    if ($count > 1)
        throw new Exception("Error GetUsersByEmail : more than one user found. (<=> more than 1 user w/ the same email)");

    /* return the first (and only) user */
    return ($result[0]);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getAllAdmin()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 09:59:24
*/
/**
 *  brief 
 *  @param 
 *  @return 
 *  @remarks 
 */
function getAllAdmin() {
    $request = "Select * FROM users WHERE id IN (SELECT idUser FROM Admin)";

    try {
        $result = request_db($request);
    } catch (Exception $e) {
        throw new Exception("Error getAllAdmin : " . $e->getMessage());
    }

    return ($result);
}
?>