<div id="messagerie-container">
   
        <input id="user-search-input" type="text" class="sub-msg" name="sender" placeholder="UserName" value="1" oninput="updateNewContact()">
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
        echo json_encode($result["firstName"]);

    } catch (Exception $e) {
        echo "error";
        throw new Exception("Error getAllMessageFromUser : " . $e->getMessage());
    }
   

}

?>
