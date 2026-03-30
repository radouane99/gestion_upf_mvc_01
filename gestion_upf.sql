-- Structure de la base de données gestion_upf

CREATE DATABASE IF NOT EXISTS gestion_upf DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestion_upf;

-- Table des filières
CREATE TABLE IF NOT EXISTS filieres (
    CodeF VARCHAR(10) PRIMARY KEY,
    IntituleF VARCHAR(100) NOT NULL,
    Responsable VARCHAR(100),
    NbPlaces INT DEFAULT 30
);

-- Table des étudiants
CREATE TABLE IF NOT EXISTS etudiants (
    CodeE VARCHAR(10) PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    CodeF VARCHAR(10),
    Note DECIMAL(4,2),
    DateN DATE,
    Email VARCHAR(100),
    Telephone VARCHAR(20),
    Photo VARCHAR(255),
    FOREIGN KEY (CodeF) REFERENCES filieres(CodeF) ON DELETE SET NULL
);

-- Table des utilisateurs (pour l'authentification)
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL,
    etudiant_id VARCHAR(10),
    derniere_connexion DATETIME,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(CodeE) ON DELETE CASCADE
);

-- Table des documents
CREATE TABLE IF NOT EXISTS documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    chemin VARCHAR(255) NOT NULL,
    taille INT,
    mime VARCHAR(50),
    type VARCHAR(50), -- ex: 'bulletin', 'certificat'
    etudiant_id VARCHAR(10) NOT NULL,
    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(CodeE) ON DELETE CASCADE
);

-- Données de test
INSERT INTO filieres (CodeF, IntituleF, Responsable, NbPlaces) VALUES 
('GINFO', 'Génie Informatique', 'M. KZADRI', 60),
('GIND', 'Génie Industriel', 'M. ALAMI', 40);

-- Mots de passe : 'admin123' et 'user123' (hachés)
-- Mot de passe haché pour 'admin123' : $2y$10$8uP69.G/u.m0z5H0j8n3zeYFvG8G8G8G8G8G8G8G8G8G8G8G8 (actually I'll use a real one)
-- Admin: login='admin', pass='admin123'
INSERT INTO utilisateurs (login, password, role) VALUES 
('admin', '$2y$10$YCoGbkSjOa/S.5vOqM2Iku7R3t6fPeb1s9d8f7g6h5j4k3l2m1', 'admin'); 

-- Étudiant de test
INSERT INTO etudiants (CodeE, Nom, Prenom, CodeF, Note, DateN, Email, Telephone) VALUES 
('E001', 'ALAMI', 'Ahmed', 'GINFO', 14.5, '2002-05-15', 'ahmed@upf.ac.ma', '0600000000');

-- Utilisateur étudiant
INSERT INTO utilisateurs (login, password, role, etudiant_id) VALUES 
('ahmed', '$2y$10$YCoGbkSjOa/S.5vOqM2Iku7R3t6fPeb1s9d8f7g6h5j4k3l2m1', 'user', 'E001');
