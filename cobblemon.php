<?php 
session_start();
include 'includes/pokemon-products.php'; 

if (!isset($_SESSION['mc_sales']) || empty($_SESSION['mc_sales'])) {
    $_SESSION['mc_sales'] = [
        1 => 5, 
        9 => 3, 
        7 => 2  
    ];
}

$sales = $_SESSION['mc_sales'];
arsort($sales); 

$top_3_ids = array_slice(array_keys($sales), 0, 3);
$badges = ['#1 ADOPTION', '#2 ADOPTION', '#3 ADOPTION'];

include 'includes/header.php'; 
?>

<main class="container">
    <section class="hero">
        <h2>LES FAVORIS DU SERVEUR</h2>
        <p style="color: #fff; font-family: 'Roboto'; margin-top: 15px;">Le classement en temps réel des compagnons les plus adoptés !</p>
    </section>

    <div class="product-grid">
        <?php foreach($top_3_ids as $index => $id): ?>
            <?php 
                if(!isset($pokemons[$id])) continue; 
                $p = $pokemons[$id]; 
                $badge = $badges[$index];
            ?>
            <div class="card <?= $p['css_type'] ?>">
                <div class="badge-top-mc"><?= $badge ?></div>
                <img src="images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="card-image-real">
                <h3><?= $p['name'] ?></h3>
                <p class="desc"><?= $p['desc'] ?></p>
                <span class="price"><?= $p['price'] ?> €</span>
                
                <form action="catalogue-cobblemon.php" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="add_id" value="<?= $id ?>">
                    <input type="number" name="quantity" value="1" min="1" max="99" class="qty-input-mc">
                    <button type="submit" class="btn-primary">PRENDRE</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <a href="catalogue-cobblemon.php" class="btn-primary" style="display:inline-block; text-decoration:none; padding:15px 30px;">
            VOIR TOUS LES POKÉMON...
        </a>
    </div>
</main>
</body>
</html>