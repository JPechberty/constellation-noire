# ARGOS-7B SATELLITE - DOCUMENTATION TECHNIQUE
## Projet classifié - NorthShield Defense Systems

### ARCHITECTURE SYSTÈME

Le satellite ARGOS-7B utilise Debian 12 (simulation embarqué) avec les composants suivants:

- **Système d'exploitation**: Debian 12 Slim (minimal footprint)
- **Langage de contrôle**: Ada 2012 (héritage programme spatial années 90)
- **Compilateur**: GNAT Community Edition
- **Port SSH custom**: 8976 (accès restreint depuis Control Station uniquement)

### ACCÈS AU SATELLITE

**IP**: 172.24.0.10
**Port SSH**: 8976
**Utilisateur**: satadmin
**Mot de passe**: S4t3ll1t3@ARGOS!

⚠️ IMPORTANT: Seule la Control Station (172.23.0.20) est autorisée à se connecter au satellite via le firewall.

### SERVICES CRITIQUES

1. **attitude_control.adb** - Contrôle d'attitude et stabilisation
2. **propulsion_system.adb** - Système de propulsion et manœuvres orbitales
3. **telemetry_logger.adb** - Enregistrement télémétrie
4. **ground_comm.adb** - Communication avec la station au sol

### SYSTÈME DE PROPULSION

Le satellite dispose de 4 propulseurs de correction:
- Propulseur NORD (thruster_north)
- Propulseur SUD (thruster_south)  
- Propulseur EST (thruster_east)
- Propulseur OUEST (thruster_west)

### VULNÉRABILITÉS CONNUES

⚠️ CONFIDENTIEL - Ne pas divulguer

1. **Buffer Overflow dans attitude_control.adb**
   - Variable `Command_Buffer` de taille fixe 256 caractères
   - Pas de vérification de taille des commandes reçues
   - Exploitation possible pour injection de code

2. **Integer Overflow dans propulsion_system.adb**
   - Calculs de trajectoire utilisant des entiers non vérifiés
   - Valeurs négatives ou trop grandes peuvent causer des comportements erratiques
   - Peut forcer des allumages répétés des propulseurs

3. **Accès logs sans authentification**
   - Les logs système sont accessibles en lecture/écriture
   - Emplacement: /var/log/satellite/system.log

### SCÉNARIOS DE SABOTAGE POSSIBLES

Pour des raisons de sécurité, ces informations doivent rester STRICTEMENT confidentielles:

**Méthode 1: Épuisement carburant**
- Activer les propulseurs de manière continue via overflow
- Le satellite perdra sa capacité de correction d'orbite
- Crash contrôlé dans l'atmosphère en 2-3 semaines

**Méthode 2: Perte de stabilisation**
- Injecter des commandes contradictoires dans le contrôle d'attitude
- Le satellite entrera en rotation incontrôlée
- Panneaux solaires ne seront plus orientés → batteries vides → crash

**Méthode 3: Rupture communication** 
- Corrompre le module de communication au sol
- Satellite devient "orphelin" et dérive
- Réentrée atmosphérique en quelques semaines

### FICHIERS SOURCES

Les codes sources Ada sont dans `/opt/satellite_control/` sur le satellite.

### RECOMPILATION

Pour recompiler après modification:
```bash
cd /opt/satellite_control
gnatmake -o attitude_control attitude_control.adb
gnatmake -o propulsion_system propulsion_system.adb
```

### ACCÈS CONTROL STATION

Pour accéder à la Control Station depuis le réseau interne:

**IP Control Station**: 172.23.0.20
**Utilisateur SSH**: ctrlops
**Mot de passe**: Ctr10ps@2024!

⚠️ Seule la workstation de développement (172.22.0.20) peut se connecter à la Control Station.

---
Document rédigé par: Dr. Marcus Chen - Lead Satellite Engineer
Dernière mise à jour: 15 Octobre 2024
Classification: TOP SECRET - NORTHSHIELD ONLY

---

## 🎯 FLAG CAPTURE

Félicitations! Vous avez trouvé et lu la documentation technique du satellite ARGOS-7B.

**FLAG 3:** `NIGHTFIRE{technical_docs_acquired}`

**Points:** 10

Cette documentation contient toutes les informations nécessaires pour comprendre l'architecture du satellite et planifier votre attaque.

Prochaines étapes:
1. Accéder à la workstation de développement (172.22.0.20)
2. Trouver les credentials pour la Control Station
3. Progresser vers le satellite

Bonne chance!
