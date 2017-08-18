import pymongo
import os
import json
import myconfig

dbEtenders = myconfig.getMongoDb()

tender_items_collection = dbEtenders.tender_items_collection

tender_items_collection.remove({})

def dumpJsonFileToDatabase(jsonfile, collection):
    if(os.path.isfile(jsonfile)):
        with open(jsonfile) as _file:
            data = json.load(_file)
            count = 0
            while(count < len(data["rows"])):
                collection.insert_one(data["rows"][count])
                count += 1

def dumpAllJsonFiles(jsonfolder, collection):
    print "dumping json from " + jsonfolder
    for jsonfile in os.listdir(jsonfolder):
        if os.path.isfile(jsonfolder + os.sep + jsonfile):
            dumpJsonFileToDatabase(jsonfolder + os.sep + jsonfile, collection)

dumpAllJsonFiles(os.path.join(myconfig.jsonfolder,"tenderitems"), tender_items_collection)