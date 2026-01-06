<?php
// Connexion à la base de données
$db_host = getenv('DB_HOST') ?: 'db-server';
$db_user = getenv('DB_USER') ?: 'webuser';
$db_pass = getenv('DB_PASS') ?: 'WebP@ss2024!';
$db_name = getenv('DB_NAME') ?: 'northshield_clients';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

// Récupération des données POST - VULNERABLE À SQL INJECTION
$username = $_POST['username'];
$password = $_POST['password'];

// Requête vulnérable (pas de préparation, concaténation directe)
$query = "SELECT * FROM clients WHERE username='$username' AND password='$password'";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NorthShield - Authentification</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            width: 90%;
        }
        .success {
            background: #51cf66;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            background: #ff6b6b;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .info {
            background: #f1f3f5;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #2a5298;
        }
        h1 { color: #1a1a2e; margin-bottom: 20px; }
        h2 { color: #2a5298; margin: 20px 0 10px; }
        p { line-height: 1.6; color: #333; }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #2a5298;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover { background: #1e3c72; }
        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "<div class='success'>";
            echo "<h1>✓ Authentification réussie!</h1>";
            echo "<p>Bienvenue, " . htmlspecialchars($user['username']) . "</p>";
            echo "</div>";
            
            echo "<h2>Informations du compte</h2>";
            echo "<div class='info'>";
            echo "<p><strong>Nom:</strong> " . htmlspecialchars($user['full_name']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
            echo "<p><strong>Niveau d'accès:</strong> " . htmlspecialchars($user['access_level']) . "</p>";
            echo "</div>";
            
            echo "<h2>🔍 Indice pour la suite</h2>";
            echo "<div class='info'>";
            echo "<p>Vous avez réussi à vous authentifier. L'infrastructure NorthShield utilise plusieurs systèmes interconnectés.</p>";
            echo "<p><strong>Indices:</strong></p>";
            echo "<ul>";
            echo "<li>Le serveur de base de données (db-server) a accès au réseau interne via SSH</li>";
            echo "<li>Cherchez des credentials SSH dans les tables de la base de données</li>";
            echo "<li>IP du file-server interne: <code>172.22.0.10</code></li>";
            echo "</ul>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<h1>✗ Échec de l'authentification</h1>";
            echo "<p>Nom d'utilisateur ou mot de passe incorrect.</p>";
            echo "</div>";
            
            echo "<div class='info'>";
            echo "<p><strong>💡 Astuce:</strong> Ce formulaire pourrait être vulnérable à l'injection SQL...</p>";
            echo "<p>Essayez des techniques classiques d'injection SQL pour contourner l'authentification.</p>";
            echo "</div>";
        }
        ?>
        <a href="index.html" class="back-link">← Retour</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
