<?php

    $server = "sql113.infinityfree.com";
    $username = "if0_38571089";
    $password = "Abhi4321Rana";
    $dbname = "if0_38571089_vintage_vault_db";

    $conn = mysqli_connect($server, $username, $password, $dbname);
 
    if(!$conn){
        die("Connection Failed:" . mysqli_connect_error());
    }
?>