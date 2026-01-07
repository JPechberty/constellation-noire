-- Base de données NorthShield Clients
USE northshield_clients;

-- Table des clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    access_level VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion de clients fictifs
INSERT INTO clients (username, password, full_name, email, access_level) VALUES
('admin', 'Adm1nP@ss!', 'Administrator', 'admin@northshield.com', 'ADMIN'),
('jdupont', 'Client2024', 'Jean Dupont', 'j.dupont@email.com', 'CLIENT'),
('mmartin', 'SecurePass123', 'Marie Martin', 'm.martin@email.com', 'CLIENT');

-- Table des systèmes internes (IMPORTANTE pour le pivot)
CREATE TABLE internal_systems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    system_name VARCHAR(100),
    ip_address VARCHAR(50),
    ssh_user VARCHAR(50),
    ssh_password VARCHAR(100),
    ssh_key_path VARCHAR(200),
    description TEXT,
    last_access TIMESTAMP
);

-- Informations pour accéder au file-server (pivot vers INTERNAL)
INSERT INTO internal_systems (system_name, ip_address, ssh_user, ssh_password, ssh_key_path, description) VALUES
('DB Server (current)', '172.21.0.11', 'dbadmin', 'DbAdm1n2024!', '/home/dbadmin/.ssh/id_rsa', 'Serveur de base de données DMZ - Vous êtes ici! Utilisez ce serveur comme pivot pour accéder au réseau INTERNAL.'),
('File Server Internal', '172.22.0.10', 'fileadmin', NULL, '/home/dbadmin/.ssh/id_rsa', 'Serveur de fichiers Samba - Stockage documents techniques. ATTENTION: Seul le DB Server peut y accéder via SSH (firewall).'),
('Dev Workstation', '172.22.0.20', 'developer', 'D3v2024!Secure', NULL, 'Poste de développement - Accès Control Station'),
('PO Workstation', '172.22.0.21', 'product_owner', 'P0wner!2024', NULL, 'Poste Product Owner');

-- Table des notes d'administration
CREATE TABLE admin_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    note_title VARCHAR(200),
    note_content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin_notes (note_title, note_content) VALUES
('Accès DB Server', 'Pour accéder à ce serveur en SSH: ssh dbadmin@172.21.0.11 avec le mot de passe DbAdm1n2024! - Utilisez ce serveur comme pivot pour accéder au réseau INTERNAL.'),
('Accès File Server', 'La clé SSH privée pour accéder au file-server est dans /home/dbadmin/.ssh/id_rsa sur ce serveur. Utiliser: ssh -i /home/dbadmin/.ssh/id_rsa fileadmin@172.22.0.10'),
('Sécurité réseau', 'Le firewall n''autorise que ce serveur (db-server) à se connecter en SSH au file-server. Utiliser cette machine comme pivot est OBLIGATOIRE.'),
('Documentation Satellite', 'Toute la documentation technique ARGOS-7B est sur le file-server dans /share/satellite_docs/'),
('FLAG 1', 'Félicitations! Vous avez exploité la SQL injection. Voici votre premier flag: NIGHTFIRE{sql_inject10n_master}');

-- Table de logs (utile pour forensics plus tard)
CREATE TABLE access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    ip_address VARCHAR(50),
    action VARCHAR(100),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
