<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php?ctrl=auth&action=login&erreur=acces");
    exit();
}
