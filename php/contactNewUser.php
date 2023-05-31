<div id="messagerie-container">
        <input id="user-search-input" type="text" class="sub-msg" name="sender" placeholder="UserName" value="1" oninput="searchSuggestions()">
        <datalist id="users-name"></datalist>
</div>



<?php
    require_once("bdd.php");

    // Connect to the database
    try {
        connect_db();
    } catch (Exception $e) {
        // Handle connection error
        echo "Database connection error: " . $e->getMessage();
        exit();
    }

    // Fetch suggestions from the database
    $searchText = $_GET['searchText']; // Assuming you're using GET method

    try {
        $query = "SELECT `firstName` FROM `User` WHERE `firstName` LIKE '%$searchText%'";
        $results = request_db(DB_RETRIEVE, $query);

        $suggestions = array();
        foreach ($results as $row) {
            $suggestions[] = $row['firstName'];
        }
    } catch (Exception $e) {
        // Handle query execution error
        echo "Query execution error: " . $e->getMessage();
        exit();
    }

    // Echo each name
    foreach ($suggestions as $name) {
        echo "<option value='".$name . "'>";
    }
?>
