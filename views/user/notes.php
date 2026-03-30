<div class="card-header" style="margin-bottom: 30px;">
    <div class="card-title" style="font-size: 1.8rem;">
        <i class="fas fa-graduation-cap" style="color: var(--primary);"></i> Mes Notes & Classement
    </div>
    <span class="badge badge-primary"><?php echo htmlspecialchars($etudiant['IntituleF']); ?></span>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
    <!-- Note Card -->
    <div class="card" style="text-align: center; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -10px; left: -10px; width: 60px; height: 60px; background: var(--gradient); opacity: 0.1; border-radius: 50%;"></div>
        
        <h3 style="color: var(--gray); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Ma Moyenne Actuelle</h3>
        <div style="font-size: 4rem; font-weight: 800; background: var(--gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 10px 0;">
            <?php echo $etudiant['Note'] !== null ? number_format($etudiant['Note'], 2) : "--"; ?>
            <small style="font-size: 1.2rem; color: var(--gray); -webkit-text-fill-color: var(--gray);">/ 20</small>
        </div>
        
        <?php if ($etudiant['Note'] !== null): ?>
            <?php 
                $n = $etudiant['Note'];
                $mention = "Insuffisant"; $class = "badge-danger";
                if ($n >= 16) { $mention = "Très Bien"; $class = "badge-success"; }
                elseif ($n >= 14) { $mention = "Bien"; $class = "badge-success"; }
                elseif ($n >= 12) { $mention = "Assez Bien"; $class = "badge-primary"; }
                elseif ($n >= 10) { $mention = "Passable"; $class = "badge-primary"; }
            ?>
            <div class="badge <?= $class ?>" style="font-size: 1rem; padding: 10px 24px; border-radius: 50px;">
                Mention : <strong><?php echo $mention; ?></strong>
            </div>
        <?php else: ?>
            <div class="badge" style="background: #f1f5f9; color: var(--gray); font-size: 0.9rem; padding: 10px 24px;">
                Évaluation en cours...
            </div>
        <?php endif; ?>
    </div>

    <!-- Ranking Card -->
    <div class="card" style="text-align: center; background: #f8fafc; border: 1px solid #e2e8f0;">
        <h3 style="color: var(--gray); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Classement Filière</h3>
        
        <?php if ($classement): ?>
            <div style="margin: 24px 0;">
                <div style="font-size: 3.5rem; font-weight: 800; color: var(--dark);">
                    <?php echo $classement['rang']; ?><small style="font-size: 1.5rem; color: var(--primary);"><?php echo $classement['rang'] == 1 ? 'er' : 'ème'; ?></small>
                </div>
                <div style="font-size: 0.9rem; color: var(--gray); margin-top: -5px;">sur tous les étudiants de la filière</div>
            </div>
            <div style="display: flex; justify-content: space-around; border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 10px;">
                <div>
                    <div style="font-size: 0.75rem; color: var(--gray); font-weight: 700; text-transform: uppercase;">Moy. Filière</div>
                    <div style="font-weight: 700; font-size: 1.2rem;"><?php echo number_format($classement['moyenne_filiere'], 2); ?></div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--gray); font-weight: 700; text-transform: uppercase;">Écart</div>
                    <?php $diff = $etudiant['Note'] - $classement['moyenne_filiere']; ?>
                    <div style="font-weight: 700; font-size: 1.2rem; color: <?= $diff >= 0 ? 'var(--success)' : 'var(--danger)' ?>;">
                        <?= $diff >= 0 ? '+' : '' ?><?= number_format($diff, 2) ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div style="padding: 40px 0; color: var(--gray);">
                <i class="fas fa-chart-line" style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.2;"></i>
                <p>Classement indisponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-history"></i> Historique des Résultats</div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Semestre / Module</th>
                    <th>Note obtenue</th>
                    <th>Crédits</th>
                    <th>Résultat Valider</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><div style="font-weight: 600;">Semestre 1 (Global)</div></td>
                    <td><span class="badge badge-primary" style="font-size: 0.95rem; font-weight: 700;"><?php echo $etudiant['Note'] !== null ? number_format($etudiant['Note'], 2) : '--'; ?></span></td>
                    <td><span style="color: var(--gray); font-weight: 600;">30 / 30</span></td>
                    <td>
                        <?php if ($etudiant['Note'] >= 10): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i> VALIDE</span>
                        <?php elseif ($etudiant['Note'] !== null): ?>
                            <span class="badge badge-danger"><i class="fas fa-times"></i> NON VALIDE</span>
                        <?php else: ?>
                            <span class="badge" style="background: #f1f5f9; color: var(--gray);">EN ATTENTE</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <button class="action-btn" title="Détail par module"><i class="fas fa-search-plus"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
