FROM debian:12-slim

RUN apt-get update && apt-get install -y \
    openssh-server \
    vim \
    curl \
    iputils-ping \
    net-tools \
    && rm -rf /var/lib/apt/lists/*

# Configuration SSH
RUN mkdir /var/run/sshd
RUN echo 'PermitRootLogin yes' >> /etc/ssh/sshd_config

# Créer l'utilisateur product_owner
RUN useradd -m -s /bin/bash product_owner
RUN echo 'product_owner:P0wner!2024' | chpasswd

EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
