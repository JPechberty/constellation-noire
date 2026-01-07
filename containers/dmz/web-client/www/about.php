<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qui sommes-nous - NorthShield Defense Systems</title>
    <link rel="stylesheet" href="style-modern.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="about.php" class="active">Qui sommes-nous</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="login.php">Espace Client</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Qui sommes-nous</h1>
            <p>Excellence technologique et segment sol critique depuis 1999</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <div class="about-intro">
                <h2>NorthShield Defense Systems</h2>
                <p class="lead">
                    Fondée en 1999, NorthShield Defense Systems conçoit des systèmes à forte criticité
                    — de l’observation orbitale jusqu’aux consoles de station de contrôle au sol.
                    Notre expertise couvre les charges utiles, les chaînes de télémesure, et l’intégration
                    de systèmes évolutifs avec des composants legacy.
                </p>
            </div>

            <div class="mission-vision">
                <div class="mission-box">
                    <h3>🎯 Notre Mission</h3>
                    <p>
                        Fournir des chaînes d’observation et de communications robustes, du capteur orbital
                        jusqu’aux réseaux et applications du segment sol (GS‑OPS), avec un niveau de fiabilité
                        compatible avec les environnements institutionnels.
                    </p>
                </div>
                <div class="vision-box">
                    <h3>🔭 Notre Vision</h3>
                    <p>
                        Être le partenaire de référence pour des systèmes dual‑use à haute disponibilité,
                        en combinant innovation, interopérabilité et maintien en conditions opérationnelles
                        sur le long terme.
                    </p>
                </div>
            </div>

            <div class="history">
                <h2>Notre Histoire</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-year">1999</div>
                        <div class="timeline-content">
                            <h4>Fondation</h4>
                            <p>Création de NorthShield Defense Systems à Fort Meade, Maryland.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2004</div>
                        <div class="timeline-content">
                            <h4>Premiers capteurs d’observation</h4>
                            <p>Mise en service d’une première plateforme d’imagerie et de télémesure (ARGOS‑1).</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2012</div>
                        <div class="timeline-content">
                            <h4>Expansion internationale</h4>
                            <p>Déploiement d’équipes d’intégration segment sol et support opérations (24/7).</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2024</div>
                        <div class="timeline-content">
                            <h4>ARGOS‑7 (programme)</h4>
                            <p>
                                Extension du programme d’observation « environnementale » avec un segment sol modernisé,
                                des protocoles de télémesure propriétaires et l’intégration d’applications legacy.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="values">
                <h2>Nos Valeurs</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">🔐</div>
                        <h3>Sécurité</h3>
                        <p>Contrôle d’accès, traçabilité et durcissement au cœur de nos systèmes.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">⚡</div>
                        <h3>Innovation</h3>
                        <p>Chaînes de traitement et exploitation de données à l’état de l’art.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">🧰</div>
                        <h3>Pérennité</h3>
                        <p>Support long terme et interopérabilité — y compris sur des briques legacy.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">🌍</div>
                        <h3>Responsabilité</h3>
                        <p>Conformité, auditabilité et séparation des jeux de données selon les habilitations.</p>
                    </div>
                </div>
            </div>

            <div class="certifications">
                <h2>Certifications & Accréditations</h2>
                <div class="cert-grid">
                    <div class="cert-item">
                        <p>✅ ISO 9001:2015 (Qualité)</p>
                    </div>
                    <div class="cert-item">
                        <p>✅ ISO 27001 (Sécurité de l'information)</p>
                    </div>
                    <div class="cert-item">
                        <p>✅ CMMC Level 3 (Cybersecurity)</p>
                    </div>
                    <div class="cert-item">
                        <p>✅ ITAR Registered (Export Control)</p>
                    </div>
                    <div class="cert-item">
                        <p>✅ Top Secret Facility Clearance</p>
                    </div>
                    <div class="cert-item">
                        <p>✅ NATO Secret Accreditation</p>
                    </div>
                </div>
            </div>

            <div class="team">
                <h2>Notre Équipe</h2>
                <p class="team-intro">
                    NorthShield emploie plus de 2,500 professionnels — ingénierie aérospatiale,
                    cybersécurité, exploitation segment sol et maintien en conditions opérationnelles.
                    Une partie de notre socle logiciel historique est maintenue en Ada pour des raisons
                    de stabilité et de certification.
                </p>
                <div class="team-stats">
                    <div class="team-stat">
                        <div class="stat-number">2,500+</div>
                        <div class="stat-label">Employés</div>
                    </div>
                    <div class="team-stat">
                        <div class="stat-number">75%</div>
                        <div class="stat-label">Ingénieurs & Scientifiques</div>
                    </div>
                    <div class="team-stat">
                        <div class="stat-number">40+</div>
                        <div class="stat-label">Nationalités</div>
                    </div>
                </div>
            </div>

            <div class="cta-section">
                <h2>Découvrir ARGOS‑7 et le segment sol</h2>
                <p>Accédez à la documentation d’intégration et aux services GS‑OPS via le portail client.</p>
                <a href="services.php" class="btn btn-primary">Nos Services</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>NorthShield Defense</h4>
                    <p>Solutions d’observation, de communications et de segment sol depuis 1999.</p>
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
