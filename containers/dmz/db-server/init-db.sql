-- ============================================
-- NORTHSHIELD DATABASE INITIALIZATION
-- ============================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS northshield_db;
USE northshield_db;

-- ============================================
-- Table: users (pour le login)
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    role VARCHAR(50) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer des utilisateurs de test
-- Note: En production, les mots de passe devraient être hashés!
INSERT INTO users (username, password, email, role) VALUES
('admin', 'admin123', 'admin@northshield.mil', 'administrator'),
('operator', 'operator2024', 'operator@northshield.mil', 'operator'),
('dbadmin', 'DbAdm1n2024!', 'dbadmin@northshield.mil', 'database_admin');

-- ============================================
-- Table: internal_systems
-- Ce sont les systèmes internes accessibles après SQL injection
-- ============================================
CREATE TABLE IF NOT EXISTS internal_systems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    system_name VARCHAR(100) NOT NULL,
    hostname VARCHAR(255) NOT NULL,
    ip_address VARCHAR(50),
    ssh_port INT DEFAULT 22,
    ssh_username VARCHAR(100),
    ssh_password VARCHAR(255),
    description TEXT,
    zone VARCHAR(50),
    status VARCHAR(20) DEFAULT 'active',
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer les systèmes internes (credentials pour pivoting)
INSERT INTO internal_systems (system_name, hostname, ip_address, ssh_port, ssh_username, ssh_password, description, zone, status) VALUES
('Database Server', 'db-server', '172.18.0.3', 22, 'dbadmin', 'DbAdm1n2024!', 'Serveur de base de données principal - MariaDB', 'DMZ', 'active'),
('File Server', 'file-server', '172.19.0.3', 22, 'fileadmin', 'F1l3Adm1n2024!', 'Serveur de fichiers - Documentation système', 'Internal', 'active'),
('Workstation 1', 'workstation1', '172.19.0.4', 22, 'developer', 'D3v2024!Secure', 'Poste de travail développeur', 'Internal', 'active'),
('Control Station', 'control-station', '172.20.0.3', 22, 'ctrlops', 'Ctr10ps@2024!', 'Station de contrôle satellite', 'Control', 'active'),
('Telemetry Database', 'telemetry-db', '172.20.0.4', 3306, 'telemetry', 'T3l3m3try2024!', 'Base de données télémétrie GPS', 'Control', 'active'),
('Satellite ARGOS-7B', 'argos7b', '172.24.0.10', 8976, 'satadmin', 'S4t3ll1t3@ARGOS!', 'Satellite de surveillance ARGOS-7B', 'Satellite', 'active'),
('Backup Server', 'backup-server', '172.18.0.5', 22, 'backup', 'B4ckup!2024', 'Serveur de sauvegarde système', 'DMZ', 'active');

-- ============================================
-- Table: satellites
-- Informations sur les satellites gérés
-- ============================================
CREATE TABLE IF NOT EXISTS satellites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    satellite_name VARCHAR(100) NOT NULL,
    designation VARCHAR(50),
    launch_date DATE,
    orbit_type VARCHAR(50),
    altitude_km INT,
    status VARCHAR(20) DEFAULT 'operational',
    last_contact TIMESTAMP,
    mission_type VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO satellites (satellite_name, designation, launch_date, orbit_type, altitude_km, status, last_contact, mission_type) VALUES
('ARGOS-1', 'NS-001', '2004-03-15', 'LEO', 550, 'operational', NOW(), 'Surveillance'),
('ARGOS-3', 'NS-003', '2010-08-22', 'LEO', 580, 'operational', NOW(), 'Communication'),
('ARGOS-5', 'NS-005', '2018-11-10', 'MEO', 1200, 'operational', NOW(), 'Navigation'),
('ARGOS-7B', 'NS-007B', '2024-01-05', 'LEO', 600, 'operational', NOW(), 'Surveillance & Tracking'),
('ARGOS-4', 'NS-004', '2015-05-18', 'GEO', 35786, 'maintenance', '2025-12-01 10:30:00', 'Communication'),
('ARGOS-6', 'NS-006', '2020-09-25', 'LEO', 520, 'decommissioned', '2025-06-15 08:00:00', 'Research');

-- ============================================
-- Table: access_logs
-- Logs d'accès au système (pour réalisme)
-- ============================================
CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    ip_address VARCHAR(50),
    action VARCHAR(255),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Quelques logs pour le réalisme
INSERT INTO access_logs (username, ip_address, action, success) VALUES
('admin', '192.168.1.100', 'Login successful', TRUE),
('operator', '192.168.1.101', 'Login successful', TRUE),
('unknown', '203.0.113.45', 'Failed login attempt', FALSE),
('dbadmin', '192.168.1.102', 'Login successful', TRUE),
('unknown', '198.51.100.23', 'Failed login attempt', FALSE);

-- ============================================
-- Table: missions
-- Missions en cours
-- ============================================
CREATE TABLE IF NOT EXISTS missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_name VARCHAR(100) NOT NULL,
    satellite_id INT,
    start_date DATE,
    end_date DATE,
    status VARCHAR(50) DEFAULT 'active',
    classification VARCHAR(50),
    description TEXT,
    FOREIGN KEY (satellite_id) REFERENCES satellites(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO missions (mission_name, satellite_id, start_date, end_date, status, classification, description) VALUES
('Operation Nightwatch', 4, '2024-01-10', '2024-12-31', 'active', 'SECRET', 'Surveillance continue de zones sensibles'),
('Project Skyguard', 1, '2024-03-01', '2024-09-30', 'active', 'TOP SECRET', 'Tracking de menaces balistiques'),
('Mission Atlas', 3, '2023-06-15', '2024-06-15', 'completed', 'CONFIDENTIAL', 'Cartographie haute résolution');

-- ============================================
-- FLAG 1 - Caché dans un commentaire SQL
-- ============================================
-- 🚩 FLAG 1: NIGHTFIRE{sql_inject10n_master}
-- Ce flag peut être découvert via SQL injection sur le formulaire de login

-- ============================================
-- Vues utiles
-- ============================================

-- Vue: Systèmes actifs par zone
CREATE OR REPLACE VIEW active_systems_by_zone AS
SELECT 
    zone,
    COUNT(*) as system_count,
    GROUP_CONCAT(system_name SEPARATOR ', ') as systems
FROM internal_systems
WHERE status = 'active'
GROUP BY zone;

-- Vue: Satellites opérationnels
CREATE OR REPLACE VIEW operational_satellites AS
SELECT 
    satellite_name,
    designation,
    orbit_type,
    altitude_km,
    mission_type,
    DATEDIFF(NOW(), last_contact) as days_since_contact
FROM satellites
WHERE status = 'operational';

-- ============================================
-- Permissions
-- ============================================
GRANT ALL PRIVILEGES ON northshield_db.* TO 'root'@'%';
FLUSH PRIVILEGES;

-- ============================================
-- Afficher un résumé
-- ============================================
SELECT '✅ Database initialized successfully!' as status;
SELECT 'Tables created:' as info;
SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'northshield_db';
SELECT '🔑 Test credentials: admin / admin123' as credentials;
SELECT '🚩 FLAG 1: Check admin.php after successful SQL injection' as flag_hint;
