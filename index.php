<?php
session_start();
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = "Accès réseau autorisé. Bienvenue Dresseur !";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeRayou - Le Multivers</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="portal-body">

    <div class="stars-bg"></div>

    <div class="portal-container">
        
        <div class="portal-header">
            <h1 class="portal-title">POKERAYOU</h1>
            <p class="portal-subtitle">Sélectionnez votre dimension</p>
        </div>

        <div class="portal-choices">
            
            <a href="classic.php" class="portal-card card-classic">
                <div class="card-glow"></div>
                <div class="card-content">
                    <img src="images/pokeball.png" alt="Poké Ball" class="portal-image">
                    
                    <h2 class="font-modern">POKÉSHOP</h2>
                    <p class="font-modern desc-text">L'expérience Classique</p>
                    <span class="btn-enter classic-btn">ENTRER</span>
                </div>
            </a>

            <a href="cobblemon.php" class="portal-card card-minecraft">
                <div class="card-glow"></div>
                <div class="card-content">
                    <img src="images/384.png" alt="Cobblemon" class="portal-image">
                    
                    <h2 class="font-pixel">COBBLEMON</h2>
                    <p class="font-pixel desc-text" style="font-size: 0.6rem; color: #aaa; margin-top: 15px;">Le monde Cubique</p>
                    <span class="btn-enter mc-btn">JOUER</span>
                </div>
            </a>
            
        </div>

        <div class="auth-panel">
            <h3><i class="fas fa-id-card"></i> CARTE DRESSEUR</h3>
            
            <?php if(!empty($message)): ?>
                <p class="msg-info"><?php echo $message; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="pseudo" placeholder="Identifiant" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="btn-login">CONNEXION AU RÉSEAU</button>
            </form>
            
            <div class="auth-links">
                <a href="#">Nouvel arrivant ? Créer un profil</a>
            </div>
        </div>

    </div>

</body>
</html>