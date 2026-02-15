<?php
require 'admin_check.php';
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $desc = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // Déplacement de l'image vers un dossier local [cite: 40]
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);

    // Requête préparée pour la sécurité 
    $stmt = $pdo->prepare("INSERT INTO items (nom, description, prix, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $desc, $prix, $stock, $image]);
    
    echo "Produit ajouté !";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nom" placeholder="Nom du produit" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="number" step="0.01" name="prix" placeholder="Prix" required>
    <input type="number" name="stock" placeholder="Quantité en stock" required>
    <input type="file" name="image" required>
    <button type="submit">Ajouter l'article</button>
</form>