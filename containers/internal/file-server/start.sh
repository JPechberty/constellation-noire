#!/bin/bash

echo "Démarrage du File Server..."

# Démarrer SSH
service ssh start

# Démarrer Samba
smbd -D
nmbd -D

echo "File Server opérationnel!"
echo "SSH: Port 22"
echo "Samba: Ports 139/445"

# Garder le conteneur actif
#tail -f /dev/null
