<?php
require_once 'models/FiliereModel.php';

class FiliereController {
    private $filiereModel;

    public function __construct() {
        require_once 'includes/auth_check_admin.php';
        $this->filiereModel = new FiliereModel();
    }

    public function liste() {
        $filieres = $this->filiereModel->findAll();
        require_once 'views/layout/header.php';
        require_once 'views/admin/filieres/liste.php';
        require_once 'views/layout/footer.php';
    }

    public function ajouter() {
        require_once 'views/layout/header.php';
        require_once 'views/admin/filieres/ajouter.php';
        require_once 'views/layout/footer.php';
    }

    public function ajouterTraitement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->filiereModel->insert($_POST)) {
                header("Location: index.php?ctrl=filiere&action=liste&msg=filiere_ajoutee");
            } else {
                header("Location: index.php?ctrl=filiere&action=ajouter&erreur=doublon");
            }
            exit();
        }
    }
}
