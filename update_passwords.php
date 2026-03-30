<?php
require_once 'config/config.php';
require_once 'models/Database.php';

try {
    $db = Database::getInstance()->getPDO();
    
    $passAdmin = password_hash('admin123', PASSWORD_BCRYPT);
    
    $stmt = $db->prepare("UPDATE utilisateurs SET password = ? WHERE login = ?");
    
    $stmt->execute([$passAdmin, 'admin']);
    echo "Password for 'admin' updated.\n";
    
    $stmt->execute([$passAdmin, 'ahmed']);
    echo "Password for 'ahmed' updated.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
