FROM debian:12

RUN apt-get update && apt-get install -y \
    openssh-server \
    vim \
    git \
    python3 \
    curl \
    iputils-ping \
    iproute2 \
    net-tools \
    smbclient \
    && rm -rf /var/lib/apt/lists/*

# Configuration SSH
RUN mkdir /var/run/sshd
RUN echo 'PermitRootLogin yes' >> /etc/ssh/sshd_config

# Créer l'utilisateur developer
RUN useradd -m -s /bin/bash developer
RUN echo 'developer:D3v2024!Secure' | chpasswd

# Ajouter des notes pour l'utilisateur
RUN mkdir -p /home/developer/notes
COPY notes/ /home/developer/notes/
COPY FLAG.txt /home/developer/FLAG.txt
RUN chown -R developer:developer /home/developer

# Créer une clé SSH pour accéder à la Control Station
RUN mkdir -p /home/developer/.ssh
COPY ssh_keys/ /home/developer/.ssh/
RUN chown -R developer:developer /home/developer/.ssh
RUN chmod 700 /home/developer/.ssh
RUN chmod 600 /home/developer/.ssh/* 2>/dev/null || true

EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
