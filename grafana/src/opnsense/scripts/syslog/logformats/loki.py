import re

from . import NewBaseLogFormat

loki_format = r'^level=(.+?)\sts=(.+?)\scaller=(.+)msg=(.+)'

class LokiLogFormat(NewBaseLogFormat):
    def __init__(self, filename):
        super().__init__(filename)
        self._priority = 100

    def match(self, line):
        return self._filename.find('loki') > -1 and re.match(loki_format, line) is not None

    @property
    def timestamp(self):
        tmp = re.match(loki_format, self._line)
        return tmp.group(2)

    @property
    def line(self):
        tmp = re.match(loki_format, self._line)
        return tmp.group(4).strip()
    
    @property
    def process_name(self):
        tmp = re.match(loki_format, self._line)
        return tmp.group(3)

    @property
    def severity(self):
        tmp = re.match(loki_format, self._line)
        level = tmp.group(1)
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
        return "loki"
        
