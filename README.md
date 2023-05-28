# opn-repo
Custom opensense repository

# List of packages
* Grafana
* Loki
* Promtail

# Prerequires

1. Enable ports 
```
opnsense-code tools ports src
```

2. Install grafana
```
cd /usr/ports/www/grafana9/ && make install clean
```

3. Install loki & promtail
```
cd /usr/ports/sysutils/loki/ && make install clean
```

4. Enable services:

```
sysrc grafana_enable=YES
sysrc loki_enable=YES
sysrc promtail_enable=YES
```

# Install plugin
```
rsync -a ./src/ root@opnsenseIP:/usr/local/
```