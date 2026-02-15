<?php
session_start(); // Obligatoire pour accéder à la session actuelle

// On vide toutes les variables de session
$_SESSION = array();

// On détruit la session
session_destroy();

// Redirection vers la page d'accueil ou de connexion
header("Location: index.php");
exit();
?>