# SCHÉMA DE BASE DE DONNÉES - App de suivi des FLAGS

## 📊 Diagramme relationnel

```
┌─────────────────┐       ┌──────────────────┐       ┌─────────────────┐
│     TEAMS       │       │   SUBMISSIONS    │       │     FLAGS       │
├─────────────────┤       ├──────────────────┤       ├─────────────────┤
│ id (PK)         │◄──┐   │ id (PK)          │   ┌──►│ id (PK)         │
│ name            │   │   │ team_id (FK)     │   │   │ name            │
│ password_hash   │   └───┤ flag_id (FK)     ├───┘   │ value           │
│ created_at      │       │ submitted_at     │       │ points          │
│ is_admin        │       │ is_correct       │       │ category        │
└─────────────────┘       │ ip_address       │       │ description     │
                          └──────────────────┘       │ order_required  │
                                                     │ is_bonus        │
┌─────────────────┐                                 │ is_active       │
│    HINTS        │                                 └─────────────────┘
├─────────────────┤
│ id (PK)         │       ┌──────────────────┐
│ flag_id (FK)    ├──────►│  HINTS_USED      │
│ content         │       ├──────────────────┤
│ penalty_points  │       │ id (PK)          │
│ order           │   ┌───┤ team_id (FK)     │
└─────────────────┘   │   │ hint_id (FK)     │
                      │   │ used_at          │
┌─────────────────┐   │   └──────────────────┘
│     TEAMS       │◄──┘
└─────────────────┘

┌─────────────────┐
│   SETTINGS      │
├─────────────────┤
│ id (PK)         │
│ key             │
│ value           │
│ updated_at      │
└─────────────────┘
```

---

## 📋 Tables détaillées

### 1. TEAMS (Équipes)

Stocke les informations des équipes participantes.

```sql
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    total_points INT DEFAULT 0,
    INDEX idx_name (name),
    INDEX idx_points (total_points DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Champs:**
- `id` - Identifiant unique
- `name` - Nom de l'équipe (unique)
- `password_hash` - Mot de passe hashé (bcrypt)
- `email` - Email de contact
- `created_at` - Date de création
- `last_login` - Dernière connexion
- `is_admin` - Flag administrateur
- `is_active` - Compte actif/désactivé
- `total_points` - Score total (calculé)

---

### 2. FLAGS (Drapeaux)

Contient tous les flags du challenge.

```sql
CREATE TABLE flags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    value VARCHAR(255) NOT NULL UNIQUE,
    points INT NOT NULL DEFAULT 10,
    category VARCHAR(50) NOT NULL,
    description TEXT,
    hint TEXT,
    order_required INT DEFAULT 0,
    is_bonus BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_order (order_required)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Champs:**
- `id` - Identifiant unique
- `name` - Nom du flag (ex: "FLAG 1: SQL Injection")
- `value` - Valeur du flag (ex: "NIGHTFIRE{sql_inject10n_master}")
- `points` - Points accordés
- `category` - Catégorie (DMZ, Internal, Control, Satellite, Bonus)
- `description` - Description détaillée
- `hint` - Indice optionnel
- `order_required` - Ordre requis (0 = aucun ordre)
- `is_bonus` - Flag bonus ou standard
- `is_active` - Flag actif/désactivé

---

### 3. SUBMISSIONS (Soumissions)

Enregistre toutes les tentatives de soumission.

```sql
CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    flag_id INT,
    submitted_value VARCHAR(255) NOT NULL,
    is_correct BOOLEAN NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (flag_id) REFERENCES flags(id) ON DELETE SET NULL,
    INDEX idx_team (team_id),
    INDEX idx_flag (flag_id),
    INDEX idx_time (submitted_at DESC),
    INDEX idx_correct (is_correct)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Champs:**
- `id` - Identifiant unique
- `team_id` - Équipe qui soumet
- `flag_id` - Flag correspondant (NULL si incorrect)
- `submitted_value` - Valeur soumise
- `is_correct` - Soumission correcte ou non
- `submitted_at` - Date/heure de soumission
- `ip_address` - Adresse IP
- `user_agent` - User agent du navigateur

---

### 4. HINTS (Indices)

Stocke les indices disponibles pour chaque flag.

```sql
CREATE TABLE hints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag_id INT NOT NULL,
    content TEXT NOT NULL,
    penalty_points INT DEFAULT 5,
    order_num INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (flag_id) REFERENCES flags(id) ON DELETE CASCADE,
    INDEX idx_flag (flag_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Champs:**
- `id` - Identifiant unique
- `flag_id` - Flag concerné
- `content` - Contenu de l'indice
- `penalty_points` - Pénalité en points
- `order_num` - Ordre d'affichage (1, 2, 3...)
- `created_at` - Date de création

---

### 5. HINTS_USED (Indices utilisés)

Trace les indices demandés par chaque équipe.

```sql
CREATE TABLE hints_used (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    hint_id INT NOT NULL,
    used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (hint_id) REFERENCES hints(id) ON DELETE CASCADE,
    UNIQUE KEY unique_team_hint (team_id, hint_id),
    INDEX idx_team (team_id),
    INDEX idx_hint (hint_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Champs:**
- `id` - Identifiant unique
- `team_id` - Équipe ayant demandé l'indice
- `hint_id` - Indice utilisé
- `used_at` - Date/heure d'utilisation

---

### 6. SETTINGS (Paramètres)

Configuration globale de l'application.

```sql
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Champs:**
- `id` - Identifiant unique
- `setting_key` - Clé du paramètre
- `setting_value` - Valeur du paramètre
- `description` - Description
- `updated_at` - Dernière modification

**Paramètres types:**
```sql
INSERT INTO settings (setting_key, setting_value, description) VALUES
('competition_name', 'Operation Nightfire', 'Nom du CTF'),
('competition_start', '2026-01-15 09:00:00', 'Début de la compétition'),
('competition_end', '2026-01-15 18:00:00', 'Fin de la compétition'),
('allow_registration', 'true', 'Autoriser nouvelles inscriptions'),
('require_order', 'false', 'Forcer l''ordre des flags'),
('max_attempts_per_flag', '5', 'Tentatives max par flag'),
('rate_limit_seconds', '10', 'Délai entre soumissions');
```

---

## 🔍 Vues utiles

### Vue: Scoreboard (Classement)

```sql
CREATE OR REPLACE VIEW scoreboard AS
SELECT 
    t.id,
    t.name AS team_name,
    t.total_points,
    COUNT(DISTINCT s.flag_id) AS flags_found,
    COALESCE(SUM(h.penalty_points), 0) AS hints_penalty,
    (t.total_points - COALESCE(SUM(h.penalty_points), 0)) AS final_score,
    MAX(s.submitted_at) AS last_submission,
    TIMESTAMPDIFF(SECOND, t.created_at, MAX(s.submitted_at)) AS completion_time
FROM teams t
LEFT JOIN submissions s ON t.id = s.team_id AND s.is_correct = TRUE
LEFT JOIN hints_used hu ON t.id = hu.team_id
LEFT JOIN hints h ON hu.hint_id = h.id
WHERE t.is_admin = FALSE AND t.is_active = TRUE
GROUP BY t.id, t.name, t.total_points
ORDER BY final_score DESC, completion_time ASC;
```

### Vue: Progression par équipe

```sql
CREATE OR REPLACE VIEW team_progress AS
SELECT 
    t.id AS team_id,
    t.name AS team_name,
    f.id AS flag_id,
    f.name AS flag_name,
    f.category,
    f.points,
    CASE 
        WHEN s.id IS NOT NULL THEN 'Trouvé'
        ELSE 'Non trouvé'
    END AS status,
    s.submitted_at AS found_at
FROM teams t
CROSS JOIN flags f
LEFT JOIN submissions s ON t.id = s.team_id 
    AND f.id = s.flag_id 
    AND s.is_correct = TRUE
WHERE t.is_admin = FALSE AND t.is_active = TRUE AND f.is_active = TRUE
ORDER BY t.name, f.order_required, f.id;
```

### Vue: First Blood (Premiers à trouver)

```sql
CREATE OR REPLACE VIEW first_blood AS
SELECT 
    f.id AS flag_id,
    f.name AS flag_name,
    t.name AS team_name,
    MIN(s.submitted_at) AS found_at
FROM flags f
JOIN submissions s ON f.id = s.flag_id AND s.is_correct = TRUE
JOIN teams t ON s.team_id = t.id
WHERE t.is_admin = FALSE AND t.is_active = TRUE
GROUP BY f.id, f.name, t.name
ORDER BY found_at ASC;
```

---

## 📊 Requêtes utiles

### Calculer le score d'une équipe

```sql
SELECT 
    SUM(f.points) - COALESCE(
        (SELECT SUM(h.penalty_points) 
         FROM hints_used hu
         JOIN hints h ON hu.hint_id = h.id
         WHERE hu.team_id = ?), 0
    ) AS total_score
FROM submissions s
JOIN flags f ON s.flag_id = f.id
WHERE s.team_id = ? AND s.is_correct = TRUE;
```

### Statistiques globales

```sql
SELECT 
    COUNT(DISTINCT t.id) AS total_teams,
    COUNT(DISTINCT f.id) AS total_flags,
    COUNT(DISTINCT CASE WHEN s.is_correct THEN s.id END) AS correct_submissions,
    COUNT(DISTINCT CASE WHEN NOT s.is_correct THEN s.id END) AS incorrect_submissions,
    AVG(CASE WHEN s.is_correct THEN f.points END) AS avg_points_per_flag
FROM teams t
CROSS JOIN flags f
LEFT JOIN submissions s ON s.team_id = t.id AND s.flag_id = f.id
WHERE t.is_admin = FALSE AND t.is_active = TRUE;
```

### Top 10 des équipes

```sql
SELECT * FROM scoreboard LIMIT 10;
```

### Flags les plus difficiles (moins trouvés)

```sql
SELECT 
    f.name,
    f.points,
    COUNT(DISTINCT s.team_id) AS teams_found,
    (SELECT COUNT(*) FROM teams WHERE is_admin = FALSE) AS total_teams,
    ROUND(COUNT(DISTINCT s.team_id) * 100.0 / 
          (SELECT COUNT(*) FROM teams WHERE is_admin = FALSE), 2) AS success_rate
FROM flags f
LEFT JOIN submissions s ON f.id = s.flag_id AND s.is_correct = TRUE
WHERE f.is_active = TRUE
GROUP BY f.id, f.name, f.points
ORDER BY teams_found ASC, f.points DESC;
```

---

## 🔐 Données initiales

### Flags de Operation Nightfire

```sql
INSERT INTO flags (name, value, points, category, description, order_required, is_bonus) VALUES
('FLAG 1: SQL Injection', 'NIGHTFIRE{sql_inject10n_master}', 10, 'DMZ', 'Exploiter la SQL injection sur le site web', 1, FALSE),
('FLAG 2: Accès DB-Server', 'NIGHTFIRE{pivot_point_established}', 15, 'DMZ', 'Accéder au serveur de base de données via SSH', 2, FALSE),
('FLAG 3: Documentation Satellite', 'NIGHTFIRE{technical_docs_acquired}', 10, 'Internal', 'Lire la documentation technique du satellite', 3, FALSE),
('FLAG 4: Workstation1', 'NIGHTFIRE{developer_workspace_breached}', 10, 'Internal', 'Accéder à la workstation de développement', 4, FALSE),
('FLAG 5: Control Station', 'NIGHTFIRE{mission_control_compromised}', 15, 'Control', 'Accéder à la station de contrôle', 5, FALSE),
('FLAG 6: Exfiltration GPS', 'NIGHTFIRE{coordinates_exfiltrated_a7b9c2d4}', 15, 'Control', 'Exfiltrer les coordonnées GPS des cibles', 6, FALSE),
('FLAG 7: Accès Satellite', 'NIGHTFIRE{satellite_access_granted}', 15, 'Satellite', 'Accéder au satellite ARGOS-7B', 7, FALSE),
('FLAG 8: Exploitation Ada', 'NIGHTFIRE{ada_vulnerability_exploited}', 20, 'Satellite', 'Exploiter une vulnérabilité dans le code Ada', 8, FALSE),
('FLAG 9: Sabotage', 'NIGHTFIRE{satellite_destroyed_mission_complete}', 20, 'Satellite', 'Saboter le satellite avec succès', 9, FALSE),
('FLAG 10: Nettoyage', 'NIGHTFIRE{ghost_in_the_machine}', 10, 'Cleanup', 'Effacer vos traces dans les logs', 10, FALSE),
('BONUS: Speed Demon', 'NIGHTFIRE{speed_demon_achieved}', 50, 'Bonus', 'Terminer en moins de 4 heures', 0, TRUE),
('BONUS: Autonomous', 'NIGHTFIRE{autonomous_hacker}', 25, 'Bonus', 'Terminer sans utiliser d''indices', 0, TRUE),
('BONUS: Perfectionist', 'NIGHTFIRE{perfectionist_unlocked}', 25, 'Bonus', 'Trouver tous les flags', 0, TRUE);
```

### Indices

```sql
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
-- FLAG 1
(1, 'Le formulaire de login n''utilise pas de requêtes préparées. Essayez d''injecter du SQL dans le champ username.', 5, 1),
(1, 'Utilisez la technique classique: admin'' OR ''1''=''1'' --', 3, 2),

-- FLAG 2
(2, 'La table internal_systems contient des credentials SSH. Exploitez SQLMap pour l''extraire.', 5, 1),
(2, 'ssh dbadmin@localhost -p 2222 avec le mot de passe trouvé dans la base', 3, 2),

-- FLAG 3
(3, 'Le file-server contient un dossier /share/satellite_docs/', 5, 1),
(3, 'Cherchez un fichier .md dans ce dossier', 3, 2);

-- Etc...
```

### Paramètres

```sql
INSERT INTO settings (setting_key, setting_value, description) VALUES
('competition_name', 'Operation Nightfire', 'Nom du hackathon'),
('competition_start', '2026-01-15 09:00:00', 'Début du CTF'),
('competition_end', '2026-01-15 18:00:00', 'Fin du CTF'),
('allow_registration', 'true', 'Autoriser les inscriptions'),
('require_order', 'false', 'Forcer l''ordre des flags'),
('max_attempts_per_flag', '5', 'Tentatives max par flag'),
('rate_limit_seconds', '10', 'Délai entre soumissions (secondes)'),
('show_scoreboard', 'true', 'Afficher le scoreboard en temps réel'),
('hints_enabled', 'true', 'Activer le système d''indices');
```

---

## 📈 Indexes de performance

```sql
-- Index pour les requêtes fréquentes
CREATE INDEX idx_submissions_team_flag ON submissions(team_id, flag_id, is_correct);
CREATE INDEX idx_submissions_correct_time ON submissions(is_correct, submitted_at DESC);
CREATE INDEX idx_teams_active_points ON teams(is_active, total_points DESC);
CREATE INDEX idx_flags_active_order ON flags(is_active, order_required);
```

---

## 🔒 Contraintes de sécurité

### Trigger: Mettre à jour le score total

```sql
DELIMITER //
CREATE TRIGGER update_team_score_after_submission
AFTER INSERT ON submissions
FOR EACH ROW
BEGIN
    IF NEW.is_correct = TRUE THEN
        UPDATE teams 
        SET total_points = (
            SELECT COALESCE(SUM(f.points), 0)
            FROM submissions s
            JOIN flags f ON s.flag_id = f.id
            WHERE s.team_id = NEW.team_id AND s.is_correct = TRUE
        )
        WHERE id = NEW.team_id;
    END IF;
END//
DELIMITER ;
```

### Trigger: Empêcher double soumission

```sql
DELIMITER //
CREATE TRIGGER prevent_duplicate_flag
BEFORE INSERT ON submissions
FOR EACH ROW
BEGIN
    DECLARE flag_exists INT;
    
    SELECT COUNT(*) INTO flag_exists
    FROM submissions
    WHERE team_id = NEW.team_id 
      AND flag_id = NEW.flag_id 
      AND is_correct = TRUE;
    
    IF flag_exists > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Flag already submitted by this team';
    END IF;
END//
DELIMITER ;
```

---

## 📦 Export complet

Voir fichier `ctf_database.sql` pour le script complet de création.

---

## 🚀 Utilisation

```bash
# Créer la base de données
mysql -u root -p < ctf_database.sql

# Ou avec Docker
docker exec -i ctf-mysql mysql -u root -ppassword < ctf_database.sql
```
