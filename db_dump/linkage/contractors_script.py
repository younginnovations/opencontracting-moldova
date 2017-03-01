# -*- coding: utf-8 -*- 
import pymongo
import xlrd
from xlutils.copy import copy 

def parsexls(sheet_no):
	book = xlrd.open_workbook('companies-matches.xls')
	writablebook = copy(book)
	sheet = book.sheet_by_index(sheet_no)
	return sheet,writablebook

def readCollections(database,readsheet,writebook):
	print "Processing the contractor collection ..."
	ref_names,clean_names = readsheet.col_values(1)[1:],readsheet.col_values(2)[1:]
	collection = database['contractors']
	for (reference,clearname) in zip(ref_names,clean_names):
		collection.update({"full_name":reference},
								{"$set":{"clearName":clearname.strip()}},
								multi=True) #a instance may appear where the condition for update is satisfied by multiple documents. the multi flag ensures that all documents are updated not just the first document
try:
	connection = pymongo.MongoClient()
	db = connection['etenders']
except pymongo.errors.ConnectionFailure, e:
	print "Could not connect to MongoDB",e
readsheet,writebook = parsexls(0)	#sheet no that contains the contractors dataset
readCollections(db,readsheet,writebook)