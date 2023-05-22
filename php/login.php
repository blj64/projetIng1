<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include "./php/bdd.php";
        $login = $_POST['login'];
        $pwd = $_POST['password'];
        $errEmpty = "Please complete this field.";
        /* Case of empty fields */
        if (empty($login)) {
            $loginErr = $errEmpty;
        }
        if (empty($pwd)) {
            $pwdErr = $errEmpty;
        }
        /* Case of completed fields */
        if (!(isset($loginErr) || isset($pwdErr))) {
            /* Verification of the database connection */
            if (! is_connected_db()) {
                try {
                    connect_db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                } catch (Exception $e) {
                    echo $e -> getMessage();
                    exit();
                }
            }
            /* Verify if the user is registered */
            if (existUserByEmail($login)) {
                $hashpwd = password_hash($pwd, PASSWORD_BCRYPT);
                try {
                    $result = request_db(DB_RETRIEVE, "SELECT * FROM `User` WHERE `password` = $hashpwd AND `email` = $login");
                } catch (Exception $e) {
                    echo $e -> getMessage();
                    exit();
                }
                /* Case of an incorrect password */
                if (!isset($result[0])) {
                    $loginErr = "The password is incorrect";
                } else {
                    /* Check the issue of several users with the same registered email */
                    try {
                        isUnique($result);
                    } catch (Exception $e) {
                        echo $e -> getMessage();
                        exit();
                    }
                    session_start();
                    $_SESSION["id"] = $result["id"];
                    $_SESSION["login"] = $result["email"];
                }
            } else {
                $loginErr = "The login is incorrect.";
            }
        }
    }
