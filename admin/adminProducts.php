<?php
session_start();
require '../db.php'; 

// Vérification Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php'); 
    exit();
}

// LOGIQUE DE SUPPRESSION
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: adminProducts.php?success=deleted');
    exit();
}

// RÉCUPÉRATION DES PRODUITS
$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - PokeRayou</title>
    <link rel="stylesheet" href="../style-admin.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="container">
        
        <div class="admin-header">
            <h1><i class="fas fa-user-shield"></i> DASHBOARD ADMIN</h1>
            <p>Centre de contrôle du catalogue PokeRayou</p>
            <a href="../index.php" class="back-link"><i class="fas fa-arrow-left"></i> Retour au portail</a>
        </div>

        <div style="text-align: right; margin-bottom: 20px;">
            <a href="admin_add.php" class="btn btn-add"><i class="fas fa-plus"></i> NOUVEAU PRODUIT</a>
        </div>

        <div class="admin-panel table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <img src="../images/<?= htmlspecialchars($p['image']) ?>" alt="pkmn" width="60" height="60" class="img-preview">
                            </td>
                            <td style="font-weight: bold; font-size: 1.1rem;"><?= htmlspecialchars($p['nom']) ?></td>
                            <td style="color: #ccc;"><?= number_format($p['prix'], 2) ?> €</td>
                            <td>
                                <span class="stock-badge"><?= $p['stock'] ?></span>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="admin_edit.php?id=<?= $p['id'] ?>" class="btn-edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="adminProducts.php?delete=<?= $p['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer définitivement ce produit ?')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #888;">Aucun produit dans le catalogue.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>