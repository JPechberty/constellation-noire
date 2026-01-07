# QUICKSTART - OPERATION NIGHTFIRE

## Déploiement rapide en 3 étapes

### 1. Décompression
```bash
tar -xzf operation-nightfire.tar.gz
cd operation-nightfire
```

### 2. Lancement
```bash
docker-compose up -d --build
```

### 3. Vérification
```bash
docker-compose ps
```

Tous les services doivent être "Up".

## Point d'entrée

🌐 **http://localhost:8080**

C'est le site web NorthShield à attaquer en premier !

## Commandes utiles

**Voir les logs d'un service:**
```bash
docker-compose logs [service-name]
# Exemple: docker-compose logs web-client
```

**Redémarrer un service:**
```bash
docker-compose restart [service-name]
```

**Se connecter à un conteneur:**
```bash
docker exec -it nightfire-[container] /bin/bash
# Exemple: docker exec -it nightfire-web /bin/bash
```

**Arrêter l'environnement:**
```bash
docker-compose down
```

**Reset complet (supprime données):**
```bash
docker-compose down -v
```

## Architecture réseau

```
Internet (vous)
    ↓
web-client:8080 (DMZ) ← Commencez ici !
    ↓
db-server (DMZ) ← Pivot #1
    ↓
file-server (INTERNAL) ← Pivot #2
    ↓
workstation1 (INTERNAL) ← Pivot #3
    ↓
control-station (CONTROL) ← Pivot #4
    ↓
satellite:8976 (SATELLITE) ← Objectif final !
```

## Première étape: SQL Injection

Testez le formulaire de connexion sur http://localhost:8080

**Hint:** `admin' OR '1'='1' -- `

## Documentation complète

- `README.md` - Documentation principale
- `SOLUTION_GUIDE.md` - Guide de solution complet (pour l'instructeur)

## Durée estimée

⏱️ **6-8 heures** pour les étudiants BTS SIO 2

## Support

En cas de problème:
1. Vérifier que Docker est bien lancé
2. Vérifier les logs: `docker-compose logs`
3. Reset: `docker-compose down -v && docker-compose up -d --build`

Bonne chance ! 🚀
