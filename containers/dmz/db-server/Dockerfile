FROM mariadb:11

COPY init-db.sql /docker-entrypoint-initdb.d/
COPY .ssh/ /root/.ssh/
RUN chmod 700 /root/.ssh && chmod 600 /root/.ssh/id_rsa 2>/dev/null || true

RUN apt-get update && apt-get install -y \
    openssh-client \
    iputils-ping \
    net-tools \
    iproute2 \
    && rm -rf /var/lib/apt/lists/*

EXPOSE 3306
