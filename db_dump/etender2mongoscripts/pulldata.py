#!/usr/bin/env python

import os
import requests
import myconfig

from datetime import datetime
from dateutil.relativedelta import relativedelta

def makeFolder(folder):
    if not os.path.isdir(folder):
        os.makedirs(folder)

def saveJson(folder, content, page):
    makeFolder(folder)
    filepath = os.path.join(folder, str(page) + '.json')
    with open(filepath, 'w') as _file:
        _file.write(content);

def pullJson(type, folder):    
    nextMonth = datetime.strptime(os.environ["import_start_date"], '%Y-%m-%d')
    endMonth = datetime.today()

    while(nextMonth <= endMonth):
        url = 'http://etender.gov.md/json/'+nextMonth.strftime('%Y/%m')+"/"+type
        print "requesting ", url
        r = requests.post(url);
        saveJson(folder, r.content, nextMonth.strftime('%Y-%m'))
        totalPage = r.json().get("total")
        nextMonth = nextMonth + relativedelta(months=1)

if __name__ == "__main__":
    pullJson("contractList", os.path.join(myconfig.jsonfolder,"contracts"))
    pullJson("budgetList", os.path.join(myconfig.jsonfolder,"announcements"))
    pullJson("tenderList", os.path.join(myconfig.jsonfolder,"tenders"))
    pullJson("statistics", os.path.join(myconfig.jsonfolder,"statistics"))
