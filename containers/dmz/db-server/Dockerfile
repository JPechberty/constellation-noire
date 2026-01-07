FROM mariadb:11

COPY init-db.sql /docker-entrypoint-initdb.d/
COPY .ssh/ /root/.ssh/
RUN chmod 700 /root/.ssh && chmod 600 /root/.ssh/id_rsa 2>/dev/null || true

RUN apt-get update && apt-get install -y \
    openssh-server \
    openssh-client \
    iputils-ping \
    iproute2 \
    net-tools \
    && rm -rf /var/lib/apt/lists/*

# Configuration SSH
RUN mkdir -p /run/sshd
RUN echo 'PermitRootLogin yes' >> /etc/ssh/sshd_config
RUN echo 'PasswordAuthentication yes' >> /etc/ssh/sshd_config

# Créer un utilisateur dbadmin pour l'accès SSH
RUN useradd -m -s /bin/bash dbadmin
RUN echo 'dbadmin:DbAdm1n2024!' | chpasswd
RUN usermod -aG sudo dbadmin 2>/dev/null || true

# Donner accès à la clé SSH à dbadmin
RUN cp -r /root/.ssh /home/dbadmin/
RUN chown -R dbadmin:dbadmin /home/dbadmin/.ssh

# Placer le FLAG
COPY FLAG.txt /home/dbadmin/FLAG.txt
RUN chown dbadmin:dbadmin /home/dbadmin/FLAG.txt

# Script pour lancer MariaDB et SSH
COPY start-db.sh /start-db.sh
RUN chmod +x /start-db.sh

EXPOSE 3306 22

# CMD ["/start-db.sh"]
