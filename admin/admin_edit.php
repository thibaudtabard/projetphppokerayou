<?php
session_start();
require '../db.php';

//  Vérification Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

//  RÉCUPÉRATION DU PRODUIT
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

//  TRAITEMENT DE LA MISE À JOUR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    
    // image 
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
    } else {
        $image = $product['image']; // On garde l'ancienne image si pas de nouvelle
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
    <link rel="stylesheet" href="styles/style.css">
</head>
<body style="background: #222; color: white; font-family: sans-serif;">

<div class="container" style="max-width: 600px; margin: 50px auto; background: #333; padding: 20px; border-radius: 10px;">
    <h2><i class="fas fa-edit"></i> Modifier le produit</h2>
    <hr>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Nom du Produit :</label><br>
        <input type="text" name="nom" value="<?= htmlspecialchars($product['nom']) ?>" required style="width:100%; margin-bottom:15px;">

        <label>Description :</label><br>
        <textarea name="description" rows="4" style="width:100%; margin-bottom:15px;"><?= htmlspecialchars($product['description']) ?></textarea>

        <label>Prix  :</label><br>
        <input type="number" step="0.01" name="prix" value="<?= $product['prix'] ?>" required style="width:100%; margin-bottom:15px;">

        <label>Stock :</label><br>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required style="width:100%; margin-bottom:15px;">

        <label>Image actuelle :</label><br>
        <img src="../images/<?= $product['image'] ?>" width="100" style="margin-bottom:10px;"><br>
        <label>Changer l'image (optionnel) :</label>
        <input type="file" name="image" style="width:100%; margin-bottom:15px;">

        <button type="submit" style="background: #ffcb05; color: black; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; width: 100%;">
            ENREGISTRER LES MODIFICATIONS
        </button>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="adminProducts.php" style="color: #ccc;">Annuler et retour</a>
        </p>
    </form>
</div>

</body>
