import re

from . import NewBaseLogFormat

loki_format = r'^level=(.+?)\sts=(.+?)\scaller=(.+)msg=(.+)'

class LokiLogFormat(NewBaseLogFormat):
    def __init__(self, filename):
        super().__init__(filename)
        self._priority = 200

    def match(self, line):
        # need to check file name here otherwise it will fallback to another LogFormater
        # weird thing happen in FormatContainer.get_format that take first line match base on piority.
        return self._filename.find('loki') > -1 and re.match(loki_format, line) is not None
    
    def set_line(self, line):
        super().set_line(line)
        self._parts = re.match(loki_format, self._line)
    
    def get_key(self, key):
        try:
            return self._parts.group(key)
        except:
            return None

    @property
    def timestamp(self):
        return self.get_key(2)

    @property
    def line(self):
        return self.get_key(4)
    
    @property
    def process_name(self):
        return self.get_key(3)

    @property
    def severity(self):
        level = self.get_key(1)
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
