import re
import datetime
from . import NewBaseLogFormat
grafana_timeformat = r'^(\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z).*'


# example raw log
# logger=infra.usagestats t=2023-05-26T16:31:36.731677722Z level=error msg="Failed to get last sent time" error="context canceled"

class GrafanaLogFormat(NewBaseLogFormat):
    def __init__(self, filename):
        super(GrafanaLogFormat, self).__init__(filename)
        self._priority = 100

    def match(self, line):
        return true
        # return self._filename.find('grafana') > -1 and re.match(grafana_timeformat, line) is not  None

    def getProperty(line, propertyName):
        match = re.match(r'^logger=(.+?)\st=(.+?)\slevel=(.+?)\smsg=\"(.+?)\"(?:\serror=\"(.+?)\")?(?:\sservice=(.+?)\s)?(?:[\s]?reason=\"(.+?)\")?', line)
        logger = match.group[1]
        time = match.group[2]
        level = match.group[3]
        msg = match.group[4]
        err = match.group[5]
        svc = match.group[6]
        reason = match.group[7]
        match propertyName:
            case process_name:
                return match.group[1] #logger
            case timestamp:
                return match.group[2]
            case level:
                return match.group[3]

    @property
    def timestamp(line):
        tmp = re.match(grafana_timeformat, line)
        grp = tmp.group(1)
        return datetime.datetime.strptime(grp, "%Y-%m-%dT%H:%M:%SZ").isoformat()

    @property
    def line(line): # return msg log line
        return line[20:].strip()

    @property
    def level(line):
        match = re.match(r'^logger=(.+?)\st=(.+?)\slevel=(.+?)\smsg=\"(.+?)\"(?:\serror=\"(.+?)\")?(?:\sservice=(.+?)\s)?(?:[\s]?reason=\"(.+?)\")?', line)
        logger = match.group[1]
        time = match.group[2]
        level = match.group[3]
        msg = match.group[4]
        err = match.group[5]
        svc = match.group[6]
        reason = match.group[7]
        return msg.strip()
