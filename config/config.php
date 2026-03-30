<?php
// Configuration globale
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_upf');
define('DB_USER', 'root');
define('DB_PASS', '');

define('PAR_PAGE', 5);
define('MAX_PHOTO', 2097152); // 2 Mo
define('MAX_PDF', 5242880);   // 5 Mo

define('UPLOAD_PHOTOS', 'uploads/photos/');
define('UPLOAD_DOCS', 'uploads/documents/');

// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);
