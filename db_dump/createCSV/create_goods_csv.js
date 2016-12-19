/* 
To run this script, run the following command in the cli
# mongo localhost:27017/etenders create_goods_csv.js
*/
var start = new Date().getTime();
print("starting Execution for Goods and Services")
db.tmp_goods_summary.remove({})
var goods = [];
db.ocds_release.find().forEach(function(release){
	release.awards.forEach(function(awards){
		if(typeof awards.items !== 'undefined' && awards.items.length){

			if(goods.indexOf(awards.items[0]['classification']['description']) == -1){
				goods.push(awards.items[0]['classification']['description']);
				var t = {
			        'id'          			: awards.items[0]['id'],
			        'goods_and_services'    : awards.items[0]['classification']['description'],
			        'scheme'    			: awards.items[0]['classification']['scheme'],
			        'cpv_code' 				: awards.items[0]['classification']['id']
				}
				db.tmp_goods_summary.insert(t);    
			}
        }
           
	});      
});

var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);
print("finished Execution for Goods and Services");

//mongoexport -d etenders -c tmp_goods_summary --type=csv --fields id,goods_and_services,scheme,cpv_code --out goods_csv.csv

