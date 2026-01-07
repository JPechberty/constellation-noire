#!/bin/bash
# Script exécuté au démarrage du conteneur pour placer le flag
cp /FLAG.txt /home/dbadmin/FLAG.txt
chown dbadmin:dbadmin /home/dbadmin/FLAG.txt
chmod 644 /home/dbadmin/FLAG.txt
