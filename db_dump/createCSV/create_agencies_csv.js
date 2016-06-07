/* 
To run this script, run the following command in the cli
# mongo localhost:27017/etenders create_agencies_csv.js
*/
var start = new Date().getTime();
print("starting Execution")
db.tmp_agencies_summary.remove({})
var agencies = [];
db.ocds_release.find().forEach(function(release){

		if(agencies.indexOf(release.buyer.name) == -1){
				agencies.push(release.buyer.name);
				var t = {
			        'name'     : release.buyer.name,
			        'address'  : release.buyer.address.streetAddress,
			        'email'    : release.buyer.contactPoint.email,
			        'phone'    : release.buyer.contactPoint.telephone,
			        'url'      : (typeof release.buyer.contactPoint.url !== 'undefined')?release.buyer.contactPoint.url:'-'
				}
				db.tmp_agencies_summary.insert(t);  
			}  
	
});

var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);

//mongoexport -d etenders -c tmp_agencies_summary --type=csv --fields name,address,email,phone,url --out agencies_csv.csv

