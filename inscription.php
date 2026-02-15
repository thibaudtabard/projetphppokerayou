<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!$email) {
        $erreur = "Format d'email invalide.";
    } elseif ($password !== $confirm_password) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà 
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Hachage du mot de passe 
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insertion sécurisée 
            $insert = $pdo->prepare("INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, 'user')");
            $insert->execute([$nom, $email, $hash]);
            header('Location: connexion.php');
            exit();
        }
    }
}
?>

<form method="POST">
    <input type="text" name="nom" placeholder="Votre nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="password" name="confirm_password" placeholder="Répétez le mot de passe" required>
    <button type="submit">S'inscrire</button>
</form>