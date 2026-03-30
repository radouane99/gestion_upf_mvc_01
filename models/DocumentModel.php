<?php

class DocumentModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function findByEtudiant($code, $search = '') {
        $query = "SELECT * FROM documents WHERE etudiant_id = ?";
        $params = [$code];
        
        if (!empty($search)) {
            $query .= " AND nom LIKE ?";
            $params[] = "%$search%";
        }
        
        $query .= " ORDER BY date_upload DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insert($data) {
        $stmt = $this->pdo->prepare("INSERT INTO documents (nom, chemin, taille, mime, type, etudiant_id) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nom'], $data['chemin'], $data['taille'], 
            $data['mime'], $data['type'], $data['etudiant_id']
        ]);
    }

    public function compter() {
        return $this->pdo->query("SELECT COUNT(*) FROM documents")->fetchColumn();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM documents WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
