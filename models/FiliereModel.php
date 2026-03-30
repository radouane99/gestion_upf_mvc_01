<?php

class FiliereModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function findAll() {
        $sql = "SELECT f.*, COUNT(e.CodeE) as NbEtudiants 
                FROM filieres f 
                LEFT JOIN etudiants e ON f.CodeF = e.CodeF 
                GROUP BY f.CodeF";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function findByCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM filieres WHERE CodeF = ?");
        $stmt->execute([$code]);
        return $stmt->fetch() ?: null;
    }

    public function insert($data) {
        if ($this->codeExiste($data['CodeF'])) return false;
        
        $stmt = $this->pdo->prepare("INSERT INTO filieres (CodeF, IntituleF, Responsable, NbPlaces) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['CodeF'], $data['IntituleF'], $data['Responsable'], $data['NbPlaces']]);
    }

    public function codeExiste($code) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM filieres WHERE CodeF = ?");
        $stmt->execute([$code]);
        return $stmt->fetchColumn() > 0;
    }
}
