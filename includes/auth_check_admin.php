<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?ctrl=auth&action=login&erreur=acces");
    exit();
}
