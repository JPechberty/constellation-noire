<?php
session_start();

// Configuration de la base de données
$host = 'localhost';
$dbname = 'northshield_db';
$username = 'root';
$password = '';

// Message d'erreur
$error = '';
$success = '';

// Si l'utilisateur est déjà connecté, rediriger vers admin
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    try {
        // Connexion à la base de données
        $conn = new mysqli($host, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            $error = "Erreur de connexion à la base de données.";
        } else {
            // VULNÉRABILITÉ: SQL Injection ici (pas de préparation de requête)
            $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
            $result = $conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                // Login réussi
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user;
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                
                header('Location: admin.php');
                exit();
            } else {
                $error = "Identifiants incorrects. Veuillez réessayer.";
            }
            
            $conn->close();
        }
    } catch (Exception $e) {
        $error = "Erreur système: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - NorthShield Defense Systems</title>
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
                    <li><a href="services.php">Services</a></li>
                    <li><a href="login.php" class="active">Espace Client</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="login-container">
                <div class="login-header">
                    <h1>🔐 Espace Client Sécurisé</h1>
                    <p>Accédez à votre portail de gestion de systèmes</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <strong>⚠️ Erreur:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <strong>✓ Succès:</strong> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php" class="login-form">
                    <div class="form-group">
                        <label for="username">
                            <span class="label-icon">👤</span>
                            Nom d'utilisateur
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Entrez votre nom d'utilisateur"
                            required
                            autocomplete="username"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <span class="label-icon">🔑</span>
                            Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Entrez votre mot de passe"
                            required
                            autocomplete="current-password"
                        >
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Se souvenir de moi</span>
                        </label>
                        <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Se connecter
                    </button>
                </form>

                <div class="login-info">
                    <div class="info-box">
                        <h3>🔒 Accès Sécurisé</h3>
                        <p>
                            Cette zone est réservée aux clients autorisés de NorthShield Defense Systems. 
                            Toutes les connexions sont enregistrées et surveillées.
                        </p>
                    </div>

                    <div class="info-box">
                        <h3>📋 Niveau de Classification</h3>
                        <p>
                            <strong>SECRET // NOFORN</strong><br>
                            Accès restreint aux personnels habilités uniquement.
                        </p>
                    </div>

                    <div class="info-box warning">
                        <h3>⚠️ Avertissement de Sécurité</h3>
                        <p>
                            L'accès non autorisé à ce système est strictement interdit et constitue 
                            une violation de la loi. Toute tentative d'intrusion sera détectée, 
                            enregistrée et poursuivie.
                        </p>
                    </div>
                </div>

                <div class="login-help">
                    <h3>Besoin d'assistance ?</h3>
                    <p>
                        Pour toute demande de support technique ou problème d'accès, 
                        contactez notre équipe support :
                    </p>
                    <p>
                        📧 <a href="mailto:support@northshield.mil">support@northshield.mil</a><br>
                        📞 +1 (555) 123-4567 (Ligne sécurisée 24/7)
                    </p>
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

    <script>
        // Simple script pour montrer/cacher le mot de passe
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter un petit easter egg pour les étudiants
            console.log('%c⚠️ NORTHSHIELD SECURITY SYSTEM', 'color: red; font-size: 20px; font-weight: bold;');
            console.log('%cUnauthorized access is prohibited!', 'color: orange; font-size: 14px;');
            console.log('%c... but for educational purposes, you might want to check the form 😉', 'color: green; font-size: 12px;');
        });
    </script>
</body>
</html>
