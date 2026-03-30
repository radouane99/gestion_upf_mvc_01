<div class="welcome-banner" style="margin-bottom: 30px; padding: 40px; border-radius: 30px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 8px;"><i class="fas fa-users"></i> Gestion des Étudiants</h1>
            <p style="opacity: 0.9; font-size: 1.1rem;">Consultez, filtrez et gérez l'ensemble des inscrits à l'UPF.</p>
        </div>
        <a href="index.php?ctrl=etudiant&action=ajouter" class="btn" style="background: white; color: #4f46e5; border-radius: 14px; padding: 12px 24px; font-weight: 700; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
            <i class="fas fa-plus-circle"></i> Nouveau Étudiant
        </a>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success glass-card" style="margin-bottom: 24px; border-left: 5px solid var(--success);">
        <i class="fas fa-check-circle"></i>
        <?php 
            switch($_GET['msg']) {
                case 'ajoute': echo "Étudiant ajouté avec succès !"; break;
                case 'modifie': echo "Modifications enregistrées avec succès."; break;
                case 'supprime': echo "Étudiant retiré de la base de données."; break;
                case 'doc_ajoute': echo "Document archivé avec succès."; break;
            }
        ?>
    </div>
<?php endif; ?>

<!-- Modern Filter Section -->
<div class="card glass-card" style="margin-bottom: 30px; padding: 25px; border-radius: 24px;">
    <form action="index.php" method="GET" style="display: grid; grid-template-columns: 1fr 1fr auto auto; gap: 20px; align-items: end;">
        <input type="hidden" name="ctrl" value="etudiant">
        <input type="hidden" name="action" value="liste">
        
        <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px; display: block;">
                <i class="fas fa-search"></i> Recherche Globale
            </label>
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" name="recherche" value="<?php echo htmlspecialchars($recherche); ?>" placeholder="Nom, Prénom, Code..." style="padding-left: 45px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0;">
            </div>
        </div>
        
        <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px; display: block;">
                <i class="fas fa-filter"></i> Filtrer par Filière
            </label>
            <select name="filiere" style="border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; height: 46px;">
                <option value="">Toutes les filières</option>
                <?php foreach ($filieres as $f): ?>
                    <option value="<?php echo $f['CodeF']; ?>" <?php echo $filiere === $f['CodeF'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($f['IntituleF']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary" style="height: 46px; border-radius: 12px; padding: 0 20px;"><i class="fas fa-search"></i> Filtrer</button>
        <a href="index.php?ctrl=etudiant&action=liste" class="btn btn-light" style="height: 46px; width: 46px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 12px;"><i class="fas fa-sync-alt"></i></a>
    </form>
</div>

<!-- Table Card -->
<div class="card glass-card" style="padding: 0; overflow: hidden; border-radius: 24px;">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(248, 250, 252, 0.5);">
                    <th style="padding: 20px 24px; text-align: left; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Étudiant & Matricule</th>
                    <th style="padding: 20px 24px; text-align: left; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Filière</th>
                    <th style="padding: 20px 24px; text-align: center; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Moyenne</th>
                    <th style="padding: 20px 24px; text-align: center; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Statut</th>
                    <th style="padding: 20px 24px; text-align: right; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $e): ?>
                    <?php 
                        $note = $e['Note'];
                        $statusText = "Non évalué";
                        $statusColor = "#94a3b8";
                        $statusBg = "#f1f5f9";
                        
                        if ($note !== null) {
                            if ($note >= 10) {
                                $statusText = "Admis";
                                $statusColor = "#16a34a";
                                $statusBg = "#f0fdf4";
                            } else {
                                $statusText = "Ajourné";
                                $statusColor = "#dc2626";
                                $statusBg = "#fef2f2";
                            }
                        }
                    ?>
                    <tr style="border-bottom: 1px solid rgba(226, 232, 240, 0.4); transition: background 0.2s;" onmouseover="this.style.background='rgba(248, 250, 252, 0.8)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: #e2e8f0; overflow: hidden; border: 2px solid white; box-shadow: var(--shadow-sm);">
                                    <?php if($e['Photo'] && file_exists($e['Photo'])): ?>
                                        <img src="<?= $e['Photo'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #64748b; background: #f1f5f9; font-size: 0.85rem;">
                                            <?= strtoupper(substr($e['Nom'], 0, 1) . substr($e['Prenom'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: var(--dark); font-size: 0.95rem;"><?= htmlspecialchars($e['Nom'] . ' ' . $e['Prenom']) ?></div>
                                    <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8;"><?= htmlspecialchars($e['CodeE']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px 24px;">
                            <span style="font-weight: 600; color: #64748b; font-size: 0.9rem;"><?= htmlspecialchars($e['IntituleF']) ?></span>
                        </td>
                        <td style="padding: 16px 24px; text-align: center;">
                            <?php if($note !== null): ?>
                                <span style="font-weight: 800; font-family: 'JetBrains Mono', monospace; font-size: 1rem; color: <?= $statusColor ?>;">
                                    <?= number_format($note, 2) ?>
                                </span>
                            <?php else: ?>
                                <span style="color: #cbd5e1;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 16px 24px; text-align: center;">
                            <span class="badge" style="background: <?= $statusBg ?>; color: <?= $statusColor ?>; padding: 6px 14px; border-radius: 10px; font-weight: 700; font-size: 0.8rem; border: 1px solid rgba(0,0,0,0.02);">
                                <?= $statusText ?>
                            </span>
                        </td>
                        <td style="padding: 16px 24px; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="index.php?ctrl=etudiant&action=detail&code=<?= $e['CodeE'] ?>" class="action-btn" title="Voir l'étudiant" style="background: #f8fafc; color: #3b82f6; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                    <i class="fas fa-eye-slash"></i>
                                </a>
                                <a href="index.php?ctrl=etudiant&action=modifier&code=<?= $e['CodeE'] ?>" class="action-btn" title="Modifier" style="background: #f8fafc; color: #f59e0b; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <a href="index.php?ctrl=etudiant&action=supprimer&code=<?= $e['CodeE'] ?>" class="action-btn" title="Révoquer" style="background: #fef2f2; color: #ef4444; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onclick="return confirm('Attention : Cette action est irréversible. Révoquer cet étudiant ?')">
                                    <i class="fas fa-user-times"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Creative Pagination -->
<?php if ($nbPages > 1): ?>
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 40px; background: rgba(255, 255, 255, 0.5); width: fit-content; margin: 40px auto 0; padding: 8px; border-radius: 18px; backdrop-filter: blur(10px); border: 1px solid white; box-shadow: var(--shadow-sm);">
        <?php for ($i = 1; $i <= $nbPages; $i++): 
            $query = $_GET;
            $query['page'] = $i;
            $url = 'index.php?' . http_build_query($query);
            $isActive = ($page == $i);
        ?>
            <a href="<?= $url ?>" class="btn" style="min-width: 42px; height: 42px; border-radius: 12px; font-weight: 700; transition: all 0.3s; <?= $isActive ? 'background: var(--primary); color: white; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);' : 'background: transparent; color: var(--gray);' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
