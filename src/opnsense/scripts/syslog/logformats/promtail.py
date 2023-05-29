import json

from . import NewBaseLogFormat

class PromtailLogFormat(NewBaseLogFormat):
    def __init__(self, filename):
        super().__init__(filename)
        self._priority = 200

    def match(self, line):
        # need to check file name here otherwise it will fallback to another LogFormater
        # weird thing happen in FormatContainer.get_format that take first line match base on piority.
        if self._filename.find('promtail') == -1:
            return None
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
        return self.get_key('ts')

    @property
    def line(self):
        msg = self.get_key('msg')
        err = self.get_key('err')
        reason = self.get_key('reason')
        if err is not None:
            msg += ". Error: " + err
        if reason is not None:
            msg += ". Reason: " + reason
        return msg
    
    @property
    def process_name(self):
        self.get_key('caller')

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
        return "promtail"
        
