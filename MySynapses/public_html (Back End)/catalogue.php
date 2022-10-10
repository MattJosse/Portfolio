<?php
    require 'project101/headers/cors_header.php';
    require 'project101/includes/database.class.php';
    $dbh=Database::connect();
    $list=Database::getCatalogue($dbh);
    $tab=array();
    $tab['cours']=$list;
    echo json_encode($tab);
    ?>