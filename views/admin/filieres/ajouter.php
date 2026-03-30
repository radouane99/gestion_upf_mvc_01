<h2><i class="fas fa-plus-circle"></i> Ajouter une Filière</h2>

<div class="card">
    <form action="index.php?ctrl=filiere&action=ajouterTraitement" method="POST">
        <?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'doublon'): ?>
            <div class="alert alert-danger">Le code de la filière existe déjà.</div>
        <?php endif; ?>

        <div class="form-group">
            <label for="CodeF">Code Filière</label>
            <input type="text" name="CodeF" id="CodeF" required placeholder="Ex: GINFO">
        </div>

        <div class="form-group">
            <label for="IntituleF">Intitulé de la Filière</label>
            <input type="text" name="IntituleF" id="IntituleF" required placeholder="Ex: Génie Informatique">
        </div>

        <div class="form-group">
            <label for="Responsable">Nom du Responsable</label>
            <input type="text" name="Responsable" id="Responsable" placeholder="Ex: M. KZADRI">
        </div>

        <div class="form-group">
            <label for="NbPlaces">Nombre de places</label>
            <input type="number" name="NbPlaces" id="NbPlaces" value="30" min="1">
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="index.php?ctrl=filiere&action=liste" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
