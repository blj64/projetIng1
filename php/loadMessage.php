<?php
    require_once("bdd.php");
    $idSender = isset($_GET["idSender"]) ? $_GET["idSender"] : "3";
    $idReceiver = isset($_GET["idReceiver"]) ? $_GET["idReceiver"] : "5";
    if (!is_connected_db()) {
        try {
            connect_db();
        } catch (Exception $e){
            echo $e->getMessage();
            exit();
        }
    }
    $query = "SELECT * FROM `Message` where (`idSender` = '$idReceiver' and `idReceiver` = '$idSender') or (`idReceiver` = '$idReceiver' and `idSender` = '$idSender')";
    $messages_seen = "UPDATE `Message` SET `seen` = 1 WHERE
    (`idSender` = '$idReceiver' AND `idReceiver` = '$idSender')
    OR (`idReceiver` = '$idReceiver' AND `idSender` = '$idSender')";

    try {
        // Call the request_db function and pass the query
        $result = request_db(DB_RETRIEVE, $query);
        request_db(DB_ALTER, $messages_seen);
    } catch (Exception $e) {
        echo "Echec dans le chargement des messages";
        throw new Exception("Error getAllMessageFromUser : " . $e->getMessage());
    }
    if ($result === null) {
        echo "Aucun message";
    }else{
        foreach($result as $row) {
            echo $row["idSender"]." : ".$row["messageContent"]." at ".$row["timestamp"]."<br>";
        }
    }
   

?>