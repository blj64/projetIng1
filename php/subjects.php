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

static $jsonFilePath = "../json/subjects.json";

/* **************************************************************************** */
/*                          FUNCTIONS                                           */

/*
 *  *fn function alterDescDataC($idDataC, $newDesc)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 14:22:00
 * */
/**
 * brief update the description of a data challenge
 * @param $idDataC : the id of the data challenge to which the description is updated
 * @param $newDesc : the new description of the data challenge
 * @return true if the description was altered successfully
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function alterDescDataC($idDataC, $newDesc) {
    $s = "Error alterDescDataC : ";
    $json = file_get_contents($jsonFilePath);

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

    /* Case of an invalid id for the data challenge */
    if (!$check) {
        throw new Exception("" . $s . "the id of the data challenge is not valid");
    }

    $obj = json_encode($dataC);

    if (!$obj) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents($jsonFilePath, $obj);

    if (!$json) {
        throw new Exception("" . $s . "unable to write in file");
    }

    return(true);
}

/* **************************************************************************** */

/*
 *  *fn function alterDescSubject($idDataC, $idSubject, $newDesc)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 15:46:50
 * */
/**
 * brief update the description of a subject of a data challenge
 * @param $idDataC   : the id of the data challenge linked to the given subject
 * @param $idSubject : the id of the subject to which the description is updated
 * @param $newDesc   : the new description of the data challenge
 * @return true if the description was altered successfully
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function alterDescSubject($idDataC, $idSubject, $newDesc) {
    $s = "Error alterDescSubject : ";
    $json = file_get_contents($jsonFilePath);

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
        /* Check idDataC to update the correct data challenge */
        if ($dataC[$i]['idDataC'] == $idDataC) {
            $nb_subjects = $dataC[$i]['nbSubjects'];
            $subjects = $dataC[$i]['subjects'];
            /* Check idS of all subjects (up to 3) to update the correct one */
            for ($j = 0; $j < $nb_subjects; $j++) {
                if ($subjects[$j]['idS'] == $idSubject) {
                    $subjects[$j]['description'] = $newDesc;
                    $checkUpdate = true;
                }
            }
            $check = !$check;
        }
        $i++;
    }

    /* Case of an invalid id for the subject */
    if (isset($checkUpdate)) {
        throw new Exception("" . $s . "the id of the subject is not valid");
    }

    $obj = json_encode($dataC);

    if (!$obj) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents($jsonFilePath, $obj);

    if (!$json) {
        throw new Exception("" . $s . "unable to write in file");
    }

    return(true);
}

/* **************************************************************************** */

/*
 *  *fn function getDescDataC($idDataC)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 16:51:45
 * */
/**
 * brief get the description of a data challenge
 * @param $idDataC : the id of the data challenge
 * @return string w/ the description of the given data challenge
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function getDescDataC($idDataC) : string {
    $s = "Error getDescDataC : ";
    $json = file_get_contents($jsonFilePath);

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
            $desc = $dataC[$i]['description'];
            $check = !$check;
        }
        $i++;
    }

    /* Case of an invalid id for the data challenge */
    if (!isset($desc)) {
        throw new Exception("" . $s . "the id of the data challenge is not valid");
    }

    return ($desc);
}

/* **************************************************************************** */

/*
 *  *fn function getDescSubject($idDataC, $idSubject)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 17:02:10
 * */
/**
 * brief get the description of a subject of a data challenge
 * @param $idDataC   : the id of the data challenge
 * @param $idSubject : the id of the subject
 * @return string w/ the description of the given data challenge
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function getDescSubject($idDataC, $idSubject) {
    $s = "Error getDescSubject : ";
    $json = file_get_contents($jsonFilePath);

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
        /* Check idDataC to update the correct data challenge */
        if ($dataC[$i]['idDataC'] == $idDataC) {
            $nb_subjects = $dataC[$i]['nbSubjects'];
            $subjects = $dataC[$i]['subjects'];
            /* Check idS of all subjects (up to 3) to update the correct one */
            for ($j = 0; $j < $nb_subjects; $j++) {
                if ($subjects[$j]['idS'] == $idSubject) {
                    $desc = $subjects[$j]['description'];
                }
            }
            $check = !$check;
        }
        $i++;
    }

    /* Case of an invalid id for the subject */
    if (isset($desc)) {
        throw new Exception("" . $s . "the id of the subject is not valid");
    }

    return ($desc);
}

?>
