cd createCSV

mongo localhost:27017/etenders create_agencies_csv.js
mongo localhost:27017/etenders create_contractors_csv.js
mongo localhost:27017/etenders create_contracts_csv.js
mongo localhost:27017/etenders create_goods_csv.js
mongo localhost:27017/etenders create_tender_csv.js

mongoexport -d etenders -c tmp_agencies_summary --type=csv --fields name,address,email,phone,url --out agencies_csv.csv
mongoexport -d etenders -c tmp_contractors_summary --type=csv --fields name,scheme --out contractors_csv.csv
mongoexport -d etenders -c tmp_contracts_summary --type=csv --fields id,title,description,status,goods,contractor,startDate,endDate,amount --out contracts_csv.csv
mongoexport -d etenders -c tmp_goods_summary --type=csv --fields id,goods_and_services,scheme,cpv_code --out goods_csv.csv
mongoexport -d etenders -c tmp_tenders_summary --type=csv --fields tender_id,title,description,procuringEntity,status,procurementMethod,tender_start_date,tender_end_date --out tenders_csv.csv

 #db.tmp_agencies_summary.drop()
 #db.tmp_contractors_summary.drop()
 #db.tmp_contracts_summary.drop()
 #db.tmp_goods_summary.drop()
 #db.tmp_tenders_summary.drop()