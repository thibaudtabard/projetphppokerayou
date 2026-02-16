<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeRayou - Cobblemon Academy</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header>
    <div class="container header-content">
        <div class="logo-container">
            <div class="logo-main">POKERAYOU</div>
            <div class="logo-sub">COBBLEMON ACADEMY</div>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" style="background-color: #555;">⬅ PORTAIL</a></li>
                <li><a href="cobblemon.php">ACCUEIL</a></li>
                <li><a href="catalogue-cobblemon.php">CATALOGUE</a></li>
                
                <?php 
                    $mc_cart_count = 0;
                    if(isset($_SESSION['mc_cart'])) {
                        foreach($_SESSION['mc_cart'] as $qty) {
                            $mc_cart_count += $qty;
                        }
                    }
                ?>
                <li>
                    <a href="cart-cobblemon.php" style="border-color: #ffcb05; color: #ffcb05;">
                        <i class="fas fa-shopping-cart"></i> PANIER 
                        <?= ($mc_cart_count > 0) ? "($mc_cart_count)" : "" ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li><a href="admin/adminProducts.php" style="color: #ffcb05;"><i class="fas fa-tools"></i> ADMIN</a></li>
                    <?php endif; ?>
                    <li><a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> DÉCONNEXION</a></li>
                <?php else: ?>
                    <li><a href="connexion.php"><i class="fas fa-user"></i> CONNEXION</a></li>
                <?php endif; ?>
                </ul>
        </nav>
    </div>
</header>