<?php
session_start();
// On vérifie si l'utilisateur est connecté ET s'il a le rôle 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit();
}
?>