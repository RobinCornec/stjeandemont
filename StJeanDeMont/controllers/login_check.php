<?php
//pdo init
include('../DAO/config.php');
$pdo = new PDO('mysql:host='.configbdd::HOST.';dbname='.configbdd::DBNAME, configbdd::USERNAME, configbdd::PASSWORD);

//POST/GET value
$username = $_POST['username'];
$password = hash('sha512',$_POST['pwd']);

// Vérification des identifiants
$req = $pdo->prepare('SELECT id, nom, prenom, isAdmin, tel, mail FROM users WHERE username = :username AND password = :password');
$req->bindParam(':username', $username);
$req->bindParam(':password', $password);

$req->execute();

$resultat = $req->fetch();

if (!$resultat)
{
	// Suppression des variables de session et de la session
	$_SESSION = array();
	session_destroy();

	session_start();

    $_SESSION['erreurMsg'] = 'Mauvais identifiant ou mot de passe !';
    $_SESSION['login'] = false;

	// Suppression des cookies de connexion automatique
	setcookie('login', '');
	setcookie('pass_hache', '');
	
    header('Location: ../login.php'); 
}
else
{
	session_start();

    $_SESSION['id'] = $resultat['id'];
    $_SESSION['nom'] = $resultat['nom'];
    $_SESSION['prenom'] = $resultat['prenom'];
    $_SESSION['isAdmin'] = $resultat['isAdmin'];
    $_SESSION['tel'] = $resultat['tel'];
    $_SESSION['mail'] = $resultat['mail'];
    $_SESSION['username'] = $username;
    $_SESSION['login'] = true;

    header('Location: ../index.php');
}