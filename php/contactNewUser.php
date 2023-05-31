<div id="messagerie-container">
   
    <form id="contact-new-user-form">
        <input id="user-search-input" type="text" class="sub-msg" name="sender" placeholder="UserName" value=7>
        <input type="text" class="sub-msg" name="msg" placeholder="Message">
        <input type="hidden" name="receiver" value=6>
        <button class="sub-msg" onclick="contactNewUser()">Contacter</button>
    </form>
</div>



<?php
    require_once("bdd.php");
    if (!is_connected_db()) {
        try {
            connect_db();
        } catch (Exception $e){
            echo $e->getMessage();
            exit();
        }
    }


if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];

    $query = "SELECT * FROM User WHERE firstName LIKE '%$searchTerm%' OR lastName LIKE '%$searchTerm%'";
    try {
        // Call the request_db function and pass the query
        $result = request_db(DB_RETRIEVE, $query);
    } catch (Exception $e) {
        throw new Exception("Error getAllMessageFromUser : " . $e->getMessage());
    }
   

    echo json_encode($suggestions["firstName"]);
}

?>
