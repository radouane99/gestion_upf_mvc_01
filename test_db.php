<?php
require_once 'config/config.php';
require_once 'models/Database.php';

try {
    $db = Database::getInstance()->getPDO();
    echo "Connection successful!\n";
    
    $stmt = $db->query("SELECT login, role FROM utilisateurs");
    $users = $stmt->fetchAll();
    echo "Users in database:\n";
    foreach ($users as $user) {
        echo "- " . $user['login'] . " (" . $user['role'] . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
