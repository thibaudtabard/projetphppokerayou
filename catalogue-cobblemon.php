<?php 
session_start();
require 'db.php';

// On récupère les Pokémons de la base de données
$stmt = $pdo->query("SELECT * FROM items");
$pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// LOGIQUE D'AJOUT AU PANIER 
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_id'])) {
    $id = $_POST['add_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if(!isset($_SESSION['mc_cart'])) $_SESSION['mc_cart'] = [];
    
    if(isset($_SESSION['mc_cart'][$id])) {
        $_SESSION['mc_cart'][$id] += $qty;
    } else {
        $_SESSION['mc_cart'][$id] = $qty;
    }
    header("Location: catalogue-cobblemon.php?success=1");
    exit();
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
<?php foreach($pokemons as $p): ?>
    <div class="card">
        <img src="images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>" class="card-image-real">
        <h3><?= htmlspecialchars($p['nom']) ?></h3>
        <p class="desc"><?= htmlspecialchars($p['description']) ?></p>
        <span class="price"><?= $p['prix'] ?> €</span>
        
        <form action="" method="POST">
            <input type="hidden" name="add_id" value="<?= $p['id'] ?>">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">ADOPTER</button>
        </form>
    </div>
<?php endforeach; ?>
    </div>
</main>
</body>
</html>