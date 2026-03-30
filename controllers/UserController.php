<?php
require_once 'models/EtudiantModel.php';
require_once 'models/DocumentModel.php';
require_once 'models/Database.php';

class UserController {
    private $etudiantModel;
    private $documentModel;
    private $pdo;

    public function __construct() {
        require_once 'includes/auth_check_user.php';
        $this->etudiantModel = new EtudiantModel();
        $this->documentModel = new DocumentModel();
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function profil() {
        $etudiant = $this->etudiantModel->findByCode($_SESSION['etudiant_id']);
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip === '::1') $ip = '127.0.0.1';
        $ua = $_SERVER['HTTP_USER_AGENT'];
        require_once 'views/layout/header.php';
        require_once 'views/user/profil.php';
        require_once 'views/layout/footer.php';
    }

    public function notes() {
        $etudiant = $this->etudiantModel->findByCode($_SESSION['etudiant_id']);
        $classement = $this->etudiantModel->getClassementFiliere($_SESSION['etudiant_id']);
        require_once 'views/layout/header.php';
        require_once 'views/user/notes.php';
        require_once 'views/layout/footer.php';
    }

    public function documents() {
        $recherche = $_GET['recherche'] ?? '';
        $documents = $this->documentModel->findByEtudiant($_SESSION['etudiant_id'], $recherche);
        require_once 'views/layout/header.php';
        require_once 'views/user/documents.php';
        require_once 'views/layout/footer.php';
    }

    public function changerPassword() {
        require_once 'views/layout/header.php';
        require_once 'views/user/changer_password.php';
        require_once 'views/layout/footer.php';
    }

    public function changerPasswordTraitement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $old = $_POST['old_pass'];
            $new = $_POST['new_pass'];
            $conf = $_POST['conf_pass'];

            $stmt = $this->pdo->prepare("SELECT password FROM utilisateurs WHERE id = ?");
            $stmt->execute([$user_id]);
            $hash = $stmt->fetchColumn();

            if (password_verify($old, $hash)) {
                if (strlen($new) >= 8 && $new === $conf) {
                    $newHash = password_hash($new, PASSWORD_DEFAULT);
                    $upd = $this->pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                    $upd->execute([$newHash, $user_id]);
                    header("Location: index.php?ctrl=user&action=profil&msg=pass_ok");
                } else {
                    header("Location: index.php?ctrl=user&action=changerPassword&erreur=validation");
                }
            } else {
                header("Location: index.php?ctrl=user&action=changerPassword&erreur=ancien_faux");
            }
            exit();
        }
    }

    public function modifierPhotoTraitement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codeE = $_SESSION['etudiant_id'];
            $etudiant = $this->etudiantModel->findByCode($codeE);
            $oldPhoto = $etudiant['Photo'];

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // 1. Taille
                if ($_FILES['photo']['size'] > MAX_PHOTO) {
                    header("Location: index.php?ctrl=user&action=profil&erreur=taille");
                    exit();
                }

                // 2. Extension
                $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    header("Location: index.php?ctrl=user&action=profil&erreur=extension");
                    exit();
                }

                // 3. MIME type réel
                $mime = mime_content_type($_FILES['photo']['tmp_name']);
                if (strpos($mime, 'image/') !== 0) {
                    header("Location: index.php?ctrl=user&action=profil&erreur=format");
                    exit();
                }

                // 4. Renommer & Déplacer
                $filename = 'photo_' . $codeE . '_' . time() . '.' . $ext;
                $dest = UPLOAD_PHOTOS . $filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
                    // Supprimer l'ancienne photo si elle existe
                    if ($oldPhoto && file_exists($oldPhoto)) {
                        unlink($oldPhoto);
                    }
                    
                    // 5. Enregistrer en BDD
                    $stmt = $this->pdo->prepare("UPDATE etudiants SET Photo = ? WHERE CodeE = ?");
                    $stmt->execute([$dest, $codeE]);
                    
                    header("Location: index.php?ctrl=user&action=profil&msg=photo_ok");
                    exit();
                }
            }
            header("Location: index.php?ctrl=user&action=profil&erreur=upload");
            exit();
        }
    }
}
