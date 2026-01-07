# OPERATION NIGHTFIRE - Red Team Hackathon
## BTS SIO 2 - SLAM & SISR

### CONTEXTE

Hackathon de sécurité offensive mettant en scène l'infiltration d'un système de contrôle de satellites militaires ARGOS-7 exploité par NorthShield Defense Systems.

### OBJECTIF PÉDAGOGIQUE

Ce scénario permet d'apprendre et de mettre en pratique:
- SQL Injection
- Pivoting réseau et SSH tunneling
- Mouvement latéral entre zones
- Exploitation de failles (upload, RCE)
- Craquage de mots de passe
- Programmation Ada legacy
- Gestion de logs et effacement de traces

### ARCHITECTURE

```
INTERNET
    |
  [ROUTER avec iptables]
    |
    ├── DMZ (172.21.0.0/24)
    |   ├── web-client (172.21.0.10) - Port 8080
    |   └── db-server (172.21.0.11)
    |
    ├── INTERNAL (172.22.0.0/24)
    |   ├── file-server (172.22.0.10)
    |   ├── workstation1 (172.22.0.20)
    |   └── workstation2 (172.22.0.21)
    |
    ├── CONTROL (172.23.0.0/24)
    |   ├── telemetry-db (172.23.0.10)
    |   └── control-station (172.23.0.20)
    |
    └── SATELLITE (172.24.0.0/24)
        └── argos7b (172.24.0.10) - Port SSH 8976
```

### FIREWALLING

Le router implémente des règles strictes:
- Internet → DMZ: Ports 80, 443 uniquement
- DMZ → Internal: SSH (22) uniquement depuis db-server → file-server
- Internal → Control: SSH (22) uniquement depuis workstation1 → control-station
- Control → Satellite: SSH custom (8976) uniquement depuis control-station → satellite

### DÉPLOIEMENT

**Prérequis:**
- Docker & Docker Compose installés
- Au moins 4 GB RAM disponible
- 10 GB espace disque

**Installation:**

```bash
# Décompresser l'archive
tar -xzf operation-nightfire.tar.gz
cd operation-nightfire

# Construire et lancer tous les conteneurs
docker-compose up -d

# Vérifier que tous les services sont actifs
docker-compose ps
```

**Accès initial:**

Le point d'entrée est le serveur web:
- URL: http://localhost:8080
- Première étape: Exploiter l'injection SQL

Une fois les credentials trouvés via SQL injection:
- SSH vers db-server: localhost:2222 (dbadmin / DbAdm1n2024!)
- Le db-server sert de pivot vers le réseau internal

### POINT DE DÉPART POUR LES ÉTUDIANTS

1. Accéder à http://localhost:8080
2. Trouver et exploiter la vulnérabilité SQL injection
3. Découvrir les informations dans la base de données
4. Utiliser le db-server comme pivot vers le réseau internal
5. Progresser zone par zone jusqu'au satellite

### PROGRESSION ATTENDUE

**Phase 1 - DMZ (30 min)**
- SQL injection sur login.php
- Extraction des tables (internal_systems, admin_notes)
- Récupération clé SSH et credentials

**Phase 2 - INTERNAL (45 min)**
- SSH vers file-server depuis db-server
- Exploration du partage Samba
- Lecture documentation ARGOS7B_TECHNICAL_DOC.md
- Accès workstation1 (developer)
- Récupération clé SSH control-station

**Phase 3 - CONTROL (45 min)**
- SSH vers control-station depuis workstation1
- Accès telemetry-db (coordonnées GPS)
- Exfiltration des données sensibles
- Préparation accès satellite

**Phase 4 - SATELLITE (60 min)**
- SSH vers satellite (port 8976) depuis control-station
- Analyse codes Ada (attitude_control.adb, propulsion_system.adb)
- Exploitation buffer overflow / integer overflow
- Sabotage du satellite
- Effacement des logs

**Phase 5 - CLEANUP (30 min)**
- Nettoyage des traces dans tous les logs
- Vérification que le crash semble être un bug

### DURÉE ESTIMÉE

6-8 heures pour les étudiants BTS SIO 2

### INDICES ET SOLUTIONS

Un guide détaillé avec indices et solutions est disponible dans `SOLUTION_GUIDE.md`

### ARRÊT DE L'ENVIRONNEMENT

```bash
# Arrêter tous les conteneurs
docker-compose down

# Arrêter et supprimer les volumes (reset complet)
docker-compose down -v
```

### TROUBLESHOOTING

**Les conteneurs ne démarrent pas:**
```bash
docker-compose logs [nom-service]
```

**Problème de réseau:**
```bash
docker network ls
docker network inspect operation-nightfire_dmz
```

**Reset complet:**
```bash
docker-compose down -v
docker system prune -a
docker-compose up -d --build
```

### SUPPORT

Pour toute question ou problème technique, contacter l'équipe pédagogique.

### LICENCE

Ce matériel pédagogique est destiné à un usage éducatif uniquement dans le cadre du BTS SIO.

---
© 2024 BTS SIO - Operation Nightfire
