FROM debian:12-slim

RUN apt-get update && apt-get install -y \
    samba \
    openssh-server \
    vim \
    curl \
    iputils-ping \
    iproute2 \
    net-tools \
    && rm -rf /var/lib/apt/lists/*

# Configuration SSH
RUN mkdir /var/run/sshd
RUN echo 'PermitRootLogin yes' >> /etc/ssh/sshd_config

# Créer l'utilisateur fileadmin
RUN useradd -m -s /bin/bash fileadmin
RUN mkdir -p /home/fileadmin/.ssh
COPY authorized_keys /home/fileadmin/.ssh/
RUN chown -R fileadmin:fileadmin /home/fileadmin/.ssh
RUN chmod 700 /home/fileadmin/.ssh
RUN chmod 600 /home/fileadmin/.ssh/authorized_keys

# Créer l'utilisateur developer avec mot de passe
RUN useradd -m -s /bin/bash developer
RUN echo 'developer:D3v2024!Secure' | chpasswd

# Créer la structure de partage Samba
RUN mkdir -p /share/satellite_docs
RUN mkdir -p /share/employee_files/developer
RUN mkdir -p /share/employee_files/product_owner

# Copier les fichiers de documentation
COPY share/ /share/
RUN chown -R fileadmin:fileadmin /share

# Configuration Samba
COPY smb.conf /etc/samba/smb.conf

# Mot de passe Samba pour fileadmin
RUN (echo 'F1l3Adm1n2024!'; echo 'F1l3Adm1n2024!') | smbpasswd -a -s fileadmin

EXPOSE 22 139 445

# Script de démarrage
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
