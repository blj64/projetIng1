<?php

/*!
 *  \file subjects.php
 *  \author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 14:11:15
 *
 *  \brief
 *      This file handles the data of the different subjects of a given data challenge.
 * 
 */

/* **************************************************************************** */
/*                          GLOBAL VARIABLES                                    */
// maybe static $json;

/* **************************************************************************** */

/*
 *  *fn function alterDescDataC($idDataC, $newDesc)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 14:22:00
 * */
/**
 * brief send a request to alter the `User` table
 * @param $idDataC : the id of the data challenge to which the description is updated
 * @param $newDesc : the new description of the data challenge
 * @return true if the description was altered successfully
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function alterDescDataC($idDataC, $newDesc) {
    $s = "Error alterDescDataC : ";
    $json = file_get_contents("../json/subjects.json");

    if (!$json) {
        throw new Exception("" . $s . "unable to read data.");
    }
    $obj = json_decode($json, true);

    if ($obj == null) {
        throw new Exception("" . $s . "unable to decode json");
    }
    $dataC = $obj['dataC'];
    $check = false;
    $i = 0;

    try {
        $nb_dataC = count($dataC);
    } catch (Exception $e) {
        throw new Exception("" . $s . $e->getMessage());
    }
    
    while ($i < $nb_dataC && !$check) {
        if ($dataC[$i]['idDataC'] == $idDataC) {
            $dataC[$i]['description'] = $newDesc;
            $check = !$check;
        }
        $i++;
    }

    $obj = json_encode($dataC);

    if (!$obj) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents("../json/subjects.json", $obj);

    if (!$json) {
        throw new Exception("" . $s . "unable to write in file");
    }

    return(true);
}

/*
 *  *fn function alterDescSubject($idDataC, $idSubject, $newDesc)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 15:46:50
 * */
/**
 * brief send a request to alter the `User` table
 * @param $idDataC   : the id of the data challenge linked to the given subject
 * @param $idSubject : the id of the subject to which the description is updated
 * @param $newDesc   : the new description of the data challenge
 * @return true if the description was altered successfully
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function alterDescSubject($idDataC, $idSubject, $newDesc) {
    $s = "Error alterDescSubject : ";
    $json = file_get_contents("../json/subjects.json");

    if (!$json) {
        throw new Exception("" . $s . "unable to read data");
    }
    $obj = json_decode($json, true);

    if ($obj == null) {
        throw new Exception("" . $s . "unable to decode json");
    }
    $dataC = $obj['dataC'];
    $check = false;
    $i = 0;

    try {
        $nb_dataC = count($dataC);
    } catch (Exception $e) {
        throw new Exception("" . $s . $e->getMessage());
    }

    while ($i < $nb_dataC && !$check) {
        if ($dataC[$i]['idDataC'] == $idDataC) {
            /* Check if the id of the subject entered as a parameter is a valid one */
            $nb_subjects = $dataC[$i]['nbSubjects'];
            if ($idSubject <= $nb_subjects && 0 < $idSubject) {
                throw new Exception("" . $s . "the id of the subject is not valid");
            }
            $subjects = $dataC[$i]['subjects'];
            $subjects[$idSubject - 1]['description'] = $newDesc;
            $check = !$check;
        }
        $i++;
    }

    $obj = json_encode($dataC);

    if (!$obj) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents("../json/subjects.json", $obj);

    if (!$json) {
        throw new Exception("" . $s . "unable to write in file");
    }

    return(true);
}

