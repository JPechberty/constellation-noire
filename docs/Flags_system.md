# SYSTÈME DE FLAGS - Operation Nightfire

## 🎯 Concept

Chaque étape importante du hackathon contient un **flag** au format :
```
NIGHTFIRE{description_etape}
```

Les étudiants soumettent les flags sur une plateforme CTF (ou script local) pour valider leur progression.

---

## 🏁 Liste des FLAGS et emplacements

### FLAG 1: SQL Injection (10 points)
**Emplacement:** Dans la table `admin_notes` de la base de données
**Flag:** `NIGHTFIRE{sql_inject10n_master}`
**Condition:** Accessible après exploitation SQL injection

### FLAG 2: Accès DB-Server (15 points)
**Emplacement:** `/home/dbadmin/FLAG.txt` sur db-server
**Flag:** `NIGHTFIRE{pivot_point_established}`
**Condition:** SSH sur db-server avec credentials trouvés

### FLAG 3: Documentation Satellite (10 points)
**Emplacement:** Dans `/share/satellite_docs/ARGOS7B_TECHNICAL_DOC.md` sur file-server
**Flag:** `NIGHTFIRE{technical_docs_acquired}`
**Condition:** Lecture du fichier après pivot vers file-server

### FLAG 4: Accès Workstation1 (10 points)
**Emplacement:** `/home/developer/FLAG.txt` sur workstation1
**Flag:** `NIGHTFIRE{developer_workspace_breached}`
**Condition:** SSH sur workstation1

### FLAG 5: Accès Control Station (15 points)
**Emplacement:** `/home/ctrlops/FLAG.txt` sur control-station
**Flag:** `NIGHTFIRE{mission_control_compromised}`
**Condition:** SSH sur control-station

### FLAG 6: Exfiltration GPS (15 points)
**Emplacement:** Données de la table `target_coordinates`
**Flag:** Généré à partir des coordonnées (MD5 hash des 3 premières cibles)
**Flag:** `NIGHTFIRE{coordinates_exfiltrated_a7b9c2d4}`
**Condition:** SELECT * FROM target_coordinates et calculer le hash

### FLAG 7: Accès Satellite (15 points)
**Emplacement:** `/home/satadmin/FLAG.txt` sur satellite
**Flag:** `NIGHTFIRE{satellite_access_granted}`
**Condition:** SSH sur le satellite ARGOS-7B

### FLAG 8: Exploitation Ada (20 points)
**Emplacement:** Déclenché après exploitation réussie du buffer overflow ou integer overflow
**Flag:** `NIGHTFIRE{ada_vulnerability_exploited}`
**Condition:** Causer un crash système des programmes Ada

### FLAG 9: Sabotage Réussi (20 points)
**Emplacement:** Flag affiché quand les propulseurs sont compromis
**Flag:** `NIGHTFIRE{satellite_destroyed_mission_complete}`
**Condition:** Sabotage du satellite (carburant épuisé OU système instable)

### FLAG 10: Nettoyage Traces (10 points)
**Emplacement:** Validation via script de vérification
**Flag:** `NIGHTFIRE{ghost_in_the_machine}`
**Condition:** Logs nettoyés sur au moins 3 systèmes différents

---

## 📊 Barème de points

| Flag | Description | Points |
|------|-------------|--------|
| FLAG 1 | SQL Injection | 10 |
| FLAG 2 | Accès DB-Server | 15 |
| FLAG 3 | Documentation Satellite | 10 |
| FLAG 4 | Accès Workstation1 | 10 |
| FLAG 5 | Accès Control Station | 15 |
| FLAG 6 | Exfiltration GPS | 15 |
| FLAG 7 | Accès Satellite | 15 |
| FLAG 8 | Exploitation Ada | 20 |
| FLAG 9 | Sabotage Satellite | 20 |
| FLAG 10 | Nettoyage Traces | 10 |
| **TOTAL** | | **140** |

---

## 🎮 Options de soumission des flags

### Option A: Plateforme CTF (RECOMMANDÉ)

Utiliser CTFd (inclus dans l'environnement Docker).

**Avantages:**
- Interface web professionnelle
- Scoreboard en temps réel
- Gestion automatique des points
- Historique des soumissions
- Anti-brute-force intégré

**Déploiement:**
```bash
cd ctf-platform
docker-compose up -d
# Accès: http://localhost:8000
```

### Option B: Script de validation local

Pour les environnements sans accès web.

**Utilisation:**
```bash
./validate_flag.sh "NIGHTFIRE{sql_inject10n_master}"
# ✓ Flag correct! (+10 points)
# Score actuel: 10/140
```

### Option C: Soumission manuelle

Les étudiants documentent leurs flags dans un fichier `FLAGS.txt`:
```
FLAG 1: NIGHTFIRE{sql_inject10n_master} - Timestamp: 10:23
FLAG 2: NIGHTFIRE{pivot_point_established} - Timestamp: 10:45
...
```

---

## 🔒 Sécurité des flags

### Règles importantes:

1. **Ne JAMAIS hardcoder les flags** dans le code applicatif visible
2. **Placer les flags dans des fichiers système** ou bases de données
3. **Flags uniques** par équipe si possible (voir FLAG_GENERATOR.md)
4. **Format strict** pour éviter les erreurs de typo

### Anti-triche:

- Flags différents par équipe (optionnel)
- Timestamps des soumissions
- Ordre logique requis (FLAG 7 avant FLAG 8)
- Rate limiting sur les soumissions

---

## 📝 Format des flags

**Standard:** `NIGHTFIRE{descriptif_en_snake_case}`

**Exemples valides:**
- `NIGHTFIRE{sql_inject10n_master}`
- `NIGHTFIRE{satellite_destroyed_mission_complete}`

**Exemples invalides:**
- `nightfire{test}` (pas de majuscules)
- `NIGHTFIRE{Test}` (pas de CamelCase)
- `NIGHTFIRE{test test}` (espaces)

---

## 🎯 FLAGS spéciaux (bonus)

### FLAG BONUS 1: Speed Run (50 points)
**Condition:** Terminer en moins de 4 heures
**Flag:** `NIGHTFIRE{speed_demon_achieved}`

### FLAG BONUS 2: No Hints (25 points)
**Condition:** Terminer sans utiliser le SOLUTION_GUIDE
**Flag:** `NIGHTFIRE{autonomous_hacker}`

### FLAG BONUS 3: Clean Sweep (25 points)
**Condition:** Trouver TOUS les flags (1-10)
**Flag:** `NIGHTFIRE{perfectionist_unlocked}`

---

## 📊 Scoring avancé

### Multiplicateurs de temps:

- **0-4h:** Score × 1.5
- **4-6h:** Score × 1.2
- **6-8h:** Score × 1.0
- **8-10h:** Score × 0.8
- **10h+:** Score × 0.6

### Pénalités:

- **Hints utilisés:** -5 points par hint
- **Soumissions incorrectes:** -1 point après 3 tentatives
- **Flags dans le désordre:** Warning (peut indiquer triche)

---

## 🏆 Classement

### Critères de classement:

1. **Points totaux** (prioritaire)
2. **Temps de complétion** (tiebreaker)
3. **Nombre de hints** (tiebreaker)

### Exemple de scoreboard:

| Rang | Équipe | Points | Temps | Flags |
|------|--------|--------|-------|-------|
| 🥇 1 | TeamRocket | 190 | 3h45 | 10/10 |
| 🥈 2 | H4ck3rs | 175 | 5h12 | 10/10 |
| 🥉 3 | CyberNinjas | 140 | 6h30 | 10/10 |

---

## 💡 Conseils pour les instructeurs

### Pendant le hackathon:

1. **Monitorer les soumissions** - Repérer qui est bloqué
2. **Hints progressifs** - Donner des indices si bloqué >30 min
3. **Encourager la documentation** - Demander un write-up final
4. **Célébrer les first bloods** - Premier à trouver chaque flag

### Après le hackathon:

1. **Debrief collectif** - Discuter des différentes approches
2. **Show & tell** - Les équipes présentent leurs solutions
3. **Remise des flags** - Expliquer où étaient cachés les flags difficiles
4. **Feedback** - Recueillir les retours pour améliorer

---

## 🎓 Valeur pédagogique

Le système de flags apprend aux étudiants:

✅ **Format CTF** - Standard dans l'industrie de la cybersécurité
✅ **Validation objective** - Preuve concrète de réussite
✅ **Gamification** - Motivation par la compétition amicale
✅ **Documentation** - Nécessité de noter sa progression
✅ **Travail d'équipe** - Répartition des tâches par flag

---

## 🔄 Alternative: Questionnaire hybride

Si vous voulez **combiner** flags + questions:

**Flags (70%)** - Validation technique
**Questions (30%)** - Compréhension conceptuelle

**Exemple de questions:**
1. Expliquez pourquoi le pivot via db-server est nécessaire
2. Quelle vulnérabilité avez-vous exploitée dans le code Ada?
3. Comment avez-vous évité la détection dans les logs?

---

## 📦 Déploiement

Les flags sont **déjà intégrés** dans l'environnement Docker.

Pour activer la plateforme CTF:
```bash
cd operation-nightfire
docker-compose -f docker-compose.yml -f docker-compose.ctf.yml up -d
```

Accès plateforme: http://localhost:8000

---

**Recommandation:** Utilisez le système de FLAGS avec CTFd pour une expérience professionnelle et motivante! 🚀
