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
    <title>Console GS‑OPS - NorthShield Defense Systems</title>
    <link rel="stylesheet" href="style-modern.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <div class="logo">
                <h1>🛡️ NorthShield</h1>
                <p class="tagline">GS‑OPS / Administration</p>
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
                <h2>✅ Session ouverte (GS‑OPS)</h2>
                <p>Bienvenue sur la console d’exploitation du segment sol — programme ARGOS‑7</p>
                <p><small>Connecté depuis: <?php echo htmlspecialchars($login_time); ?></small></p>
            </div>

            <!-- FLAG 1 - Prominent Display -->
            <div class="flag-container">
                <div class="flag-header">
                    <h2>🚩 VALIDATION D’ACCÈS — FLAG 1</h2>
                </div>
                <div class="flag-content">
                    <div class="flag-banner">
                        <pre class="flag-ascii">
╔══════════════════════════════════════════════════════════════════════╗
║                                                                      ║
║     ███████╗██╗      █████╗  ███████╗      ██╗                       ║
║     ██╔════╝██║     ██╔══██╗██╔════╝     ███║                       ║
║     █████╗  ██║     ███████║███████╗    ╚██║                       ║
║     ██╔══╝  ██║     ██╔══██║╚════██║     ██║                       ║
║     ██║     ███████╗██║  ██║███████║     ██║                       ║
║     ╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝     ╚═╝                       ║
║                                                                      ║
╚══════════════════════════════════════════════════════════════════════╝
                        </pre>
                    </div>
                    
                    <div class="flag-box">
                        <h3>🎯 Accès validé</h3>
                        <p>Vous avez contourné le contrôle d’accès du portail et atteint la console GS‑OPS.</p>

                        <div class="flag-value">
                            <label>FLAG:</label>
                            <code class="flag-code">NIGHTFIRE{sql_inject10n_master}</code>
                        </div>

                        <div class="flag-details">
                            <h4>📋 Détails (pédagogie)</h4>
                            <ul>
                                <li><strong>Type de vulnérabilité:</strong> SQL Injection</li>
                                <li><strong>Vecteur:</strong> Formulaire d’authentification</li>
                                <li><strong>Exemple de payload:</strong> <code>' OR '1'='1' --</code> (ou similaire)</li>
                                <li><strong>Impact:</strong> Bypass d’authentification</li>
                                <li><strong>Points:</strong> 10</li>
                            </ul>
                        </div>

                        <div class="flag-next-steps">
                            <h4>🧭 Suite (inventaire & pivot)</h4>
                            <p>
                                Une fois dans la console, l’étape suivante consiste à identifier les actifs internes
                                (stations, serveurs, référentiels) et leurs accès associés.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Menu -->
            <div class="admin-grid">
                <div class="admin-card">
                    <div class="card-icon">📊</div>
                    <h3>Supervision</h3>
                    <p>Vue d'ensemble des systèmes GS‑OPS</p>
                    <div class="card-stats">
                        <div class="stat">
                            <span class="stat-value">7</span>
                            <span class="stat-label">Satellites / charges utiles</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">99.9%</span>
                            <span class="stat-label">Uptime</span>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🗄️</div>
                    <h3>Référentiels</h3>
                    <p>Inventaire et données système</p>
                    <div class="card-info">
                        <p>💡 <strong>Indice:</strong> La base contient un inventaire d’actifs internes.</p>
                        <p>🔎 Table intéressante: <code>internal_systems</code></p>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">📡</div>
                    <h3>Station sol</h3>
                    <p>Accès aux opérations et télémesure</p>
                    <div class="satellite-list">
                        <div class="satellite-item">
                            <span class="sat-name">ARGOS‑1</span>
                            <span class="sat-status status-ok">🟢 Opérationnel</span>
                        </div>
                        <div class="satellite-item">
                            <span class="sat-name">ARGOS‑3</span>
                            <span class="sat-status status-ok">🟢 Opérationnel</span>
                        </div>
                        <div class="satellite-item">
                            <span class="sat-name">ARGOS‑7B</span>
                            <span class="sat-status status-ok">🟢 Opérationnel</span>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🔐</div>
                    <h3>Sécurité</h3>
                    <p>Logs et alertes</p>
                    <div class="security-alerts">
                        <div class="alert-item alert-warning">
                            <span>⚠️</span>
                            <span>Événement d’authentification anormal détecté</span>
                        </div>
                        <div class="alert-item alert-info">
                            <span>ℹ️</span>
                            <span>Nouvelle session console ouverte</span>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🧠</div>
                    <h3>Interop legacy</h3>
                    <p>Compatibilité console & modules historiques</p>
                    <div class="user-count">
                        <span class="count-number">Ada</span>
                        <span class="count-label">socle applicatif</span>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-icon">🧩</div>
                    <h3>Accès internes</h3>
                    <p>Infrastructure et connexions</p>
                    <div class="network-info">
                        <p>💡 Les systèmes internes sont accessibles via SSH</p>
                        <p>🔑 Les accès figurent dans les référentiels (BDD)</p>
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
                            <h4>Explorez l’inventaire</h4>
                            <p>
                                Utilisez un outil comme <code>sqlmap</code> pour extraire les données.
                                La table <code>internal_systems</code> contient des informations précieuses.
                            </p>
                        </div>
                    </div>
                    <div class="hint-item">
                        <span class="hint-number">2</span>
                        <div class="hint-content">
                            <h4>Trouvez les accès SSH</h4>
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
                                Une fois les accès obtenus, utilisez SSH pour vous connecter au db-server
                                et progresser dans le réseau.
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
            <p>&copy; 2026 NorthShield Defense Systems - GS‑OPS Console</p>
            <p>
                <a href="?logout">Déconnexion</a> | 
                <a href="index.php">Retour au site</a>
            </p>
        </div>
    </footer>
</body>
</html>
