PROJET GESTION UPF - ARCHITECTURE MVC
------------------------------------------

Base de données : gestion_upf
Fichier SQL : gestion_upf.sql

COMPTES DE TEST :
-----------------

1. ADMINISTRATEUR
   Login : admin
   Pass : admin123

2. ÉTUDIANT
   Login : ahmed
   Pass : admin123 (utilisé pour les deux comptes dans le SQL de test)

INSTALLATION :
--------------
1. Copier le dossier dans C:\xampp\htdocs\gestion_upf_mvc
2. Importer gestion_upf.sql via phpMyAdmin
3. Accéder via http://localhost/gestion_upf_mvc/

FONCTIONNALITÉS :
----------------
- Authentification avec cookies et session
- Dashboard statistique (Admin)
- CRUD Étudiants complet avec Upload photo/documents (Admin)
- Gestion des Filières (Admin)
- Espace Étudiant : Profil, Notes, Classement, Documents (User)
- Changement de mot de passe sécurisé (User)
- Protection CSRF et XSS (htmlspecialchars + PDO)
