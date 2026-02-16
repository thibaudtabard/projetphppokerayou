<?php
session_start();
require '../db.php';

// Vérification Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: adminProducts.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Produit introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
    } else {
        $image = $product['image'];
    }

    $update = $pdo->prepare("UPDATE items SET nom = ?, description = ?, prix = ?, stock = ?, image = ? WHERE id = ?");
    $update->execute([$nom, $description, $prix, $stock, $image, $id]);

    header('Location: adminProducts.php?success=update');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit - Admin</title>
    <link rel="stylesheet" href="../style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="admin-panel admin-panel-sm">
        <h2><i class="fas fa-edit" style="color: #00ffcc;"></i> Modifier le produit</h2>
        
        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nom du Produit :</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($product['nom']) ?>" required>
            </div>

            <div class="form-group">
                <label>Description :</label>
                <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Prix (€) :</label>
                <input type="number" step="0.01" name="prix" value="<?= $product['prix'] ?>" required>
            </div>

            <div class="form-group">
                <label>Stock :</label>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
            </div>

            <div class="form-group">
                <label>Image actuelle :</label>
                <div style="margin-bottom: 15px; text-align: center; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 8px;">
                    <img src="../images/<?= htmlspecialchars($product['image']) ?>" width="100" class="img-preview">
                </div>
                
                <label>Changer l'image (optionnel) :</label>
                <input type="file" name="image">
            </div>

            <button type="submit" class="btn btn-submit" style="background: linear-gradient(90deg, #00ffcc, #00b3ff);">
                ENREGISTRER LES MODIFICATIONS
            </button>
            
            <p style="text-align: center; margin-top: 20px;">
                <a href="adminProducts.php" class="back-link">Annuler et retour</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>