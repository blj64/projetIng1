<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 31/05/2023 23:58:48 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file currentUserTeam.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Wed 31 May 2023 - 23:58:48
 *
 *  @brief 
 *      return the current user team (null if not in a team)
 *
 */

require_once('../bdd.php');

if (!is_connected_db())
    connect_db();


if(!isset($_POST['idUser'])){
    echo "error : missing idUser";
    exit();
}



$idUser = $_GET['idUser'];

try{
    $team = getGroupByStudentId($idUser);

    if($team)
        echo "Success :" . var_dump($team);
    else
        echo "Success :null";
} catch (Exception $e){
    echo "Error : " . $e->getMessage();
}

