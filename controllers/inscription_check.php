<?php
session_start();

//pdo init
include('../DAO/config.php');
require_once('mailer.php');
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

//POST/GET value
$password = hash('sha512',$_POST['pwd']);
$nom = $_POST['nom'];
$prenom = $_POST['prenom'] ? $_POST['prenom'] : null;
$mail = $_POST['email'];
$tel = $_POST['phone'] ? $_POST['phone'] : null;
$codePostal = $_POST['codePostal'] ? $_POST['codePostal'] : null;
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
    $to = $mail;
    $subject = 'Gîte St-Jean-De-Monts - Inscription';
    $corp = "Bonjour,<br/> 
Nous vous confirmons votre inscription sur notre site et vous souhaitons une agréable visite.<br/>
Vous pouvez dès à présent vous connecter et réserver vos vacances à l'adresse http://ddns.robincornec.ovh/stjeandemonts <br><br>
Cordialement, <br>
La famille Cornec.
";
    $mail = new Mailer();
    $mail->sendMessage($to,$subject,$corp);
}
catch (Exception $e){
	$_SESSION['errorInscritption'] = 'Il y a un problème avec l\'inscription, veuillez vérifier vos informations : ' . $e->getMessage();
}

header('Location: ../inscription.php');