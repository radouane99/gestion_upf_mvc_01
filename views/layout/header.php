<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPF Gestion - Système Universitaire</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <nav class="container nav-row">
            <a href="index.php" class="logo-wrapper">
                <div class="logo-icon">UPF</div>
                <div class="logo-text">UPF <span>Gestion</span></div>
            </a>

            <ul class="main-nav">
                <?php if (isset($_SESSION['role'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="index.php?ctrl=etudiant&action=dashboard" class="<?= ($_GET['action'] == 'dashboard') ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Mon Dashboard</a></li>
                        <li><a href="index.php?ctrl=etudiant&action=liste" class="<?= ($_GET['action'] == 'liste' || $_GET['action'] == 'ajouter') ? 'active' : '' ?>"><i class="fas fa-user-graduate"></i> Étudiants</a></li>
                        <li><a href="index.php?ctrl=filiere&action=liste" class="<?= ($_GET['ctrl'] == 'filiere') ? 'active' : '' ?>"><i class="fas fa-university"></i> Filières</a></li>
                    <?php else: ?>
                        <li><a href="index.php?ctrl=user&action=profil" class="<?= ($_GET['action'] == 'profil') ? 'active' : '' ?>"><i class="fas fa-user-circle"></i> Mon Profil</a></li>
                        <li><a href="index.php?ctrl=user&action=notes" class="<?= ($_GET['action'] == 'notes') ? 'active' : '' ?>"><i class="fas fa-graduation-cap"></i> Mes Notes</a></li>
                        <li><a href="index.php?ctrl=user&action=documents" class="<?= ($_GET['action'] == 'documents') ? 'active' : '' ?>"><i class="fas fa-file-invoice"></i> Documents</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <form action="index.php" method="GET" class="nav-search-form">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <input type="hidden" name="ctrl" value="etudiant">
                    <input type="hidden" name="action" value="liste">
                <?php else: ?>
                    <input type="hidden" name="ctrl" value="user">
                    <input type="hidden" name="action" value="documents">
                <?php endif; ?>
                <div class="search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" name="recherche" placeholder="Rechercher...">
                </div>
            </form>

            <?php if (isset($_SESSION['login'])): ?>
                <div class="user-wide-badge" id="openSidebar">
                    <div class="user-avatar-circle">
                        <?php 
                            $profilePhoto = 'assets/default_user.png';
                            if ($_SESSION['role'] === 'user') {
                                require_once 'models/EtudiantModel.php';
                                $em = new EtudiantModel();
                                $currentEtudiant = $em->findByCode($_SESSION['etudiant_id']);
                                if ($currentEtudiant && $currentEtudiant['Photo'] && file_exists($currentEtudiant['Photo'])) {
                                    $profilePhoto = $currentEtudiant['Photo'];
                                }
                            }
                        ?>
                        <img src="<?= $profilePhoto ?>" alt="Avatar">
                    </div>
                    <div class="user-info-text">
                        <strong><?= htmlspecialchars($_SESSION['login']) ?></strong>
                        <span><?= strtoupper($_SESSION['role']) ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </nav>
    </header>

    <?php if (isset($_SESSION['login'])): ?>
    <!-- Modern Right Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="user-sidebar" id="userSidebar">
        <div class="sidebar-header">
            <div class="sidebar-close" id="closeSidebar"><i class="fas fa-times"></i></div>
            <div style="width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.3); padding: 5px;">
                <img src="<?= $profilePhoto ?? 'assets/default_user.png' ?>" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; background: white;">
            </div>
            <h3 style="margin-bottom: 5px;"><?= htmlspecialchars($_SESSION['login']) ?></h3>
            <span class="badge" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);"><?= ucfirst($_SESSION['role']) ?></span>
        </div>
        
        <div class="sidebar-body">
            <h4 style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray); letter-spacing: 0.1em; margin-bottom: 15px;">Navigation Rapide</h4>
            <ul class="sidebar-menu">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=etudiant&action=dashboard"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=etudiant&action=liste"><i class="fas fa-users"></i> Étudiants</a></li>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=filiere&action=liste"><i class="fas fa-university"></i> Filières</a></li>
                <?php else: ?>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=user&action=profil"><i class="fas fa-user-circle"></i> Mon Profil</a></li>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=user&action=notes"><i class="fas fa-award"></i> Mes Notes</a></li>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=user&action=documents"><i class="fas fa-file-pdf"></i> Mes Documents</a></li>
                    <li class="sidebar-menu-item"><a href="index.php?ctrl=user&action=changerPassword"><i class="fas fa-shield-alt"></i> Sécurité</a></li>
                <?php endif; ?>
            </ul>
        </div>
        
        <div class="sidebar-footer">
            <a href="index.php?ctrl=auth&action=logout" class="btn btn-danger" style="width: 100%; justify-content: center;">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </div>

    <script>
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('userSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        if(openBtn) openBtn.addEventListener('click', toggleSidebar);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
    </script>
    <?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'dashboard'): ?>
        <!-- Le dashboard a sa propre structure de bannière -->
    <?php else: ?>
        <main class="container" style="padding-top: 40px;">
    <?php endif; ?>
