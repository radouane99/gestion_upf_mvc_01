<div class="welcome-banner" style="margin-bottom: 30px; padding: 40px; border-radius: 30px; background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 8px;"><i class="fas fa-user-edit"></i> Modifier Étudiant</h1>
            <p style="opacity: 0.9; font-size: 1.1rem;">Mettez à jour les informations de <?= htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']) ?>.</p>
        </div>
        <a href="index.php?ctrl=etudiant&action=liste" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 14px; padding: 12px 24px; font-weight: 700; backdrop-filter: blur(10px);">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card glass-card" style="padding: 40px; border-radius: 30px;">
    <form action="index.php?ctrl=etudiant&action=modifierTraitement" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Matricule (Lecture seule)</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                        <input type="text" name="CodeE" value="<?php echo htmlspecialchars($etudiant['CodeE']); ?>" readonly style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f1f5f9; color: #64748b;">
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Nom Complet</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <input type="text" name="Nom" value="<?php echo htmlspecialchars($etudiant['Nom']); ?>" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;" required>
                        <input type="text" name="Prenom" value="<?php echo htmlspecialchars($etudiant['Prenom']); ?>" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;" required>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Filière Académique</label>
                    <div style="position: relative;">
                        <i class="fas fa-graduation-cap" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <select name="CodeF" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc; height: 50px;" required>
                            <?php foreach ($filieres as $f): ?>
                                <option value="<?php echo $f['CodeF']; ?>" <?php echo $etudiant['CodeF'] === $f['CodeF'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($f['IntituleF']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Email Institutionnel</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <input type="email" name="Email" value="<?php echo htmlspecialchars($etudiant['Email']); ?>" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Contact Téléphonique</label>
                    <div style="position: relative;">
                        <i class="fas fa-phone" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary);"></i>
                        <input type="tel" name="Telephone" value="<?php echo htmlspecialchars($etudiant['Telephone']); ?>" style="padding-left: 45px; border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Date de Naissance</label>
                        <input type="date" name="DateN" value="<?php echo htmlspecialchars($etudiant['DateN']); ?>" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Note Moyenne</label>
                        <input type="number" step="0.01" name="Note" value="<?php echo htmlspecialchars($etudiant['Note']); ?>" style="border-radius: 14px; border: 1px solid #e2e8f0; background: #f8fafc;" min="0" max="20">
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 700; color: var(--dark); margin-bottom: 10px; display: block;">Photo de Profil</label>
                    <div style="display: flex; gap: 20px; align-items: start;">
                        <div style="flex: 1; background: #f8fafc; border: 2px dashed #cbd5e1; padding: 20px; border-radius: 20px; text-align: center; position: relative;">
                            <i class="fas fa-camera" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 8px; display: block;"></i>
                            <input type="file" name="photo" id="photo" accept="image/*" style="opacity: 0; position: absolute; width: 0; height: 0;">
                            <label for="photo" style="display: inline-block; padding: 8px 20px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.8rem; cursor: pointer; font-weight: 700; color: var(--dark);">Changer la photo</label>
                        </div>
                        
                        <?php if ($etudiant['Photo']): ?>
                            <div style="text-align: center;">
                                <div style="width: 90px; height: 90px; border-radius: 18px; overflow: hidden; border: 3px solid white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                                    <img src="<?php echo $etudiant['Photo']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <small style="display: block; margin-top: 5px; color: #94a3b8; font-weight: 700; font-size: 0.7rem;">Actuelle</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #f1f5f9; display: flex; gap: 15px; justify-content: flex-end;">
            <a href="index.php?ctrl=etudiant&action=liste" class="btn btn-light" style="padding: 12px 30px; border-radius: 14px; font-weight: 700;">Annuler</a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 40px; border-radius: 14px; font-weight: 700; background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%); border: none; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
