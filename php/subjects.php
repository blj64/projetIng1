<?php

require(__DIR__ . '/bdd.php');


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

define ("JSON_FILEPATH", __DIR__ . "../json/subjects.json");

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
    $json = file_get_contents(JSON_FILEPATH);

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

    $obj['dataC'] = $dataC;

    $objE = json_encode($obj);

    if (!$objE) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents(JSON_FILEPATH, $objE);

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
    $json = file_get_contents(JSON_FILEPATH);

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
                    $dataC[$i]['subjects'] = $subjects;
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

    $obj['dataC'] = $dataC;

    $objE = json_encode($obj);

    if (!$objE) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents(JSON_FILEPATH, $objE);

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
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read a file
 */
function getDescDataC($idDataC) : string {
    $s = "Error getDescDataC : ";
    $json = file_get_contents(JSON_FILEPATH);

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
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read a file
 */
function getDescSubject($idDataC, $idSubject) {
    $s = "Error getDescSubject : ";
    $json = file_get_contents(JSON_FILEPATH);

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

/* **************************************************************************** */

/*
 *  *fn function jsonUpdateDataC($idDataC)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 17:02:10
 * */
/**
 * brief update the json file to add a new data challenge or update it and its subjects
 * @param $idDataC : the id of the data challenge
 * @return true if the data challenge was successfully added
 * @remarks throw an exception if the encoding / decoding of the json file fails or if unable to read / write a file
 */
function jsonUpdateDataC($idDataC) {
    $error = "Error jsonUpdateDataC : ";

    require(__DIR__ . '/bdd.php');

    if (!is_connected_db()) {
        try {
            connect_db();
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }
    }

    /* Checking if $idDataC is a valid id */
    $request = 
    "SELECT EXISTS(SELECT * FROM `DataChallenge` WHERE `idDataC` = '$idDataC') AS Res";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    if ($result[0]['Res'] == 0) {
        throw new Exception("" . $error . "this id is not valid one");
    }

    $json = file_get_contents(JSON_FILEPATH);

    if (!$json) {
        throw new Exception("" . $error . "unable to read data");
    }
    $obj = json_decode($json, true);

    if ($obj == null) {
        throw new Exception("" . $error . "unable to decode json");
    }
    $dataC = $obj['dataC'];
    $check = false;
    $i = 0;

    try {
        $nb_dataC = count($dataC);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    while ($i < $nb_dataC && !$check) {
        if ($dataC[$i]['idDataC'] == $idDataC) {
            $row = $i;
            $check = !$check;
        }
        $i++;
    }

    if ($check) {
        /* Case of a data challenge already existing in the json file */
        $nb_subjectsJson = $dataC[$row]['nbSubjects'];
        $subjects = $dataC[$row]['subjects'];

        /* Get the id of the subjects within the database */
        $request = 
        "SELECT `idSubject` FROM `Subject` WHERE `idDataC` = '$idDataC'"; 
        
        try {
            $result = request_db(DB_RETRIEVE, $request);
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }

        try {
            $nb = count($result);
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }

        if ($nb_subjectsJson == 0) {
            /* Case of no subjects for a data challenge in json file */
            for ($i = 0; $i < $nb; $i++) {
                $idSubject = $result[$i]['idSubject'];
                /* Array corresponding to a subject */
                $subject = array();
                $subject['idS'] = $idSubject;
                $subject['name'] = "";
                $subject['description'] = "";
                /* Adding the subject to array obtained from json file */
                $subjects[] = $subject;
            }
            $dataC[$row]['nbSubjects'] = $nb;
            $dataC[$row]['subjects'] = $subjects;
        } else {
            /* Case of some subjects already in json file */
            /* $subject to store subjects for this case */
            $subject = array();
            $nbSubjects = 0;
            for ($i = 0; $i < $nb_subjectsJson; $i++) {
                /* Checking if the id of a subject in json file exists in the database */
                if (in_array($subjects[$i]['idS'], $result['idSubject'])) {
                    /* Case of a subject in the json file existing in the database */
                    $subject[] = $subjects[$i];
                    $nbSubjects++;
                }
            }
            /* Adding subjects in json file */
            for ($i = 0; $i < $nb; $i++) {
                /* Checking if the subject is not already in json file */
                if (!in_array($result[$i]['idSubject'], $subject['idS'])) {
                    /* Adding one subject */
                    $s = array();
                    $s['idS'] = $result[$i]['idSubject'];
                    $s['name'] = "";
                    $s['description'] = "";
                    $subject[] = $s;
                    $nbSubjects++;
                }
            }
            $dataC[$row]['nbSubjects'] = $nbSubjects;
            $dataC[$row]['subjects'] = $subject;
        }
    } else {
        /* Case of a data challenge not existing in the json file */
        $newDataC = array();
        $newDataC['idS'] = $idDataC;

        /* Getting the name from the database */
        $request =
        "SELECT `name` FROM `DataChallenge` WHERE `idDataC` = '$idDataC'";

        try {
            $result = request_db(DB_RETRIEVE, $request);
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }

        $newDataC['name'] = $result[0]['name'];
        $newDataC['description'] = "";

        /* $subjects to store the list of subjects */
        $subjects = array();

        /* Get the id of the subjects within the database */
        $request = 
        "SELECT `idSubject` FROM `Subject` WHERE `idDataC` = '$idDataC'"; 
        
        try {
            $result = request_db(DB_RETRIEVE, $request);
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }

        try {
            $nb = count($result);
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }

        for ($i = 0; $i < $nb; $i++) {
            /* $subject for one subject and adding it to the list of subjects */
            $subject = array();
            $subject['idS'] = $result[$i]['idSubject'];
            $subject['name'] = "";
            $subject['description'] = "";
            $subjects[] = $subject;
        }

        $newDataC['nbSubjects'] = $nb;

        /* Adding the list of subjects as part of a data challenge in json file */
        $newDataC['subjects'] = $subjects;
        $dataC[] = $newDataC;
    }

    $obj['dataC'] = $dataC;

    $objE = json_encode($obj);

    if (!$objE) {
        throw new Exception("" . $s . "unable to encode json");
    }

    $json = file_put_contents(JSON_FILEPATH, $objE);

    if (!$json) {
        throw new Exception("" . $s . "unable to write in file");
    }

    return(true);
}
?>
