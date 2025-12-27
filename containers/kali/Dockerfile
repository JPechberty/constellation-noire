FROM kalilinux/kali-rolling:latest

RUN apt-get update && apt-get install -y \
    openssh-server \
    nano \
    dnsutils \
    iputils-ping \
    nmap \
    netcat-traditional \
    gobuster \
    smbclient \
    nfs-common \
    postgresql-client \
    python3-pip \
    sqlmap \
    curl \
    wget \
    git \
    vim \
    hydra \
    john \
    metasploit-framework \
    iproute2 \
    # Interface graphique et RDP \
    kali-desktop-xfce \
    xrdp \
    dbus-x11 \
    firefox-esr \
    keyboard-configuration \
    console-setup \
    && rm -rf /var/lib/apt/lists/*

# Configure SSH
RUN echo 'root:kali' | chpasswd
RUN useradd -m -s /bin/bash student && echo 'student:student' | chpasswd
RUN usermod -aG sudo student

RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config

# Configure clavier AZERTY (fr)
#RUN echo 'XKBMODEL="pc105"' > /etc/default/keyboard && \
#    echo 'XKBLAYOUT="fr"' >> /etc/default/keyboard && \
#    echo 'XKBVARIANT=""' >> /etc/default/keyboard && \
#    echo 'XKBOPTIONS=""' >> /etc/default/keyboard && \
#    echo 'BACKSPACE="guess"' >> /etc/default/keyboard

# Configure locale FR
RUN sed -i 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen && \
    locale-gen fr_FR.UTF-8 && \
    update-locale LANG=fr_FR.UTF-8

ENV LANG=fr_FR.UTF-8
ENV LANGUAGE=fr_FR:fr
ENV LC_ALL=fr_FR.UTF-8

# Configure xRDP
RUN sed -i 's/port=3389/port=3389/g' /etc/xrdp/xrdp.ini
RUN sed -i 's/max_bpp=32/max_bpp=24/g' /etc/xrdp/xrdp.ini
RUN adduser xrdp ssl-cert

# Configuration de la session XFCE pour xRDP avec clavier FR
RUN rm -f /etc/xrdp/startwm.sh && \
    echo '#!/bin/sh' > /etc/xrdp/startwm.sh && \
    echo 'if [ -r /etc/default/locale ]; then' >> /etc/xrdp/startwm.sh && \
    echo '  . /etc/default/locale' >> /etc/xrdp/startwm.sh && \
    echo '  export LANG LANGUAGE LC_ALL' >> /etc/xrdp/startwm.sh && \
    echo 'fi' >> /etc/xrdp/startwm.sh && \
    echo 'setxkbmap fr -variant mac' >> /etc/xrdp/startwm.sh && \
    echo 'startxfce4' >> /etc/xrdp/startwm.sh && \
    chmod +x /etc/xrdp/startwm.sh

# Créer un script de démarrage XFCE pour l'utilisateur student
RUN mkdir -p /home/student/.config/autostart && \
    echo '[Desktop Entry]' > /home/student/.config/autostart/keyboard.desktop && \
    echo 'Type=Application' >> /home/student/.config/autostart/keyboard.desktop && \
    echo 'Name=Keyboard Layout' >> /home/student/.config/autostart/keyboard.desktop && \
    echo 'Exec=setxkbmap fr -variant mac' >> /home/student/.config/autostart/keyboard.desktop && \
    echo 'Hidden=false' >> /home/student/.config/autostart/keyboard.desktop && \
    chown -R student:student /home/student/.config

# Create working directories
RUN mkdir -p /root/tools /root/loot /root/notes
RUN touch /var/log/auth.log

EXPOSE 22 3389

# Script de démarrage
RUN echo '#!/bin/bash' > /start.sh && \
    echo 'service ssh start' >> /start.sh && \
    echo 'service xrdp start' >> /start.sh && \
    echo 'tail -f /var/log/auth.log' >> /start.sh && \
    chmod +x /start.sh

CMD ["/start.sh"]