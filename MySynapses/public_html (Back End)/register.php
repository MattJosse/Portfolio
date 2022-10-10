<?php
require 'project101/headers/cors_header.php';
require 'project101/includes/database.class.php';

if (isset($_POST['userid']) && $_POST['userid']!= "") {
    $userid = $_POST['userid'];
} else {
    $error=array('error'=>"Veuillez entrer un Identifiant.");
    echo json_encode($error);
    exit();

}

if (isset($_POST['mdp1']) && $_POST['mdp1']!= "") {
    $mdp1 = $_POST['mdp1'];
} else {
    $error=array('error'=>"Veuillez entrer un Mot De Passe.");
    echo json_encode($error);
    exit();

}

if (isset($_POST['mdp2']) && $_POST['mdp2']!= "") {
    $mdp2 = $_POST['mdp2'];
} else {
    $error=array('error'=>"Veuillez confirmer le Mot De Passe.");
    echo json_encode($error);
    exit();

}

if ($mdp1!=$mdp2) {
    $error=array('error'=>"Les Mots De Passe ne correspondent pas.");
    echo json_encode($error);
    exit();

}


if (isset($_POST['nom']) && $_POST['nom']!= "") {
    $nom = $_POST['nom'];
} else {
    $error=array('error'=>"Veuillez entrer un Nom");
    echo json_encode($error);
    exit();

}

if (isset($_POST['prenom']) && $_POST['prenom']!= "") {
    $prenom = $_POST['prenom'];
} else {
    $error=array('error'=>"Veuillez entrer un Prenom");
    echo json_encode($error);
    exit();

}

if (isset($_POST['email']) && $_POST['email']!= "") {
    $email = $_POST['email'];
} else {
    $error=array('error'=>"Veuillez entrer un e-mail");
    echo json_encode($error);
    exit();

}

$dbh=Database::connect();
if (!Database::getIfUserExists($dbh,$userid)) {
    $error=array('error'=>"Cet Identifiant est deja utilise.");
    echo json_encode($error);
    exit();

}




Database::insertUser($dbh,$userid,$mdp1,$nom,$prenom,$email);
$error=array('error'=>"Bienvenue chew MySynapseS ".$userid." !");
echo json_encode($error);