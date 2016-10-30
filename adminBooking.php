<?php
include 'header.php';

//pdo init
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);
?>

  <h1>Administration - Réservations</h1>
  <hr>

<?php

// Récupérer les reservation
$req = $pdo->prepare('SELECT r.id, r.nom, r.prenom, r.mail, r.phone, r.dateDebut, r.dateFin, r.nbPersonne, s.libelle
                      FROM reservations r
                        JOIN statut s ON r.idStatut = s.id
  WHERE r.dateDebut > current_date()
                      ORDER BY idStatut, dateDebut, dateFin');
$req->execute();

$resultat = $req->fetchAll();

foreach ($resultat as $res)
{
    if ($res['libelle'] == "Valide"){
        echo '<div class="panel panel-success">';
    }
    elseif ($res['libelle'] == "En Attente"){
        echo '<div class="panel panel-primary">';
    }
    elseif ($res['libelle'] == "Refuse"){
        echo '<div class="panel panel-danger">';
    }
    else{
        echo '<div class="panel panel-default">';
    }
    echo   '<div class="panel-heading">Du ' . $res['dateDebut'] . ' Au ' . $res['dateFin'] . '</div>
            <div class="panel-body"> 
                Nom : ' . $res['nom'] . '<br> 
                Prenom : ' . $res['prenom'] . '<br> 
                Mail : ' . $res['mail'] . '<br> 
                Phone : ' . $res['phone'] . '<br> 
                Nombre de personne(s) : ' . $res['nbPersonne'] . '<br><form method="POST" action="./controllers/changeStatutReservation.php"><input type="hidden" id="idBooking" name="idBooking" value="'.$res['id'].'">';
    if ($res['libelle'] == "Valide"){
        echo '  <button type="submit" class="btn btn-danger" id="refuse" name="refuse">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>';
    }
    elseif ($res['libelle'] == "Refuse"){
        echo '  <button type="submit" class="btn btn-success" id="valid" name="valid">
                    <span class="glyphicon glyphicon-ok"></span>
                </button> ';
    }
    else{
        echo '  <button type="submit" class="btn btn-success" id="valid" name="valid">
                    <span class="glyphicon glyphicon-ok"></span>
                </button>        
                <button type="submit" class="btn btn-danger" id="refuse" name="refuse">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>';
    }

    echo '</form></div>
        </div>';
}

include 'footer.php';