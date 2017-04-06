import os
import requests
import myconfig

def makeFolder(folder):
    if not os.path.isdir(folder):
        os.makedirs(folder)

def saveJson(folder, content, page):
    makeFolder(folder)
    filepath = os.path.join(folder, str(page) + '.json')
    with open(filepath, 'w') as _file:
        _file.write(content);

def pullJson(url, folder):    
    totalPage = 1
    nextPage = 1
    while(nextPage == 1 or nextPage <= totalPage):
        print "requesting ", url
        r = requests.post(url, data = {"rows": 200, "page": nextPage});
        saveJson(folder, r.content, nextPage)
        totalPage = r.json().get("total")
        nextPage += 1

if __name__ == "__main__":
    # pull all contracts data
    pullJson("http://etender.gov.md/json/contractList", os.path.join(myconfig.jsonfolder,"contracts"))
    pullJson("http://etender.gov.md/json/intentionAnounceList", os.path.join(myconfig.jsonfolder,"announcements"))
    pullJson("http://etender.gov.md/json/tenderList", os.path.join(myconfig.jsonfolder,"tenders"))