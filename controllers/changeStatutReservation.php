<?php

session_start();

//post variables
if(isset($_POST['valid'])) {
    $valid = $_POST['valid'];
}
else{
    $valid = null;
}
if(isset($_POST['refuse'])) {
    $refuse = $_POST['refuse'];
}
else{
    $refuse = null;
}
$idBooking = $_POST['idBooking'];

//pdo init
include('../DAO/config.php');
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

if($valid !== null && $refuse === null){
    $libelleStatut = "Valide";
}
elseif ($refuse !== null && $valid === null){
    $libelleStatut = "Refuse";
}
else{
    $libelleStatut = "En Attente";
}

$req1 = $pdo->prepare('SELECT id FROM statut WHERE libelle = :libelleStatut');
$req1->bindParam(':libelleStatut', $libelleStatut);
$req1->execute();

$resultat = $req1->fetch();
$idStatut = $resultat['id'];

$req2 = $pdo->prepare('UPDATE reservations SET idStatut = :idStatut WHERE id = :id');
$req2->bindParam(':id', $idBooking);
$req2->bindParam(':idStatut', $idStatut);

$req2->execute();

header('Location: ../adminBooking.php');