<?php
include 'header.php';
?>

<h1>Connexion</h1>
<hr>

 <form method="POST" action="controllers/login_check.php" class="form-inline">
  <div class="form-group">
    <label class="sr-only" for="username">Nom d'utilisateur :</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" required>
  </div>
  <div class="form-group">
    <label class="sr-only" for="pwd">Mot de passe :</label>
    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe" required>
  </div>
  <button type="submit" class="btn btn-default">Se connecter</button>
</form>
<?php
if(isset($_SESSION['erreurMsg']) && !empty($_SESSION['erreurMsg'])){
  echo '<br><div class="alert alert-danger">
           <strong>Attention !</strong> ' . $_SESSION["erreurMsg"] . '
        </div>';
  $_SESSION['erreurMsg'] = "";
}

include 'footer.php';