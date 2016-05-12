<?php

    require_once("connection.php");
    
    //open database connection
    $mysqli = openConnection();

    //retrieve and display shoe data
    $nameArray = array($_GET["name_1"]);
    $shoeArray = getShoesByNames($mysqli, $nameArray);
    echo json_encode($shoeArray);
    
    // close connection 
    closeConnection($mysqli);

?>
