<?php
require_once 'models/EtudiantModel.php';
require_once 'models/FiliereModel.php';
require_once 'models/DocumentModel.php';

class EtudiantController {
    private $etudiantModel;
    private $filiereModel;
    private $documentModel;

    public function __construct() {
        require_once 'includes/auth_check_admin.php';
        $this->etudiantModel = new EtudiantModel();
        $this->filiereModel = new FiliereModel();
        $this->documentModel = new DocumentModel();
    }

    public function dashboard() {
        $stats = $this->etudiantModel->getStatistiques();
        $nbDocs = $this->documentModel->compter();
        require_once 'views/layout/header.php';
        require_once 'views/admin/dashboard.php';
        require_once 'views/layout/footer.php';
    }

    public function liste() {
        $recherche = $_GET['recherche'] ?? '';
        $filiere = $_GET['filiere'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = PAR_PAGE;
        $offset = ($page - 1) * $limit;

        $etudiants = $this->etudiantModel->findAll($recherche, $filiere, $limit, $offset);
        $total = $this->etudiantModel->compter($recherche, $filiere);
        $nbPages = ceil($total / $limit);
        $filieres = $this->filiereModel->findAll();

        require_once 'views/layout/header.php';
        require_once 'views/admin/etudiants/liste.php';
        require_once 'views/layout/footer.php';
    }

    public function ajouter() {
        $filieres = $this->filiereModel->findAll();
        require_once 'views/layout/header.php';
        require_once 'views/admin/etudiants/ajouter.php';
        require_once 'views/layout/footer.php';
    }

    public function ajouterTraitement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['Photo'] = null;

            // Gestion Upload Photo (7 étapes)
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                if ($_FILES['photo']['size'] <= MAX_PHOTO) {
                    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png'];
                    if (in_array($ext, $allowed)) {
                        $mime = mime_content_type($_FILES['photo']['tmp_name']);
                        if (strpos($mime, 'image/') === 0) {
                            $filename = 'photo_' . $data['CodeE'] . '.' . $ext;
                            $dest = UPLOAD_PHOTOS . $filename;
                            if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
                                $data['Photo'] = $dest;
                            }
                        }
                    }
                }
            }

            if ($this->etudiantModel->insert($data)) {
                header("Location: index.php?ctrl=etudiant&action=liste&msg=ajoute");
            } else {
                header("Location: index.php?ctrl=etudiant&action=ajouter&erreur=insertion");
            }
            exit();
        }
    }

    public function modifier() {
        $code = $_GET['code'];
        $etudiant = $this->etudiantModel->findByCode($code);
        $filieres = $this->filiereModel->findAll();
        require_once 'views/layout/header.php';
        require_once 'views/admin/etudiants/modifier.php';
        require_once 'views/layout/footer.php';
    }

    public function modifierTraitement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['CodeE'];
            $etudiant = $this->etudiantModel->findByCode($code);
            $photo = $etudiant['Photo'];

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                if ($_FILES['photo']['size'] <= MAX_PHOTO) {
                    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                        if (strpos(mime_content_type($_FILES['photo']['tmp_name']), 'image/') === 0) {
                            if ($photo && file_exists($photo)) unlink($photo);
                            $filename = 'photo_' . $code . '.' . $ext;
                            $photo = UPLOAD_PHOTOS . $filename;
                            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
                        }
                    }
                }
            }

            $data = $_POST;
            $data['Photo'] = $photo;
            if ($this->etudiantModel->update($code, $data)) {
                header("Location: index.php?ctrl=etudiant&action=liste&msg=modifie");
            } else {
                header("Location: index.php?ctrl=etudiant&action=modifier&code=$code&erreur=update");
            }
            exit();
        }
    }

    public function supprimer() {
        $code = $_GET['code'];
        $etudiant = $this->etudiantModel->findByCode($code);
        if ($etudiant && $etudiant['Photo'] && file_exists($etudiant['Photo'])) {
            unlink($etudiant['Photo']);
        }
        // Supprimer aussi les documents physiques
        $docs = $this->documentModel->findByEtudiant($code);
        foreach ($docs as $doc) {
            if (file_exists($doc['chemin'])) unlink($doc['chemin']);
        }

        if ($this->etudiantModel->delete($code)) {
            header("Location: index.php?ctrl=etudiant&action=liste&msg=supprime");
        } else {
            header("Location: index.php?ctrl=etudiant&action=liste&erreur=suppression");
        }
        exit();
    }

    public function detail() {
        $code = $_GET['code'];
        $etudiant = $this->etudiantModel->findByCode($code);
        $documents = $this->documentModel->findByEtudiant($code);
        require_once 'views/layout/header.php';
        require_once 'views/admin/etudiants/detail.php';
        require_once 'views/layout/footer.php';
    }

    public function uploadDocument() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codeE = $_POST['etudiant_id'];
            if (isset($_FILES['doc']) && $_FILES['doc']['error'] === UPLOAD_ERR_OK) {
                if ($_FILES['doc']['size'] <= MAX_PDF) {
                    $ext = strtolower(pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION));
                    if ($ext === 'pdf' && mime_content_type($_FILES['doc']['tmp_name']) === 'application/pdf') {
                        $filename = 'doc_' . $codeE . '_' . time() . '.pdf';
                        $dest = UPLOAD_DOCS . $filename;
                        if (move_uploaded_file($_FILES['doc']['tmp_name'], $dest)) {
                            $this->documentModel->insert([
                                'nom' => $_POST['nom_doc'],
                                'chemin' => $dest,
                                'taille' => $_FILES['doc']['size'],
                                'mime' => 'application/pdf',
                                'type' => $_POST['type_doc'],
                                'etudiant_id' => $codeE
                            ]);
                            header("Location: index.php?ctrl=etudiant&action=detail&code=$codeE&msg=doc_ajoute");
                            exit();
                        }
                    }
                }
            }
            header("Location: index.php?ctrl=etudiant&action=detail&code=$codeE&erreur=upload_doc");
            exit();
        }
    }
}
