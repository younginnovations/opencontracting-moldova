# -*- coding: utf-8 -*- 
import pymongo
import xlrd
from xlutils.copy import copy 

def parsexls(sheet_no):
	book = xlrd.open_workbook('companies-matches.xls')
	writablebook = copy(book)
	sheet = book.sheet_by_index(sheet_no)
	return sheet,writablebook

def processCollections(database,readsheet,writebook):
	print "Processing the blacklist collection ..."
	ref_names,clean_names = readsheet.col_values(0)[1:],readsheet.col_values(3)[1:]
	collection = database['blacklist_collection']
	for (reference,clearname) in zip(ref_names,clean_names):
		collection.update({'organizationName':{'$regex':clearname.strip(), #checks if the string pattern clearname appears in the organizationName
												'$options':'i'}}, #strip removes the trailing and preceeding spaces
						   {"$set":{"clear_name":clearname.strip()}})

	print "Writing to the blacklist collection ..."
	writesheet = writebook.get_sheet(1)
	for (c,(reference,clearname)) in enumerate(zip(ref_names,clean_names)):
		s = collection.find({'organizationName':{'$regex':clearname.strip(),'$options':'i'}})
		for i in range(s.count()): 
			writesheet.write(c+1,1,s[i]['organizationName']+",")   #
			writesheet.write(c+1,2,clearname.strip())			   # Write block to write to the blacklist dataset
			writesheet.write(c+1,4,readsheet.cell(c+1,0).value)	   #
	writebook.save('companies-matches.xls')

try:
	connection = pymongo.MongoClient()
	db = connection['etenders']
except pymongo.errors.ConnectionFailure, e:
	print "Could not connect to MongoDB",e
readsheet,writebook = parsexls(1)	#sheet no for the blacklist dataset
processCollections(db,readsheet,writebook)