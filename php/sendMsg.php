<?php 
require_once("bdd.php");

if ( !is_connected_db() )
    try {
        connect_db();
    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }


$msg = isset($_POST["msg"]) ? $_POST["msg"] : "";
$sender = isset($_POST["sender"]) ? $_POST["sender"] : "3";
$receiver = isset($_POST["receiver"]) ? $_POST["receiver"] : "5";
$datetime = isset($_POST["datetime"]) ? $_POST["datetime"] : "";

$msgSend = alterMessage_db($sender, $receiver, $msg);
if ($msgSend) {
  echo "msg send";
}else{
  echo "marche po";
}
?>