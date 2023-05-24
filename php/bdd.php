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
 *  @brief check if the database is connected
 *  @param [global] $bdd   : the database connection
 *  @return true if the database is connected, false otherwise
 *  @remarks if no parameters are given, the function will use the global variable $bdd
 */
function is_connected_db() : bool {
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
 *
 *  *fn function alterUser_db($idUser, $newFirstName = null, $newLastName = null, $newPassword = null, $newPhone = null, $newEmail = null)
 *  *author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  *version 0.1
 *  *date Sat 20 May 2023 - 17:11:25
 * */
/**
 * brief send a request to alter the `User` table
 * @param $idUser         : the id of the user to which data is updated
 * @param $newFirstName   : the new first name
 * @param $newLastName    : the new last name
 * @param $newPassword    : the new password
 * @param $newPhone       : the new phone number
 * @param $newEmail       : the new email
 * @return true if the database was altered successfully
 * @remarks throw an exception if the request is not valid
 */
function alterUser_db($idUser, $newFirstName = null, $newLastName = null, $newPassword = null, $newPhone = null, $newEmail = null) : bool {
    global $bdd;

    if (!is_connected_db()) {
        throw new mysqli_sql_exception("db not connected.");
    }
    if (!isset($idUser)) {
        throw new mysqli_sql_exception("id not set.");
    }
    $newHashpwd = password_hash($newPassword, PASSWORD_BCRYPT);

    if (!$newHashpwd) {
        throw new Exception("Error alterUser_db : password hash failed.");
    }

    $request = 
    "UPDATE `User` '
    SET `firstName` = '$newFirstName', `lastName` = '$newLastName', `password` = '$newHashpwd', `number` = '$newPhone', `email` = '$newEmail 
    WHERE `id` = '$idUser'S";
    $queryR = mysqli_query($bdd, $request);

    if (!$queryR) {
        throw new mysqli_sql_exception("request not valid.");
    }

    return(true);
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
 *  @param $dbRequestType   : DB_RETRIEVE to retrieve data or DB_ALTER to alter the database
 *  @param $request         : the request to send
 *  @return array w/ null if altering the database else is the result of the request when retrieving data
 *  @remarks throw an exception if the request is not valid
 */
function request_db($dbRequestType, $request = null) : array | null {
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
        while ($row = mysqli_fetch_assoc($queryR)) {
            $result[] = $row;
        }
        return ($result);
    } else {
        return(null);
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
 *  @param $arr   : the array to check
 *  @return the only element of the array
 *  @remarks throw an exception if the array is empty or contains more than one element
 */
function isUnique($arr) {
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
 *  @param none
 *  @return array w/ all users
 *  @remarks throw an exception if the request is not valid
 */
function getAllUsers() : array {
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
    $request ="SELECT * FROM `User` WHERE email = '$email'";
    
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
    $request = "Select * FROM `User` AS U JOIN `Manager` AS M ON U.`id` = M.`idUser`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
        $result = isUnique($result);
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
    "Select `id`, `idGroup`, `firstName`, `lastName`, `password`, `number`, `email`, `lvStudy`, `school`, `city`
    FROM `User` AS U 
    JOIN `Student` AS S ON U.`id` = S.`idUser`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
        $result = isUnique($result);
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
 *  @param none
 *  @return array w/ all admins
 *  @remarks throw an exception if the request is not valid
 */
function getAllAdmins() {
    $request = "Select * FROM `User` WHERE `id` IN (SELECT `idUser` FROM `Admin`)";

    try {
        $result = request_db(DB_RETRIEVE, $request);
        // $result = isUnique($result);
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
function getGroupsDataC($idDataC) : array {
    $request =
    "SELECT `id`, `name`, `idLeader`
    FROM `Group` AS G 
    WHERE `idDataC` = '$idDataC'";

    try {
        $result = request_db(DB_RETRIEVE, $request); 
    } catch (Exception $e) {
        throw new Exception("Error getGroupsDataC : " . $e->getMessage());
    }

    return($result);
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
function getStudentsGroup($idGroup) : array  {
    $request =
    "SELECT `id`, `firstName`, `lastName`, `password`, `number`, `email`, `lvStudy`, `school`, `city`
    FROM `Student` AS S
    JOIN `User` AS U ON S.`idUser` = U.`id`
    WHERE S.`idGroup` = '$idGroup'";

    try {
        $result = request_db(DB_RETRIEVE, $request); 
    } catch (Exception $e) {
        throw new Exception("Error getStudentsGroup : " . $e->getMessage());
    }
    $request = 
    "SELECT `idLeader` 
    FROM `Group` 
    WHERE `idGroup` = '$idGroup'";

    try {
        $result2 = request_db(DB_RETRIEVE, $request); 
    } catch (Exception $e) {
        throw new Exception("Error getStudentsGroup : " . $e->getMessage());
    }

    $student = array();
    foreach ($result as $row) {
        /* Add a 'leader' column to the previous result containing a bool which defines if the student is the leader or not */
        $row['leader'] = ($row['id'] == $result2['idLeader']);
        $student[] = $row;
    }

    return($student);
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
    "SELECT `id`, `firstName`, `lastName`, `password`, `number`, `email`, `company`, M.`startDate`, M.`endDate`, DC.`idDataC`, DC.`name`, 
    DC.`startDate`, DC.`endDate`, DC.`image` FROM `User` AS U 
    JOIN `Manager` AS M ON U.`id` = M.`idUser` 
    JOIN `Handle` AS H ON H.`idUser` = H.`idUser` 
    JOIN DataChallenge AS DC ON DC.`idDataC` = H.`idDataC`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
        $result = isUnique($result);
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
 *  @param $email   : the email of the user
 *  @return true if the user exists
 *  @remarks do not verify if the user is unique
 */
function existUserByEmail($email) {
    $request = "SELECT * FROM `User` WHERE email = '$email'";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error existUserByEmail : " . $e->getMessage());
    }

    return ($result != array());
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
 *  @param $firstname   : the firstname of the user
 *  @param $lastname    : the lastname of the user
 *  @param $email       : the email of the user
 *  @param $password    : the password of the user
 *  @param $phone       : the phone of the user
 *  @param $address     : the address of the user
 *  @return true if the user has been created
 *  @remarks re-check if the email already exists before inserting the user
 */
function createUser($firstname, $lastname, $password, $phone, $email) {
    
    if (existUserByEmail($email)) {
        throw new Exception("Error createUser : email already used.");
    }
    $hashpwd = password_hash($password, PASSWORD_BCRYPT);
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
 *  @param $idUser : the id of the user
 *  @return true if the student has been inserted successfully
 *  @remarks check if a user with the id $userId exists
 */
function createStudent($idUser, $idGroup, $lvStudy, $school, $city) : bool {
    $request = 
    "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idUser')";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createStudent : " . $e->getMessage());
    }

    if (!$result[0]) {
        throw new Exception("Error createStudent : the corresponding user does not exist");
    }

    $request =
    "INSERT INTO `Student` VALUES ('$idUser', '$idGroup', '$lvStudy', '$school', '$city')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createStudent: " . $e->getMessage());
    }

    return(true);
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
 *  @param $idUser    : the id of the user
 *  @param $company   : the company of the manager
 *  @param $startDate : the start date of the manager
 *  @param $endDate   : the end date of the manager
 *  @return true if the manager has been inserted successfully
 *  @remarks check if a user with the id $userId exists
 */
function createManager($idUser, $company, $startDate, $endDate) : bool {
    /* Check if the user exists */
    $request = 
    "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idUser')";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createManager : " . $e->getMessage());
    }

    if (!$result[0]) {
        throw new Exception("Error createManager : the corresponding user does not exist");
    }

    /* Insert the new manager in the database */
    $request = 
    "INSERT INTO `Manager` VALUES ('$idUser', '$company', '$startDate', '$endDate')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createManager : " . $e->getMessage());
    }

    return(true);
    
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
 *  @param $idUser : the id of the user
 *  @return true if the admin has been inserted successfully
 *  @remarks check if a user with the id $userId exists
 */
function createAdmin($idUser) : bool {
    /* Check if the user exists */
    $request = 
    "SELECT EXISTS(SELECT * FROM `User` WHERE `id` = '$idUser')";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error createAdmin : " . $e->getMessage());
    }

    if (!$result[0]) {
        throw new Exception("Error createAdmin : the corresponding user does not exist");
    }

    /* Insert the new admin in the database */
    $request = "
    INSERT INTO `Admin` VALUES ('$idUser')";

    try {
        $result = request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error createManager : " . $e->getMessage());
    }

    return(true);
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
 *  @param $idUser  : the id of the user
 *  @return true if the user has been successfully deleted
 */
function deleteUser($idUser) : bool {
    $request =
    "DELETE FROM `User` 
    WHERE `id` = '$idUser'";

    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error deleteUser : " . $e->getMessage());
    }

    return(true);

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
 *  @param $idUser  : the id of the manager
 *  @param $idDataC : the id of the data challenge
 *  @return true if the manager has the right to manage a given data challenge
 *  @remarks if $idUser is not the id of a manager the function returns false
 */
function checkManagerDates($idUser, $idDataC) : bool {
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
        return(false);
    }

    $startDate = $result['startDate'];
    $endDate = $result['endDate'];
    $currentDate = date('Y-m-d');
    
    return(!($currentDate < $startDate || $currentDate > $endDate));
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
 *  @param none
 *  @return array w/ all data challenges already started but not ended
 */
function getAllDataCStarted() : array {
    $currentDate = date('Y-m-d');
    $request = "
    SELECT `idDataC`, `name`, `startDate`, `endDate`, `image`
    FROM `DataChallenge`
    WHERE `startDate` < '$currentDate' AND '$currentDate' < `endDate`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllDataCStarted : " . $e->getMessage());
    }

    return($result);
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
 *  @param none
 *  @return array w/ all data challenges that have ended
 */
function getAllDataCEnded() : array {
    $currentDate = date('Y-m-d');
    $request = 
    "SELECT `idDataC`, `name`, `startDate`, `endDate`, `image`
    FROM `DataChallenge`
    WHERE '$currentDate' > `endDate`";

    try {
        $result = request_db(DB_RETRIEVE, $request);
    } catch (Exception $e) {
        throw new Exception("Error getAllDataCEnded : " . $e->getMessage());
    }

    return($result);
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
function alterMessage_db($idSender, $idReceiver, $message = null) : bool {

    $request = "INSERT INTO Message VALUES (null, '$idSender', '$idReceiver', '$message', null)";
    
    try {
        request_db(DB_ALTER, $request);
    } catch (Exception $e) {
        throw new Exception("Error alterMessage_db : " . $e->getMessage());
    }
    
    return (true);
}

/* -------------------------------------------------------------------------- */

/*
 *  fn function roleUser($idUser, $role)
 *  author Michel-Dansac Lilian François Jean-Philippe <micheldans@cy-tech.fr>
 *  version 0.1
 *  date Tue 23 May 2023 - 15:42:59
*/
/**
 *  brief check if a user has a certain role
 *  @param $idUser : the id of the user
 *  @param $role : ADMIN for administrator, MANAGER for manager and STUDENT for student
 *  @return true if the user has the given role
 */
function roleUser($idUser, $role) : bool {
    $reqDeb = "SELECT EXISTS(SELECT * FROM ";
    $reqFin = " WHERE `idUser` = '$idUser')";
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

    return($result[0]);
}

/* -------------------------------------------------------------------------- */

/*
*
*  *fn function getAllMessageFromUser($idReceiver)
*  *author Lioger--Bun Jérémi <liogerbunj@cy-tech.fr>
*  *version 0.1
*  *date Sat 20 May 2023 - 17:11:25
*/
/**
* brief send a request to alter the `Message` table

* @remarks throw an exception if the request is not valid
*/
function getAllMessageFromUser($idReceiver) : array{
    $query = "SELECT * FROM `Message` WHERE `idSender` = '$idReceiver' OR `idReceiver`='$idReceiver'";
    
    try {
        // Call the request_db function and pass the query
        $result = request_db(DB_RETRIEVE, $query);
    } catch (Exception $e) {
        throw new Exception("Error getAllMessageFromUser : " . $e->getMessage);
    }

    return($result);
 }
 
/* -------------------------------------------------------------------------- */

?>
