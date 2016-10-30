<?php
include 'header.php';
//pdo init
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

// Récupérer les reservation
$req = $pdo->prepare('SELECT r.dateDebut, r.dateFin, r.idUser, r.nom, r.prenom, r.mail, r.phone, s.libelle
FROM reservations r JOIN statut s ON r.idStatut = s.id
ORDER BY dateDebut ASC ');
$req->execute();
$resultat = $req->fetchAll();
?>

    <h1>Réservations</h1>
    <hr>
<?php
if(isset($_SESSION['successReservation']) && !empty($_SESSION['successReservation'])){
    echo '<div class="alert alert-success">
		     <strong>Succès !</strong> ' . $_SESSION["successReservation"] . '
		  </div>';

    $_SESSION['successReservation'] = "";
}
elseif(isset($_SESSION['errorReservation']) && !empty($_SESSION['errorReservation'])){
    echo '<div class="alert alert-danger">
		     <strong>Attention !</strong> ' . $_SESSION["errorReservation"] . '
		  </div>';

    $_SESSION['errorReservation'] = "";
}

?>

    <!-- Calendrier -->
    <div id='calendar'></div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajouter une reservation</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form_reservation" action="controllers/enregistrer_reservation.php" role="form" data-toggle="validator">
                        <div class="form-group has-feedback">
                            <label class="sr-only" for="nom">Nom* :</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom*" value="<?php if(isset($_SESSION['nom'])) {echo $_SESSION['nom'];} ?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="sr-only" for="prenom">Prénom :</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="<?php if(isset($_SESSION['prenom'])) {echo $_SESSION['prenom'];} ?>">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="sr-only" for="email">Email* :</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email*" value="<?php if(isset($_SESSION['mail'])) {echo $_SESSION['mail'];} ?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="sr-only" for="phone">Téléphone :</label>
                            <input type="tel" pattern="^[0-9]{10}$" class="form-control" id="phone" name="phone" placeholder="Téléphone" value="<?php if(isset($_SESSION['tel'])) {echo $_SESSION['tel'];} ?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="sr-only" for="nbPersonne">Nombre de personne(s)* :</label>
                            <input type="nbPersonne" pattern="^[0-9]+$" class="form-control" id="nbPersonne" name="nbPersonne" placeholder="Nombre de personne(s)*" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class='input-group date' id='datePickerDebut'>
                                <label class="sr-only" for="dateDebut">Date de début* :</label>
                                <input type="text" pattern="^[0-9]{2}/[0-9]{2}/[0-9]{4}$" class="form-control" id="dateDebut" name="dateDebut" placeholder="Date de début*" required>
                                <span class="input-group-addon" style="cursor: pointer;">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class='input-group date' id='datePickerFin'>
                                <label class="sr-only" for="dateFin">Date de fin* :</label>
                                <input type="text" class="form-control" id="dateFin" name="dateFin" placeholder="Date de fin*" required>
                                <span class="input-group-addon" style="cursor: pointer;">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Demander une réservation</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.glyphicon-calendar').on('click', function () {
                $(this).parent().parent().datepicker({
                    format: 'dd/mm/yyyy'
                });
            });
            $('#form_reservation').validator();


            $('#calendar').fullCalendar({
                locale: 'fr',
                customButtons: {
                    myCustomButton: {
                        text: 'Ajouter une réservation',
                        click: function() {
                            $('#myModal').modal('show');
                        }
                    }
                },
                header: {
                    left: 'title',
                    center: '',
                    right: 'myCustomButton prev,today,next'
                },
                events: [
<?php
foreach ($resultat as $res){
    if($_SESSION['isAdmin']){
        echo "{
            start: '" . $res['dateDebut'] . "',
            end: '" . $res['dateFin'] . "',
            title: '" . $res['nom'] . " " . $res['prenom'] . " - " . $res['mail'] . " - " . $res['phone'] . "',";
            if ($res['libelle'] == 'Valide') {
                echo "color: '#4CAF50',";
            }
            elseif ($res['libelle'] == 'Refuse'){
                echo "color: '#D9534F',";
            }
        echo "},";
    }
    elseif($res['libelle'] != 'Refuse') {
        echo "{
            start: '" . $res['dateDebut'] . "',
            end: '" . $res['dateFin'] . "',";
        if (isset($res['idUser']) && !empty($res['idUser']) && $_SESSION['login'] && $res['idUser'] == $_SESSION['id']) {
            echo "title: '" . $res['nom'] . " " . $res['prenom'] . " - " . $res['mail'] . " - " . $res['phone'] . "',";
            if ($res['libelle'] == 'Valide') {
                echo "color: '#4CAF50',";
            }
        }
        echo "},";
    }
}
?>
                    /*{
                        title: 'My Event',
                        start: '2016-10-10',
                        end: '2016-10-20',
                        description: 'This is a cool event'
                    }*/
                    // more events here
                ],
                eventRender: function(event, element) {}
            });

        });
    </script>
<?php
include 'footer.php';