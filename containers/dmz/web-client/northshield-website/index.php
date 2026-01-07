<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NorthShield Defense Systems - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <h1>🛡️ NorthShield</h1>
                <p class="tagline">Defense Systems</p>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Accueil</a></li>
                    <li><a href="about.php">Qui sommes-nous</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="login.php">Espace Client</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay">
            <div class="container">
                <h2>Votre partenaire en systèmes de défense avancés</h2>
                <p>Solutions spatiales et systèmes de surveillance de nouvelle génération</p>
                <div class="hero-buttons">
                    <a href="services.php" class="btn btn-primary">Découvrir nos services</a>
                    <a href="about.php" class="btn btn-secondary">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section class="services-preview">
        <div class="container">
            <h2>Nos Domaines d'Excellence</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🛰️</div>
                    <h3>Systèmes Satellitaires</h3>
                    <p>Développement et gestion de satellites militaires de surveillance et communication.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🎯</div>
                    <h3>Systèmes de Guidage</h3>
                    <p>Technologies de guidage de précision pour applications défensives.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🔒</div>
                    <h3>Cybersécurité</h3>
                    <p>Protection des infrastructures critiques et des systèmes de commandement.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📡</div>
                    <h3>Communications Sécurisées</h3>
                    <p>Réseaux de communication cryptés pour opérations sensibles.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Années d'expérience</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Satellites en orbite</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Pays clients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Fiabilité opérationnelle</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Besoin d'une solution de défense sur mesure ?</h2>
            <p>Notre équipe d'experts est à votre disposition pour étudier vos besoins</p>
            <a href="login.php" class="btn btn-primary">Accéder à votre espace client</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>NorthShield Defense</h4>
                    <p>Leader en systèmes de défense et technologies spatiales depuis 1999.</p>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>📧 contact@northshield.mil</p>
                    <p>📞 +1 (555) 123-4567</p>
                    <p>📍 Fort Meade, Maryland, USA</p>
                </div>
                <div class="footer-section">
                    <h4>Liens rapides</h4>
                    <p><a href="about.php">Qui sommes-nous</a></p>
                    <p><a href="services.php">Services</a></p>
                    <p><a href="login.php">Espace Client</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 NorthShield Defense Systems. Tous droits réservés. | Niveau de classification: PUBLIC</p>
            </div>
        </div>
    </footer>
</body>
</html>
