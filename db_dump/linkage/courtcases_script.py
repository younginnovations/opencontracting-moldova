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
	print "Processing the court cases collection ..."
	ref_names,clean_names = readsheet.col_values(0)[1:],readsheet.col_values(3)[1:]
	collection = database['court_cases_collection']
	for (c,(reference,clearname)) in enumerate(zip(ref_names,clean_names)):
		
		# works good
		collection.update({'title':{'$regex':clearname.strip(),
							'$options':'i'}},
	   {"$set":{"clear_name":clearname.strip()}})
	print "Writing to the court cases collection ..."
	writesheet = writebook.get_sheet(2)
	for (c,(reference,clearname)) in enumerate(zip(ref_names,clean_names)):
		
		s = collection.find({'title':{'$regex':clearname.strip(),'$options':'i'}})
		if(s.count()!=0):
			listing = ""
			for i in range(s.count())[:5]: listing+=s[i]['title']+","   #the [:5] limit is imposed as I have said, the find query may be satisfied by a large number of documents in the courtcases collection
			listing=listing[:-1] #to remove the final comma character
			writesheet.write(c+1,1,listing)
			writesheet.write(c+1,2,clearname.strip())
			writesheet.write(c+1,4,readsheet.cell(c+1,0).value)
	writebook.save('companies-matches.xls')

def insertClearNames(database,readsheet):
	print "Inserting clear_names ..."
	ref_names,clean_names = readsheet.col_values(1)[1:],readsheet.col_values(2)[1:]
	collection = database['court_cases_collection']
	for (c,(reference,clearname)) in enumerate(zip(ref_names,clean_names)):
		
		if ""!=clearname.encode('utf-8'):
			court_names=reference.split(',')
			for court in court_names:


				# works good
				collection.update({'title':{'$regex':court.strip().replace("&quot;",""),
									'$options':'i'}},
			   {"$set":{"clear_name":clearname.strip()}})
			



try:
	connection = pymongo.MongoClient()
	db = connection['etendersdemo']
except pymongo.errors.ConnectionFailure, e:
	print "Could not connect to MongoDB",e
readsheet,writebook = parsexls(2)	
insertClearNames(db,readsheet)
# processCollections(db,readsheet,writebook)