/* 
To run this script, run the following command in the cli
# mongo localhost:27017/etenders create_contracts_csv.js
*/
var start = new Date().getTime();
print("starting Execution")
db.tmp_contracts_summary.remove({})
db.ocds_release.find().forEach(function(release){
	release.contracts.forEach(function(contracts){

		var t = {
            'id'         	: contracts['id'],
            'title'         : contracts['title'],
            'description'   : contracts['description'],
            'status' 		: contracts['status'],
            'startDate'		: contracts['dateSigned'],
            'endDate' 		: contracts['period']['endDate'],
            'amount'		: contracts['value']['amount']
        }
		var awardID = contracts['awardID'];
		var myCursor = db.ocds_release.find({'awards.id':awardID},{'awards.suppliers' : 1, 'awards.items' : 1});
		var myDocument = myCursor.hasNext() ? myCursor.next() : null;
		
		if(myDocument['awards'].length){
			t.contractor = (myDocument['awards'][0]['suppliers'])?myDocument['awards'][0]['suppliers'][0]['name']:'-';
			t.goods = (typeof myDocument['awards'][0]['items'][0] !== 'undefined')?myDocument['awards'][0]['items'][0]['classification']['description']:'-';	
		}

        db.tmp_contracts_summary.insert(t);   
	});                 
       
});
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);

//mongoexport -d etenders -c tmp_contracts_summary --type=csv --fields id,title,description,status,goods,contractor,startDate,endDate,amount --out contracts_csv.csv
