cd createCSV

mongo localhost:27017/$DATABASE create_agencies_csv.js
mongo localhost:27017/$DATABASE create_contractors_csv.js
mongo localhost:27017/$DATABASE create_contracts_csv.js
mongo localhost:27017/$DATABASE create_goods_csv.js
mongo localhost:27017/$DATABASE create_tender_csv.js

mongoexport -d $DATABASE -c tmp_agencies_summary --type=csv --fields name,address,email,phone,url --out $PUBLIC_PATH/csv/agencies_csv.csv
mongoexport -d $DATABASE -c tmp_contractors_summary --type=csv --fields name,scheme --out $PUBLIC_PATH/csv/contractors_csv.csv
mongoexport -d $DATABASE -c tmp_contracts_summary --type=csv --fields ocid,id,title,description,status,period/startDate,period/endDate,value/amount,value/currency,dateSigned,items/description,items/id,procuringEntity/name,procuringEntity/id,suppliers/name,suppliers/id --out $PUBLIC_PATH/csv/contracts_csv.csv
mongoexport -d $DATABASE -c tmp_goods_summary --type=csv --fields id,goods_and_services,scheme,cpv_code --out $PUBLIC_PATH/csv/goods_csv.csv
mongoexport -d $DATABASE -c tmp_tenders_summary --type=csv --fields ocid,id,title,description,status,procurementMethod,tenderPeriod/startDate,tenderPeriod/endDate,procuringEntity/name,procuringEntity/id --out $PUBLIC_PATH/csv/tenders_csv.csv

#mongoexport -d etenders -c tmp_agencies_summary --type=csv --fields name,address,email,phone,url --out /Users/yipl/Projects/opencontracting-moldova/db_dump/csv/agencies_csv.csv
#mongoexport -d etenders -c tmp_contractors_summary --type=csv --fields name,scheme --out /Users/yipl/Projects/opencontracting-moldova/db_dump/csv/contractors_csv.csv
#mongoexport -d etenders -c tmp_contracts_summary --type=csv --fields id,title,description,status,tenderID,tenderTitle,goods,goodsCPV,contractorID,contractor,procuringAgencyID,procuringAgency,contractStartDate,contractEndDate,amount --out /Users/yipl/Projects/opencontracting-moldova/db_dump/csv/contracts_csv.csv
#mongoexport -d etenders -c tmp_goods_summary --type=csv --fields id,goods_and_services,scheme,cpv_code --out /Users/yipl/Projects/opencontracting-moldova/db_dump/csv/goods_csv.csv
#mongoexport -d etenders -c tmp_tenders_summary --type=csv --fields tender_id,title,description,procuringEntity,status,procurementMethod,tender_start_date,tender_end_date --out /Users/yipl/Projects/opencontracting-moldova/db_dump/csv/tenders_csv.csv

 #db.tmp_agencies_summary.drop()
 #db.tmp_contractors_summary.drop()
 #db.tmp_contracts_summary.drop()
 #db.tmp_goods_summary.drop()
 #db.tmp_tenders_summary.drop()