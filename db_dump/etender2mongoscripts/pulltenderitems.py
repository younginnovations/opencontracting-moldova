#!/usr/bin/env python
# -*- coding: utf-8 -*- 
import pymongo
import codecs
import json
import requests
import pulldata
import os

import myconfig

"""
This pulls the tender items from http://etender.gov.md/proceduricard?pid=10395423 

http://etender.gov.md/json/positionList for each tender. Each of the item has extra information like goods quantity and unit measure.

    {
      "id": 10395539,
      "goods": {
        "id": 52668,
        "created": "15.11.2011",
        "endDate": null,
        "mdValue": "Servicii de baze de date",
        "ruValue": "Услуги по базам данных",
        "enValue": "Database services.",
        "code": "72320000-4",
        "parentId": 52650,
        "typeId": 2
      },
      "goodsName": "EBSCO Publishing",
      "quantity": 1.0,
      "unitMeasure": {
        "id": 1,
        "created": "05.12.2008",
        "endDate": null,
        "mdValue": "Bucată",
        "ruValue": "Штука",
        "enValue": null
      },
      "description": "abonament anual la baza carte electronica, asigurarea accesului, deservire sistem, actualizare BD,  pentru rețeaua Bibliotecii municipale",
      "tenderLot": {
        "id": 10395531,
        "seqNumber": 1,
        "name": "baze de date"
      },
      "fkTenderDataId": 10395425
    },

"""

dbEtenders = myconfig.getMongoDb()

url = "http://etender.gov.md/json/positionList"
folder = os.path.join(myconfig.jsonfolder,"tenderitems")
tenders_collection = dbEtenders.tenders_collection
tender_items_collection = dbEtenders.tender_items_collection
for tender_obj in tenders_collection.find():
    _id = tender_obj["tenderData"]["id"]
    tender_items_cursor = tender_items_collection.find({"fkTenderDataId": _id})
    if tender_items_cursor.count():
      print "found _id:", _id
    else:
      r = requests.post(url, data = {"rows": "ALL", "page": 1, "id": _id});
      pulldata.saveJson(folder, r.content, _id)
      tender_items_collection.insert_many(r.json().get("rows"))
      print "Pulling ", _id, " ", r.json().get("records"), " records"
    # break

