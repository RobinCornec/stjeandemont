<?php
session_start();
if(!isset($_SESSION['login'])){	
	$_SESSION['login'] = false;
}


if(strpos($_SERVER['REQUEST_URI'], 'presentation.php') !== false){
	$menu = "presentation";
}
elseif(strpos($_SERVER['REQUEST_URI'], 'reservation.php') !== false){
	$menu = "reservation";
}
elseif(strpos($_SERVER['REQUEST_URI'], 'apropos.php') !== false){
	$menu = "apropos";
}
elseif(strpos($_SERVER['REQUEST_URI'], 'admin') !== false){
	$menu = "administration";
}
elseif(strpos($_SERVER['REQUEST_URI'], 'inscription.php') !== false){
	$menu = "inscription";
}
elseif(strpos($_SERVER['REQUEST_URI'], 'login.php') !== false){
	$menu = "login";
}
elseif(strpos($_SERVER['REQUEST_URI'], 'moncompte.php') !== false){
	$menu = "moncompte";
}
else{
	$menu = "index";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  	<title>St-Jean-De-Mont</title>

  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.print.css" rel="stylesheet" media="print">
  	<link rel="stylesheet" href="./public/css/css.css">

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script> 
  	<script src="./public/js/jquery-3.1.1.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/locale-all.js"></script>

  <?php 
  	include('./DAO/config.php');
  ?>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	      </button>
	      <a class="navbar-brand" href="index.php">Logo</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <li <?php if($menu == "index"){echo 'class="active"';} ?> ><a href="index.php">Accueil</a></li>
	        <li <?php if($menu == "presentation"){echo 'class="active"';} ?> ><a href="presentation.php">Présentation</a></li>
	        <li <?php if($menu == "reservation"){echo 'class="active"';} ?> ><a href="reservation.php">Réservations</a></li>
	        <li <?php if($menu == "apropos"){echo 'class="active"';} ?> ><a href="apropos.php">A Propos</a></li>
	        <?php
	        if($_SESSION['login'] && $_SESSION['isAdmin']){
	        	if($menu == "administration"){
                    echo '  <li class="dropdown active">';
	        	}
	        	else{
	        		echo '  <li class="dropdown">';
	        	}
	        	echo '      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="adminBooking.php">Réservations</a></li>
                                <li><a href="adminUser.php">Utilisateurs</a></li>
                                <li><a href="adminText.php">Textes</a></li>
                              </ul>
                            </li>';
	        }
	        ?>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        
	        <?php
	        	if ($_SESSION['login'])
				{
					if($menu == "moncompte"){
						 echo '	<li><a>Bonjour '.$_SESSION["prenom"]. ' ' .$_SESSION["nom"].'</a></li>
						 	<li class="active">
				    			<a href="moncompte.php">Mon Compte</a>
				    		</li>
				    		<li>
				    			<a href="controllers/logout.php"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a>
				    		</li>';
					}
					else{
						echo '	<li><a>Bonjour '.$_SESSION["prenom"]. ' ' .$_SESSION["nom"].'</a></li>
							<li>
				    			<a href="moncompte.php">Mon Compte</a>
				    		</li>
				    		<li>
				    			<a href="controllers/logout.php"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a>
				    		</li>';
					}
				   
				}
				else{
					if($menu == "inscription"){
						echo'	<li class="active">
								<a href="inscription.php"><span class="glyphicon glyphicon-registration-mark"></span> S\'inscrire</a>
							</li>
							<li>
								<a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a>
							</li>';
					}
					elseif ($menu == "login") {
						echo'	<li>
								<a href="inscription.php"><span class="glyphicon glyphicon-registration-mark"></span> S\'inscrire</a>
							</li>
							<li class="active">
								<a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a>
							</li>';
					}
					else{
						echo'	<li>
								<a href="inscription.php"><span class="glyphicon glyphicon-registration-mark"></span> S\'inscrire</a>
							</li>
							<li>
								<a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a>
							</li>';
					}

					
				}
	        		
	        ?>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container-fluid text-center">
		<h3>Fixed Navbar</h3>
		  <div class="row content">
		    <div class="col-sm-2 sidenav">
				<h4>Liens utiles</h4>
		      	<p><a href="http://www.saintjeandemonts.fr/" target="_blank">Mairie de Saint-Jean-de-Monts</a></p>
				<p><a href="https://www.saint-jean-de-monts.com/" target="_blank">Office de Tourisme</a></p>
				<p><a href="http://www.golfsaintjeandemonts.fr/" target="_blank">Golf</a></p>
				<p><a href="http://www.thalasso.com/thalasso/les-destinations/saint-jean-de-monts" target="_blank">Thalasso</a></p>

			</div>

			<div class="col-sm-8 text-left"> 
