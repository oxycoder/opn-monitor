#!/bin/sh

pw adduser promtail -d /nonexistent -s /usr/sbin/nologin -c "promtail user"

cp /usr/local/opnsense/scripts/OmsVN/Promtail/promtail /usr/local/etc/rc.d/
chmod +x /usr/local/etc/rc.d/promtail

mkdir -p /var/log/promtail
chown -R promtail:promtail /var/log/promtail
chmod 750 /var/log/promtail