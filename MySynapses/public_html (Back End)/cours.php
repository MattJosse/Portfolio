<?php
    $code = "INF471T-2022";
    if(isset($_GET['code'])){
        $code=$_GET['code'];
    }
    require 'project101/headers/cors_header.php';
    require 'project101/includes/database.class.php';
    $dbh=Database::connect();
    $list=Database::getDetailCours($dbh, $code);
    
    $result=$list[0];
    $result[0]['professor']=$list[1];

    $tab=array();
    $tab['detailcours']=$result;

    echo json_encode($tab);
