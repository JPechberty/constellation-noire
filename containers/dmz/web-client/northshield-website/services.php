<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - NorthShield Defense Systems</title>
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
            <p>Solutions de défense avancées pour missions critiques</p>
        </div>
    </section>

    <!-- Services Content -->
    <section class="services-content">
        <div class="container">
            <div class="services-intro">
                <h2>Des solutions complètes pour vos besoins en défense</h2>
                <p class="lead">
                    NorthShield Defense Systems offre une gamme complète de services et de produits 
                    couvrant tous les aspects des systèmes de défense modernes, de la conception à 
                    l'opération et la maintenance.
                </p>
            </div>

            <!-- Service 1 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🛰️</div>
                    <div>
                        <h2>Systèmes Satellitaires</h2>
                        <p class="service-subtitle">Technologies spatiales de pointe pour surveillance et communication</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Conception et développement de satellites militaires</li>
                        <li>✓ Intégration et tests de systèmes spatiaux</li>
                        <li>✓ Lancement et mise en orbite</li>
                        <li>✓ Opérations et contrôle satellitaire 24/7</li>
                        <li>✓ Maintenance orbitale et extension de durée de vie</li>
                        <li>✓ Traitement et analyse de données satellitaires</li>
                    </ul>
                    <div class="service-highlight">
                        <h4>🌟 Produit Phare: ARGOS-7B</h4>
                        <p>
                            Notre dernière génération de satellite de surveillance offre une résolution 
                            sub-métrique, des capacités de tracking en temps réel, et une autonomie 
                            opérationnelle de 15 ans.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🎯</div>
                    <div>
                        <h2>Systèmes de Guidage de Précision</h2>
                        <p class="service-subtitle">Navigation et guidage pour applications défensives</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Systèmes de navigation inertielle de haute précision</li>
                        <li>✓ Guidage GPS/GNSS multi-constellation</li>
                        <li>✓ Systèmes de guidage terminal</li>
                        <li>✓ Intégration de systèmes de visée avancés</li>
                        <li>✓ Simulateurs et systèmes d'entraînement</li>
                        <li>✓ Support technique et maintenance</li>
                    </ul>
                    <div class="service-metrics">
                        <div class="metric">
                            <div class="metric-value">&lt; 1m</div>
                            <div class="metric-label">Précision CEP</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value">99.99%</div>
                            <div class="metric-label">Fiabilité</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value">24/7</div>
                            <div class="metric-label">Support</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🔒</div>
                    <div>
                        <h2>Cybersécurité & Protection des Infrastructures</h2>
                        <p class="service-subtitle">Sécurisation des systèmes critiques de défense</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Audit de sécurité et tests d'intrusion</li>
                        <li>✓ Architecture de sécurité pour systèmes de commandement</li>
                        <li>✓ Solutions de cryptographie avancée</li>
                        <li>✓ Monitoring et détection d'intrusions (24/7 SOC)</li>
                        <li>✓ Réponse aux incidents et forensique</li>
                        <li>✓ Formation du personnel en cybersécurité</li>
                    </ul>
                    <div class="service-highlight warning">
                        <h4>⚠️ Certification de Sécurité</h4>
                        <p>
                            Tous nos systèmes sont certifiés selon les standards les plus élevés: 
                            CMMC Level 3, ISO 27001, et approuvés pour traitement d'informations 
                            classifiées jusqu'au niveau Top Secret.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">📡</div>
                    <div>
                        <h2>Communications Sécurisées</h2>
                        <p class="service-subtitle">Réseaux de communication militaires robustes</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Conception de réseaux tactiques sécurisés</li>
                        <li>✓ Communication par satellite (SATCOM)</li>
                        <li>✓ Systèmes radio cryptés</li>
                        <li>✓ Réseaux maillés (mesh networks) résilients</li>
                        <li>✓ Infrastructure de commandement et contrôle (C2)</li>
                        <li>✓ Solutions de communications unifiées</li>
                    </ul>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="service-detail">
                <div class="service-detail-header">
                    <div class="service-icon-large">🔧</div>
                    <div>
                        <h2>Maintenance & Support Opérationnel</h2>
                        <p class="service-subtitle">Disponibilité maximale de vos systèmes critiques</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Maintenance préventive et corrective</li>
                        <li>✓ Support technique 24/7/365</li>
                        <li>✓ Gestion du cycle de vie des équipements</li>
                        <li>✓ Modernisation et mise à niveau</li>
                        <li>✓ Pièces de rechange et logistique</li>
                        <li>✓ Formation des opérateurs</li>
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
                        <h2>Formation & Consulting</h2>
                        <p class="service-subtitle">Transfert de compétences et expertise</p>
                    </div>
                </div>
                <div class="service-detail-content">
                    <h3>Services Inclus</h3>
                    <ul class="service-list">
                        <li>✓ Formation technique sur nos systèmes</li>
                        <li>✓ Programmes de certification opérateurs</li>
                        <li>✓ Consulting stratégique en défense</li>
                        <li>✓ Études de faisabilité et analyses techniques</li>
                        <li>✓ Assistance à l'intégration de systèmes</li>
                        <li>✓ Workshops et séminaires spécialisés</li>
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
                        <p>Étude approfondie de vos exigences opérationnelles et contraintes</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h3>Conception</h3>
                        <p>Développement d'une solution sur mesure adaptée à votre mission</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h3>Développement</h3>
                        <p>Fabrication et intégration selon les plus hauts standards de qualité</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h3>Tests & Validation</h3>
                        <p>Vérification exhaustive de toutes les performances et spécifications</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">5</div>
                        <h3>Déploiement</h3>
                        <p>Installation et mise en service avec formation des équipes</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">6</div>
                        <h3>Support Continu</h3>
                        <p>Maintenance et support technique tout au long du cycle de vie</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="cta-section">
                <h2>Prêt à discuter de votre projet ?</h2>
                <p>Nos experts sont disponibles pour analyser vos besoins et vous proposer la solution optimale.</p>
                <a href="login.php" class="btn btn-primary">Accéder à votre espace client</a>
            </div>
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
