<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 30/05/2023 15:39:17 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file uploadImage.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Tue 30 May 2023 - 15:39:17
 *
 *  @brief 
 *
 *
 */

define('DIR', '../../asset/uploaded/');

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo "Error: wrong request method";
    exit(1);
}

$count = 0;
foreach (new DirectoryIterator(DIR) as $file) {
    if($file->isDot()) continue;
    $count++;
}

if (session_start() != PHP_SESSION_ACTIVE)
    session_start();

require '../bdd.php';

// fonction pour upload l'image dans le dossier asset
move_uploaded_file($_FILES['image']['tmp_name'], DIR . $count . $_FILES['image']['name']);

echo "Success :/asset/uploaded/". $count . $_FILES['image']['name'];