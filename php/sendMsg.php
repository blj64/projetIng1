<?php 
require_once("/php/bdd.php");

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

$msgSend = alterMessage_db($sender, $receiver, $msg);


echo $msgSend === true ? $msg : "Message non envoyé";
if ($msgSend === true) {
    if ($msgSend["idSender"] === $sender) {
        echo "<div class='msg right'>";
            echo "<div class='sub-msg'>";
                echo "<p>".$msgSend["messageContent"]."</p>";
            echo "</div>";
        echo "</div>";
    }else{
        echo "<div class='msg left'>";
            echo "<div class='sub-msg'>";
                echo "<p>".$msgSend["messageContent"]."</p>";
            echo "</div>";
        echo "</div>";
    }
} else {
    echo "Message non envoyé";
}
?>