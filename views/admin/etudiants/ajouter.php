<div class="welcome-banner" style="margin-bottom: 30px; padding: 40px; border-radius: 30px; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 8px;"><i class="fas fa-user-plus"></i> Nouvel Étudiant</h1>
            <p style="opacity: 0.9; font-size: 1.1rem;">Remplissez les informations ci-dessous pour inscrire un nouvel étudiant.</p>
        </div>
        <a href="index.php?ctrl=etudiant&action=liste" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 14px; padding: 12px 24px; font-weight: 700; backdrop-filter: blur(10px);">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<div class="card glass-card" style="padding: 40px; border-radius: 30px;">
    <form action="index.php?ctrl=etudiant&action=ajouterTraitement" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Matricule Étudiant</label>
                    <div style="position: relative;">
                        <i class="fas fa-id-card" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <input type="text" name="CodeE" placeholder="Ex: E2024001" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Nom Complet</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <input type="text" name="Nom" placeholder="Nom" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;" required>
                        <input type="text" name="Prenom" placeholder="Prénom" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Filière Académique</label>
                    <div style="position: relative;">
                        <i class="fas fa-graduation-cap" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <select name="CodeF" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc; height: 50px;" required>
                            <option value="">Sélectionner une filière</option>
                            <?php foreach ($filieres as $f): ?>
                                <option value="<?php echo $f['CodeF']; ?>"><?php echo htmlspecialchars($f['IntituleF']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Email Institutionnel</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <input type="email" name="Email" placeholder="etudiant@upf.ac.ma" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Contact Téléphonique</label>
                    <div style="position: relative;">
                        <i class="fas fa-phone" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <input type="tel" name="Telephone" placeholder="06XXXXXXXX" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Date de Naissance</label>
                        <input type="date" name="DateN" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Note (Optionnel)</label>
                        <input type="number" step="0.01" name="Note" placeholder="0.00" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Photo d'Identité</label>
                    <div style="background: #f8fafc; border: 2px dashed #cbd5e1; padding: 25px; border-radius: 20px; text-align: center; transition: border-color 0.3s; cursor: pointer;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='#cbd5e1'">
                        <i class="fas fa-camera-retro" style="font-size: 2rem; color: var(--primary); margin-bottom: 10px; display: block;"></i>
                        <span style="display: block; font-size: 0.9rem; font-weight: 600; color: #64748b; margin-bottom: 5px;">Cliquez pour télécharger</span>
                        <input type="file" name="photo" id="photo" accept="image/*" style="opacity: 0; position: absolute; width: 0; height: 0;">
                        <label for="photo" style="display: inline-block; padding: 8px 20px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.8rem; cursor: pointer; font-weight: 700; color: var(--dark);">Choisir un fichier</label>
                        <small style="display: block; color: #94a3b8; margin-top: 10px; font-size: 0.75rem;">JPG ou PNG, Max 5Mo</small>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #f1f5f9; display: flex; gap: 15px; justify-content: flex-end;">
            <button type="reset" class="btn btn-light" style="padding: 12px 30px; border-radius: 14px; font-weight: 700;">Réinitialiser</button>
            <button type="submit" class="btn btn-primary" style="padding: 12px 40px; border-radius: 14px; font-weight: 700; box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);">
                <i class="fas fa-cloud-upload-alt"></i> Finaliser l'inscription
            </button>
        </div>
    </form>
</div>
