<?php
/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 11:01:48 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file addForm.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Thu 01 June 2023 - 11:01:48
 *
 *  @brief 
 *
 *
 */

if (session_status() == PHP_SESSION_NONE) 
    session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

if (!is_connected_db())
{
    try {
        connect_db();
    } catch (Exception $e) {
        echo "Erreur lors de la connexion à la base de donnée";
        exit(1);
    }
}

if (!isset($_POST['idDataC']) || !isset($_POST['url']) || !isset($_POST['startDate']) || !isset($_POST['endDate']))
{
    echo "Erreur lors de la récupération des données";
    exit(1);
}

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])){
    header('Location: /pages/connexion.php?error=Vous devez être connecté pour accéder à cette page');
    exit(1);
}

if (!roleUser($_SESSION['user']['id'], MANAGER))
{
    header('Location: /pages/acceuil.php?error=Vous n\'avez pas les droits pour accéder à cette page');
    exit(1);
}


try {
    createFormulaire($_POST['idDataC'], $_POST['url'], $_POST['startDate'], $_POST['endDate']);
} catch (Exception $e) {
    echo "Erreur lors de la création du formulaire";
    exit(1);
}

echo "Success: Formulaire créé avec succès";