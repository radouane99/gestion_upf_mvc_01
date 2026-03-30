<?php

class EtudiantModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function findAll($recherche = '', $filiere = '', $limit = 5, $offset = 0) {
        $sql = "SELECT e.*, f.IntituleF 
                FROM etudiants e 
                LEFT JOIN filieres f ON e.CodeF = f.CodeF 
                WHERE (e.Nom LIKE :search OR e.Prenom LIKE :search OR e.CodeE LIKE :search)";
        
        if (!empty($filiere)) {
            $sql .= " AND e.CodeF = :filiere";
        }
        
        $sql .= " ORDER BY e.Nom ASC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        $searchParam = "%$recherche%";
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        if (!empty($filiere)) {
            $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function findByCode($code) {
        $stmt = $this->pdo->prepare("SELECT e.*, f.IntituleF FROM etudiants e LEFT JOIN filieres f ON e.CodeF = f.CodeF WHERE e.CodeE = ?");
        $stmt->execute([$code]);
        return $stmt->fetch() ?: null;
    }

    public function insert($data) {
        $stmt = $this->pdo->prepare("INSERT INTO etudiants (CodeE, Nom, Prenom, CodeF, Note, DateN, Email, Telephone, Photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['CodeE'], $data['Nom'], $data['Prenom'], $data['CodeF'], 
            $data['Note'], $data['DateN'], $data['Email'], $data['Telephone'], $data['Photo']
        ]);
    }

    public function update($code, $data) {
        $stmt = $this->pdo->prepare("UPDATE etudiants SET Nom = ?, Prenom = ?, CodeF = ?, Note = ?, DateN = ?, Email = ?, Telephone = ?, Photo = ? WHERE CodeE = ?");
        return $stmt->execute([
            $data['Nom'], $data['Prenom'], $data['CodeF'], $data['Note'], 
            $data['DateN'], $data['Email'], $data['Telephone'], $data['Photo'], $code
        ]);
    }

    public function delete($code) {
        try {
            $this->pdo->beginTransaction();
            
            // Supprimer les documents liés
            $stmt1 = $this->pdo->prepare("DELETE FROM documents WHERE etudiant_id = ?");
            $stmt1->execute([$code]);
            
            // Supprimer le compte utilisateur
            $stmt2 = $this->pdo->prepare("DELETE FROM utilisateurs WHERE etudiant_id = ?");
            $stmt2->execute([$code]);
            
            // Supprimer l'étudiant
            $stmt3 = $this->pdo->prepare("DELETE FROM etudiants WHERE CodeE = ?");
            $stmt3->execute([$code]);
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function compter($recherche = '', $filiere = '') {
        $sql = "SELECT COUNT(*) FROM etudiants WHERE (Nom LIKE :search OR Prenom LIKE :search OR CodeE LIKE :search)";
        if (!empty($filiere)) {
            $sql .= " AND CodeF = :filiere";
        }
        $stmt = $this->pdo->prepare($sql);
        $searchParam = "%$recherche%";
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        if (!empty($filiere)) {
            $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getStatistiques() {
        $total = $this->pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
        $recus = $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note >= 10")->fetchColumn();
        
        return [
            'total' => $total,
            'recus' => $recus,
            'ajournes' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note < 10 AND Note IS NOT NULL")->fetchColumn(),
            'en_attente' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note IS NULL")->fetchColumn(),
            'moyenne_generale' => round($this->pdo->query("SELECT AVG(Note) FROM etudiants")->fetchColumn(), 2),
            'meilleur' => $this->pdo->query("SELECT CONCAT(Nom, ' ', Prenom) FROM etudiants ORDER BY Note DESC LIMIT 1")->fetchColumn(),
            'taux_reussite' => ($total > 0) ? round(($recus / $total) * 100, 1) : 0,
            
            // Répartition des notes
            'repartition' => [
                'tres_bien' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note >= 16")->fetchColumn(),
                'bien' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note >= 14 AND Note < 16")->fetchColumn(),
                'assez_bien' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note >= 12 AND Note < 14")->fetchColumn(),
                'passable' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note >= 10 AND Note < 12")->fetchColumn(),
                'insuffisant' => $this->pdo->query("SELECT COUNT(*) FROM etudiants WHERE Note < 10 AND Note IS NOT NULL")->fetchColumn(),
            ],
            
            // Top 5 étudiants
            'top_etudiants' => $this->pdo->query("SELECT e.*, f.IntituleF FROM etudiants e LEFT JOIN filieres f ON e.CodeF = f.CodeF ORDER BY Note DESC LIMIT 5")->fetchAll(),
            
            // Derniers inscrits (utilisant CodeE comme proxy sil n'y a pas de date d'inscription)
            'derniers_inscrits' => $this->pdo->query("SELECT e.*, f.IntituleF FROM etudiants e LEFT JOIN filieres f ON e.CodeF = f.CodeF ORDER BY CodeE DESC LIMIT 4")->fetchAll(),
            
            // Effectifs par filière
            'filieres_stats' => $this->pdo->query("SELECT f.IntituleF, COUNT(e.CodeE) as nb, f.NbPlaces FROM filieres f LEFT JOIN etudiants e ON f.CodeF = e.CodeF GROUP BY f.CodeF")->fetchAll()
        ];
    }

    public function getClassementFiliere($codeEtudiant) {
        $etudiant = $this->findByCode($codeEtudiant);
        if (!$etudiant || $etudiant['Note'] === null) return null;

        $codeFiliere = $etudiant['CodeF'];
        $note = $etudiant['Note'];

        // Rang
        $stmt = $this->pdo->prepare("SELECT COUNT(*) + 1 FROM etudiants WHERE CodeF = ? AND Note > ?");
        $stmt->execute([$codeFiliere, $note]);
        $rang = $stmt->fetchColumn();

        // Moyenne filière
        $stmt2 = $this->pdo->prepare("SELECT AVG(Note) FROM etudiants WHERE CodeF = ?");
        $stmt2->execute([$codeFiliere]);
        $moyenne = round($stmt2->fetchColumn(), 2);

        return ['rang' => $rang, 'moyenne_filiere' => $moyenne];
    }
}
