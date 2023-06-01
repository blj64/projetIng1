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
define("DB_NAME", "IAPau");

define("DB_RETRIEVE", 1);
define("DB_ALTER", 2);

define("ADMIN", 5);
define("MANAGER", 4);
define("STUDENT", 3);

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
 * @brief connect to a database
 * @param $host : the host of the database
 * @param $user : the user of the database
 * @param $pass : the password of the database
 * @param $db : the name of the database
 * @return true if the connection is successful, false otherwise
 * @remarks if no parameters are given, the function will use the default values of DEFINE
 */
function connect_db($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME): bool
{
    global $bdd;

    $bdd = mysqli_connect($host, $user, $pass, $db);

    if (mysqli_connect_errno()) {
        throw new Exception("Connexion failure : " . mysqli_connect_error());
    }
    return (true);
}

/* -------------------------------------------------------------------------- */

/**
 *  fn function is_connected_db()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Tue 16 May 2023 - 15:06:18
 * @brief check if the database is connected
 * @param [global] $bdd   : the database connection
 * @return true if the database is connected, false otherwise
 * @remarks if no parameters are given, the function will use the global variable $bdd
 */
function is_connected_db(): bool
{
    global $bdd;
    return (isset($bdd) && $bdd != null);
}

/* -------------------------------------------------------------------------- */

/**
 *  *fn function disconnect_db()
 *  *author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  *version 0.1
 *  *date Tue 16 May 2023 - 15:05:34
 * @brief disconnect from the database
 * @param [global] $bdd   : the database connection
 * @return true if the disconnection is successful
 * @remarks neeed to call connect_db() before
 */
function disconnect_db(): bool
{
    global $bdd;

    if (!is_connected_db()) {
        throw new mysqli_sql_exception("db not connected.");
    }
    mysqli_close($bdd);

    if (is_connected_db()) {
        throw new mysqli_sql_exception("db not disconnected.");
    }
    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterUser_db($idUser, $newFirstName = null, $newLastName = null, $newPassword = null, $newPhone = null, $newEmail = null)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sat 20 May 2023 - 17:11:25
 * */
/**
 * brief send a request to alter the `User` table
 * @param $idUser : the id of the user to which data is updated
 * @param $newFirstName : the new first name
 * @param $newLastName : the new last name
 * @param $newPassword : the new password (not hashed)
 * @param $newPhone : the new phone number
 * @param $newEmail : the new email
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterUser_db($idUser, $newFirstName = null, $newLastName = null, $newPassword = null, $newPhone = null, $newEmail = null): bool
{
    $error = "Error alterUser_db : ";

    $request =
        "SHOW COLUMNS FROM `User`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            if ($i == 3) {
                $newHashpwd = password_hash($newPassword, PASSWORD_DEFAULT);
                if (!$newHashpwd) {
                    throw new Exception("" . $error . "password hash failed.");
                }
                $request =
                    "UPDATE `User` SET `password` = '$newHashpwd' WHERE `id` = '$idUser'";
                try {
                    request_db(DB_ALTER, $request);
                } catch (Exception $e) {
                    throw new Exception("" . $error . $e->getMessage());
                }
            } else {
                /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `User` table */
                $column = $list_columns[$i]['Field'];
                $request =
                    "UPDATE `User` SET $column = '$listArgs[$i]' WHERE `id` = '$idUser'";
                try {
                    request_db(DB_ALTER, $request);
                } catch (Exception $e) {
                    throw new Exception("" . $error . $e->getMessage());
                }
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterDataC_db($idDataC, $newName, $newStartDate, $newEndDate, $newImage, $newDescription)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Thu 25 May 2023 - 11:04:06
 * */
/**
 * brief send a request to alter the `DataChallenge` table
 * @param $idDataC : the id of the data challenge to which data is updated
 * @param $newName : the new name of the data challenge
 * @param $newStartDate : the new start date of the data challenge
 * @param $newEndDate : the new end date of the data challenge
 * @param $newImage : the new image of the data challenge
 * @param $newDescription : the new description of the data challenge
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterDataC_db($idDataC, $newName = null, $newStartDate = null, $newEndDate = null, $newImage = null, $newDescription = null): bool
{
    $error = "Error alterDataC_db : ";

    $request =
        "SHOW COLUMNS FROM `DataChallenge`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `DataChallenge` table */
            $column = $list_columns[$i]['Field'];
            $request =
                "UPDATE `DataChallenge` SET $column = '$listArgs[$i]' WHERE `idDataC` = '$idDataC'";
            try {
                request_db(DB_ALTER, $request);
            } catch (Exception $e) {
                throw new Exception("" . $error . $e->getMessage());
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterSubject_db($idSubject, $newIdDataC, $newName, $newDescription)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Mon 29 May 2023 - 17:46:30
 * */
/**
 * brief send a request to alter the `Subject` table
 * @param $idSubject : the id of the subject
 * @param $newIdDataC : the new id of the data challenge to which the subject is linked
 * @param $newName : the new name of the subject
 * @param $newDescription : the new description of the subject
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterSubject_db($idSubject, $newIdDataC = null, $newName = null, $newDescription = null)
{
    $error = "Error alterSubject_db : ";

    $request =
        "SHOW COLUMNS FROM `Subject`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    if ($listArgs[1] != null) {
        /* Check if the data challenge exists */

        $request =
            "SELECT EXISTS(SELECT * FROM `DataChallenge` WHERE `idDataC` = '$newIdDataC') AS Res";

        try {
            $result = request_db(DB_RETRIEVE, $request);
        } catch (Exception $e) {
            throw new Exception("" . $error . $e->getMessage());
        }

        if ($result[0]['Res'] == 0) {
            throw new Exception("" . $error . "the corresponding data challenge does not exist");
        }
    }

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `Subject` table */
            $column = $list_columns[$i]['Field'];
            $request =
                "UPDATE `DataChallenge` SET $column = '$listArgs[$i]' WHERE `idSubject` = '$idSubject'";
            try {
                request_db(DB_ALTER, $request);
            } catch (Exception $e) {
                throw new Exception("" . $error . $e->getMessage());
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterManager_db($idManager, $newCompany, $newStartDate, $newEndDate)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Fri 26 May 2023 - 09:33:40
 * */
/**
 * brief send a request to alter the `Manager` table
 * @param $idManager : the id of the manager to which data is updated
 * @param $newCompany : the new company name of the manager
 * @param $newStartDate : the new start date of the manager
 * @param $newEndDate : the new end date of the manager
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterManager_db($idManager, $newCompany = null, $newStartDate = null, $newEndDate = null): bool
{
    $error = "Error alterManager_db : ";

    $request =
        "SHOW COLUMNS FROM `Manager`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `Manager` table */
            $column = $list_columns[$i]['Field'];
            $request =
                "UPDATE `Manager` SET $column = '$listArgs[$i]' WHERE `idUser` = '$idManager'";
            try {
                request_db(DB_ALTER, $request);
            } catch (Exception $e) {
                throw new Exception("" . $error . $e->getMessage());
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterHandle_db($idManager, $oldIdDataC, $newIdDataC)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 19:45:48
 * */
/**
 * brief send a request to alter the `Handle` table
 * @param $idManager : the id of the manager
 * @param $oldIdDataC : the id of a data challenge no longer handle by a given manager
 * @param $newIdDataC : the id of the data challenge to be handled by a given manager
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterHandle_db($idManager, $oldIdDataC, $newIdDataC)
{
    $request =
    "UPDATE `Handle` SET `idDataC` = '$newIdDataC' WHERE `idDataC` = '$oldIdDataC' AND `idUser` = '$idManager'";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error alterHandle_db : " . $e->getMessage());
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function insertHandle_db($idManager, $idDataC)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 28 May 2023 - 19:45:48
 * */
/**
 * brief send a request to alter the `Handle` table
 * @param $idManager : the id of the manager
 * @param $idDataC : the id of the data challenge to be handled by a given manager
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function insertHandle_db($idManager, $idDataC)
{
    $error = "Error insertHandle_db : ";

    /* Check if the user exists */
    $request =
        "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idManager') AS Res";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    if ($result[0]['Res'] == 0) {
        throw new Exception("" . $error . "the corresponding user does not exist");
    }

    /* Inserting the values */
    $request =
    "INSERT INTO `Handle` VALUES ($idManager, $idDataC)";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterStudent_db($idStudent, $newIdGroup, $newLvStudy, $newSchool, $newCity)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Fri 26 May 2023 - 09:50:35
 * */
/**
 * brief send a request to alter the `Student` table
 * @param $idStudent    : the id of the student to which data is updated
 * @param $oldIdGroup   : the old id of the group for the student
 * @param $newIdGroup   : the id of the new group for the student
 * @param $newLvStudy   : the new study level of the student
 * @param $newSchool    : the new school of the student
 * @param $newCity      : the new city of the student
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterStudent_db($idStudent, $oldIdGroup = null, $newIdGroup = null, $newLvStudy = null, $newSchool = null, $newCity = null) : bool {
    $error = "Error alterStudent_db : ";

    $request =
        "SHOW COLUMNS FROM `Student`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            if ($i == 1) {
                if ($listArgs[$i + 1] != null) {
                    $request = 
                    "UPDATE `In` SET `idGroup` = '$newIdGroup' WHERE `idUser` = '$idStudent' AND `idGroup` = '$oldIdGroup'";

                    try {
                        request_db(DB_ALTER, $request);
                    } catch (Exception $e) {
                        throw new Exception("" . $error . $e->getMessage());
                    }
                }
                /* Saut pour changer le niveau d'étude au prochain tour de bouvle */
                $i = 2;
            } else {
                /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `Student` table */
                $column = $list_columns[$i - 2]['Field'];
                $request =
                "UPDATE `Student` SET $column = '$listArgs[$i]' WHERE `idUser` = '$idStudent'";
                try {
                    request_db(DB_ALTER, $request);
                } catch (Exception $e) {
                    throw new Exception("" . $error . $e->getMessage());
                }
            }
        }
        $i++;
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterGroup_db($idGroup, $newName, $newIdLeader)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Fri 26 May 2023 - 10:34:47
 * */
/**
 * brief send a request to alter the `Group` table
 * @param $idGroup : the id of the group to which data is updated
 * @param $newName : the new name of the group
 * @param $newIdLeader : the new leader of the group
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterGroup_db($idGroup, $newName = null, $newIdLeader = null): bool
{
    $error = "Error alterGroup_db : ";

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            if ($i == 1) {
                $request =
                    "UPDATE `Group` SET `name` = '$listArgs[$i]' WHERE `id` = '$idGroup'";
            } else {
                $request =
                    "UPDATE `Group` SET `idLeader` = '$listArgs[$i]' WHERE `id` = '$idGroup'";
            }

            try {
                request_db(DB_ALTER, $request);
            } catch (Exception $e) {
                throw new Exception("" . $error . $e->getMessage());
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterQuiz_db($idQuiz, $newIdDataC, $newName, $newStartDate, $newEndDate)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Fri 26 May 2023 - 11:06:30
 * */
/**
 * brief send a request to alter the `Quiz` table
 * @param $idQuiz : the id of the quiz to which data is updated
 * @param $newIdDataC : the new id of the data challenge for the quiz
 * @param $newName : the new name of the quiz
 * @param $newStartDate : the new start date of the quiz
 * @param $newEndDate : the new end date of the quiz
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterQuiz_db($idQuiz, $newIdDataC = null, $newName = null, $newStartDate = null, $newEndDate = null): bool
{
    $error = "Error alterQuiz_db : ";

    $request =
        "SHOW COLUMNS FROM `Quiz`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `Quiz` table */
            $column = $list_columns[$i]['Field'];
            $request =
                "UPDATE `Quiz` SET $column = '$listArgs[$i]' WHERE `idQuiz` = '$idQuiz'";
            try {
                request_db(DB_ALTER, $request);
            } catch (Exception $e) {
                throw new Exception("" . $error . $e->getMessage());
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterResource_db($idResource, $newIdDataC, $newName, $newPath)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Fri 26 May 2023 - 13:18:45
 * */
/**
 * brief send a request to alter the `Resource` table
 * @param $idResource : the id of the resource to which data is updated
 * @param $newIdDataC : the new id of the data challenge for the resource
 * @param $newName : the new name of the resource
 * @param $newPath : the new path to the resource
 * @return true if the database was altered successfully
 * @remarks throw an exception if a request is not valid
 */
function alterResource_db($idResource, $newIdDataC = null, $newName = null, $newPath = null)
{
    $error = "Error alterQuiz_db : ";

    $request =
        "SHOW COLUMNS FROM `Resource`";

    try {
        $list_columns = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    $numArgs = func_num_args();
    $listArgs = func_get_args();

    for ($i = 1; $i < $numArgs; $i++) {
        if ($listArgs[$i] != null) {
            /* The result of request_db(DB_RETRIEVE, $request) has a column 'Field' which contains the name of the columns in the `Resource` table */
            $column = $list_columns[$i]['Field'];
            $request =
                "UPDATE `Resource` SET $column = '$listArgs[$i]' WHERE `idResource` = '$idResource'";
            try {
                request_db(DB_ALTER, $request);
            } catch (Exception $e) {
                throw new Exception("" . $error . $e->getMessage());
            }
        }
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *
 *  *fn function request_db($dbRequestType, $request = null)
 *  *author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sat 20 May 2023 - 17:35:25
 * */
/**
 *  brief send a request to alter the database or retrieve data
 * @param $dbRequestType : DB_RETRIEVE to retrieve data or DB_ALTER to alter the database
 * @param $request : the request to send
 * @return array w/ null if altering the database else is the result of the request when retrieving data
 * @remarks throw an exception if the request is not valid
 */
function request_db($dbRequestType, $request = null)
{
    global $bdd;

    if (!is_connected_db()) {
        throw new mysqli_sql_exception("db not connected.");
    }
    if (!isset($dbRequestType)) {
        throw new mysqli_sql_exception("request type not defined.");
    }
    if (!isset($request)) {
        throw new mysqli_sql_exception("request not set.");
    }
    $queryR = mysqli_query($bdd, $request);

    if (!$queryR) {
        throw new mysqli_sql_exception("request not valid.");
    }

    if ($dbRequestType == DB_RETRIEVE) {
        $result = array();
        if (mysqli_num_rows($queryR) > 0) {
            while ($row = mysqli_fetch_assoc($queryR)) {
                $result[] = $row;
            }
        }
        return ($result);
    } else {
        return (null);
    }
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function isUnique($arr)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 10:29:22
*/
/**
 *  brief check if an 2Darray contains only one element
 * @param $arr : the array to check
 * @return the only element of the array
 * @remarks throw an exception if the array is empty or contains more than one element
 */
function isUnique($arr)
{
    /* check if the user exists and is unique */
    $count = count($arr);
    if ($count == 0) {
        throw new Exception("Error isUnique : no item found.");
    }
    if ($count > 1) {
        throw new Exception("Error isUnique : more than one item found.");
    }
    /* return the only element of the array */
    return ($arr[0]);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getAllUsers()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 09:48:15
*/
/**
 *  brief get all users from the database
 * @param none
 * @return array w/ all users
 * @remarks throw an exception if the request is not valid
 */
function getAllUsers(): array
{
    $request = "SELECT * FROM `User`";
    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllUsers : " . $e->getMessage());
    }

    /* return an array of users */
    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function ByEmail($email)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 09:51:43
*/
/**
 *  brief get a user from the database by his email
 * @param $email : the email of the user
 * @return array w/ the data of the user
 * @remarks throw an exception if the request is not valid
 */
function getUserByEmail($email): array
{
    $request = "SELECT * FROM `User` WHERE email = '$email'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getUsersByEmail : " . $e->getMessage());
    }

    /* return the first (and only) user */
    return ($result[0]);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function getAllManagers()
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 21 May 2023 - 18:30:45
 * */
/**
 * brief get all managers from the database
 * @param none
 * @return array w/ all managers
 * @remarks throw an exception if the request is not valid
 */
function getAllManagers() {
    $request = 
    "SELECT * FROM `User` AS U JOIN `Manager` AS M ON U.`id` = M.`idUser`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllManagers : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function getAllStudents()
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 21 May 2023 - 18:58:00
 * */
/**
 * brief get all students from the database
 * @param none
 * @return array w/ all students
 * @remarks throw an exception if the request is not valid
 */
function getAllStudents() {
    $request = 
    "SELECT `id`, `firstName`, `lastName`, `number`, `email`, `lvStudy`, `school`, `city`
    FROM `User` AS U 
    JOIN `Student` AS S ON U.`id` = S.`idUser`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllStudents : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getAllAdmins()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 09:59:24
*/
/**
 *  brief get all admins from the database
 * @param none
 * @return array w/ all admins
 * @remarks throw an exception if the request is not valid
 */
function getAllAdmins() {
    $request = 
    "SELECT * FROM `User` WHERE `id` IN (SELECT `idUser` FROM `Admin`)";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllAdmins : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function getGroupsDataC($idDataC)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Mon 22 May 2023 - 13:04:00
 * */
/**
 * brief get the groups for a given data challenge
 * @param $idDataC : the id of the data challenge
 * @return array w/ the groups for the given data challenge
 * @remarks throw an exception if the request is not valid
 */
function getGroupsDataC($idDataC): array
{
    $request =
        "SELECT `id`, `name`, `idLeader`
    FROM `Group` AS G 
    WHERE `idDataC` = '$idDataC'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getGroupsDataC : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function getStudentsGroup($idGroup)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Mon 22 May 2023 - 13:35:28
 * */
/**
 * brief get all students of a given group
 * @param $idGroup : the id of the group
 * @return array w/ the students of the given group
 * @remarks throw an exception if the request is not valid
 */
function getStudentsGroup($idGroup): array
{
    $request =
    "SELECT U.`id`, `firstName`, `lastName`, `number`, `email`, `lvStudy`, `school`, `city`
    FROM `Student` AS S
    JOIN `User` AS U ON S.`idUser` = U.`id`
    join `In` as I on I.`idUser` = U.`id`
    join `Group` as G on G.`id` = I.`idGroup`
    WHERE G.`id` = '$idGroup'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getStudentsGroup : " . $e->getMessage());
    }
    $request =
        "SELECT `idLeader` 
    FROM `Group` 
    WHERE `id` = '$idGroup'";

    try {
        $result2 = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getStudentsGroup : " . $e->getMessage());
    }

    $student = array();
    foreach ($result as $row) {
        /* Add a 'leader' column to the previous result containing a bool which defines if the student is the leader or not */
        $row['leader'] = ($row['id'] == $result2[0]['idLeader']) ? true : false;
        $student[] = $row;
    }

    return ($student);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function getManagersDataChallenges()
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sun 21 May 2023 - 18:58:00
 * */
/**
 * brief get all data challenges and managers handling them
 * @param none
 * @return array w/ all data challenges and managers handling them
 * @remarks throw an exception if the request is not valid
 */
function getManagersDataChallenges() {
    $request = 
    "SELECT `id`, `firstName`, `lastName`, `email`, DC.`idDataC`, DC.`name`, 
    DC.`startDate`, DC.`endDate`, DC.`image`, DC.`description` FROM `User` AS U 
    JOIN `Manager` AS M ON U.`id` = M.`idUser` 
    JOIN `Handle` AS H ON H.`idUser` = M.`idUser` 
    JOIN DataChallenge AS DC ON DC.`idDataC` = H.`idDataC`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getManagersDataChallenges : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function existUserByEmail($email)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 10:28:11
*/
/**
 *  brief Verify if a user exists in the database by his email
 * @param $email : the email of the user
 * @return true if the user exists
 * @remarks do not verify if the user is unique
 */
function existUserByEmail($email): bool
{
    $request = "SELECT * FROM `User` WHERE email = '$email'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error existUserByEmail : " . $e->getMessage());
    }

    return (!empty($result));
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createUser($firstname, $lastname, $email, $password, $phone, $address, $city, $zipCode, $country, $isAdmin)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 17 May 2023 - 10:42:06
*/
/**
 *  brief insert a new user in the database
 * @param $firstname : the firstname of the user
 * @param $lastname : the lastname of the user
 * @param $email : the email of the user
 * @param $password : the password of the user
 * @param $phone : the phone of the user
 * @param $address : the address of the user
 * @return int id of the new user
 * @remarks re-check if the email already exists before inserting the user
 */
function createUser($firstname, $lastname, $password, $phone, $email): int
{

    if (existUserByEmail($email)) {
        throw new Exception("Error createUser : email already used.");
    }
    $hashpwd = password_hash($password, PASSWORD_DEFAULT);
    if (!$hashpwd) {
        throw new Exception("Error createUser : password hash failed.");
    }
    $request = "INSERT INTO User VALUES (null, '$firstname', '$lastname', '$hashpwd', '$phone', '$email')";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createUser : " . $e->getMessage());
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createStudent($idUser, $idGroup, $lvStudy, $school, $city)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Wed 24 May 2023 - 15:00:00
*/
/**
 *  brief insert a new student in the database
 * @param $idUser : the id of the user
 * @return true if the student has been inserted successfully
 * @remarks check if a user with the id $userId exists
 */
function createStudent($idUser, $idGroup, $lvStudy, $school, $city): bool
{
    /* Check if the user exists */
    $request =
        "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idUser') AS Res";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createStudent : " . $e->getMessage());
    }

    if ($result[0]['Res'] == 0) {
        throw new Exception("Error createStudent : the corresponding user does not exist");
    }

    /* Insert the new student in the database */
    $request =
    "INSERT INTO `Student` VALUES ('$idUser', '$lvStudy', '$school', '$city')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createStudent: " . $e->getMessage());
    }

    /* Insert in the `In` table for the group */

    $request =
    "INSERT INTO `In` VALUES ('$idUser', '$idGroup')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createStudent: " . $e->getMessage());
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createManager($idUser, $company, $startDate, $endDate)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Tue 23 May 2023 - 14:44:37
*/
/**
 *  brief insert a new manager in the database
 * @param $idUser : the id of the user
 * @param $company : the company of the manager
 * @param $startDate : the start date of the manager
 * @param $endDate : the end date of the manager
 * @return true if the manager has been inserted successfully
 * @remarks check if a user with the id $userId exists
 */
function createManager($idUser, $company, $startDate = null, $endDate = null): bool
{
    /* Check if the user exists */
    $request =
        "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idUser') AS Res";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createManager : " . $e->getMessage());
    }

    if ($result[0]['Res'] == 0) {
        throw new Exception("Error createManager : the corresponding user does not exist");
    }

    /* Insert the new manager in the database */
    $request =
        "INSERT INTO `Manager` VALUES ('$idUser', '$company', null, null)";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createManager : " . $e->getMessage());
    }

    if ($startDate != null) {
        $request =
            "UPDATE `Manager` SET `startDate` = '$startDate' WHERE `idUser` = '$idUser'";

        try {
            $result = request_db(DB_ALTER, $request);
        } catch (Exception $e) {
            throw new Exception("Error createManager : " . $e->getMessage());
        }
    }

    if ($endDate != null) {
        $request =
            "UPDATE `Manager` SET `endDate` = '$endDate' WHERE `idUser` = '$idUser'";

        try {
            $result = request_db(DB_ALTER, $request);
        } catch (Exception $e) {
            throw new Exception("Error createManager : " . $e->getMessage());
        }
    }

    return (true);

}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createAdmin($idUser)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Wed 24 May 2023 - 13:08:51
*/
/**
 *  brief insert a new admin in the database
 * @param $idUser : the id of the user
 * @return true if the admin has been inserted successfully
 * @remarks check if a user with the id $userId exists
 */
function createAdmin($idUser): bool
{
    /* Check if the user exists */
    $request =
        "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idUser') AS Res";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createAdmin : " . $e->getMessage());
    }

    if ($result[0]['Res'] == 0) {
        throw new Exception("Error createAdmin : the corresponding user does not exist");
    }

    /* Insert the new admin in the database */
    $request = "
    INSERT INTO `Admin` VALUES ('$idUser')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createAdmin : " . $e->getMessage());
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createDataC($name, $startDate, $endDate, $image, $description)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Mon 29 May 2023 - 17:59:50
*/
/**
 *  brief insert a new data challenge in the database
 * @param $name : the name of the data challenge
 * @param $startDate : the start date of the data challenge
 * @param $endDate : the end date of the data challenge
 * @param $image : the image of the data challenge
 * @param $description : the description of the data challenge
 * @return true if the data challenge has been inserted successfully
 */
function createDataC($name, $startDate, $endDate, $image, $description): int
{
    $request = "INSERT INTO `DataChallenge` VALUES (null, '$name', '$startDate', '$endDate', '$image', '$description')";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createDataC : " . $e->getMessage());
    }

    $request = "SELECT LAST_INSERT_ID() AS id";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createDataC : " . $e->getMessage());
    }

    return ($result[0]['id']);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createSubject($idDataC, $name, $description)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Mon 29 May 2023 - 18:02:45
*/
/**
 *  brief insert a new subject in the database
 * @param $idDataC : the id of the data challenge to which the subject is linked
 * @param $name : the name of the subject
 * @param $description : the description of the subject
 * @return true if the subject has been inserted successfully
 * @remarks check if a data challenge with the id $idDataC exists
 */
function createSubject($idDataC, $name, $description)
{
    $error = "Error createSubject : ";

    /* Check if the data challenge exists */
    $request =
        "SELECT EXISTS(SELECT * FROM `DataChallenge` WHERE `idDataC` = '$idDataC') AS Res";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    if ($result[0]['Res'] == 0) {
        throw new Exception("" . $error . "the corresponding data challenge does not exist");
    }

    /* Insert the new subject in the database */

    $request = "INSERT INTO `Subject` VALUES (null, '$idDataC', '$name', '$description')";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("" . $error . $e->getMessage());
    }

    return (true);
}


/* -------------------------------------------------------------------------- */

/*
 *  fn function deleteUser($idUser)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Tue 23 May 2023 - 14:05:00
*/
/**
 *  brief delete a user in the database
 * @param $idUser : the id of the user
 * @return true if the user has been successfully deleted
 */
function deleteUser($idUser): bool
{

    $request =
        "SELECT EXISTS(SELECT * FROM `Group` WHERE `idLeader` = '$idUser') AS RES";

    try {
        $find = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error deleteUser : error while checking if the user is a leader");
    } 

    if ($find[0]['RES']) {
        throw new Exception("Error deleteUser : cannot delete the leader of a group");
    }

    $request =
        "DELETE FROM `User` 
    WHERE `id` = '$idUser'";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error deleteUser : " . $e->getMessage());
    }

    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function checkManagerDates($idUser, $idDataC)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Mon 22 May 2023 - 10:13:36
*/
/**
 *  brief check if the current date is between the manager startDate and endDate for a given data challenge
 * @param $idUser : the id of the manager
 * @param $idDataC : the id of the data challenge
 * @return true if the manager has the right to manage a given data challenge
 * @remarks if $idUser is not the id of a manager the function returns false
 */
function checkManagerDates($idUser, $idDataC): bool
{
    $request =
        "SELECT M.`startDate`, M.`endDate` FROM `Manager` AS M
    JOIN `Handle` AS H ON M.`idUser` = H.`idUser`
    WHERE H.`idDataC` = '$idDataC' AND M.`idUser` = '$idUser'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error checkManagerDates : " . $e->getMessage());
    }

    if (!$result) {
        return (false);
    }

    $startDate = $result['startDate'];
    $endDate = $result['endDate'];
    $currentDate = date('Y-m-d');

    return (!($currentDate < $startDate || $currentDate > $endDate));
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getAllDataCStarted()
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Mon 22 May 2023 - 15:33:50
*/
/**
 *  brief get all data challenges that have already started but have not ended yet
 * @param none
 * @return array w/ all data challenges already started but not ended
 */
function getAllDataCStarted(): array
{
    $currentDate = date('Y-m-d');
    $request =
        "SELECT `idDataC`, `name`, `startDate`, `endDate`, `image`, `description`
    FROM `DataChallenge`
    WHERE '$currentDate' < `endDate`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllDataCStarted : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getAllDataCEnded()
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Tue 23 May 2023 - 13:26:40
*/
/**
 *  brief get all data challenges that have ended
 * @param none
 * @return array w/ all data challenges that have ended
 */
function getAllDataCEnded(): array
{
    $currentDate = date('Y-m-d');
    $request =
        "SELECT `idDataC`, `name`, `startDate`, `endDate`, `image`, `description`
    FROM `DataChallenge`
    WHERE '$currentDate' > `endDate`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllDataCEnded : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  *fn function alterMessage_db($idSender, $ideReceiver, $Message = null)
 *  *author Lioger--Bun Jérémi <liogerbunj@cy-tech.fr>
 *  *version 0.1
 *  *date Sat 20 May 2023 - 17:11:25
*/
/**
 * brief send a request to alter the `Message` table
 * @remarks throw an exception if the request is not valid
 */
function alterMessage_db($idSender, $idReceiver, $message = null): bool
{

    $request = "INSERT INTO Message VALUES (null, '$idSender', '$idReceiver', '$message', NOW(), 0)";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error alterMessage_db : " . $e->getMessage());
    }

    return (true);
}

/**
 *  brief check if a user has a certain role
 * @param $idUser : the id of the user
 * @param $role : ADMIN for administrator, MANAGER for manager and STUDENT for student
 * @return true if the user has the given role
 */
function roleUser($idUser, $role): bool
{
    $reqDeb = "SELECT EXISTS(SELECT * FROM ";
    $reqFin = " WHERE `idUser` = '$idUser') AS Res";
    switch ($role) {
        case ADMIN :
            $request = $reqDeb . "`Admin`" . $reqFin;

            try {
                $result = request_db(DB_RETRIEVE, $request);
            } catch (Exception $e) {
                throw new Exception("Error roleUser : " . $e->getMessage());
            }
            break;

        case MANAGER :
            $request = $reqDeb . "`Manager`" . $reqFin;

            try {
                $result = request_db(DB_RETRIEVE, $request);
            } catch (Exception $e) {
                throw new Exception("Error roleUser : " . $e->getMessage());
            }
            break;

        case STUDENT :
            $request = $reqDeb . "`Student`" . $reqFin;

            try {
                $result = request_db(DB_RETRIEVE, $request);
            } catch (Exception $e) {
                throw new Exception("Error roleUser : " . $e->getMessage());
            }
            break;

        default :
            break;
    }

    if (!isset($result)) {
        throw new Exception("Error roleUser : " . $role . " is not defined");
    }

    return ($result[0]["Res"] == 1);
}

/* -------------------------------------------------------------------------- */

/*
*  *fn function getAllMessageFromUser($idReceiver)
*  *author Lioger--Bun Jérémi <liogerbunj@cy-tech.fr>
*  *version 0.1
*  *date Sat 20 May 2023 - 17:11:25
*/
/**
 * brief send a request to alter the `Message` table
 * @remarks throw an exception if the request is not valid
 */
function getAllMessageFromUser($idReceiver, $idSender): array
{
    if (!is_connected_db()) {
        try {
            connect_db();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }
    $query = "SELECT * FROM `Message` where (`idSender` = '$idReceiver' and `idReceiver` = '$idSender') or (`idReceiver` = '$idReceiver' and `idSender` = '$idSender')";

    try {
        // Call the request_db function and pass the query
        $result = request_db(DB_RETRIEVE, $query);
    } catch (Exception $e) {
        throw new Exception("Error getAllMessageFromUser : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */


/*
 *  fn function getGroupById($idGroup)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Sat 27 May 2023 - 16:08:47
*/
/**
 *  brief get a group by its id from the database
 * @param $idGroup : the id of the group
 * @return the group
 * @remarks throw an exception if the request is not valid
 */
function getGroupById($idGroup)
{
    $request = "SELECT * FROM `Group` WHERE `id` = '$idGroup'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getGroupById : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
*  *fn function getAllUserContacted($idReceiver)
*  *author Lioger--Bun Jérémi <liogerbunj@cy-tech.fr>
*  *version 0.1
*  *date Sat 20 May 2023 - 17:11:25
*/
/**
 * brief send a request to alter the `Message` table
 * @remarks throw an exception if the request is not valid
 */
function getAllUserContacted($idReceiver): array
{
    if (!is_connected_db()) {
        try {
            connect_db();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }
    $query = "SELECT DISTINCT u.firstName, u.lastName, u.id
    FROM User u
    JOIN Message m ON (u.id = m.idSender AND m.idReceiver = '$idReceiver')
        OR (u.id = m.idReceiver AND m.idSender = '$idReceiver')";

    try {
        // Call the request_db function and pass the query
        $result = request_db(DB_RETRIEVE, $query);
    } catch (Exception $e) {
        throw new Exception("Error getAllMessageFromUser : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */


/*
 *  fn function getHandlerByIdManager($idManager)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Tue 30 May 2023 - 23:51:45
*/
/**
 *  brief get all the handler of a manager
 * @param $idManager : the id of the manager
 * @return all the handler of the manager
 * @remarks --
 */
function getHandlerByIdManager($idManager)
{
    $request = "SELECT * FROM `Handle` WHERE `idUser` = '$idManager'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getHandlerByIdManager : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getHandlerByIdChallenge($idChallenge)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Tue 30 May 2023 - 23:52:36
*/
/**
 *  brief get all the handler of a challenge
 * @param $idChallenge : the id of the challenge
 * @return all the handler of the challenge
 * @remarks --
 */
function getHandlerByIdChallenge($idChallenge)
{
    $request = "SELECT * FROM `Handle` WHERE `idUser` = '$idChallenge'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getHandlerByIdChallenge : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getDataChallengeById($idDataC)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 31 May 2023 - 10:52:34
*/
/**
 *  brief get a data challenge by its id
 * @param $idDataC : the id of the data challenge
 * @return the data challenge
 * @remarks throw an exception if the request is not valid
 */
function getDataChallengeById($idDataC)
{
    $request = "SELECT * FROM `DataChallenge` WHERE `idDataC` = $idDataC";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getDataChallengeById : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getSubjectsByIdChallenge($idChallenge)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 31 May 2023 - 11:02:52
*/
/**
 *  brief get all the subjects of a challenge
 * @param $idChallenge : the id of the challenge
 * @return all the subjects of the challenge
 * @remarks throw an exception if the request is not valid
 */
function getSubjectsByIdChallenge($idChallenge)
{
    $request = "SELECT * FROM `Subject` WHERE `idDataC` = $idChallenge";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getSubjectsByIdChallenge : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getGroupByStudentId($idStudent)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Wed 31 May 2023 - 21:05:05
*/
/**
 *  brief get the group of a student
 * @param $idStudent : the id of the student
 * @return the group of the student
 * @remarks throw an exception if the request is not valid
 */
function getGroupByStudentId($idStudent)
{
    $request = "SELECT G.*
    FROM `User` AS U 
    JOIN `Student` AS S ON U.`id` = S.`idUser`
    JOIN `In` AS I ON S.`idUser` = I.`idUser`
    JOIN `Group` AS G ON I.`idGroup` = G.`id`
    WHERE U.`id` = '$idStudent'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getGroupByStudentId : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function getStudentByIdUser($idUser)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Thu 01 June 2023 - 00:41:10
*/
/**
 *  brief
 * @param
 * @return
 * @remarks
 */
function getStudentByIdUser($idUser)
{
    $request = "SELECT * FROM `Student` 
    JOIN `User` ON `Student`.`idUser` = `User`.`id`
    WHERE `Student`.`idUser` = '$idUser'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getStudentByIdUser : " . $e->getMessage());
    }

    return ($result);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createGroup()
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Thu 01 June 2023 - 01:27:02
*/
/**
 *  brief create a group
 * @param $name : the name of the group
 * @param $idDataC : the id of the data challenge
 * @param $idLeader : the id of the leader of the group
 * @return the id of the group
 * @remarks do not check if the group already exist
 */
function createGroup($name, int $idDataC, int $idLeader)
{
    $request = "INSERT INTO `Group` VALUES (null, '$name', $idDataC, $idLeader)";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createGroup : " . $e->getMessage());
    }

    $request = "SELECT LAST_INSERT_ID() AS `id`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createGroup : " . $e->getMessage());
    }

    return ($result[0]['id']);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function createIn($idUser, $idGroup)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Thu 01 June 2023 - 01:34:18
*/
/**
 *  brief create a link between a user and a group
 * @param $idUser : the id of the user
 * @param $idGroup : the id of the group
 * @return true if the link is created
 * @remarks do not check if the link already exist
 */
function createIn($idUser, $idGroup)
{
    $request = "INSERT INTO `In` VALUES ('$idUser', '$idGroup')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createIn : " . $e->getMessage());
    }

    return ($result);
}

function updateStudentJson($idStudent, $newJson): bool
{
    $error = "Error updateStudentJson : ";

    $request = "UPDATE `Student` SET `json` = '$newJson' WHERE `idUser` = '$idStudent'";


    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception($error . $e->getMessage());
    }
    return (true);
}

function existJsonFromStudent($idStudent)
{
    $error = "Error existJsonFromStudent : ";
    $request = "SELECT `json` FROM `Student` WHERE `idUser` = '$idStudent'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception($error . $e->getMessage());
    }


        return $result;
}


/* -------------------------------------------------------------------------- */

/*
 *  fn function createFormulaire($idDataC, $url, $startDate, $endDate)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Thu 01 June 2023 - 11:11:09
*/
/**
 *  brief create a formulaire
 *  @param $idDataC     : the id of the data challenge
 *  @param $url         : the url of the formulaire
 *  @param $startDate   : the start date of the formulaire
 *  @param $endDate     : the end date of the formulaire
 *  @return --
 *  @remarks --
 */
function createFormulaire($idDataC, $url, $startDate, $endDate) {
    $request = "INSERT INTO `Quiz` VALUES (null, '$idDataC', '$url', '$startDate', '$endDate')";
    
    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createFormulaire : " . $e->getMessage());
    }

    return ($result);
}