cd createCSV

mongo localhost:27017/etenders create_agencies_csv.js
mongo localhost:27017/etenders create_contractors_csv.js
mongo localhost:27017/etenders create_contracts_csv.js
mongo localhost:27017/etenders create_goods_csv.js
mongo localhost:27017/etenders create_tender_csv.js

mongoexport -d etenders -c tmp_agencies_summary --type=csv --fields name,address,email,phone,url --out /home/moldova-ocds/demo/current/public/csv/agencies_csv.csv
mongoexport -d etenders -c tmp_contractors_summary --type=csv --fields name,scheme --out /home/moldova-ocds/demo/current/public/csv/contractors_csv.csv
mongoexport -d etenders -c tmp_contracts_summary --type=csv --fields id,title,description,status,tenderID,tenderTitle,goods,goodsCPV,contractorID,contractor,procuringAgencyID,procuringAgency,contractStartDate,contractEndDate,amount --out /home/moldova-ocds/demo/current/public/csv/contracts_csv.csv
mongoexport -d etenders -c tmp_goods_summary --type=csv --fields id,goods_and_services,scheme,cpv_code --out /home/moldova-ocds/demo/current/public/csv/goods_csv.csv
mongoexport -d etenders -c tmp_tenders_summary --type=csv --fields tender_id,title,description,procuringEntity,status,procurementMethod,tender_start_date,tender_end_date --out /home/moldova-ocds/demo/current/public/csv/tenders_csv.csv

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