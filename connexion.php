<?php
// Fichier : connexion.php
session_start();
require 'db.php';

$erreur = ""; // On initialise la variable pour les erreurs

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête préparée pour trouver l'utilisateur 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe haché 
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role']; // Utile pour le back-office
        
        // Redirection vers l'accueil (Portail Multivers)
        header('Location: index.php'); 
        exit();
    } else {
        $erreur = "Identifiants ou mot de passe incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeRayou - Connexion</title>
    <link rel="stylesheet" href="style-inscription.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="stars-bg"></div>

    <div class="auth-wrapper">
        <div class="auth-panel">
            
            <div class="auth-header">
                <i class="fas fa-user-shield auth-icon"></i>
                <h2>CONNEXION RÉSEAU</h2>
                <p>Identifiez-vous, Dresseur</p>
            </div>

            <?php if (!empty($erreur)): ?>
                <div class="error-msg">
                    <i class="fas fa-exclamation-triangle"></i> <?= $erreur ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Adresse Email" required autocomplete="off">
                </div>

                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <button type="submit" class="btn-submit">SE CONNECTER</button>
            </form>

            <div class="auth-links">
                <p>Pas encore de profil ? <a href="inscription.php">S'enregistrer</a></p>
                <p style="margin-top: 10px;"><a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Retour au portail</a></p>
            </div>

        </div>
    </div>

</body>
</html>