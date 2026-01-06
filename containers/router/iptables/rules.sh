#!/bin/bash
set -e

# TESTING ALL OPEN
# Politiques par défaut
iptables -P FORWARD ACCEPT
iptables -P INPUT ACCEPT
iptables -P OUTPUT ACCEPT

## =========================
## Paramètres (à adapter)
## =========================
#INTERNET_NET="10.10.0.0/24"
#DMZ_NET="10.10.1.0/24"
#INTERNAL_NET="10.10.2.0/24"
#CONTROL_NET="10.10.3.0/24"
#SATELLITE_NET="10.10.4.0/24"
#
#DB_SERVER_IP="10.10.1.15"
#FILE_SERVER_IP="10.10.2.20"
#
#WORKSTATION1_IP="10.10.2.30"
#CONTROL_STATION_IP="10.10.3.10"
#
#SATELLITE_IP="10.10.4.10"
#
## =========================
## Remise à zéro
## =========================
#iptables -F
#iptables -X
#iptables -t nat -F
#
## Politiques par défaut
#iptables -P FORWARD DROP
#iptables -P INPUT DROP
#iptables -P OUTPUT ACCEPT
#
## Autoriser le trafic de retour
#iptables -A FORWARD -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT
#
## =========================
## Règles demandées (ciblage IP/subnet)
## =========================
#
## 1) Internet -> DMZ : 80, 443 uniquement
#iptables -A FORWARD -p tcp -s "${INTERNET_NET}" -d "${DMZ_NET}" -m conntrack --ctstate NEW --dport 80 -j ACCEPT
#iptables -A FORWARD -p tcp -s "${INTERNET_NET}" -d "${DMZ_NET}" -m conntrack --ctstate NEW --dport 443 -j ACCEPT
#
## 2) DMZ -> Internal : SSH (22) uniquement depuis db-server -> file-server
#iptables -A FORWARD -p tcp -s "${DB_SERVER_IP}" -d "${FILE_SERVER_IP}" -m conntrack --ctstate NEW --dport 22 -j ACCEPT
#
## 3) Internal -> Control : SSH (22) uniquement depuis workstation1 -> control-station
#iptables -A FORWARD -p tcp -s "${WORKSTATION1_IP}" -d "${CONTROL_STATION_IP}" -m conntrack --ctstate NEW --dport 22 -j ACCEPT
#
## 4) Control -> Satellite : SSH custom (8976) uniquement depuis control-station -> satellite
#iptables -A FORWARD -p tcp -s "${CONTROL_STATION_IP}" -d "${SATELLITE_IP}" -m conntrack --ctstate NEW --dport 8976 -j ACCEPT
#
## Log des paquets rejetés (limité)
#iptables -A FORWARD -m limit --limit 10/min --limit-burst 20 -j LOG --log-prefix "FW-DROP: "
#

echo "[router test Mode] Firewall rules loaded."

# Garder le conteneur en vie
tail -f /dev/null

