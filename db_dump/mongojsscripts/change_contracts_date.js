/* 
 To run this script, run the following command in the cli
 # mongo localhost:27017/etenders change_contracts_date.js
 */
db.contracts_collection.find({}).forEach(function(contract){
    var changeToISO = function(dt){

        if(dt!==''){
            try {
                var newDt = dt.split('.');
            } catch (err) {
                return dt;
            }

            if(typeof newDt[2] !== 'undefined'){
                // print(newDt);
                var tm = newDt[2].split(' ');

                if(tm.length >1){
                    newDt=tm[0]+'-'+newDt[1]+'-'+newDt[0]+'T'+tm[1]+':00Z';
                }else{
                    newDt=newDt[2]+'-'+newDt[1]+'-'+newDt[0];
                }

                var isoDate = new Date(newDt).toISOString();
                return isoDate;
            }
        }

        return dt;

    }

    contract.contractDate = changeToISO(contract.contractDate);
    contract.finalDate    = changeToISO(contract.finalDate);
    contract.contractDate    = new Date(contract.contractDate);
    contract.finalDate    = new Date(contract.finalDate);
    // // printjson(contract);
    //    db.contracts_collection.insert(contract);

    db.contracts_collection.save(contract)
});
