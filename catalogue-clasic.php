<?php 
session_start();

//  SÉCURITÉ : Redirige vers l'index si le dresseur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=auth");
    exit();
}

require 'db.php';

//  RÉCUPÉRATION DES PRODUITS DEPUIS LA BDD
$stmt = $pdo->query("SELECT * FROM items ORDER BY nom ASC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// LOGIQUE D'AJOUT AU PANIER
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_id'])) {
    $id = (int)$_POST['add_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if($qty < 1) $qty = 1;

    // Vérifier si le produit existe en BDD avant d'ajouter
    $check = $pdo->prepare("SELECT id FROM items WHERE id = ?");
    $check->execute([$id]);
    
    if($check->fetch()) { 
        // Initialisation du panier 
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Ajout ou cumul de la quantité
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $qty; 
        } else {
            $_SESSION['cart'][$id] = $qty; 
        }

        header("Location: catalogue-clasic.php?success=1");
        exit();
    }
}

include 'includes/header-classic.php'; 
?>

<main class="container">

    <section class="hero">
        <h2>Catalogue Complet</h2>
        <p>Tout notre équipement pour votre aventure.</p>
        
        <?php if(isset($_GET['success'])): ?>
            <p style="color: #4eff5a; font-weight: bold; margin-top: 15px; padding: 10px; border: 1px solid #4eff5a; border-radius: 10px; display: inline-block;">
                Produit ajouté au sac avec succès !
            </p>
        <?php endif; ?>
    </section>

    <div class="product-grid">
        <?php if(count($products) > 0): ?>
            <?php foreach($products as $p): ?>
                <div class="card">
                    <img src="images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>" class="card-image-real">
                    
                    <h3><?= htmlspecialchars($p['nom']) ?></h3>
                    
                    <p class="desc"><?= htmlspecialchars($p['description']) ?></p>
                    
                    <span class="price"><?= number_format($p['prix'], 2) ?> €</span>
                    
                    <form action="catalogue-clasic.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="add_id" value="<?= $p['id'] ?>">
                        
                        <div style="margin: 10px 0;">
                            <label>Quantité :</label>
                            <input type="number" name="quantity" value="1" min="1" max="<?= $p['stock'] ?>" class="qty-input">
                        </div>
                        
                        <button type="submit" class="btn-add">Ajouter au sac</button>
                    </form>
                    
                    <p style="font-size: 0.7rem; color: #888; margin-top: 5px;">
                        En stock : <?= $p['stock'] ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; grid-column: 1 / -1;">La boutique est vide pour le moment.</p>
        <?php endif; ?>
    </div>

</main>
</body>
</html>