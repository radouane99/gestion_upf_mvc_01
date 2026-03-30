<h2><i class="fas fa-lock"></i> Sécurité : Changer mon mot de passe</h2>

<div class="card" style="max-width: 500px; margin: 30px auto;">
    <?php if (isset($_GET['erreur'])): ?>
        <div class="alert alert-danger">
            <?php 
                switch($_GET['erreur']) {
                    case 'validation': echo "Le nouveau mot de passe doit faire min. 8 caractères et correspondre à la confirmation."; break;
                    case 'ancien_faux': echo "L'ancien mot de passe est incorrect."; break;
                    default: echo "Une erreur est survenue lors de la mise à jour.";
                }
            ?>
        </div>
    <?php endif; ?>

    <form action="index.php?ctrl=user&action=changerPasswordTraitement" method="POST">
        <div class="form-group">
            <label for="old_pass">Ancien mot de passe</label>
            <input type="password" name="old_pass" id="old_pass" required>
        </div>
        
        <div class="form-group" style="margin-top: 20px;">
            <label for="new_pass">Nouveau mot de passe (min. 8 car.)</label>
            <input type="password" name="new_pass" id="new_pass" required minlength="8">
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label for="conf_pass">Confirmer le nouveau mot de passe</label>
            <input type="password" name="conf_pass" id="conf_pass" required>
        </div>

        <div style="margin-top: 40px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Mettre à jour</button>
            <a href="index.php?ctrl=user&action=profil" class="btn btn-secondary" style="flex: 1; text-align: center;">Annuler</a>
        </div>
    </form>
</div>
