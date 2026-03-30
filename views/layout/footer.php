    <?php if (!(isset($_GET['action']) && $_GET['action'] === 'dashboard')): ?>
        </main>
    <?php endif; ?>
    
    <footer style="margin-top: 80px; text-align: center; padding: 40px 0; background: #f8fafc; border-top: 1px solid #e2e8f0; color: var(--gray);">
        <div class="container">
            <div style="font-family: 'Outfit', sans-serif; font-weight: 800; color: var(--primary); margin-bottom: 15px; font-size: 1.2rem;">
                <i class="fas fa-university"></i> UPF Gestion
            </div>
            <p style="font-size: 0.95rem;">&copy; <?php echo date('Y'); ?> Université Privée de Fès (UPF) - Système de Gestion MVC Professionnel</p>
            <p style="margin-top: 5px; font-size: 0.85rem; opacity: 0.7;">Réalisé dans le cadre du cours Technologie Web 2 - Pr. M. KZADRI</p>
            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 20px; font-size: 1.2rem;">
                <i class="fab fa-facebook" style="opacity: 0.5;"></i>
                <i class="fab fa-twitter" style="opacity: 0.5;"></i>
                <i class="fab fa-linkedin" style="opacity: 0.5;"></i>
            </div>
        </div>
    </footer>
</body>
</html>
