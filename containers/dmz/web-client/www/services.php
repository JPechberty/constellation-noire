<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - NorthShield Defense Systems</title>
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
                    <li><a href="about.php">Qui sommes-nous</a></li>
                    <li><a href="services.php" class="active">Services</a></li>
                    <li><a href="login.php">Espace Client</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Nos Services</h1>
            <p>Chaînes d’observation, segment sol GS‑OPS et cybersécurité pour missions critiques</p>
        </div>
    </section>

    <!-- Services Content -->
    <section class="services-content">
        <div class="container">
            <div class="services-intro">
                <h2>Des solutions complètes, du capteur orbital aux consoles opérateur</h2>
                <p class="lead">
                    NorthShield Defense Systems fournit des systèmes complets d’observation et de transmission,
                    de la conception de plateformes et charges utiles jusqu’au segment sol, à l’exploitation
                    et au maintien en conditions opérationnelles.
                </p>
            </div>

            <!-- Service 1 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🛰️</div>
                    <div>
                        <h2>Observation orbitale & télémesure (ARGOS‑7)</h2>
                        <p class="service-subtitle">Acquisition multispectrale, collecte, horodatage et distribution des données</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Conception et intégration de charges utiles d’observation</li>
                        <li>✓ Chaînes de télémesure et télécommande (TLM/TC)</li>
                        <li>✓ Traitement, indexation et pipeline de diffusion des données</li>
                        <li>✓ Calibration et validation de capteurs</li>
                        <li>✓ Exploitation et support 24/7/365</li>
                        <li>✓ Gouvernance des données (jeux « publics » vs « restreints »)</li>
                    </ul>
                    <div class="service-highlight">
                        <h4>🌟 Programme Phare: ARGOS‑7</h4>
                        <p>
                            ARGOS‑7 combine des capteurs haute résolution, des capacités de suivi et une chaîne
                            de télémesure propriétaire (A7‑TLM) intégrée au segment sol GS‑OPS.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">📡</div>
                    <div>
                        <h2>Stations sol & opérations (GS‑OPS)</h2>
                        <p class="service-subtitle">Planification des passes, consoles opérateur, ingestion et supervision</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Déploiement de stations de contrôle au sol</li>
                        <li>✓ Planification et automatisation des sessions (passes)</li>
                        <li>✓ Consoles opérateur et tableaux de bord supervision</li>
                        <li>✓ Passerelles d’intégration et interconnexions réseau</li>
                        <li>✓ Protocoles de communication satellite propriétaires</li>
                        <li>✓ Journalisation et traçabilité orientées conformité</li>
                    </ul>
                    <div class="service-metrics">
                        <div class="metric">
                            <div class="metric-value">24/7</div>
                            <div class="metric-label">Ops & Astreinte</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value">99.95%</div>
                            <div class="metric-label">SLA segment sol</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value">Multi‑site</div>
                            <div class="metric-label">Déploiement</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🔐</div>
                    <div>
                        <h2>Cybersécurité & protection des infrastructures</h2>
                        <p class="service-subtitle">Sécurisation des environnements critiques et des flux sol‑orbite</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Audit de sécurité et tests d’intrusion</li>
                        <li>✓ Architecture Zero‑Trust et contrôle d’accès (IAM)</li>
                        <li>✓ Durcissement des passerelles et segmentation réseau</li>
                        <li>✓ Supervision SOC (détection et corrélation)</li>
                        <li>✓ Réponse aux incidents et analyse forensique</li>
                        <li>✓ Formation sécurité pour équipes opérateur</li>
                    </ul>
                    <div class="service-highlight warning">
                        <h4>⚠️ Environnements habilités</h4>
                        <p>
                            Nos solutions supportent des exigences élevées de traçabilité, d’audit et de séparation
                            des données, avec un focus sur les flux TLM/TC et le segment sol.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">📶</div>
                    <div>
                        <h2>Communications & transport sécurisé</h2>
                        <p class="service-subtitle">Réseaux robustes pour données, télémesure et supervision</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Conception de réseaux résilients (multi‑liaisons)</li>
                        <li>✓ SATCOM et interconnexions de stations sol</li>
                        <li>✓ chiffrement, authentification et gestion des clés</li>
                        <li>✓ Passerelles de protocole et multiplexage propriétaire</li>
                        <li>✓ Infrastructure d’exploitation et supervision (NOC)</li>
                        <li>✓ Documentation d’intégration et exploitation</li>
                    </ul>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🛠️</div>
                    <div>
                        <h2>Maintenance & support opérationnel</h2>
                        <p class="service-subtitle">Disponibilité maximale sur le long terme</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Maintenance préventive et corrective</li>
                        <li>✓ Support technique 24/7/365</li>
                        <li>✓ Gestion du cycle de vie (obsolescence, correctifs)</li>
                        <li>✓ Modernisation et mise à niveau progressive</li>
                        <li>✓ Maintien d’applications legacy (dont modules Ada)</li>
                        <li>✓ Support des passerelles de protocoles propriétaires</li>
                    </ul>
                    <div class="service-sla">
                        <h4>📋 Garanties SLA</h4>
                        <p>• Temps de réponse: &lt; 15 minutes pour incidents critiques</p>
                        <p>• Disponibilité: 99.95% garantie</p>
                        <p>• Présence sur site: 24-48h partout dans le monde</p>
                    </div>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🎓</div>
                    <div>
                        <h2>Formation & consulting</h2>
                        <p class="service-subtitle">Transfert de compétences et expertise segment sol</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Formation opérateur (consoles GS‑OPS)</li>
                        <li>✓ Programmes de certification exploitation & supervision</li>
                        <li>✓ Consulting intégration (pipelines données et télémesure)</li>
                        <li>✓ Études de faisabilité et analyses techniques</li>
                        <li>✓ Assistance à l’interopérabilité legacy (dont Ada)</li>
                        <li>✓ Workshops protocoles et bonnes pratiques sécurité</li>
                    </ul>
                </div>
            </div>

            <!-- Process Section -->
            <div class="process-section">
                <h2>Notre Processus de Livraison</h2>
                <div class="process-steps">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h3>Analyse des Besoins</h3>
                        <p>Étude des contraintes opérationnelles, conformité et segmentation des données</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h3>Conception</h3>
                        <p>Architecture capteur/segment sol, protocoles et intégrations</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h3>Développement</h3>
                        <p>Implémentation, intégration et packaging déployable</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h3>Tests & Validation</h3>
                        <p>Validation fonctionnelle, performance et sécurité</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">5</div>
                        <h3>Déploiement</h3>
                        <p>Installation multi‑site, formation et mise en service</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">6</div>
                        <h3>Support Continu</h3>
                        <p>MCO, correctifs et support exploitation</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="cta-section">
                <h2>Prêt à discuter de votre projet ?</h2>
                <p>Nos experts sont disponibles pour analyser vos besoins segment sol et intégration ARGOS‑7.</p>
                <a href="login.php" class="btn btn-primary">Accéder à votre portail</a>
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
