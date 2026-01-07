# FIX: Address Already in Use (Router)

## 🔴 Erreur

```
ERROR: for router  Cannot start service router: Address already in use
```

## 🔍 Cause

Les plages d'adresses IP utilisées par Operation Nightfire (172.20-24.0.0/24) sont déjà utilisées par un autre réseau Docker sur votre système.

## ✅ Solution 1: Nettoyer les réseaux existants (RECOMMANDÉ)

### Étape 1: Exécuter le script de nettoyage

```bash
./cleanup-networks.sh
```

Ce script va:
- Arrêter les conteneurs Operation Nightfire
- Supprimer les anciens réseaux Docker
- Nettoyer les réseaux inutilisés

### Étape 2: Relancer

```bash
docker-compose up -d --build
```

---

## ✅ Solution 2: Utiliser des plages IP alternatives

Si le nettoyage ne suffit pas, utilisez la version alternative avec des plages IP différentes.

### Option A: Manuel (Simple)

**1. Sauvegarder l'original:**
```bash
mv docker-compose.yml docker-compose.yml.original
```

**2. Utiliser la version alternative:**
```bash
cp docker-compose-alt.yml docker-compose.yml
```

**3. Mettre à jour les règles de firewall du router:**
```bash
cp router/firewall-rules-alt.sh router/firewall-rules.sh
```

**4. Lancer:**
```bash
docker-compose up -d --build
```

### Option B: Script automatique

**Créer et exécuter ce script:**

```bash
cat > switch-to-alt.sh << 'EOF'
#!/bin/bash
echo "Passage à la configuration IP alternative..."
mv docker-compose.yml docker-compose.yml.original
cp docker-compose-alt.yml docker-compose.yml
cp router/firewall-rules-alt.sh router/firewall-rules.sh
echo "✓ Configuration mise à jour!"
echo ""
echo "Nouvelle configuration réseau:"
echo "  Internet: 10.100.0.0/24"
echo "  DMZ: 10.101.0.0/24"
echo "  Internal: 10.102.0.0/24"
echo "  Control: 10.103.0.0/24"
echo "  Satellite: 10.104.0.0/24"
echo ""
echo "Lancer avec: docker-compose up -d --build"
EOF

chmod +x switch-to-alt.sh
./switch-to-alt.sh
```

**Puis:**
```bash
docker-compose up -d --build
```

---

## 🔍 Solution 3: Diagnostic approfondi

Si les deux solutions précédentes échouent, identifiez le conflit:

### Étape 1: Lister tous les réseaux Docker

```bash
docker network ls
```

### Étape 2: Inspecter les réseaux utilisant 172.20-24.x.x

```bash
docker network inspect $(docker network ls -q) | grep -A 5 "172.2[0-4]"
```

### Étape 3: Identifier les conteneurs utilisant ces réseaux

```bash
docker ps -a | grep -E "172.2[0-4]"
```

### Étape 4: Arrêter les conteneurs en conflit

```bash
docker stop <container_id>
```

### Étape 5: Supprimer les réseaux en conflit

```bash
docker network rm <network_name>
```

---

## 🧪 Vérification après résolution

Une fois le problème résolu:

```bash
# Vérifier que tous les conteneurs sont UP
docker-compose ps

# Vérifier les réseaux créés
docker network ls | grep nightfire

# Tester l'accès au site web
curl http://localhost:8080
```

---

## 📊 Comparaison des configurations

### Configuration Originale (docker-compose.yml)
```
Internet:   172.20.0.0/24
DMZ:        172.21.0.0/24
Internal:   172.22.0.0/24
Control:    172.23.0.0/24
Satellite:  172.24.0.0/24
```

### Configuration Alternative (docker-compose-alt.yml)
```
Internet:   10.100.0.0/24
DMZ:        10.101.0.0/24
Internal:   10.102.0.0/24
Control:    10.103.0.0/24
Satellite:  10.104.0.0/24
```

**Note importante:** Les adresses IP sont différentes, mais le scénario reste identique. Les étudiants devront simplement utiliser les nouvelles adresses IP dans leurs commandes.

---

## 🆘 Dernier recours: Reset complet Docker

Si rien ne fonctionne:

```bash
# ATTENTION: Cela supprimera TOUS vos conteneurs et réseaux Docker!

# Arrêter tous les conteneurs
docker stop $(docker ps -aq)

# Supprimer tous les conteneurs
docker rm $(docker ps -aq)

# Supprimer tous les réseaux
docker network prune -f

# Supprimer toutes les images (optionnel)
docker image prune -a -f

# Rebuild Operation Nightfire
cd operation-nightfire
docker-compose up -d --build
```

---

## 📞 Besoin d'aide?

Si vous êtes toujours bloqué:

1. **Collectez les informations:**
   ```bash
   docker network ls > networks.txt
   docker ps -a > containers.txt
   docker-compose logs > logs.txt
   ```

2. **Partagez ces fichiers** avec l'équipe de support pédagogique

3. **Incluez le message d'erreur complet** de `docker-compose up`

---

## ✨ TL;DR (Solution rapide)

```bash
# Nettoyer les réseaux
./cleanup-networks.sh

# Rebuild
docker-compose down -v
docker-compose up -d --build
```

**Si ça ne marche pas:**
```bash
# Utiliser la version alternative
mv docker-compose.yml docker-compose.yml.original
cp docker-compose-alt.yml docker-compose.yml
cp router/firewall-rules-alt.sh router/firewall-rules.sh
docker-compose up -d --build
```

🚀 **Ça devrait résoudre le problème!**
