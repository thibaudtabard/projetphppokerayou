<?php
require 'admin_check.php';
require '../db.php';

// Suppression d'un article 
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin_products.php');
}

// Récupération de tous les produits 
$items = $pdo->query("SELECT * FROM items ORDER BY date_publication DESC")->fetchAll();
?>

<h1>Gestion des produits</h1>
<a href="admin_add.php">Ajouter un produit</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= $item['id'] ?></td>
        <td><img src="../uploads/<?= $item['image'] ?>" width="50"></td>
        <td><?= htmlspecialchars($item['nom']) ?></td>
        <td><?= $item['prix'] ?> €</td>
        <td><?= $item['stock'] ?></td>
        <td>
            <a href="admin_edit.php?id=<?= $item['id'] ?>">Modifier</a> | <a href="?delete=<?= $item['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a> </td>
    </tr>
    <?php endforeach; ?>
</table>