<?php 
session_start();
include 'includes/products.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_id'])) {
    $id = $_POST['add_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if($qty < 1) $qty = 1;

    if(isset($products[$id])) { 
        
        //panier
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $qty; 
        } else {
            $_SESSION['cart'][$id] = $qty; 
        }

        // compteru top3
        if(!isset($_SESSION['sales'])) {
            $_SESSION['sales'] = [];
        }
        if(isset($_SESSION['sales'][$id])) {
            $_SESSION['sales'][$id] += $qty;
        } else {
            $_SESSION['sales'][$id] = $qty;
        }

        header("Location: catalogue-clasic.php?success=1");
        exit();
    }
}

include 'includes/header-classic.php'; 
?>

<main class="container">

    <section class="hero">
        <h2> Catalogue Complet</h2>
        <p>Tout notre équipement pour votre aventure.</p>
        
        <?php if(isset($_GET['success'])): ?>
            <p style="color: #4eff5a; font-weight: bold; margin-top: 15px; padding: 10px; border: 1px solid #4eff5a; border-radius: 10px; display: inline-block;">
                Produits ajoutés au panier avec succès !
            </p>
        <?php endif; ?>
    </section>

    <div class="product-grid">
        <?php foreach($products as $id => $p): ?>
            <div class="card">
                <img src="images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="card-image-real">
                <h3><?= $p['name'] ?></h3>
                <p class="desc"><?= $p['desc'] ?></p>
                <span class="price"><?= $p['price'] ?> €</span>
                
                <form action="catalogue-clasic.php" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="add_id" value="<?= $id ?>">
                    
                    <input type="number" name="quantity" value="1" min="1" max="99" class="qty-input">
                    
                    <button type="submit" class="btn-add">Ajouter</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</main>
</body>
</html>