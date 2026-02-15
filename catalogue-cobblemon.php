<?php 
session_start();
include 'includes/pokemon-products.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_id'])) {
    $id = $_POST['add_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    if($qty < 1) $qty = 1;

    if(isset($pokemons[$id])) { 
        
        //  panier
        if(!isset($_SESSION['mc_cart'])) $_SESSION['mc_cart'] = [];
        if(isset($_SESSION['mc_cart'][$id])) {
            $_SESSION['mc_cart'][$id] += $qty;
        } else {
            $_SESSION['mc_cart'][$id] = $qty;
        }

        // top3
        if(!isset($_SESSION['mc_sales'])) $_SESSION['mc_sales'] = [];
        if(isset($_SESSION['mc_sales'][$id])) {
            $_SESSION['mc_sales'][$id] += $qty;
        } else {
            $_SESSION['mc_sales'][$id] = $qty;
        }

        header("Location: catalogue-cobblemon.php?success=1");
        exit();
    }
}

include 'includes/header.php'; 
?>

<main class="container">
    <section class="hero">
        <h2>CENTRE D'ADOPTION</h2>
        <p style="color:#fff; font-family:'Roboto'; margin-top:10px;">Tous les Pokémon disponibles sur le serveur.</p>
        <?php if(isset($_GET['success'])): ?>
            <div style="background-color: rgba(78, 255, 90, 0.2); border: 4px solid #4eff5a; padding: 10px; margin-top: 20px; color: #4eff5a;">
                <h3 style="font-size: 0.8rem;"> COMPAGNON(S) AJOUTÉ(S) AU PANIER !</h3>
            </div>
        <?php endif; ?>
    </section>

    <div class="product-grid">
        <?php foreach($pokemons as $id => $p): ?>
            <div class="card <?= $p['css_type'] ?>">
                <img src="images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="card-image-real">
                <h3><?= $p['name'] ?></h3>
                <p class="desc"><?= $p['desc'] ?></p>
                <span class="price"><?= $p['price'] ?> €</span>
                
                <form action="catalogue-cobblemon.php" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="add_id" value="<?= $id ?>">
                    <input type="number" name="quantity" value="1" min="1" max="99" class="qty-input-mc">
                    <button type="submit" class="btn-primary">ADOPTER</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>