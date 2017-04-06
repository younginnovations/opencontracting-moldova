# -*- coding: utf-8 -*- 
import pymongo #Python mongodb driver
import xlrd    #module to read the input xls file
from xlutils.copy import copy  #module@func to prepare a input xls file for insertion

#args: sheet no is in relation to the xls file. 
#copy(book) prepares the xls file for writes
#sheet no is corresponding sheet number where dataset for corresponding table is stored
def parsexls(sheet_no):
	book = xlrd.open_workbook('companies-matches.xls')
	writablebook = copy(book)
	sheet = book.sheet_by_index(sheet_no)
	return sheet,writablebook

def readCollections(database,readsheet,writebook):
	print "Processing the ocds_release collection ..."
	ref_names,clean_names = readsheet.col_values(0)[1:],readsheet.col_values(3)[1:] #reads values from the 1st and 4th columns, but since the first element of both columns contain titles, they are ignored
	collection = database['ocds_release'] #ocds_release is the name of the collection in the database -- in this case fragmented
	dictmap = dict(zip(ref_names,clean_names)) # key/value pairs created from ref_names as keys and clean_names as values{zip turns correponding elements of parameter list into tuples and returns a list of tuples. dict turns the returned tuple list into key/values}
	for (c,(reference,clearname)) in enumerate(zip(dictmap.keys(),dictmap.values())):#enumerate indexes a list
		docs = collection.aggregate([{"$match":{"awards.suppliers.name":reference}}])#one step aggregation pipeline to match all documents which satisfies the mentioned condition
		for doc in docs:
			subdocs = collection.aggregate([
					{"$match":{"_id":doc['_id']}},
					{"$unwind":"$awards"}
				]) # 2 step aggregation pipeline to unwind the awards array for the documents that satisfy the condition in the match operator
			for subdoc in subdocs:
				refer = subdoc['awards']['suppliers'][0]['name'] # accessed only for logging purposes
				try:
					collection.update(
							{"awards.id":subdoc['awards']['id']},
							{"$set":{"awards.$.suppliers.0.clearName":dictmap[refer].strip()}}) # postitional operator returns first document that satisfies the update condition
				except KeyError:
					print refer in ref_names
					continue

try:
	connection = pymongo.MongoClient() 
	db = connection['etenders'] #fragmented is the name of db.
except pymongo.errors.ConnectionFailure, e:
	print "Could not connect to MongoDB",e #check to see if mongod server is running
readsheet,writebook = parsexls(0) #sheet no for the ocds dataset	
readCollections(db,readsheet,writebook)