<?php
session_start();
require '../db.php'; 

//  Vérification Admin
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
    <link rel="stylesheet" href="styles/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-table { width: 95%; margin: 20px auto; border-collapse: collapse; background: white; color: black; border-radius: 8px; overflow: hidden; }
        .admin-table th, .admin-table td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
        .admin-table th { background-color: #f8f9fa; font-weight: bold; }
        .btn-add { display: inline-block; margin: 20px; padding: 12px 25px; background: #ffcb05; color: #000; text-decoration: none; font-weight: bold; border-radius: 5px; transition: 0.3s; }
        .btn-add:hover { background: #e6b800; }
        .btn-edit { color: #007bff; text-decoration: none; font-weight: bold; margin-right: 15px; }
        .delete-link { color: #dc3545; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body style="background: #1a1a1a; color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <div style="text-align: center; padding: 30px;">
        <h1><i class="fas fa-user-shield"></i> DASHBOARD ADMIN</h1>
        <p>Gestion du catalogue PokeRayou</p>
        <a href="../index.php" style="color: #ffcb05; text-decoration: none;">⬅ Retour au portail</a>
    </div>

    <div class="container">
        <div style="width: 95%; margin: 0 auto; text-align: right;">
            <a href="admin_add.php" class="btn-add"><i class="fas fa-plus"></i> NOUVEAU PRODUIT</a>
        </div>

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
                            <img src="../images/<?= htmlspecialchars($p['image']) ?>" alt="pkmn" width="50" style="border-radius: 5px; border: 1px solid #ddd;">
                        </td>
                        <td style="font-weight: bold;"><?= htmlspecialchars($p['nom']) ?></td>
                        <td><?= number_format($p['prix'], 2) ?> PDN</td>
                        <td>
                            <span style="padding: 4px 8px; background: #eee; border-radius: 4px;"><?= $p['stock'] ?></span>
                        </td>
                        <td style="text-align: center;">
                            <a href="admin_edit.php?id=<?= $p['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i> MODIFIER
                            </a>
                            
                            <a href="adminProducts.php?delete=<?= $p['id'] ?>" class="delete-link" onclick="return confirm('Supprimer définitivement ce Pokémon ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Aucun produit dans le catalogue.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>