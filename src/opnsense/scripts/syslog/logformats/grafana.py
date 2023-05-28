import json

from . import NewBaseLogFormat

class GrafanaLogFormat(NewBaseLogFormat):
    def __init__(self, filename):
        super().__init__(filename)
        self._priority = 1

    def match(self, line):
        if bool(line and not line.isspace()):
            return json.loads(line)
        
    def get_key(self, key):
        try:
            return self._parts[key]
        except:
            return None
    
    def set_line(self, line):
        super().set_line(line)
        self._parts = json.loads(self._line)

    @property
    def timestamp(self):
        return self.get_key('t')

    @property
    def line(self):
        msg = self.get_key('msg')
        err = self.get_key('error')
        reason = self.get_key('reason')
        if err is not None:
            msg += ". Error: " + err
        if reason is not None:
            msg += ". Reason: " + reason
        return msg
    
    @property
    def process_name(self):
        return self.get_key('logger')

    @property
    def severity(self):
        level = self.get_key('level')
        if level == "info":
            return 6
        if level == "debug":
            return 7
        if level == "warn":
            return 4
        if level == "critical":
            return 2
        if level == "error":
            return 3
        return None

    @property
    def pid(self):
        return "grafana"
        
