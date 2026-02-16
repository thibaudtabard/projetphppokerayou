<?php
session_start();
require '../db.php';

// Vérification Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    
    $image = "default.png";
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
    }

    $stmt = $pdo->prepare("INSERT INTO items (nom, description, prix, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $stock, $image]);

    header('Location: adminProducts.php?success=add');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit - Admin</title>
    <link rel="stylesheet" href="../style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="admin-panel admin-panel-sm">
        <h2><i class="fas fa-plus-circle" style="color: #ffcb05;"></i> Ajouter un produit</h2>
        
        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nom du produit :</label>
                <input type="text" name="nom" placeholder="Ex: Pikachu" required>
            </div>

            <div class="form-group">
                <label>Description :</label>
                <textarea name="description" rows="4" placeholder="Description du produit..." required></textarea>
            </div>

            <div class="form-group">
                <label>Prix (€) :</label>
                <input type="number" step="0.01" name="prix" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>Stock initial :</label>
                <input type="number" name="stock" placeholder="10" required>
            </div>

            <div class="form-group">
                <label>Image du produit :</label>
                <input type="file" name="image" required>
            </div>

            <button type="submit" class="btn btn-submit">AJOUTER AU CATALOGUE</button>
            
            <p style="text-align: center; margin-top: 20px;">
                <a href="adminProducts.php" class="back-link">Annuler et retour</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>