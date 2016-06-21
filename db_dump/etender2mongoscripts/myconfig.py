import pymongo
import os

jsonfolder = os.path.join(os.path.dirname(os.path.abspath(__file__)), "../data")

def getMongoDb():
    client = pymongo.MongoClient('localhost', 27017)
    return client.etenders_stage
