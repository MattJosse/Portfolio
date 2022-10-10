<?php
require 'includes/database.class.php';
$dbh=Database::connect();
$query = "SELECT * FROM catalogue WHERE code LIKE 'INF%' ";
$sth=$dbh->prepare($query);
$sth->execute();

$result=$sth->fetchALL(PDO::FETCH_ASSOC);
var_dump($result) 
?>