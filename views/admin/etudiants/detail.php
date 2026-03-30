<div class="card-header" style="margin-bottom: 30px;">
    <div class="card-title" style="font-size: 1.8rem;">
        <i class="fas fa-id-card" style="color: var(--primary);"></i> Fiche Étudiant
    </div>
    <a href="index.php?ctrl=etudiant&action=liste" class="btn btn-light"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Infos Photo & Bio -->
    <div class="card" style="text-align: center; height: fit-content;">
        <div style="position: relative; width: 160px; height: 160px; margin: 0 auto 24px;">
            <img src="<?php echo $etudiant['Photo'] ?? 'assets/default_user.png'; ?>" style="width: 100%; height: 100%; border-radius: 20px; object-fit: cover; border: 4px solid white; box-shadow: var(--shadow);">
            <div style="position: absolute; bottom: -10px; right: -10px; width: 40px; height: 40px; background: var(--gradient); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; border: 3px solid white;">
                <i class="fas fa-camera" style="font-size: 0.9rem;"></i>
            </div>
        </div>
        
        <h2 style="font-size: 1.6rem; font-weight: 800;"><?php echo htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']); ?></h2>
        <span class="badge badge-primary"><?php echo htmlspecialchars($etudiant['IntituleF']); ?></span>
        
        <div style="margin-top: 32px; text-align: left; display: flex; flex-direction: column; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 12px; color: var(--gray);">
                <i class="fas fa-id-badge" style="width: 20px; color: var(--primary);"></i>
                <span>Matricule: <strong><?php echo htmlspecialchars($etudiant['CodeE']); ?></strong></span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; color: var(--gray);">
                <i class="fas fa-envelope" style="width: 20px; color: var(--primary);"></i>
                <span><?php echo htmlspecialchars($etudiant['Email'] ?: 'Non renseigné'); ?></span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; color: var(--gray);">
                <i class="fas fa-phone-alt" style="width: 20px; color: var(--primary);"></i>
                <span><?php echo htmlspecialchars($etudiant['Telephone'] ?: 'Non renseigné'); ?></span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; color: var(--gray);">
                <i class="fas fa-birthday-cake" style="width: 20px; color: var(--primary);"></i>
                <span>Né(e) le <?php echo htmlspecialchars($etudiant['DateN'] ?: '--'); ?></span>
            </div>
        </div>
        
        <div style="margin-top: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <a href="index.php?ctrl=etudiant&action=modifier&code=<?= $etudiant['CodeE'] ?>" class="btn btn-light" style="width: 100%; justify-content: center;"><i class="fas fa-edit"></i> Modifier</a>
            <a href="index.php?ctrl=etudiant&action=supprimer&code=<?= $etudiant['CodeE'] ?>" class="btn btn-danger" style="width: 100%; justify-content: center;" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i></a>
        </div>
    </div>

    <!-- Scolarité & Documents -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-graduation-cap"></i> Informations Académiques</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div style="background: #f8fafc; padding: 24px; border-radius: 16px; text-align: center; border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--gray); text-transform: uppercase; margin-bottom: 8px;">Moyenne Actuelle</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);"><?php echo number_format($etudiant['Note'] ?? 0, 2); ?> <small style="font-size: 1rem;">/ 20</small></div>
                </div>
                <div style="background: #f8fafc; padding: 24px; border-radius: 16px; text-align: center; border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--gray); text-transform: uppercase; margin-bottom: 8px;">Statut de réussite</div>
                    <?php 
                        $isPass = ($etudiant['Note'] >= 10);
                        $color = $isPass ? 'var(--success)' : 'var(--danger)';
                    ?>
                    <div style="font-size: 1.5rem; font-weight: 800; color: <?= $color ?>; margin-top: 5px;">
                        <i class="fas <?= $isPass ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                        <?= $isPass ? 'ADMIS(E)' : 'AJOURNÉ(E)' ?>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 24px;">
                <div class="progress-header">
                    <span>Niveau de performance</span>
                    <strong style="color: var(--primary);"><?= ($etudiant['Note'] / 20) * 100 ?>%</strong>
                </div>
                <div class="progress-track" style="height: 12px;">
                    <div class="progress-bar" style="width: <?= ($etudiant['Note'] / 20) * 100 ?>%;"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-file-invoice"></i> Documents Numérisés (PDF)</div>
                <span class="badge badge-primary"><?= count($documents) ?> fichiers</span>
            </div>
            
            <?php if (empty($documents)): ?>
                <div style="text-align: center; padding: 40px 0; color: var(--gray);">
                    <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p>Aucun document n'a été uploadé pour cet étudiant.</p>
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-top: 20px;">
                    <?php foreach ($documents as $doc): ?>
                        <div class="doc-card">
                            <div class="doc-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="doc-info">
                                <span class="doc-name"><?php echo htmlspecialchars($doc['nom']); ?></span>
                                <div class="doc-meta"><?php echo round($doc['taille'] / 1024, 1); ?> Ko • <?php echo htmlspecialchars($doc['type']); ?></div>
                            </div>
                            <a href="<?php echo $doc['chemin']; ?>" download class="action-btn" title="Télécharger">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid #f1f5f9;">
                <h4 style="margin-bottom: 20px; font-weight: 700;"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Ajouter un document</h4>
                <form action="index.php?ctrl=etudiant&action=uploadDocument" method="POST" enctype="multipart/form-data" class="upload-form">
                    <input type="hidden" name="etudiant_id" value="<?php echo $etudiant['CodeE']; ?>">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Désignation du document</label>
                            <input type="text" name="nom_doc" required placeholder="ex: Relevé de notes S1">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-folder"></i> Catégorie</label>
                            <select name="type_doc">
                                <option value="Inscription">Inscription</option>
                                <option value="Bulletin">Bulletin</option>
                                <option value="Certificat">Certificat</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <div class="upload-zone" onclick="document.getElementById('doc_file').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p style="font-weight: 600; color: var(--dark);">Cliquez pour choisir le fichier PDF</p>
                        <p style="font-size: 0.8rem; color: var(--gray);">Format PDF uniquement (Max 5 Mo)</p>
                        <input type="file" id="doc_file" name="doc" accept=".pdf" required style="display: none;">
                        <div id="file-name" style="margin-top: 10px; font-weight: 700; color: var(--primary); display: none;"></div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; justify-content: center;">
                        <i class="fas fa-upload"></i> Lancer l'upload du document
                    </button>
                </form>

                <script>
                    document.getElementById('doc_file').addEventListener('change', function() {
                        const fileName = this.files[0] ? this.files[0].name : '';
                        const display = document.getElementById('file-name');
                        if (fileName) {
                            display.textContent = 'Fichier sélectionné : ' + fileName;
                            display.style.display = 'block';
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
