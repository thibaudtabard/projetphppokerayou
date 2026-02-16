# PokéRayou - Site E-Commerce Pokémon

## 📝 Description

**PokéRayou** est un site e-commerce spécialisé dans la vente de produits Pokémon. Le projet propose une expérience d'achat immersive avec deux catalogues distincts : **Cobblemon** et **Classic**. Les utilisateurs peuvent créer un compte, consulter le catalogue, gérer un panier d'achat, et les administrateurs peuvent gérer les produits.

### Pour les utilisateurs
-  **Système d'authentification** : Inscription et connexion sécurisées avec email
-  **Catalogue produits** :
  - Thème Cobblemon (avec images et présentation spécifique)
  - Thème Classic (catalogue traditionnel)
-  **Panier d'achat** : Gestion complète du panier (ajout, suppression, modification)
-  **Profil utilisateur** : Gestion des informations personnelles
-  **Déconnexion** sécurisée

### Pour les administrateurs
-  **Panel d'administration** : Accès réservé aux administrateurs
-  **Ajout de produits** : Création de nouveaux produits
-  **Modification de produits** : Édition des produits existants
-  **Suppression de produits** : Gestion complète du catalogue

##  Technologies utilisées

- **Backend** : PHP 7.x+
- **Base de données** : MySQL / MariaDB
- **Frontend** : HTML5, CSS3
- **Sécurité** : PDO avec requêtes préparées, hachage des mots de passe

##  Structure du projet

```
ProjetSiteECPHP/
├── index.php                 # Page de connexion
├── inscription.php           # Page d'inscription
├── connexion.php             # Logique de connexion
├── deconnexion.php           # Déconnexion utilisateur
├── db.php                    # Configuration base de données
├── admincheck.php            # Vérification droits admin
│
├── admin/                    # Panel d'administration
│   ├── adminProducts.php     # Liste des produits
│   ├── admin_add.php         # Ajouter un produit
│   └── admin_edit.php        # Modifier un produit
│
├── catalogue-classic.php     # Catalogue thème Classic
├── catalogue-cobblemon.php   # Catalogue thème Cobblemon
├── classic.php               # Page Classic
├── cobblemon.php             # Page Cobblemon
│
├── cart.php                  # Gérer le panier (Classic)
├── cart-cobblemon.php        # Gérer le panier (Cobblemon)
│
├── includes/                 # Fichiers réutilisables
│   ├── header.php            # En-tête principal
│   ├── header-classic.php    # En-tête thème Classic
│   ├── footer.php            # Pied de page
│   ├── products.php          # Affichage produits (Classic)
│   └── pokemon-products.php  # Affichage produits (Cobblemon)
│
├── styles/                   # Feuilles de style
│   ├── style.css             # Style principal Cobblemon
│   ├── style-classic.css     # Style thème Classic
│   └── style-inscription.css # Style formulaires
│
├── images/                   # Images produits et ressources
└── README.md                 # Ce fichier
```

## 🚀 Installation et configuration

### Prérequis
- XAMPP / WAMP / LAMP (local ou serveur)
- PHP 7.4+
- MySQL / MariaDB

### Étapes d'installation

1. **Clonez le projet** dans votre dossier `htdocs` (XAMPP)
   ```bash
   git clone <votre-repo> c:\xampp\htdocs\ProjetSiteECPHP
   ```

2. **Configurez la base de données** : Modifiez les paramètres dans [db.php](db.php)
   ```php
   $host = 'localhost';
   $dbname = 'dbsiteecommercey';
   $user = 'root';
   $pass = '';
   ```

4. **Lancez le projet**
   - Démarrez XAMPP (Apache + MySQL)
   - Accédez à `http://localhost/ProjetSiteECPHP/`

##  Utilisateurs par défaut

*(À configurer lors de l'installation)*

- **Admin** : email `aurelremond78@gmail.com` / mot de passe `mdptest`
- **Utilisateur classique** : Créez via la page d'inscription

##  Sécurité

- ✅ Mots de passe hachés avec `password_hash()`
- ✅ Requêtes SQL préparées (PDO) contre les injections SQL
- ✅ Sessions PHP pour la gestion d'authentification
- ✅ Vérification des droits admin sur les pages sensibles

##  Thèmes disponibles

###  Cobblemon
- Style moderne et vibrant
- Catalogue dédié aux produits Cobblemon
- Panier spécifique : `cart-cobblemon.php`
- Fichier principal : [cobblemon.php](cobblemon.php)

###  Classic
- Design épuré et traditionnel
- Catalogue classique
- Panier spécifique : `cart.php`
- Fichier principal : [classic.php](classic.php)

##  Utilisation

### En tant qu'utilisateur
1. Accédez à [index.php](index.php) ou créez un compte via [inscription.php](inscription.php)
2. Connectez-vous avec votre email et mot de passe
3. Explorez les catalogues (Cobblemon ou Classic)
4. Ajoutez des produits au panier
5. Procédez au paiement *(à implémenter)*
6. Déconnectez-vous via [deconnexion.php](deconnexion.php)

### En tant qu'administrateur
1. Connectez-vous avec un compte admin
2. Accédez au panel admin : `/admin/adminProducts.php`
3. Gérez les produits :
   - Voir tous les produits : [adminProducts.php](admin/adminProducts.php)
   - Ajouter un produit : [admin_add.php](admin/admin_add.php)
   - Modifier un produit : [admin_edit.php](admin/admin_edit.php)
-