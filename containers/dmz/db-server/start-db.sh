#!/bin/bash

echo "Démarrage du serveur DB avec SSH..."

# Démarrer SSH en arrière-plan
/usr/sbin/sshd

# Démarrer MariaDB (script original de l'image)
exec docker-entrypoint.sh mysqld
