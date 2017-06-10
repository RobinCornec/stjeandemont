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
require_once('mailer.php');
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

$req3 = $pdo->prepare('SELECT dateDebut,dateFin,nbPersonne,mail FROM reservations WHERE id = :id');
$req3->bindParam(':id', $idBooking);
$req3->execute();

$resultat3 = $req3->fetch();

$BDDdateDebut = $resultat3['dateDebut'];
$dateDebut = DateTime::createFromFormat('Y-m-d', $BDDdateDebut);

$BDDdateFin = $resultat3['dateFin'];
$dateFin = DateTime::createFromFormat('Y-m-d', $BDDdateFin);

$nbPersonne = $resultat3['nbPersonne'];
$email = $resultat3['mail'];

if($valid !== null && $refuse === null){
    $libelleStatut = "Valide";

    $corp = "Bonjour,<br/> 
Nous vous informons votre demande de réservation est maintenant Validée.<br/>
Nous reviendrons vers vous pour les modalités d'arrivée (Récupération des clés,...)<br/>
En vous souhaitant d'agréables vacances chez nous.<br><br>

Réservation Du ".$dateDebut->format('d/m/Y')." Au ".$dateFin->format('d/m/Y')."<br>
Nombre de personnes : ".$nbPersonne."

 <br><br>
A bientôt, <br>
La famille Cornec.
";
}
elseif ($refuse !== null && $valid === null){
    $libelleStatut = "Refuse";

    $corp = "Bonjour,<br/> 
Nous vous informons malheureusement que votre demande de réservation a été Refusée.<br/><br>

Réservation Du ".$dateDebut->format('d/m/Y')." Au ".$dateFin->format('d/m/Y')."<br>
Nombre de personnes : ".$nbPersonne."

 <br><br>
A bientôt, <br>
La famille Cornec.
";

}
else{
    $libelleStatut = "En Attente";

    $corp = "Bonjour,<br/> 
Nous vous informons votre demande de réservation est maintenant En Attente.<br/>
Nous reviendrons vers vous pour plus d'informations. <br><br>

Réservation Du ".$dateDebut->format('d/m/Y')." Au ".$dateFin->format('d/m/Y')." <br/>
Nombre de personnes : ".$nbPersonne."

 <br><br>
A bientôt, <br>
La famille Cornec.
";
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



$to =  $email;
$subject = 'Gîte St-Jean-De-Monts - Votre Réservation';

$mail = new Mailer();
$mail->sendMessage($to,$subject,$corp);

header('Location: ../adminBooking.php');