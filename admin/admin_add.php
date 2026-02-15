<?php
session_start();
require '../db.php';

// SÉCURITÉ : Vérification Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    
    // Gestion de l'image
    $image = "default.png"; // Image par défaut
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        // Assure-toi que le dossier ../images/ existe !
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
    }

    // Insertion en base de données
    $stmt = $pdo->prepare("INSERT INTO items (nom, description, prix, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $stock, $image]);

    // Redirection vers la liste
    header('Location: adminProducts.php?success=add');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body style="background: #222; color: white; font-family: sans-serif;">

<div class="container" style="max-width: 600px; margin: 50px auto; background: #333; padding: 20px; border-radius: 10px;">
    <h2><i class="fas fa-plus-circle"></i> Ajouter un nouveau produit</h2>
    <hr>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Nom du produit :</label><br>
        <input type="text" name="nom" placeholder="Pikachu" required style="width:100%; margin-bottom:15px; padding: 8px;">

        <label>Description :</label><br>
        <textarea name="description" rows="4" placeholder="Description du produit..." style="width:100%; margin-bottom:15px; padding: 8px;"></textarea>

        <label>Prix :</label><br>
        <input type="number" step="0.01" name="prix" placeholder="0.00" required style="width:100%; margin-bottom:15px; padding: 8px;">

        <label>Stock initial :</label><br>
        <input type="number" name="stock" placeholder="10" required style="width:100%; margin-bottom:15px; padding: 8px;">

        <label>Image du produit :</label><br>
        <input type="file" name="image" required style="width:100%; margin-bottom:15px;">

        <button type="submit" style="background: #ffcb05; color: black; padding: 12px; border: none; cursor: pointer; font-weight: bold; width: 100%; border-radius: 5px;">
            AJOUTER AU CATALOGUE
        </button>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="adminProducts.php" style="color: #ccc;">Annuler et retour</a>
        </p>
    </form>
</div>

</body>
</html>