import json

from . import NewBaseLogFormat

def is_not_blank(s):
    return bool(s and not s.isspace())

class GrafanaLogFormat(NewBaseLogFormat):
    def __init__(self, filename):
        super().__init__(filename)
        self._priority = 100

    def match(self, line):
        try:
            if is_not_blank(line):
                return json.loads(line)
            return False
        except:
            return False

    @property
    def timestamp(self):
        tmp = json.loads(self._line)
        return tmp['t']

    @property
    def line(self):
        tmp = json.loads(self._line)
        msg = tmp['msg']
        if 'error' in tmp:
            msg += "\nError:" + tmp['error']
        if 'reason' in tmp:
            msg += "\nReason:" + tmp['reason']
        return msg
    
    @property
    def process_name(self):
        tmp = json.loads(self._line)
        return tmp['logger']

    @property
    def severity(self):
        tmp = json.loads(self._line)
        level = tmp['level']
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
        
