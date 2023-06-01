<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 01:17:07 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file signStudent.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 01:17:07
 *
 *  @brief 
 *      sign a student to a team
 *      -- if the user is a student, sign him to the team and update his informations
 */

define("EMPTY_STRING", "");


if($_SERVER['REQUEST_METHOD'] !== 'POST')
    exit();

if(session_status() == PHP_SESSION_NONE)
    session_start();

require_once('./bdd.php');

if (!is_connected_db())
    connect_db();

if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])){
    echo "error : missing user";
    exit();
}

/* check if we create a new group */
$newGroup = null;
if( isset($_POST['teamName']) && $_POST['teamName'] != EMPTY_STRING)
{
    try {
        $newGroup = createGroup($_POST['teamName'], $_POST['idDataC'], null);
        $_SESSION['user']['group'] = array('id' => $newGroup, 'group' => $_POST['teamName'], "login" => $_SESSION['user']['login']);
    } catch (Exception $e) {
        echo "Error : " . $e->getMessage();
        exit();
    }
}

/* create / update the student */
if (roleUser($_POST['id'], STUDENT))
{
    try {
        alterStudent_db($_POST['id'], null, null , $_POST['lvlStudy'], $_POST['school'], $_POST['city']);
        if ($newGroup != null)
            createIn($_POST['id'], $newGroup);
    } catch (Exception $e) {
        echo "Error : " . $e->getMessage();
        exit();
    }
}
else
{
    $test = $_POST['id'];
    $request = "UPDATE `Group` SET `idLeader` = '$test' WHERE `id` = '$newGroup'";
    try {
        createStudent($_POST['id'], $newGroup,  $_POST['lvlStudy'], $_POST['school'], $_POST['city']);
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        echo "Error : " . $e->getMessage();
        exit();
    } 
}
echo "Success";
header("Location: /pages/accueil.php");
exit();
