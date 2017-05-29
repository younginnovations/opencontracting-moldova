# -*- coding: utf-8 -*-
import time
start_time = time.time()

import datetime
import pymongo
import xlrd
from dbconfig import *

def getVal(val):
    if isinstance(val, datetime.date):
        return val
    if val is None:
        return ""
    if isinstance(val, (int, long, float, complex)):
        return val
    return val.encode("utf-8")

def prepCompanyJson(companyVals):
    return {
        "id": companyVals[0],
        "registration_date": companyVals[1],
        "name": companyVals[2],
        "legalform": companyVals[3],
        "address": companyVals[4],
        "director": companyVals[5].split(","),
        "founders": str(companyVals[6]).split(","),
        "unauthorised": str(companyVals[7]).split(","),
        "licenced": str(companyVals[8]).split(","),
        "status": companyVals[9]
    }

def getCompanyExcelSheet(xlfile):
    xl_workbook = xlrd.open_workbook(xlfile)
    sheet_names = xl_workbook.sheet_names()
    xl_sheet = xl_workbook.sheet_by_name("RSUD")
    return xl_sheet

def insertExcelSheetDataRow(xl_sheet, companies_detail_coll):
    companies_detail_coll.remove({})
    for row in range(1, xl_sheet.nrows):
        vals = getExcelSheetRowValue(xl_sheet, row)
        companies_detail_coll.insert_one(prepCompanyJson(vals))

def getExcelSheetRowValue(xl_sheet, row):
    vals = [getVal(xl_sheet.cell(row, col).value)  for col in xrange(xl_sheet.ncols)]
    return vals

def dumpExcelDataToMongo(xlfile, companies_detail_coll):
    xl_sheet = getCompanyExcelSheet(xlfile)
    print "Xlfile read complete. Looping data for insert"
    insertExcelSheetDataRow(xl_sheet, companies_detail_coll)
    print "Data inserts complete."
    # companies_detail_coll.create_index([("name",pymongo.TEXT)])

xlfile = "../../public/uploads/company.xlsx"
db = getMongoDb()
dumpExcelDataToMongo(xlfile, db.companies_detail)

print("--- %s seconds ---" % (time.time() - start_time))

# mongoexport --db moldova --collection companies_detail --type csv --fields name,cleanname --out company.csv
