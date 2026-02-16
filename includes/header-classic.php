<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéShop - Classique</title>
    <link rel="stylesheet" href="style-classic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header>
    <div class="container header-content">
        <div class="logo">
            <h1>🔴 PokeShop</h1>
        </div>
<nav>
            <ul>
                <li><a href="index.php" class="btn-back">⬅ Portail</a></li>
                <li><a href="classic.php">Accueil (Top 3)</a></li>
                <li><a href="catalogue-clasic.php">Tout le Catalogue</a></li>
                
                <?php 
                    $cart_count = 0;
                    if(isset($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $qty) {
                            $cart_count += $qty;
                        }
                    }
                ?>
                <li>
                    <a href="cart.php" style="color: #ff3b3b;">
                        <i class="fas fa-shopping-cart"></i> Panier 
                        <?= ($cart_count > 0) ? "($cart_count)" : "" ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li><a href="admin/adminProducts.php" style="color: #ffcc00;">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php endif; ?>
                </ul>
        </nav>
    </div>
</header>