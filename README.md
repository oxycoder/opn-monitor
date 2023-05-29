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
rsync -av ./src/ root@opnsenseIP:/usr/local/
```

## Example configuration for promtail scrape configs
```
scrape_configs:
- job_name: syslog
  syslog:
    listen_address: 0.0.0.0:1514
    idle_timeout: 60s
    listen_protocol: tcp
    label_structured_data: yes
    use_rfc5424_message: true
    labels:
      job: "syslog"

  pipeline_stages:
  - match:
      selector: '{host="OPNsense.localdomain"}'
      stages:
      - regex:
          expression: '^(?P<rule_number>[\d]+),(?P<sub_rule_number>[\d]*),(?P<anchor>[\d]*),(?P<tracker>[\d]*),(?P<interface>[\w\d]*),(?P<reason>[\w]*),(?P<action>[\w]*),(?P<direction>[\w]*),(?P<ip_version>[\d]*),[x\da-f]*,[x\da-f]*,(?P<packet_ttl>[\d]*),(?P<packet_id>[\d]*),(?P<fragment_offset>[\w]*),(?P<ip_flags>.*?),(?P<protocol_id>[\d]*),(?P<protocol_name>[\w]*),(?P<source_port>[\d]*),(?P<source_ip>[\d.]*),(?P<dest_ip>[\d.]*),(?P<dest_port>[\d]*),'

      - labels:
          interface:
          action:
          direction:
          protocol_name:
          source_ip:
          source_port:
          dest_ip:
          dest_port:
```