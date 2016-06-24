/* 
To run this script, run the following command in the cli
# mongo localhost:27017/etenders create_tender_csv.js
*/

db.tmp_tenders_summary.remove({})
db.ocds_release.find().forEach(function(release){
	
            var t = {
                    'tender_id'         : release.tender['id'],
                    'title'         	: release.tender['title'],
                    'description'    	: release.tender['description'],
                    'procuringEntity' 	: release.tender['procuringEntity']['name'],
                    'status'          	: release.tender['status'],
                    'procurementMethod'	: release.tender['procurementMethod'],
                    'tender_start_date'	: release.tender['tenderPeriod']['startDate'],
                    'tender_end_date' 	: release.tender['tenderPeriod']['endDate']
            }
            db.tmp_tenders_summary.insert(t);            
       
});

// mongoexport -d etenders -c tmp_tenders_summary --type=csv --fields tender_id,title,description,procuringEntity,status,procurementMethod,tender_start_date,tender_end_date --out output.csv
// db.tmp_tenders_summary.drop();