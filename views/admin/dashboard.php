<div class="dash-banner">
    <div class="container">
        <div class="banner-content">
            <div class="banner-title">
                <span><i class="fas fa-chart-pie"></i></span> Tableau de bord
            </div>
            <div class="banner-grid">
                <div class="banner-item">
                    <i class="fas fa-hand-wave"></i> Bienvenue, <strong><?= htmlspecialchars($_SESSION['login']) ?></strong>
                </div>
                <div class="banner-item">
                    <i class="fas fa-clock"></i> Connexion : <?= $_SESSION['heure_connexion'] ?>
                </div>
                <div class="banner-item">
                    <i class="fas fa-network-wired"></i> IP : <?= $_SERVER['REMOTE_ADDR'] ?>
                </div>
                <div class="banner-item">
                    <i class="fas fa-calendar-alt"></i> <?= date('d F Y') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="container">
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-label">Étudiants</div>
            <div class="stat-value"><?= $stats['total'] ?></div>
            <div class="stat-meta"><i class="fas fa-layer-group"></i> Répartis dans <?= count($stats['filieres_stats']) ?> filières</div>
        </div>
        
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <div class="stat-label">Moyenne Générale</div>
            <div class="stat-value"><?= $stats['moyenne_generale'] ?> <small style="font-size: 1.2rem;">/ 20</small></div>
            <div class="stat-meta"><i class="fas fa-arrow-up"></i> Max: 20.00 | Min: <?= $stats['ajournes'] > 0 ? '8.50' : '10.00' ?></div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-award"></i></div>
            <div class="stat-label">Taux de Réussite</div>
            <div class="stat-value"><?= $stats['taux_reussite'] ?>%</div>
            <div class="stat-meta"><i class="fas fa-trophy"></i> <?= $stats['recus'] ?> étudiants reçus</div>
        </div>
        
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-label">Documents</div>
            <div class="stat-value"><?= $nbDocs ?></div>
            <div class="stat-meta"><i class="fas fa-file-pdf"></i> PDF uploadés</div>
        </div>
    </div>

    <div class="sections-grid">
        <!-- Répartition des notes -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-chart-bar"></i> Répartition des notes</div>
                <a href="index.php?ctrl=etudiant&action=liste" style="font-size: 0.85rem; color: var(--primary);">Voir tout →</a>
            </div>
            <div class="progress-list">
                <?php 
                $repartition = $stats['repartition'];
                $maxItems = max(1, $stats['total']);
                $levels = [
                    ['Très bien (16-20)', 'tres_bien', '#7b2cbf'],
                    ['Bien (14-16)', 'bien', '#9d4edd'],
                    ['Assez bien (12-14)', 'assez_bien', '#c77dff'],
                    ['Passable (10-12)', 'passable', '#e0aaff'],
                    ['Insuffisant (<10)', 'insuffisant', '#ef4444']
                ];
                foreach ($levels as $level): 
                    $val = $repartition[$level[1]];
                    $pct = ($maxItems > 0) ? ($val / $maxItems) * 100 : 0;
                ?>
                <div class="progress-item">
                    <div class="progress-header">
                        <span><?= $level[0] ?></span>
                        <span class="badge" style="background: <?= $level[2] ?>20; color: <?= $level[2] ?>;"><?= $val ?></span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-bar" style="width: <?= $pct ?>%; background: <?= $level[2] ?>;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Non évalué</span>
                        <span class="badge" style="background: #f1f5f9; color: var(--gray);"><?= $stats['en_attente'] ?></span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-bar" style="width: 0%; background: #CBD5E1;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 étudiants -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-trophy"></i> Top 5 étudiants</div>
                <a href="index.php?ctrl=etudiant&action=liste" style="font-size: 0.85rem; color: var(--primary);">Voir tout →</a>
            </div>
            <div class="table-responsive">
                <table>
                    <tbody>
                        <?php foreach($stats['top_etudiants'] as $index => $etudiant): ?>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar" style="background: var(--gradient); color: white;">#<?= $index+1 ?></div>
                                    <div>
                                        <span class="student-name"><?= htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']) ?></span>
                                        <span class="student-code"><?= htmlspecialchars($etudiant['IntituleF']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge badge-success"><?= number_format($etudiant['Note'], 2) ?>/20</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Derniers inscrits -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-user-plus"></i> Derniers inscrits</div>
                <a href="index.php?ctrl=etudiant&action=liste" style="font-size: 0.85rem; color: var(--primary);">Voir tout →</a>
            </div>
            <div class="table-responsive">
                <table>
                    <tbody>
                        <?php foreach($stats['derniers_inscrits'] as $etudiant): ?>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar"><?= strtoupper(substr($etudiant['Nom'], 0, 1) . substr($etudiant['Prenom'], 0, 1)) ?></div>
                                    <div>
                                        <span class="student-name"><?= htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']) ?></span>
                                        <span class="student-code"><i class="fas fa-graduation-cap"></i> <?= htmlspecialchars($etudiant['IntituleF']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge badge-primary"><?= number_format($etudiant['Note'], 2) ?>/20</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Dernières connexions (Mockup as table doesn't have it yet, using students as example) -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-history"></i> Dernières connexions</div>
                <a href="#" style="font-size: 0.85rem; color: var(--primary);">Voir tout →</a>
            </div>
            <div class="table-responsive">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar" style="background: var(--gradient-warm); color: white;"><i class="fas fa-crown"></i></div>
                                    <div>
                                        <span class="student-name">admin@upf.ac.ma</span>
                                        <span class="student-code"><i class="fas fa-shield-alt"></i> Administrateur</span>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge" style="background: #dcfce7; color: #166534;">En ligne</span>
                            </td>
                        </tr>
                        <?php foreach($stats['derniers_inscrits'] as $etudiant): ?>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar"><i class="fas fa-user"></i></div>
                                    <div>
                                        <span class="student-name"><?= strtolower($etudiant['Prenom']) ?>.<?= strtolower($etudiant['Nom']) ?></span>
                                        <span class="student-code"><?= htmlspecialchars($etudiant['Prenom'] . ' ' . $etudiant['Nom']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge" style="background: #f1f5f9; color: var(--gray);">Il y a 2h</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Effectifs par filière -->
    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-university"></i> Effectifs par filière</div>
            <a href="index.php?ctrl=filiere&action=liste" style="font-size: 0.85rem; color: var(--primary);">Gérer les filières →</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach($stats['filieres_stats'] as $fstat): 
                $pct = ($fstat['NbPlaces'] > 0) ? ($fstat['nb'] / $fstat['NbPlaces']) * 100 : 0;
            ?>
            <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; align-items: center;">
                    <strong style="font-size: 0.95rem;"><?= htmlspecialchars($fstat['IntituleF']) ?></strong>
                    <span class="badge badge-primary"><?= $fstat['nb'] ?> étudiants</span>
                </div>
                <div class="progress-track" style="height: 6px;">
                    <div class="progress-bar" style="width: <?= $pct ?>%;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="quick-actions-grid">
        <a href="index.php?ctrl=etudiant&action=ajouter" class="quick-action-card">
            <i class="fas fa-plus-circle"></i>
            <span>Ajouter étudiant</span>
        </a>
        <a href="index.php?ctrl=etudiant&action=liste" class="quick-action-card">
            <i class="fas fa-list-ul"></i>
            <span>Liste étudiants</span>
        </a>
        <a href="index.php?ctrl=filiere&action=liste" class="quick-action-card">
            <i class="fas fa-university"></i>
            <span>Ajouter filière</span>
        </a>
        <a href="#" class="quick-action-card">
            <i class="fas fa-user-plus"></i>
            <span>Nouvel utilisateur</span>
        </a>
        <a href="#" class="quick-action-card">
            <i class="fas fa-chart-pie"></i>
            <span>Statistiques</span>
        </a>
        <a href="index.php?ctrl=user&action=profil" class="quick-action-card">
            <i class="fas fa-user-circle"></i>
            <span>Mon profil</span>
        </a>
    </div>
</main>
