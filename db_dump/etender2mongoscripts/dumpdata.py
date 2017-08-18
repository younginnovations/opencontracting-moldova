#!/usr/bin/env python

import pymongo
import os
import json
import myconfig

dbEtenders = myconfig.getMongoDb()

contracts_collection = dbEtenders.contracts_collection
tenders_collection = dbEtenders.tenders_collection
announcements_collection = dbEtenders.announcements_collection

contracts_collection.remove({})
tenders_collection.remove({})
announcements_collection.remove({})

def dumpJsonFileToDatabase(jsonfile, collection):
    if(os.path.isfile(jsonfile)):
        with open(jsonfile) as _file:
            data = json.load(_file)
            if(len(data["rows"]) > 0):
                collection.insert_many(data["rows"])

def dumpAllJsonFiles(jsonfolder, collection):
    print "dumping json from " + jsonfolder
    for jsonfile in os.listdir(jsonfolder):
        if os.path.isfile(jsonfolder + os.sep + jsonfile):
            print "dumping ", jsonfile
            dumpJsonFileToDatabase(jsonfolder + os.sep + jsonfile, collection)

dumpAllJsonFiles(os.path.join(myconfig.jsonfolder,"contracts"), contracts_collection)
dumpAllJsonFiles(os.path.join(myconfig.jsonfolder,"announcements"), announcements_collection)
dumpAllJsonFiles(os.path.join(myconfig.jsonfolder,"tenders"), tenders_collection)
