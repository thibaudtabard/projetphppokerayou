<?php
session_start();
include 'includes/pokemon-products.php';

if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if(isset($_SESSION['mc_cart'][$id])) {
        unset($_SESSION['mc_cart'][$id]);
    }
    header("Location: cart-cobblemon.php");
    exit();
}

$total_price = 0;
include 'includes/header.php'; 
?>

<main class="container">
    <section class="hero">
        <h2>INVENTAIRE</h2>
        <p style="color:#fff; font-family:'Roboto'; margin-top:10px;">Vérifie tes adoptions avant de rejoindre le serveur.</p>
    </section>

    <div class="cart-container">
        <?php if(empty($_SESSION['mc_cart'])): ?>
            <div style="text-align: center; padding: 40px 0;">
                <p style="color: #fff; font-family: 'Press Start 2P'; margin-bottom: 20px;">VOTRE INVENTAIRE EST VIDE.</p>
                <a href="catalogue-cobblemon.php" class="btn-primary" style="text-decoration: none; padding: 15px; display:inline-block;">RETOURNER AU CENTRE</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr><th>POKÉMON</th><th>PRIX</th><th>QTÉ</th><th>TOTAL</th><th>ACTION</th></tr>
                </thead>
                <tbody>
                    <?php foreach($_SESSION['mc_cart'] as $id => $quantity): ?>
                        <?php 
                            if(!isset($pokemons[$id])) { unset($_SESSION['mc_cart'][$id]); continue; }
                            $p = $pokemons[$id];
                            $sous_total = $p['price'] * $quantity;
                            $total_price += $sous_total;
                        ?>
                        <tr>
                            <td>
                                <div class="cart-item-info">
                                    <img src="images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="cart-mini-img-real">
                                    <span style="color: #fff;"><?= $p['name'] ?></span>
                                </div>
                            </td>
                            <td style="color:#aaa;"><?= $p['price'] ?> €</td>
                            <td><span style="background: #222; padding: 10px; border: 2px solid #555; color: #fff;">x<?= $quantity ?></span></td>
                            <td style="color: #4eff5a; font-family: 'Press Start 2P'; font-size: 0.8rem;"><?= $sous_total ?> € </td>
                            <td><a href="?remove=<?= $id ?>" style="color: #ff3b3b; text-decoration: none; font-family: 'Press Start 2P'; font-size: 0.7rem;">[X] RETIRER</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-total-section">
                <p style="color: #aaa; font-family: 'Press Start 2P'; font-size: 0.8rem; margin-bottom: 10px;">TOTAL À PAYER :</p>
                <div class="total-price"><?= $total_price ?> €</div>
                <button class="btn-checkout">VALIDER L'ADOPTION</button>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>