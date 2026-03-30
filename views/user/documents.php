<div class="welcome-banner" style="margin-bottom: 30px; padding: 40px; border-radius: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 8px;"><i class="fas fa-file-pdf"></i> Mes Documents</h1>
            <p style="opacity: 0.9; font-size: 1.1rem;">Accédez et téléchargez vos pièces administratives en un clic.</p>
        </div>
        <div class="badge" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 1rem; backdrop-filter: blur(10px);">
            <?= count($documents) ?> fichiers
        </div>
    </div>
</div>

<div class="card glass-card" style="padding: 40px; border-radius: 30px;">
    <?php if (!empty($recherche)): ?>
        <div style="margin-bottom: 30px; display: flex; align-items: center; gap: 12px; color: var(--gray); font-weight: 600;">
            <i class="fas fa-search"></i> Résultats de recherche pour : <span style="color: var(--primary);">"<?= htmlspecialchars($recherche) ?>"</span>
            <a href="index.php?ctrl=user&action=documents" class="btn btn-sm btn-light" style="margin-left: 10px; border-radius: 8px;">Effacer</a>
        </div>
    <?php endif; ?>

    <?php if (empty($documents)): ?>
        <div style="text-align: center; padding: 80px 0; color: #94a3b8;">
            <div style="width: 120px; height: 120px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 3rem; opacity: 0.5;">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 style="color: var(--dark); font-weight: 800; margin-bottom: 10px;">Aucun document trouvé</h3>
            <p style="font-size: 1.1rem; max-width: 400px; margin: 0 auto; opacity: 0.7;">
                <?php echo empty($recherche) ? "Il semble qu'aucun document n'ait encore été déposé dans votre espace par l'administration." : "Aucun fichier ne correspond à votre recherche '" . htmlspecialchars($recherche) . "'."; ?>
            </p>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
            <?php foreach ($documents as $doc): ?>
                <div class="doc-card" style="background: white; border: 1px solid #f1f5f9; padding: 20px; border-radius: 20px; transition: var(--transition); box-shadow: var(--shadow-sm);">
                    <div class="doc-icon" style="width: 50px; height: 50px; background: #f8fafc; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #ef4444; font-size: 1.4rem; border: 1px solid #f1f5f9;">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="doc-info" style="flex-grow: 1; margin: 0 15px;">
                        <span class="doc-name" style="display: block; font-weight: 700; color: var(--dark); margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 180px;"><?php echo htmlspecialchars($doc['nom']); ?></span>
                        <div class="doc-meta" style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; display: flex; gap: 12px;">
                            <span><i class="far fa-calendar-alt"></i> <?php echo date('d M Y', strtotime($doc['date_upload'])); ?></span>
                            <span><i class="fas fa-hdd"></i> <?php echo round($doc['taille'] / 1024, 1); ?> Ko</span>
                        </div>
                    </div>
                    <a href="<?php echo $doc['chemin']; ?>" download class="action-btn" title="Télécharger" style="width: 44px; height: 44px; background: var(--primary); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; transition: var(--transition); box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 50px; background: #fffbeb; border: 1px solid #fef3c7; border-left: 6px solid #f59e0b; padding: 24px; border-radius: 18px; display: flex; gap: 20px; align-items: flex-start;">
        <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f59e0b; flex-shrink: 0;">
            <i class="fas fa-info-circle"></i>
        </div>
        <div style="font-size: 0.95rem; color: #92400e; line-height: 1.6;">
            <strong>Note Administrative :</strong> Ces documents ont une valeur légale. Pour toute demande de duplicata cacheté ou attestation spécifique, veuillez contacter le service scolarité muni de votre carte d'étudiant.
        </div>
    </div>
</div>
