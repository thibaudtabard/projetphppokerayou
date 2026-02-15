<?php
session_start();
require 'db.php'; // On appelle la connexion à la BDD

$message = "";

// LOGIQUE DE CONNEXION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $email = $_POST['email']; // Utilise l'email comme identifiant
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];
        $message = "Accès réseau autorisé. Bienvenue Dresseur " . htmlspecialchars($user['nom']) . " !";
    } else {
        $message = "Identifiants incorrects. Accès refusé.";
    }
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
                <p class="msg-info" style="color: #ffcb05; margin-bottom: 15px;"><?php echo $message; ?></p>
            <?php endif; ?>

            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-logged">
                    <p>Dresseur : <strong><?= htmlspecialchars($_SESSION['user_nom']) ?></strong></p>
                    <p>Rang : <strong><?= strtoupper($_SESSION['user_role']) ?></strong></p>
                    
                    <div class="auth-links" style="margin-top: 20px;">
                        <?php if($_SESSION['user_role'] === 'admin'): ?>
                            <a href="admin/admin_products.php" style="color: #ffcb05;"><i class="fas fa-tools"></i> Accès Admin</a> |
                        <?php endif; ?>
                        <a href="deconnexion.php" style="color: #ff4444;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </div>
                </div>

            <?php else: ?>
                <form method="POST" action="">
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email (Identifiant)" required>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" name="login_submit" class="btn-login">CONNEXION AU RÉSEAU</button>
                </form>
                
                <div class="auth-links">
                    <a href="inscription.php">Nouvel arrivant ? Créer un profil</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>