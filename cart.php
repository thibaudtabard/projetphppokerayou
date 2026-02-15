<?php 
session_start();
include 'includes/products.php';


if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if(isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit();
}

$total_price = 0;
include 'includes/header-classic.php'; 
?>

<main class="container">
    <section class="hero">
        <h2>🛒 Votre Panier</h2>
        <p>Validez vos achats avant de repartir en chasse.</p>
    </section>

    <div class="cart-container">
        <?php if(empty($_SESSION['cart'])): ?>
            <div style="text-align: center; padding: 40px 0;">
                <p style="color: #888; font-size: 1.2rem;">Votre sac est vide pour le moment.</p>
                <a href="catalogue-clasic.php" class="btn-add" style="width: 250px; margin: 30px auto 0;">Retourner au catalogue</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($_SESSION['cart'] as $id => $quantity): ?>
                        <?php 
                            if(!isset($products[$id])) {
                                unset($_SESSION['cart'][$id]);
                                continue;
                            }
                            
                            $p = $products[$id];
                            $sous_total = $p['price'] * $quantity;
                            $total_price += $sous_total;
                        ?>
                        <tr>
                            <td>
                                <div class="cart-item-info">
                                    <img src="images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="cart-mini-img-real">
                                    <span style="font-weight: bold;"><?= $p['name'] ?></span>
                                </div>
                            </td>
                            <td><?= $p['price'] ?> €</td>
                            <td><span style="background: #333; padding: 5px 15px; border-radius: 15px;">x <?= $quantity ?></span></td>
                            <td style="color: #ff3b3b; font-weight: bold;"><?= $sous_total ?> €</td>
                            <td><a href="?remove=<?= $id ?>" style="color: #ff3b3b; text-decoration: none;">Retirer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-total-section">
                <p style="color: #888; text-transform: uppercase; font-size: 0.9rem;">Total de la commande :</p>
                <div class="total-price"><?= $total_price ?> €</div>
                <button class="btn-checkout">VALIDER LA COMMANDE</button>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>