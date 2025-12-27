#!/bin/bash

# Flush existing rules
iptables -F
iptables -X
iptables -t nat -F

# Default policies
iptables -P FORWARD DROP
iptables -P INPUT DROP
iptables -P OUTPUT ACCEPT

# ===== DMZ to INTERNET =====
iptables -A FORWARD -i eth0 -o eth1 -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A FORWARD -i eth1 -o eth0 -j ACCEPT

# ===== DMZ to INTERNAL =====
# Allow only from specific IPs (intranet can receive from DMZ)
iptables -A FORWARD -s 10.10.1.15 -d 10.10.2.0/24 -j ACCEPT
iptables -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT

# ===== INTERNAL to CONTROL =====
# Only workstation-01 can access control network
iptables -A FORWARD -s 10.10.2.30 -d 10.10.3.0/24 -j ACCEPT
iptables -A FORWARD -s 10.10.3.0/24 -d 10.10.2.30 -m state --state ESTABLISHED,RELATED -j ACCEPT

# Log dropped packets
iptables -A FORWARD -j LOG --log-prefix "FW-DROP: "

# Keep container running
tail -f /dev/null
