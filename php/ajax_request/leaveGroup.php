<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   Project name                                       :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 21:36:52 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file leaveGroup.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 21:36:52
 *
 *  @brief 
 *
 *
 */

session_start();

if (!isset($_POST['idGroup']) || !isset($_POST['idUser']))
{
    echo "error : missing data";
    exit();
}

require ('../bdd.php');

if (!is_connected_db())
{
    try {
        connect_db();
    } catch (Exception $e) {
        echo "error : " . $e->getMessage();
        exit();
    }
}

$idGroup = $_POST['idGroup'];
$id = $_POST['idUser'];

$request = "DELETE FROM `In` WHERE idGroup = $idGroup AND idUser = $id";

try {
    request_db(DB_ALTER, $request);
} catch (Exception $e) {
    echo "error : " . $e->getMessage();
    exit();
}

if ($_SESSION['user']['id'] == $id)
    unset($_SESSION['user']['group']);
    
echo "Success";