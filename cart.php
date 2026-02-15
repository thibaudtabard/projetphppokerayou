<?php 
session_start();
require 'db.php'; // On utilise la BDD et non plus l'include static

// Sécurité : Redirection si pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=auth");
    exit();
}

// Logique pour retirer un objet
if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if(isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit();
}

$total_price = 0;
$cart_items = [];

// Récupération des infos produits depuis la BDD pour les IDs dans le panier
if(!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header-classic.php'; 
?>

<main class="container">
    <section class="hero">
        <h2> Votre Panier Classic</h2>
    </section>

    <div class="cart-container">
        <?php if(empty($cart_items)): ?>
            <p>Votre sac est vide.</p>
        <?php else: ?>
            <table class="cart-table">
                <?php foreach($cart_items as $p): 
                    $quantity = $_SESSION['cart'][$p['id']];
                    $sous_total = $p['prix'] * $quantity;
                    $total_price += $sous_total;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nom']) ?></td>
                        <td><?= number_format($p['prix'], 2) ?> €</td>
                        <td>x <?= $quantity ?></td>
                        <td><?= number_format($sous_total, 2) ?> €</td>
                        <td><a href="?remove=<?= $p['id'] ?>">Retirer</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="total-price">Total : <?= number_format($total_price, 2) ?> €</div>
        <?php endif; ?>
    </div>
</main>