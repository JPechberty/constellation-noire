FROM alpine:latest

RUN apk add --no-cache iptables iproute2 bash

COPY iptables/rules.sh /etc/iptables/rules.sh
RUN chmod +x /etc/iptables/rules.sh

CMD ["/etc/iptables/rules.sh"]