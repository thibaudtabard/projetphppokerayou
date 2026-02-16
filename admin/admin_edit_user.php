<?php
session_start();
require '../db.php';


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit(); // Arrête si l'utilisateur n'est pas admin
}


if (isset($_GET['delete_id'])) {
    $id_to_delete = (int)$_GET['delete_id'];
    
    // l'admin ne se supprime pas lui-même
    if ($id_to_delete === $_SESSION['user_id']) {
        header('Location: admin_edit_user.php?error=self');
        exit();
    }

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id_to_delete]);
    
    header('Location: admin_edit_user.php?success=1');
    exit();
}

// RÉCUPÉRATION DES UTILISATEURS
$stmt = $pdo->query("SELECT id, nom, email, role FROM users ORDER BY role ASC, nom ASC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style-admin.css">
</head>
<body style="background: #1a1a1a; color: white;">

    <div class="admin-container">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1><i class="fas fa-users-cog"></i> LISTE DES UTILISATEURS</h1>
            <a href="adminProducts.php" style="color: #aaa; text-decoration: none;">⬅ Retour aux Produits</a>
        </div>

        <?php if(isset($_GET['error']) && $_GET['error'] == 'self'): ?>
            <div class="msg error">Vous ne pouvez pas supprimer votre propre compte.</div>
        <?php endif; ?>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td>#<?= $u['id'] ?></td>
                    <td><strong><?= htmlspecialchars($u['nom']) ?></strong></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <span class="role-badge <?= $u['role'] === 'admin' ? 'admin-badge' : 'user-badge' ?>">
                            <?= strtoupper($u['role']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($u['id'] !== $_SESSION['user_id']): ?>
                            <a href="admin_edit_user.php?delete_id=<?= $u['id'] ?>" class="btn-del" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                <i class="fas fa-trash"></i> SUPPRIMER
                            </a>
                        <?php else: ?>
                            <span style="color: #888; font-style: italic;">(Vous)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>