<?php
session_start();
require_once 'config/config.php';
require_once 'models/Database.php';

// Routeur central
$ctrl = $_GET['ctrl'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

$controllerPath = 'controllers/' . ucfirst($ctrl) . 'Controller.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controllerName = ucfirst($ctrl) . 'Controller';
    
    if (class_exists($controllerName)) {
        $controleur = new $controllerName();
        
        if (method_exists($controleur, $action)) {
            $controleur->$action();
        } else {
            // Méthode inexistante -> redirection login par défaut ou erreur 404
            header("Location: index.php?ctrl=auth&action=login&erreur=action_introuvable");
            exit();
        }
    } else {
        header("Location: index.php?ctrl=auth&action=login&erreur=ctrl_introuvable");
        exit();
    }
} else {
    header("Location: index.php?ctrl=auth&action=login&erreur=ctrl_introuvable");
    exit();
}
