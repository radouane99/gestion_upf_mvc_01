<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2><i class="fas fa-graduation-cap"></i> Liste des Filières</h2>
    <a href="index.php?ctrl=filiere&action=ajouter" class="btn btn-success"><i class="fas fa-plus"></i> Nouvelle Filière</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">Filière ajoutée avec succès.</div>
<?php endif; ?>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Intitulé</th>
                <th>Responsable</th>
                <th>Capacité (Places)</th>
                <th>Effectif (Étudiants)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filieres as $f): ?>
                <?php 
                    $isFull = $f['NbEtudiants'] >= $f['NbPlaces'];
                    $ratio = $f['NbPlaces'] > 0 ? ($f['NbEtudiants'] / $f['NbPlaces']) * 100 : 0;
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($f['CodeF']); ?></strong></td>
                    <td><?php echo htmlspecialchars($f['IntituleF']); ?></td>
                    <td><?php echo htmlspecialchars($f['Responsable']); ?></td>
                    <td><?php echo $f['NbPlaces']; ?></td>
                    <td><?php echo $f['NbEtudiants']; ?></td>
                    <td>
                        <div style="width: 100px; height: 10px; background: #eee; border-radius: 5px; overflow: hidden; margin-bottom: 5px;">
                            <div style="width: <?php echo min(100, $ratio); ?>%; height: 100%; background: <?php echo $isFull ? 'var(--danger)' : 'var(--accent)'; ?>;"></div>
                        </div>
                        <small><?php echo round($ratio, 1); ?>%</small>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
