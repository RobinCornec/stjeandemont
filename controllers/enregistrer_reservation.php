<?php
session_start();

//pdo init
include('../DAO/config.php');
require_once('mailer.php');
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

//POST/GET value
$nom = $_POST['nom'];
$prenom = $_POST['prenom'] ? $_POST['prenom'] : "NULL";
$email = $_POST['email'];
$phone = $_POST['phone'] ? $_POST['phone'] : "NULL";
$nbPersonne = $_POST['nbPersonne'];

try{

	$dateDebut = DateTime::createFromFormat('d/m/Y', $_POST['dateDebut']);
	$dateFin = DateTime::createFromFormat('d/m/Y', $_POST['dateFin']);

	if($dateDebut > $dateFin){
		throw new Exception("La date de début est postérieur à la date de fin");
	}
	else{
		$BDDdateDebut = $dateDebut->format('Y-m-d');
        $BDDdateDebut = $dateFin->format('Y-m-d');
	}

	if($_SESSION['login']){
		
		$req = $pdo->prepare('INSERT INTO reservations (dateDebut, dateFin, nbPersonne, idUser, nom, prenom, mail, phone) VALUES (:dateDebut, :dateFin, :nbPersonne, :idUser, :nom, :prenom, :mail, :phone)');
		$req->bindParam(':dateDebut', $BDDdateDebut);
		$req->bindParam(':dateFin', $BDDdateDebut);
		$req->bindParam(':nbPersonne', $nbPersonne);
		$req->bindParam(':idUser', $_SESSION['id']);
		$req->bindParam(':nom', $nom);
		$req->bindParam(':prenom', $prenom);
		$req->bindParam(':mail', $email);
		$req->bindParam(':phone', $phone);

	}
	else{

		$req = $pdo->prepare('INSERT INTO reservations (dateDebut, dateFin, nbPersonne, nom, prenom, mail, phone) VALUES (:dateDebut, :dateFin, :nbPersonne, :nom, :prenom, :mail, :phone)');
		$req->bindParam(':dateDebut', $dateDebut);
		$req->bindParam(':dateFin', $dateFin);
		$req->bindParam(':nbPersonne', $nbPersonne);
		$req->bindParam(':nom', $nom);
		$req->bindParam(':prenom', $prenom);
		$req->bindParam(':mail', $email);
		$req->bindParam(':phone', $phone);

	}

	$req->execute();
	$_SESSION['successReservation'] = "Demande enregistrée, vous allez recevoir un mail d'ici quelques secondes, puis un autre une fois la confirmation faite par les propriétaires";

    $to =  $email;
    $subject = 'Gîte St-Jean-De-Monts - Réservation';
    $corp = "Bonjour,<br/> 
Nous vous confirmons votre demande de réservation sur notre site et vous en remercions.<br/>
Nous allons la regarder dans les plus brefs délais et reviendrons vers vous pour la suite. <br><br>

Réservation Du ".$dateDebut->format('d/m/Y')." Au ".$dateFin->format('d/m/Y')." <br/>
Nombre de personnes : ".$nbPersonne."

 <br><br>
A bientôt, <br>
La famille Cornec.
";
    $mail = new Mailer();
    $mail->sendMessage($to,$subject,$corp);

    $toAdmin =  'ncornec@neuf.fr';
    $subjectAdmin = 'Gîte St-Jean-De-Monts - Demande de Réservation';
    $corpAdmin = "
Une nouvelle demande de réservations a été faites <br><br>

Par : ".$nom . " " . $prenom ."<br>
Email : ".$email."<br>
Téléphone : ".$phone."<br>
Réservation Du ".$dateDebut->format('d/m/Y')." Au ".$dateFin->format('d/m/Y')." <br/>
Nombre de personnes : ".$nbPersonne."


";
    $mailAdmin = new Mailer();
    $mailAdmin->sendMessage($toAdmin,$subjectAdmin, $corpAdmin);

}
catch (Exception $e){
	$_SESSION['errorReservation'] = 'Il y a un problème avec la réservation, veuillez vérifier vos informations = ' . $e->getMessage();
}

header('Location: ../reservation.php');