<?php

/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 22/05/2023 09:49:11 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/** 
 *  @file verifFormSignUp.php
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Mon 22 May 2023 - 09:49:11
 *
 *  @brief 
 *      -Verif all the data in the sign in form
 *
 */

/* **************************************************************************** */
/*                                    DEFINE                                    */
define('CORRECT_EMAIL', '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$/');
define('CORRECT_NAME', '/^[a-zA-Z_-]{2,}$/');
define('CORRECT_NUMBER', '/^0[0-9]{9}$/');

/* **************************************************************************** */
/*                                   FUNCTION                                   */
/*
 *  fn function correct_pwd($pwd)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Mon 22 May 2023 - 09:57:28
*/
/**
 *  brief verify if the password is correct
 *  @param $pwd     : the password to verify
 *  @return true if the password is correct
 *  @remarks a correct password must contain at least :
 *      - 8 characters
 *      - 1 uppercase letter
 *      - 1 lowercase letter
 *      - 1 number
 *      - 1 special character
 * 
 */
function correct_pwd($pwd) : bool   {
    if( strlen($pwd) < 8 )
        throw new Exception('Password too short! Must be at least 8 characters!');

    if( !preg_match("~[0-9]+~", $pwd) )
        throw new Exception('Password must contain at least one number!');
    
    if ( !preg_match("~[a-zA-Z]+~", $pwd) )
        throw new Exception('Password must contain at least one letter!');
    
    if( $pwd == strtolower($pwd) )
        throw new Exception('Password must contain at least one uppercase letter!');

    if( $pwd == strtoupper($pwd) )
        throw new Exception('Password must contain at least one lowercase letter!');

    
    if ( !preg_match("~[\W]+~", $pwd) )
        throw new Exception('Password must contain at least one special character!');

    return (true);
}

/* ---------------------------------------------------------------------------- */

/*
 *  fn function correct_email($email)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Mon 22 May 2023 - 10:02:17
*/
/**
 *  brief 
 *  @param 
 *  @return 
 *  @remarks 
 */
function correct_email($email) : bool   {
    
    if ( $email == "" )
        throw new Exception('Email cannot be empty!');

    if( !preg_match(CORRECT_EMAIL, $email) )
        throw new Exception('Email not valid!');

    return (true);
}


/* ---------------------------------------------------------------------------- */

/*
 *  fn function correct_name($name)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Mon 22 May 2023 - 10:03:41
*/
/**
 *  brief verify if the name is correct
 *  @param $name    : the name to verify
 *  @return true if the name is correct
 *  @remarks a correct name must contain at least :
 *      - 2 characters
 *      - only alphabetic letters or "_", "-"
 *      - no space
 *      - no special character
 *      - no number
 *      
 */
function correct_name($name) : bool {
    if ( $name == "" )
        throw new Exception('Name cannot be empty!');

    if( !preg_match(CORRECT_NAME, $name) )
        throw new Exception('Name not valid! can only contain letters and "_", "-"');
        
    return (true);
}

/* ---------------------------------------------------------------------------- */

/*
 *  fn function correct_number($number)
 *  author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  version 0.1
 *  date Mon 22 May 2023 - 10:06:51
*/
/**
 *  brief verify if the number is correct
 *  @param $number  : the number to verify
 *  @return true if the number is correct
 *  @remarks a correct number must contain at least :
 *      - 10 numbers
 *      - only numbers
 *      - start with 0
 */
function correct_number($number) : bool {
    if ( $number == "" )
        throw new Exception('Number cannot be empty!');

    if( strlen($number) != 10 )
        throw new Exception('Number not valid! must contain 10 numbers');

    if( !preg_match(CORRECT_NUMBER, $number) )
        throw new Exception('Number not valid! must contain only numbers');

    return (true);
}

/* **************************************************************************** */
/*                                    MAIN                                      */

if (session_status() == PHP_SESSION_NONE)
    session_start();

$result = true;
unset($_SESSION['error']);
unset($_SESSION['old']);
$_SESSION['error'] = array();
$old = array();
/*
 * The DOOM of verification is about to rain on you
 */

/* verify if the name is correct */
try {
    $old['lastname'] = $_POST['lastname'];
    correct_name($_POST['lastname']);
} catch (Exception $e) {
    $_SESSION['error']['lastname'] = $e->getMessage();
    $result = false;
}

/* verify if the firstname is correct */
try {
    $old['firstname'] = $_POST['firstname'];
    correct_name($_POST['firstname']);
} catch (Exception $e) {
    $_SESSION['error']['firstname'] = $e->getMessage();
    $result = false;
}

/* verify if the email is correct */
try {
    $old['email'] = $_POST['email'];
    correct_email($_POST['email']);
} catch (Exception $e) {
    $_SESSION['error']['email'] = $e->getMessage();
    $result = false;
}

/* verify if the password is the same as the repeated one */
if ( $_POST['password'] != $_POST['passwordV'] ) {
    $_SESSION['error']['passwordV'] = "Password doesn't match!";
    $result = false;
}

/* verify if the password is correct */
try {
    $old['password'] = $_POST['password'];
    correct_pwd($_POST['password']);
} catch (Exception $e) {
    $_SESSION['error']['password'] = $e->getMessage();
    $result = false;
}

/* verify if the number is correct */
try {
    $old['number'] = $_POST['number'];
    correct_number($_POST['number']);
} catch (Exception $e) {
    $_SESSION['error']['number'] = $e->getMessage();
    $result = false;
}

/* if there is at least 1 error, redirect to the sign up page */
if ( $result == false ) {
    $_SESSION['old'] = $old;
    unset($old);
    header('Location: /pages/signUp.php');
    exit();
}

/* 
 * well played, you have passed the verification
 * now we can add the user to the database
 */
unset($old);
require_once($_SERVER['DOCUMENT_ROOT'].'/php/inscription.php');
header('Location: /pages/accueil.php');

?>