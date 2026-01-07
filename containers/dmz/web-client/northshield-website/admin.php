<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'] ?? 'Administrateur';
$login_time = $_SESSION['login_time'] ?? date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau d'Administration - NorthShield Defense Systems</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <div class="logo">
                <h1>🛡️ NorthShield</h1>
                <p class="tagline">Administration System</p>
            </div>
            <div class="admin-info">
                <span class="admin-user">👤 <?php echo htmlspecialchars($username); ?></span>
                <a href="?logout" class="btn btn-small btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <!-- Admin Dashboard -->
    <section class="admin-dashboard">
        <div class="container">
            <!-- Success Message -->
            <div class="alert alert-success admin-welcome">
                <h2>✅ Connexion Réussie !</h2>
                <p>Bienvenue dans le panneau d'administration NorthShield Defense Systems</p>
                <p><small>Connecté depuis: <?php echo htmlspecialchars($login_time); ?></small></p>
            </div>

            <!-- FLAG 1 - Prominent Display -->
            <div class="flag-container">
                <div class="flag-header">
                    <h2>🚩 MISSION ACCOMPLIE - FLAG 1</h2>
                </div>
                <div class="flag-content">
                    <div class="flag-banner">
                        <pre class="flag-ascii">
╔══════════════════════════════════════════════════════════════╗
║                                                              ║
║     ███████╗██╗      █████╗  ██████╗      ██╗               ║
║     ██╔════╝██║     ██╔══██╗██╔════╝     ███║               ║
║     █████╗  ██║     ███████║██║  ███╗    ╚██║               ║
║     ██╔══╝  ██║     ██╔══██║██║   ██║     ██║               ║
║     ██║     ███████╗██║  ██║╚██████╔╝     ██║               ║
║     ╚═╝     ╚══════╝╚═╝  ╚═╝ ╚═════╝      ╚═╝               ║
║                                                              ║
╚══════════════════════════════════════════════════════════════╝
                        </pre>
                    </div>
                    
                    <div class="flag-box">
                        <h3>🎯 Félicitations !</h3>
                        <p>Vous avez réussi à exploiter la vulnérabilité SQL Injection et à accéder au panneau d'administration.</p>
                        
                        <div class="flag-value">
                            <label>FLAG:</label>
                            <code class="flag-code">NIGHTFIRE{sql_inject10n_master}</code>
                        </div>

                        <div class="flag-details">
                            <h4>📋 Détails de l'Exploit</h4>
                            <ul>
                                <li><strong>Type de vulnérabilité:</strong> SQL Injection</li>
                                <li><strong>Vecteur d'attaque:</strong> Formulaire de login</li>
                                <li><strong>Payload utilisé:</strong> <code>' OR '1'='1' --</code> (ou similaire)</li>
                                <li><strong>Impact:</strong> Bypass d'authentification</li>
                                <li><strong>Points:</strong> 10</li>
                            </ul>
                        </div>

                        <div class="flag-next-steps">
                            <h4>🔜 Prochaines Étapes</h4>
                            <p>
                                Maintenant que vous avez accès au système, explorez les ressources disponibles 
                                ci-dessous pour progresser dans la chaîne d'attaque.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Menu -->
            <div class="admin-grid">
                <div class="admin-card">
                    <div class="card-icon">📊</div>
                    <h3>Tableau de Bord</h3>
                    <p>Vue d'ensemble des systèmes actifs</p>
                    <div class="card-stats">
                        <div class="stat">
                            <span class="stat-value">7</span>
                            <span class="stat-label">Satellites actifs</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">99.9%</span>
                            <span class="stat-label">Uptime</span>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🗄️</div>
                    <h3>Base de Données</h3>
                    <p>Gestion des données système</p>
                    <div class="card-info">
                        <p>💡 <strong>Astuce:</strong> La base de données contient des informations sur les systèmes internes.</p>
                        <p>🔍 Table intéressante: <code>internal_systems</code></p>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🛰️</div>
                    <h3>Contrôle Satellite</h3>
                    <p>Accès aux systèmes orbitaux</p>
                    <div class="satellite-list">
                        <div class="satellite-item">
                            <span class="sat-name">ARGOS-1</span>
                            <span class="sat-status status-ok">🟢 Opérationnel</span>
                        </div>
                        <div class="satellite-item">
                            <span class="sat-name">ARGOS-3</span>
                            <span class="sat-status status-ok">🟢 Opérationnel</span>
                        </div>
                        <div class="satellite-item">
                            <span class="sat-name">ARGOS-7B</span>
                            <span class="sat-status status-ok">🟢 Opérationnel</span>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🔐</div>
                    <h3>Sécurité</h3>
                    <p>Logs et alertes de sécurité</p>
                    <div class="security-alerts">
                        <div class="alert-item alert-warning">
                            <span>⚠️</span>
                            <span>Tentative de connexion non autorisée détectée</span>
                        </div>
                        <div class="alert-item alert-info">
                            <span>ℹ️</span>
                            <span>Nouvelle session admin créée</span>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">👥</div>
                    <h3>Utilisateurs</h3>
                    <p>Gestion des accès</p>
                    <div class="user-count">
                        <span class="count-number">42</span>
                        <span class="count-label">utilisateurs actifs</span>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">📡</div>
                    <h3>Réseaux Internes</h3>
                    <p>Infrastructure et connexions</p>
                    <div class="network-info">
                        <p>💡 Les systèmes internes sont accessibles via SSH</p>
                        <p>🔑 Les credentials sont dans la base de données</p>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="system-info">
                <h2>ℹ️ Informations Système</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Serveur:</span>
                        <span class="info-value">web-client.northshield.local</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Base de données:</span>
                        <span class="info-value">db-server.northshield.local:3306</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Niveau de sécurité:</span>
                        <span class="info-value">SECRET // NOFORN</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Session:</span>
                        <span class="info-value"><?php echo session_id(); ?></span>
                    </div>
                </div>
            </div>

            <!-- Hints for Next Steps -->
            <div class="hints-box">
                <h2>💡 Indices pour la Suite</h2>
                <div class="hint-list">
                    <div class="hint-item">
                        <span class="hint-number">1</span>
                        <div class="hint-content">
                            <h4>Explorez la base de données</h4>
                            <p>
                                Utilisez un outil comme <code>sqlmap</code> pour extraire les données de la base. 
                                La table <code>internal_systems</code> contient des informations précieuses.
                            </p>
                        </div>
                    </div>
                    <div class="hint-item">
                        <span class="hint-number">2</span>
                        <div class="hint-content">
                            <h4>Trouvez les credentials SSH</h4>
                            <p>
                                Les identifiants pour accéder aux systèmes internes sont stockés dans la base. 
                                Cherchez des usernames et passwords pour le db-server.
                            </p>
                        </div>
                    </div>
                    <div class="hint-item">
                        <span class="hint-number">3</span>
                        <div class="hint-content">
                            <h4>Pivotez vers les systèmes internes</h4>
                            <p>
                                Une fois les credentials obtenus, utilisez SSH pour vous connecter au 
                                db-server et progresser dans le réseau.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <p>&copy; 2026 NorthShield Defense Systems - Administration Panel</p>
            <p>
                <a href="?logout">Déconnexion</a> | 
                <a href="index.php">Retour au site</a>
            </p>
        </div>
    </footer>
</body>
</html>
