<?php 
session_start();
include 'includes/products.php'; 
include 'includes/header-classic.php'; 

if (!isset($_SESSION['sales']) || empty($_SESSION['sales'])) {
    $_SESSION['sales'] = [
        1 => 5,
        3 => 3, 
        2 => 2
    ];
}

$sales = $_SESSION['sales'];
arsort($sales); 

$top_3_ids = array_slice(array_keys($sales), 0, 3);
$badges = ['🏆 #1 VENTE', '🥈 #2 VENTE', '🥉 #3 VENTE'];
?>

<main class="container">

    <section class="hero">
        <h2>🔥 Les Indispensables</h2>
        <p>Les 3 objets les plus vendus cette semaine par les dresseurs.</p>
    </section>

    <div class="product-grid">
        <?php foreach($top_3_ids as $index => $id): ?>
            <?php 
                $p = $products[$id]; 
                $badge = $badges[$index];
            ?>
            <div class="card">
                <div class="badge-top"><?= $badge ?></div>
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

    <div style="text-align: center; margin-top: 50px;">
        <a href="catalogue-clasic.php" style="color: #888; text-decoration: underline;">Voir le reste du catalogue...</a>
    </div>

</main>
</body>
</html>