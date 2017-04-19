<?php
session_start();

//pdo init
include('../DAO/config.php');
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

//POST/GET value
$password = hash('sha512',$_POST['pwd']);
$nom = $_POST['nom'];
$prenom = $_POST['prenom'] ? $_POST['prenom'] : "NULL";
$mail = $_POST['email'];
$tel = $_POST['phone'] ? $_POST['phone'] : "NULL";
$codePostal = $_POST['codePostal'] ? $_POST['codePostal'] : "NULL";
$ville = $_POST['ville'] ? $_POST['ville'] : null;

$dateCreation = new DateTime();
$dateCreation = $dateCreation->format('Y-m-d H:i:s');

try{
    $reqS = $pdo->prepare('SELECT * FROM users WHERE mail = :mail');
    $reqS->bindParam(':mail', $mail);
    $reqS->execute();
    if($reqS->rowCount() > 0){
        throw new Exception("L'email est déjà utilisé");
    }


	$req = $pdo->prepare('INSERT INTO users (password, nom, prenom, mail, tel, codePostal, ville, dateCreation) VALUES (:password, :nom, :prenom, :mail, :tel, :codePostal, :ville, :dateCreation)');
	$req->bindParam(':password', $password);
	$req->bindParam(':nom', $nom);
	$req->bindParam(':prenom', $prenom);
	$req->bindParam(':mail', $mail);
	$req->bindParam(':tel', $tel);
	$req->bindParam(':codePostal', $codePostal);
	$req->bindParam(':ville', $ville);
	$req->bindParam(':dateCreation', $dateCreation);

	$req->execute();
	$_SESSION['successInscritption'] = "Inscription faite, vous allez recevoir un mail d'ici quelques secondes";
}
catch (Exception $e){
	$_SESSION['errorInscritption'] = 'Il y a un problème avec l\'inscription, veuillez vérifier vos informations : ' . $e->getMessage();
}

header('Location: ../inscription.php');