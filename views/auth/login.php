<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - UPF Gestion</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page">
    <div class="login-card">
        <h1><i class="fas fa-university"></i> UPF Gestion</h1>
        
        <?php if (isset($_GET['erreur'])): ?>
            <div class="alert alert-danger" style="margin-bottom: 24px;">
                <i class="fas fa-exclamation-circle"></i>
                <?php 
                    switch($_GET['erreur']) {
                        case 'identifiants': echo "Identifiants incorrects."; break;
                        case 'champs_vides': echo "Champs obligatoires."; break;
                        case 'acces': echo "Connexion requise."; break;
                        default: echo "Erreur de connexion.";
                    }
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deconnecte'): ?>
            <div class="alert alert-success" style="margin-bottom: 24px;">
                <i class="fas fa-check-circle"></i> Déconnexion réussie.
            </div>
        <?php endif; ?>

        <form action="index.php?ctrl=auth&action=loginTraitement" method="POST" style="text-align: left;">
            <div class="form-group">
                <label for="login">Identifiant (Email / Login)</label>
                <div style="position: relative;">
                    <i class="fas fa-user" style="position: absolute; left: 16px; top: 15px; color: var(--gray);"></i>
                    <input type="text" name="login" id="login" value="<?php echo htmlspecialchars($last_login); ?>" style="padding-left: 44px;" placeholder="votre_identifiant" required>
                </div>
            </div>
            <div class="form-group" style="margin-top: 24px;">
                <label for="password">Mot de passe</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 16px; top: 15px; color: var(--gray);"></i>
                    <input type="password" name="password" id="password" style="padding-left: 44px;" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 32px; justify-content: center; height: 50px; font-size: 1.1rem;">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <div style="margin-top: 40px; color: var(--gray); font-size: 0.85rem;">
            &copy; <?= date('Y') ?> Université Privée de Fès (UPF)<br>
            <small>Système de Gestion Universitaire MVC</small>
        </div>
    </div>
</body>
</html>
