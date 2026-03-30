<div class="welcome-banner" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%), radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; blur: 80px;"></div>
    <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em;">Bonjour, <?php echo htmlspecialchars($etudiant['Prenom']); ?> ! 👋</h1>
            <p style="opacity: 0.9; font-size: 1.15rem; font-weight: 500;">Bienvenue sur votre portail étudiant UPF nouvelle génération.</p>
        </div>
        <a href="index.php?ctrl=user&action=changerPassword" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(15px); border-radius: 16px; padding: 12px 24px; font-weight: 700; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            <i class="fas fa-key"></i> Sécurité
        </a>
    </div>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'pass_ok'): ?>
    <div class="alert alert-success glass-card" style="margin-bottom: 30px; border-left: 6px solid #10b981; animation: slideIn 0.5s ease-out;">
        <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i> <span style="font-weight: 600;">Succès :</span> Votre mot de passe a été sécurisé.
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 380px 1fr; gap: 40px; margin-top: 20px;">
    <!-- Profile Sidebar Card -->
    <div class="card glass-card" style="text-align: center; height: fit-content; padding: 50px 35px; border-radius: 35px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);">
        <form action="index.php?ctrl=user&action=modifierPhotoTraitement" method="POST" enctype="multipart/form-data" id="photoForm">
            <div style="position: relative; width: 180px; height: 180px; margin: 0 auto 30px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                <div style="width: 100%; height: 100%; border-radius: 45px; overflow: hidden; border: 6px solid white; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <img src="<?php echo $etudiant['Photo'] ?? 'assets/default_user.png'; ?>" id="profilePreview" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="position: absolute; bottom: 8px; right: 8px; width: 48px; height: 48px; background: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; border: 4px solid white; cursor: pointer; transition: all 0.2s; box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);" onclick="document.getElementById('profilePhotoInput').click()" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='var(--primary)'">
                    <i class="fas fa-camera"></i>
                </div>
                <input type="file" name="photo" id="profilePhotoInput" accept="image/*" style="display: none;" onchange="document.getElementById('photoForm').submit()">
            </div>
        </form>

        <h2 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-bottom: 8px;"><?php echo htmlspecialchars($etudiant['Nom'] . ' ' . $etudiant['Prenom']); ?></h2>
        <div style="display: inline-block; background: linear-gradient(90deg, #f0f9ff 0%, #e0f2fe 100%); color: #0369a1; padding: 6px 18px; border-radius: 12px; font-weight: 800; font-size: 0.8rem; margin-bottom: 15px; border: 1px solid #bae6fd; text-transform: uppercase; letter-spacing: 0.05em;">
            <?php echo htmlspecialchars($etudiant['IntituleF']); ?>
        </div>
        
        <div style="text-align: left; margin-top: 40px; display: flex; flex-direction: column; gap: 15px;">
            <div class="info-row" style="background: rgba(248, 250, 252, 0.5); padding: 15px; border-radius: 18px; border: 1px solid rgba(226, 232, 240, 0.5);">
                <div class="info-icon" style="background: white; border-radius: 12px;"><i class="fas fa-id-badge" style="color: #6366f1;"></i></div>
                <div class="info-content">
                    <label style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Matricule Académique</label>
                    <span style="font-weight: 700; color: #1e293b; letter-spacing: 0.02em;">#<?php echo htmlspecialchars($etudiant['CodeE']); ?></span>
                </div>
            </div>
            
            <div class="info-row" style="background: rgba(248, 250, 252, 0.5); padding: 15px; border-radius: 18px; border: 1px solid rgba(226, 232, 240, 0.5);">
                <div class="info-icon" style="background: white; border-radius: 12px;"><i class="fas fa-at" style="color: #a855f7;"></i></div>
                <div class="info-content" style="max-width: 220px;">
                    <label style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Email UPF</label>
                    <span style="font-weight: 700; color: #1e293b; word-break: break-all;"><?php echo htmlspecialchars($etudiant['Email']); ?></span>
                </div>
            </div>

            <div class="info-row" style="background: rgba(248, 250, 252, 0.5); padding: 15px; border-radius: 18px; border: 1px solid rgba(226, 232, 240, 0.5);">
                <div class="info-icon" style="background: white; border-radius: 12px;"><i class="fas fa-phone-alt" style="color: #ec4899;"></i></div>
                <div class="info-content">
                    <label style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Contact Direct</label>
                    <span style="font-weight: 700; color: #1e293b;"><?php echo htmlspecialchars($etudiant['Telephone']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        <!-- Stats & Connection Box -->
        <div class="card glass-card" style="border-radius: 35px; padding: 35px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                <h3 style="font-size: 1.4rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i class="fas fa-bolt"></i>
                    </div>
                    Tableau de Bord
                </h3>
                <div style="font-size: 0.85rem; font-weight: 700; color: #10b981; background: #f0fdf4; padding: 6px 14px; border-radius: 10px; border: 1px solid #dcfce7;">
                    <span style="display: inline-block; width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-right: 6px;"></span> Session Active
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div style="background: #f8fafc; padding: 25px; border-radius: 25px; border: 1px solid #f1f5f9; position: relative; overflow: hidden;">
                    <div style="position: absolute; right: -20px; bottom: -20px; font-size: 5rem; color: #f1f5f9; z-index: 0;"><i class="fas fa-clock"></i></div>
                    <div style="position: relative; z-index: 1;">
                        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Heure de Connexion</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;"><?php echo $_SESSION['heure_connexion']; ?></div>
                    </div>
                </div>
                <div style="background: #f8fafc; padding: 25px; border-radius: 25px; border: 1px solid #f1f5f9; position: relative; overflow: hidden;">
                    <div style="position: absolute; right: -20px; bottom: -20px; font-size: 5rem; color: #f1f5f9; z-index: 0;"><i class="fas fa-globe"></i></div>
                    <div style="position: relative; z-index: 1;">
                        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Votre Adresse IP Identifiée</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary); font-family: 'JetBrains Mono', monospace;"><?php echo $ip; ?></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 30px; display: flex; align-items: center; gap: 15px; background: #fff7ed; color: #c2410c; padding: 20px; border-radius: 20px; font-weight: 700; font-size: 0.95rem; border: 1px solid #ffedd5;">
                <div style="width: 36px; height: 36px; background: #ffedd5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f97316;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                Sécurité Session : Votre accès est authentifié et surveillé pour votre protection.
            </div>
        </div>

        <!-- High Fidelity Quick Actions -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <a href="index.php?ctrl=user&action=notes" class="card" style="background: white; border-radius: 30px; padding: 35px; text-decoration: none; transition: all 0.3s; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 25px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4338ca; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h4 style="font-weight: 800; color: #1e293b; font-size: 1.3rem; margin-bottom: 6px;">Mes Notes</h4>
                    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500; margin: 0;">Résultats & Relevés</p>
                </div>
            </a>
            
            <a href="index.php?ctrl=user&action=documents" class="card" style="background: white; border-radius: 30px; padding: 35px; text-decoration: none; transition: all 0.3s; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 25px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #fae8ff 0%, #f5d0fe 100%); color: #a21caf; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div>
                    <h4 style="font-weight: 800; color: #1e293b; font-size: 1.3rem; margin-bottom: 6px;">Documents</h4>
                    <p style="color: #64748b; font-size: 0.95rem; font-weight: 500; margin: 0;">Espace Administratif</p>
                </div>
            </a>
        </div>
    </div>
</div>
