<?php
require_once 'models/Database.php';

class AuthController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function login() {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] === 'admin') {
                header("Location: index.php?ctrl=etudiant&action=dashboard");
            } else {
                header("Location: index.php?ctrl=user&action=profil");
            }
            exit();
        }
        $last_login = $_COOKIE['last_login'] ?? '';
        require_once 'views/auth/login.php';
    }

    public function loginTraitement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = htmlspecialchars(trim($_POST['login']));
            $password = trim($_POST['password']);

            if (empty($login) || empty($password)) {
                header("Location: index.php?ctrl=auth&action=login&erreur=champs_vides");
                exit();
            }

            $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
            $stmt->execute([$login]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['etudiant_id'] = $user['etudiant_id'];
                $_SESSION['heure_connexion'] = date('H:i:s');

                // Cookie pour 30 jours
                setcookie('last_login', $login, time() + (30 * 24 * 60 * 60), "/");

                // Mise à jour date connexion
                $upd = $this->pdo->prepare("UPDATE utilisateurs SET derniere_connexion = NOW() WHERE id = ?");
                $upd->execute([$user['id']]);

                if ($user['role'] === 'admin') {
                    header("Location: index.php?ctrl=etudiant&action=dashboard");
                } else {
                    header("Location: index.php?ctrl=user&action=profil");
                }
                exit();
            } else {
                header("Location: index.php?ctrl=auth&action=login&erreur=identifiants");
                exit();
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie('last_login', '', time() - 3600, "/");
        header("Location: index.php?ctrl=auth&action=login&msg=deconnecte");
        exit();
    }
}
