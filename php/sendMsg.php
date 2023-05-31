<?php 

require_once("/php/bdd.php");
if (!is_connected_db())
    try {
        connect_db();
    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }


$msg = isset($_POST["msg"]) ? $_POST["msg"] : "";
$sender = isset($_POST["sender"]) ? $_POST["sender"] : "3";
$receiver = isset($_POST["receiver"]) ? $_POST["receiver"] : "5";

$msgSend = alterMessage_db($sender, $receiver, $msg);


if ($msgSend === true) {
        echo "<div class='sub-msg'>";
            echo "<p>".$msg."</p>";
        echo "</div>";
       

} else {
        echo "<div class='sub-msg'>";
            echo "<p>Message non envoyé</p>";
        echo "</div>";
}
?>