<?php
include 'header.php';
?>

  <h1>Inscription</h1>
  <hr>
  	<?php
		if(isset($_SESSION['successInscritption']) && !empty($_SESSION['successInscritption'])){
			echo '<div class="alert alert-success">
				     <strong>Succès !</strong> ' . $_SESSION["successInscritption"] . '
				  </div>';

		  	$_SESSION['successInscritption'] = "";
		}
		elseif(isset($_SESSION['errorInscritption']) && !empty($_SESSION['errorInscritption'])){
			echo '<div class="alert alert-danger">
				     <strong>Attention !</strong> ' . $_SESSION["errorInscritption"] . '
				  </div>';

		  	$_SESSION['errorInscritption'] = "";
		}
	?>
  <p>
  	<form method="POST" id="form_inscription" action="controllers/inscription_check.php" role="form" data-toggle="validator">
    <div class="form-group has-feedback">
        <label class="sr-only" for="email">Email* :</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email*" required>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group has-feedback">
	    <label class="sr-only" for="pwd">Mot de passe* :</label>
	    <input type="password" data-minlength="6" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe*" required>
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block">Au moins 6 caractères</div>
	  </div>	  
	  <div class="form-group has-feedback">
	    <label class="sr-only" for="pwd2">Retaper le mot de passe* :</label>
	    <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Retaper le mot de passe*" data-match="#pwd" data-match-error="Les mots de passe ne correspondent pas" required>
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block with-errors"></div>
	  </div>	  
	  <div class="form-group has-feedback">
	    <label class="sr-only" for="nom">Nom* :</label>
	    <input type="text" class="form-control" id="nom" name="nom" maxlength="32" placeholder="Nom*" required>
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block with-errors"></div>
	  </div>
	  <div class="form-group has-feedback">
	    <label class="sr-only" for="prenom">Prénom :</label>
	    <input type="text" class="form-control" id="prenom" name="prenom" maxlength="32" placeholder="Prénom">
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block with-errors"></div>
	  </div>
	  <div class="form-group has-feedback">
	    <label class="sr-only" for="phone">Téléphone :</label>
	    <input type="text" pattern="^[0-9]{10}$" class="form-control" id="phone" maxlength="20" name="phone" placeholder="Téléphone" min="10" max="10">
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block with-errors"></div>
	  </div> 
	  <div class="form-group has-feedback">
	    <label class="sr-only" for="codePostal">Code Postal :</label>
	    <input type="text" pattern="^[0-9]{5}$" class="form-control" id="codePostal" maxlength="5" name="codePostal" placeholder="Code Postal">
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block with-errors"></div>
	  </div>
	  <div class="form-group has-feedback">
	    <label class="sr-only" for="ville">Ville :</label>
	    <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville">
	    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	    <div class="help-block with-errors"></div>
	  </div>
	  <div class="form-group">
	    <button type="submit" class="btn btn-primary">S'inscrire</button>
	  </div>
	</form>
  </p>
<script type="text/javascript">
	$('#form_inscription').validator();
</script>
<?php
include 'footer.php';