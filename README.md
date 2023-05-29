Custom opnsense plugin bring support for Grafana, Loki and Promtail.

## Demos

More can be found here: [demos](https://github.com/oxycoder/opn-repo/blob/main/images)

![grafana](https://github.com/oxycoder/opn-repo/blob/main/images/grafana-general.png?raw=true)
![loki](https://github.com/oxycoder/opn-repo/blob/main/images/loki-general.png?raw=true)
![promtail](https://github.com/oxycoder/opn-repo/blob/main/images/promtail-general.png?raw=true)

## List of plugins
* Grafana
* Loki
* Promtail


## Install plugin
```
rsync -av ./src/ root@opnsenseIP:/usr/local/
```

## Install grafana, loki, promtail (build form source)

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
By default, sysutils/loki package only create loki rc.d service, so you may need to run (as root) setup script to create promtail rc.d service
```
/usr/local/opnsense/scripts/OmsVN/Promtail/setup.sh
```

4. Enable services:

```
service grafana enable
service loki enable
service promtail enable
```


## Example configuration for promtail scrape configs
```
scrape_configs:
- job_name: system
  static_configs:
  - targets:
      - localhost
    labels:
      job: systemd
      __path__: /var/log/system/*.log
  - targets:
      - localhost
    labels:
      job: configd
      __path__: /var/log/configd/*.log
  - targets:
      - localhost
    labels:
      job: audit
      __path__: /var/log/audit/*.log
  - targets:
      - localhost
    labels:
      job: boot
      __path__: /var/log/boot.log/*.log
  - targets:
      - localhost
    labels:
      job: dhcp
      __path__: /var/log/dhcp/*.log        
  - targets:
      - localhost
    labels:
      job: lighttpd
      __path__: /var/log/lighttpd/*.log
  - targets:
      - localhost
    labels:
      job: ntp
      __path__: /var/log/ntp/*.log
  - targets:
      - localhost
    labels:
      job: pkg
      __path__: /var/log/pkg/*.log
  - targets:
      - localhost
    labels:
      job: routing
      __path__: /var/log/routing.log/*.log
  - targets:
      - localhost
    labels:
      job: squid
      __path__: /var/log/squid/*.log        
  - targets:
      - localhost
    labels:
      job: suricata
      __path__: /var/log/suricata/*.log

  - targets:
      - localhost
    labels:
      job: userlog
      __path__: /var/log/userlog/*.log
  - targets:
      - localhost
    labels:
      job: resolver
      __path__: /var/log/resolver/*.log
  - targets:
      - localhost
    labels:
      job: flowd
      __path__: /var/log/flowd.log*
- job_name: packet_filter_log
  static_configs:
  - targets:
      - localhost
    labels:
      job: packet_filter_log
      __path__: /var/log/filter/*.log
  pipeline_stages:
  - regex:
      expression: '^(?P<rule_number>[\d]+),(?P<sub_rule_number>[\d]*),(?P<anchor>[\d]*),(?P<tracker>[\w\d]*),(?P<interface>[\w\d]*),(?P<reason>[\w]*),(?P<action>[\w]*),(?P<direction>[\w]*),(?P<ip_version>[\d]*),[x\da-f]*,[x\da-f]*,(?P<packet_ttl>[\d]*),(?P<packet_id>[\d]*),(?P<fragment_offset>[\w]*),(?P<ip_flags>.*?),(?P<protocol_id>[\d]*),(?P<protocol_name>[\w]*),(?P<source_port>[\d]*),(?P<source_ip>[\d.]*),(?P<dest_ip>[\d.]*),(?P<dest_port>[\d]*),'
  - labels:
      interface:
      action:
      direction:
      protocol_name:
      source_ip:
      source_port:
      dest_ip:
      dest_port:
  - geoip:
      db: "/usr/local/etc/maxmind/GeoLite2-City.mmdb"
      source: source_ip
      db_type: "city"
```