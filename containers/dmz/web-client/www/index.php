<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NorthShield Defense Systems - Accueil</title>
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
                <div class="hero-badge">
                    <span class="badge-dot"></span>
                    <span>Système ARGOS‑7 opérationnel</span>
                </div>
                <h2>Surveillance orbitale de nouvelle génération</h2>
                <p>
                    De l'acquisition multispectrale à la distribution sécurisée des données —
                    NorthShield déploie des infrastructures critiques pour la surveillance environnementale
                    et les missions institutionnelles à haute valeur ajoutée.
                </p>
                <div class="hero-buttons">
                    <a href="services.php" class="btn btn-primary">
                        <span>Explorer nos capacités</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l7-7M5 5h7v7"/></svg>
                    </a>
                    <a href="about.php" class="btn btn-secondary">À propos du programme</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <div class="stat-value">7</div>
                        <div class="stat-text">Satellites actifs</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="stat-value">24/7</div>
                        <div class="stat-text">Couverture continue</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="stat-value">&lt;1m</div>
                        <div class="stat-text">Précision géoloc.</div>
                    </div>
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
                    <h3>Observation orbitale</h3>
                    <p>Plateformes d’acquisition multispectrale et télémesure pour le programme ARGOS‑7.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📡</div>
                    <h3>Segment sol (GS‑OPS)</h3>
                    <p>Stations de contrôle, planification des passes, ingestion et distribution des données.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🔐</div>
                    <h3>Cybersécurité</h3>
                    <p>Durcissement des passerelles sol‑orbite, contrôle d’accès et journalisation.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🧩</div>
                    <h3>Interopérabilité</h3>
                    <p>Intégration de systèmes legacy et protocoles propriétaires dans des environnements modernes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-header">
                <h2>Performance et fiabilité au rendez-vous</h2>
                <p>Des indicateurs qui témoignent de notre expertise opérationnelle</p>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">📅</div>
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Années d'expérience spatiale</div>
                    <div class="stat-trend">Depuis 1999</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">🛰️</div>
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Charges utiles en orbite</div>
                    <div class="stat-trend">LEO, MEO, GEO</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">🤝</div>
                    <div class="stat-number">15</div>
                    <div class="stat-label">Partenaires institutionnels</div>
                    <div class="stat-trend">Gouvernements & agences</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">✨</div>
                    <div class="stat-number">99.95%</div>
                    <div class="stat-label">Disponibilité opérationnelle</div>
                    <div class="stat-trend">SLA garanti</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-number">&lt;3min</div>
                    <div class="stat-label">Latence image→diffusion</div>
                    <div class="stat-trend">Pipeline optimisé</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">🔒</div>
                    <div class="stat-number">0</div>
                    <div class="stat-label">Incidents de sécurité</div>
                    <div class="stat-trend positive">2024-2025</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Modern -->
    <section class="tech-modern">
        <div class="container">
            <div class="section-header-modern" data-aos="fade-up">
                <span class="section-label">Stack technique</span>
                <h2 class="section-title">
                    Architecture <span class="gradient-text">éprouvée & évolutive</span>
                </h2>
            </div>
            <div class="tech-grid-modern">
                <div class="tech-card-modern" data-aos="fade-right" data-aos-delay="100">
                    <div class="tech-icon-modern">🛰️</div>
                    <h3>Spatial</h3>
                    <div class="tech-stack">
                        <span class="tech-pill">Capteurs multispectraux</span>
                        <span class="tech-pill">SAR</span>
                        <span class="tech-pill">Bus satellite</span>
                        <span class="tech-pill">Propulsion électrique</span>
                    </div>
                </div>
                <div class="tech-card-modern" data-aos="fade-right" data-aos-delay="200">
                    <div class="tech-icon-modern">📡</div>
                    <h3>Télécommunications</h3>
                    <div class="tech-stack">
                        <span class="tech-pill">A7-TLM</span>
                        <span class="tech-pill">X-Band / Ka-Band</span>
                        <span class="tech-pill">CCSDS</span>
                        <span class="tech-pill">Multiplexage</span>
                    </div>
                </div>
                <div class="tech-card-modern" data-aos="fade-left" data-aos-delay="300">
                    <div class="tech-icon-modern">💾</div>
                    <h3>Traitement données</h3>
                    <div class="tech-stack">
                        <span class="tech-pill">Pipeline temps réel</span>
                        <span class="tech-pill">Géoréférencement</span>
                        <span class="tech-pill">Correction atm.</span>
                        <span class="tech-pill">Catalogage auto.</span>
                    </div>
                </div>
                <div class="tech-card-modern" data-aos="fade-left" data-aos-delay="400">
                    <div class="tech-icon-modern">🔐</div>
                    <h3>Sécurité</h3>
                    <div class="tech-stack">
                        <span class="tech-pill">AES-256</span>
                        <span class="tech-pill">PKI / HSM</span>
                        <span class="tech-pill">Zero-Trust</span>
                        <span class="tech-pill">SIEM</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Modern -->
    <section class="cta-modern">
        <div class="cta-glow"></div>
        <div class="container">
            <div class="cta-card-modern" data-aos="zoom-in">
                <div class="cta-content-modern">
                    <div class="cta-icon-modern">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                            <circle cx="32" cy="32" r="28" stroke="url(#ctaGrad)" stroke-width="2" opacity="0.3"/>
                            <circle cx="32" cy="32" r="20" stroke="url(#ctaGrad)" stroke-width="2"/>
                            <path d="M32 20v24M20 32h24" stroke="url(#ctaGrad)" stroke-width="3" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="ctaGrad">
                                    <stop stop-color="#4ea8ff"/>
                                    <stop offset="1" stop-color="#7c5cff"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <h2>Accédez au portail <span class="gradient-text">GS‑OPS</span></h2>
                    <p>Pilotage des opérations segment sol, support MCO et documentation technique</p>
                    <ul class="cta-features-modern">
                        <li>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5 10l3 3 7-7" stroke="#34d399" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>Planification sessions satellite</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5 10l3 3 7-7" stroke="#34d399" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>Téléchargement sécurisé</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5 10l3 3 7-7" stroke="#34d399" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>Support 24/7/365</span>
                        </li>
                    </ul>
                    <div class="cta-actions-modern">
                        <a href="login.php" class="btn-modern btn-primary large">
                            <span>Ouvrir une session</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0l-4-4m4 4l-4 4" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </a>
                        <p class="cta-note-modern">🔒 Accès sécurisé · Réservé aux clients autorisés</p>
                    </div>
                </div>
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
