FROM mariadb:11

COPY init-db.sql /docker-entrypoint-initdb.d/

RUN apt-get update && apt-get install -y \
    openssh-server \
    openssh-client \
    iputils-ping \
    iproute2 \
    net-tools \
    sudo \
    && rm -rf /var/lib/apt/lists/*

# Configuration SSH
RUN mkdir -p /run/sshd
RUN echo 'PermitRootLogin yes' >> /etc/ssh/sshd_config
RUN echo 'PasswordAuthentication yes' >> /etc/ssh/sshd_config

# Créer un utilisateur dbadmin pour l'accès SSH
RUN useradd -m -s /bin/bash dbadmin
RUN echo 'dbadmin:DbAdm1n2024!' | chpasswd
RUN usermod -aG sudo dbadmin

# Configurer les clés SSH pour dbadmin
RUN mkdir -p /home/dbadmin/.ssh
COPY ssh-keys/id_rsa /home/dbadmin/.ssh/id_rsa
COPY ssh-keys/id_rsa.pub /home/dbadmin/.ssh/id_rsa.pub
COPY ssh-keys/config /home/dbadmin/.ssh/config
RUN chmod 700 /home/dbadmin/.ssh && \
    chmod 600 /home/dbadmin/.ssh/id_rsa && \
    chmod 644 /home/dbadmin/.ssh/id_rsa.pub && \
    chmod 600 /home/dbadmin/.ssh/config && \
    chown -R dbadmin:dbadmin /home/dbadmin/.ssh

# Placer le FLAG
COPY FLAG.txt /home/dbadmin/FLAG.txt
RUN chown dbadmin:dbadmin /home/dbadmin/FLAG.txt

# Script pour lancer MariaDB et SSH
COPY start-db.sh /start-db.sh
RUN chmod +x /start-db.sh

EXPOSE 3306 22

# CMD ["/start-db.sh"]


