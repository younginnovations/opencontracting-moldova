/* 
To run this script, run the following command in the cli
# mongo localhost:27017/etenders create_contractors_csv.js
*/
var start = new Date().getTime();
print("starting Execution for Contractors.");
db.tmp_contractors_summary.remove({})
var contractors = [];
db.ocds_release.find().forEach(function(release){
	release.awards.forEach(function(awards){
		if(typeof awards.suppliers !== 'undefined' && awards.suppliers.length){
			
			if(contractors.indexOf(awards.suppliers[0]['name']) == -1){

				contractors.push(awards.suppliers[0]['name']);
				var t = {
			        'name' : awards.suppliers[0]['name'],
			        'scheme' : awards.suppliers[0]['additionalIdentifiers'][0]['scheme']
				}
				db.tmp_contractors_summary.insert(t);    

			}
        }
           
	});      
});

var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);
print("finished Execution for Contractors");

//mongoexport -d etenders -c tmp_contractors_summary --type=csv --fields name,scheme --out contractors_csv.csv

