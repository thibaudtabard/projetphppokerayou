<?php
session_start();
require '../db.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=auth");
    exit();
}

// Retirer un item du panier
if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if(isset($_SESSION['mc_cart'][$id])) {
        unset($_SESSION['mc_cart'][$id]);
    }
    header("Location: cart-cobblemon.php");
    exit();
}

$total_price = 0;
$cart_items = []; // On prépare un tableau vide

//: Récupérer les infos des items depuis la BDD
if(!empty($_SESSION['mc_cart'])) {
    // On récupère la liste des IDs
    $ids = array_keys($_SESSION['mc_cart']);
    
    // Astuce SQL pour créer autant de '?' que d'IDs
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    // chercher les infos (nom, prix, image) des IDs
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php'; 
?>

<main class="container">
    <section class="hero">
        <h2>INVENTAIRE</h2>
        <p style="color:#fff; font-family:'Roboto'; margin-top:10px;">Vérifie tes adoptions avant de rejoindre le serveur.</p>
    </section>

    <div class="cart-container">
        <?php if(empty($cart_items)): ?>
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
                    <?php foreach($cart_items as $p): ?>
                        <?php 
                            // On récupère la quantité stockée en session pour cet ID
                            $quantity = $_SESSION['mc_cart'][$p['id']];
                            $sous_total = $p['prix'] * $quantity;
                            $total_price += $sous_total;
                        ?>
                        <tr>
                            <td>
                                <div class="cart-item-info">
                                    <img src="images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>" class="cart-mini-img-real">
                                    <span style="color: #fff;"><?= htmlspecialchars($p['nom']) ?></span>
                                </div>
                            </td>
                            <td style="color:#aaa;"><?= number_format($p['prix'], 2) ?> €</td>
                            <td>
                                <span style="background: #222; padding: 10px; border: 2px solid #555; color: #fff;">x<?= $quantity ?></span>
                            </td>
                            <td style="color: #4eff5a; font-family: 'Press Start 2P'; font-size: 0.8rem;">
                                <?= number_format($sous_total, 2) ?> € 
                            </td>
                            <td>
                                <a href="?remove=<?= $p['id'] ?>" style="color: #ff3b3b; text-decoration: none; font-family: 'Press Start 2P'; font-size: 0.7rem;">[X] RETIRER</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-total-section">
                <p style="color: #aaa; font-family: 'Press Start 2P'; font-size: 0.8rem; margin-bottom: 10px;">TOTAL À PAYER :</p>
                <div class="total-price"><?= number_format($total_price, 2) ?> €</div>
                
                <button class="btn-checkout" onclick="alert('Commande validée !);">VALIDER L'ADOPTION</button>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>