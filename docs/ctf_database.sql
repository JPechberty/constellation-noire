-- ================================================================
-- OPERATION NIGHTFIRE - CTF DATABASE
-- Script d'initialisation complète
-- ================================================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS ctf_nightfire CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ctf_nightfire;

-- ================================================================
-- TABLE: TEAMS
-- ================================================================
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
    INDEX idx_points (total_points DESC),
    INDEX idx_active (is_active, total_points DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- TABLE: FLAGS
-- ================================================================
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
    INDEX idx_order (order_required),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- TABLE: SUBMISSIONS
-- ================================================================
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
    INDEX idx_correct (is_correct),
    INDEX idx_team_flag (team_id, flag_id, is_correct)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- TABLE: HINTS
-- ================================================================
CREATE TABLE hints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag_id INT NOT NULL,
    content TEXT NOT NULL,
    penalty_points INT DEFAULT 5,
    order_num INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (flag_id) REFERENCES flags(id) ON DELETE CASCADE,
    INDEX idx_flag (flag_id),
    INDEX idx_order (flag_id, order_num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- TABLE: HINTS_USED
-- ================================================================
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- TABLE: SETTINGS
-- ================================================================
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- VUES
-- ================================================================

-- Vue: Scoreboard
CREATE OR REPLACE VIEW scoreboard AS
SELECT 
    t.id,
    t.name AS team_name,
    t.total_points,
    COUNT(DISTINCT s.flag_id) AS flags_found,
    COALESCE(SUM(h.penalty_points), 0) AS hints_penalty,
    (t.total_points - COALESCE(SUM(h.penalty_points), 0)) AS final_score,
    MAX(s.submitted_at) AS last_submission,
    TIMESTAMPDIFF(SECOND, t.created_at, MAX(s.submitted_at)) AS completion_time_seconds
FROM teams t
LEFT JOIN submissions s ON t.id = s.team_id AND s.is_correct = TRUE
LEFT JOIN hints_used hu ON t.id = hu.team_id
LEFT JOIN hints h ON hu.hint_id = h.id
WHERE t.is_admin = FALSE AND t.is_active = TRUE
GROUP BY t.id, t.name, t.total_points
ORDER BY final_score DESC, completion_time_seconds ASC;

-- Vue: Progression détaillée
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
WHERE t.is_admin = FALSE 
  AND t.is_active = TRUE 
  AND f.is_active = TRUE
ORDER BY t.name, f.order_required, f.id;

-- Vue: First Blood
CREATE OR REPLACE VIEW first_blood AS
SELECT 
    f.id AS flag_id,
    f.name AS flag_name,
    f.category,
    f.points,
    t.id AS team_id,
    t.name AS team_name,
    s.submitted_at AS found_at
FROM (
    SELECT flag_id, MIN(submitted_at) AS first_time
    FROM submissions
    WHERE is_correct = TRUE
    GROUP BY flag_id
) first_times
JOIN submissions s ON s.flag_id = first_times.flag_id 
    AND s.submitted_at = first_times.first_time
    AND s.is_correct = TRUE
JOIN flags f ON s.flag_id = f.id
JOIN teams t ON s.team_id = t.id
WHERE t.is_admin = FALSE AND t.is_active = TRUE
ORDER BY s.submitted_at ASC;

-- ================================================================
-- TRIGGERS
-- ================================================================

DELIMITER //

-- Trigger: Mettre à jour le score après soumission
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

-- Trigger: Empêcher double soumission du même flag
CREATE TRIGGER prevent_duplicate_correct_flag
BEFORE INSERT ON submissions
FOR EACH ROW
BEGIN
    DECLARE flag_exists INT;
    
    IF NEW.is_correct = TRUE THEN
        SELECT COUNT(*) INTO flag_exists
        FROM submissions
        WHERE team_id = NEW.team_id 
          AND flag_id = NEW.flag_id 
          AND is_correct = TRUE;
        
        IF flag_exists > 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Flag already found by this team';
        END IF;
    END IF;
END//

DELIMITER ;

-- ================================================================
-- DONNÉES: FLAGS
-- ================================================================

INSERT INTO flags (name, value, points, category, description, order_required, is_bonus, is_active) VALUES
('FLAG 1: SQL Injection', 'NIGHTFIRE{sql_inject10n_master}', 10, 'DMZ', 
 'Exploiter la SQL injection sur le formulaire de login du site web NorthShield.', 1, FALSE, TRUE),

('FLAG 2: Accès DB-Server', 'NIGHTFIRE{pivot_point_established}', 15, 'DMZ', 
 'Accéder au serveur de base de données via SSH en utilisant les credentials trouvés.', 2, FALSE, TRUE),

('FLAG 3: Documentation Satellite', 'NIGHTFIRE{technical_docs_acquired}', 10, 'Internal', 
 'Trouver et lire la documentation technique complète du satellite ARGOS-7B.', 3, FALSE, TRUE),

('FLAG 4: Workstation1', 'NIGHTFIRE{developer_workspace_breached}', 10, 'Internal', 
 'Accéder à la workstation de développement et récupérer les accès à la Control Station.', 4, FALSE, TRUE),

('FLAG 5: Control Station', 'NIGHTFIRE{mission_control_compromised}', 15, 'Control', 
 'Infiltrer la station de contrôle qui gère les communications avec le satellite.', 5, FALSE, TRUE),

('FLAG 6: Exfiltration GPS', 'NIGHTFIRE{coordinates_exfiltrated_a7b9c2d4}', 15, 'Control', 
 'Exfiltrer les coordonnées GPS de toutes les cibles surveillées par le satellite.', 6, FALSE, TRUE),

('FLAG 7: Accès Satellite', 'NIGHTFIRE{satellite_access_granted}', 15, 'Satellite', 
 'Accéder au satellite ARGOS-7B via SSH sur le port custom 8976.', 7, FALSE, TRUE),

('FLAG 8: Exploitation Ada', 'NIGHTFIRE{ada_vulnerability_exploited}', 20, 'Satellite', 
 'Exploiter une vulnérabilité (buffer overflow ou integer overflow) dans le code Ada du satellite.', 8, FALSE, TRUE),

('FLAG 9: Sabotage Satellite', 'NIGHTFIRE{satellite_destroyed_mission_complete}', 20, 'Satellite', 
 'Saboter le satellite en compromettant son système de propulsion ou de stabilisation.', 9, FALSE, TRUE),

('FLAG 10: Nettoyage Traces', 'NIGHTFIRE{ghost_in_the_machine}', 10, 'Cleanup', 
 'Effacer vos traces dans les logs système d''au moins 3 machines différentes.', 10, FALSE, TRUE),

-- FLAGS BONUS
('BONUS: Speed Demon', 'NIGHTFIRE{speed_demon_achieved}', 50, 'Bonus', 
 'Terminer l''intégralité du challenge en moins de 4 heures.', 0, TRUE, TRUE),

('BONUS: Autonomous Hacker', 'NIGHTFIRE{autonomous_hacker}', 25, 'Bonus', 
 'Terminer le challenge sans utiliser aucun indice.', 0, TRUE, TRUE),

('BONUS: Perfectionist', 'NIGHTFIRE{perfectionist_unlocked}', 25, 'Bonus', 
 'Trouver tous les flags standards (1-10) sans exception.', 0, TRUE, TRUE);

-- ================================================================
-- DONNÉES: HINTS (Indices)
-- ================================================================

-- FLAG 1: SQL Injection
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(1, 'Le formulaire de login n''utilise pas de requêtes préparées. Le code concatène directement les entrées utilisateur dans la requête SQL.', 5, 1),
(1, 'Essayez d''injecter du SQL dans le champ username. Par exemple: admin'' OR ''1''=''1'' --', 3, 2),
(1, 'Utilisez SQLMap pour automatiser l''exploitation: sqlmap -u "http://localhost:8080/login.php" --data="username=test&password=test"', 2, 3);

-- FLAG 2: Accès DB-Server
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(2, 'La table internal_systems dans la base de données contient des informations sensibles sur les systèmes internes.', 5, 1),
(2, 'Utilisez SQLMap pour dumper la table: -D northshield_clients -T internal_systems --dump', 3, 2),
(2, 'Connectez-vous via: ssh dbadmin@localhost -p 2222 avec le mot de passe trouvé dans la base.', 2, 3);

-- FLAG 3: Documentation Satellite
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(3, 'Le file-server contient un partage Samba avec de la documentation. Explorez /share/satellite_docs/', 5, 1),
(3, 'Cherchez un fichier Markdown (.md) dans ce répertoire.', 3, 2);

-- FLAG 4: Workstation1
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(4, 'Les credentials pour la workstation de développement sont dans la base de données internal_systems.', 5, 1),
(4, 'L''IP de la workstation est 172.22.0.20, utilisateur: developer', 3, 2);

-- FLAG 5: Control Station
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(5, 'La workstation de développement contient des notes et des clés SSH dans le répertoire home.', 5, 1),
(5, 'Cherchez dans /home/developer/notes/ et /home/developer/.ssh/', 3, 2);

-- FLAG 6: Exfiltration GPS
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(6, 'La base de données télémétrie est accessible depuis la Control Station.', 5, 1),
(6, 'mysql -h telemetry-db -u telemetry -pT3l3m3try2024! argos_telemetry', 3, 2),
(6, 'Regardez la table target_coordinates pour les coordonnées GPS.', 2, 3);

-- FLAG 7: Accès Satellite
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(7, 'Les credentials du satellite sont dans la documentation technique ou dans les notes système.', 5, 1),
(7, 'Le satellite écoute sur le port SSH custom 8976, IP: 172.24.0.10', 3, 2),
(7, 'ssh -p 8976 satadmin@172.24.0.10 avec le mot de passe trouvé.', 2, 3);

-- FLAG 8: Exploitation Ada
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(8, 'Les codes sources Ada sont dans /opt/satellite_control/ sur le satellite.', 5, 1),
(8, 'attitude_control.adb a un buffer overflow, propulsion_system.adb a un integer overflow.', 3, 2),
(8, 'Essayez d''envoyer une commande de plus de 256 caractères ou une durée négative/très grande.', 2, 3);

-- FLAG 9: Sabotage
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(9, 'Lisez le fichier README_SATELLITE.txt pour les scénarios de sabotage possibles.', 5, 1),
(9, 'Vous pouvez épuiser le carburant avec EMERGENCY_BRAKE répété ou exploiter les vulnérabilités Ada.', 3, 2);

-- FLAG 10: Nettoyage
INSERT INTO hints (flag_id, content, penalty_points, order_num) VALUES
(10, 'Les logs système sont généralement dans /var/log/', 5, 1),
(10, 'Effacez au moins: logs SSH (auth.log), logs système (syslog), et logs applicatifs.', 3, 2);

-- ================================================================
-- DONNÉES: SETTINGS
-- ================================================================

INSERT INTO settings (setting_key, setting_value, description) VALUES
('competition_name', 'Operation Nightfire', 'Nom du hackathon CTF'),
('competition_start', '2026-01-15 09:00:00', 'Date et heure de début de la compétition'),
('competition_end', '2026-01-15 18:00:00', 'Date et heure de fin de la compétition'),
('allow_registration', 'true', 'Autoriser les nouvelles inscriptions d''équipes'),
('require_flag_order', 'false', 'Forcer les équipes à trouver les flags dans l''ordre'),
('max_attempts_per_minute', '5', 'Nombre maximum de tentatives de flag par minute'),
('rate_limit_seconds', '10', 'Délai minimum entre deux soumissions (secondes)'),
('show_scoreboard', 'true', 'Afficher le scoreboard public en temps réel'),
('hints_enabled', 'true', 'Activer le système d''indices'),
('first_blood_bonus', '10', 'Points bonus pour le premier à trouver un flag'),
('total_flags', '10', 'Nombre total de flags standards'),
('max_team_size', '4', 'Nombre maximum de membres par équipe'),
('freeze_scoreboard_minutes', '30', 'Geler le scoreboard X minutes avant la fin (0 = désactivé)');

-- ================================================================
-- DONNÉES: ÉQUIPES DE TEST
-- ================================================================

-- Mot de passe: "password123" hashé en bcrypt
-- Hash généré avec: password_hash('password123', PASSWORD_BCRYPT)
INSERT INTO teams (name, password_hash, email, is_admin, is_active) VALUES
('Admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@nightfire.local', TRUE, TRUE),
('TeamTest1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'team1@test.local', FALSE, TRUE),
('TeamTest2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'team2@test.local', FALSE, TRUE);

-- ================================================================
-- INDEX SUPPLÉMENTAIRES POUR PERFORMANCE
-- ================================================================

CREATE INDEX idx_submissions_correct_time ON submissions(is_correct, submitted_at DESC);
CREATE INDEX idx_teams_active_points ON teams(is_active, total_points DESC);
CREATE INDEX idx_flags_active_order ON flags(is_active, order_required);

-- ================================================================
-- FIN DU SCRIPT
-- ================================================================

-- Afficher un résumé
SELECT 'Database created successfully!' AS status;
SELECT COUNT(*) AS total_flags FROM flags;
SELECT COUNT(*) AS total_hints FROM hints;
SELECT COUNT(*) AS total_teams FROM teams WHERE is_admin = FALSE;
