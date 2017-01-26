/* 
 To run this script, run the following command in the cli
 # mongo localhost:27017/etenders create_contracts_csv.js
 */
var start = new Date().getTime();
print("starting Execution for Contracts");
db.tmp_contracts_summary.remove({});
db.ocds_release.find().forEach(function (release) {
    release.contracts.forEach(function (contracts) {
        /*Contract Id,Title,Description,Status,Tender Id,Tender Title,Goods,Goods CPV,Contractor Id,contractor,Procuring Agency id,Procuring Agency,Contract Start Date,Contract End Date,Amount*/
        var t = {
            'id'                : contracts['id'],
            'title'             : contracts['title'],
            'description'       : contracts['description'],
            'status'            : contracts['status'],
            'tenderID'          : release['tender']['id'],
            'tenderTitle'       : release['tender']['title'],
            'procuringAgencyID' : release['buyer']['identifier']['id'],
            'procuringAgency'   : release['buyer']['name'],
            'contractStartDate' : contracts['dateSigned'],
            'contractEndDate'   : contracts['period']['endDate'],
            'amount'            : contracts['value']['amount']
        };
        var awardID     = contracts['awardID'];
        var myCursor    = db.ocds_release.find({'awards.id': awardID}, {'awards.suppliers': 1, 'awards.items': 1});
        var myDocument  = myCursor.hasNext() ? myCursor.next() : null;

        if (myDocument['awards'].length) {
            t.contractorID  = (myDocument['awards'][0]['suppliers']) ? myDocument['awards'][0]['suppliers'][0]['additionalIdentifiers'][0]['id'] : '-';
            t.contractor    = (myDocument['awards'][0]['suppliers']) ? myDocument['awards'][0]['suppliers'][0]['name'] : '-';
            t.goods         = (typeof myDocument['awards'][0]['items'][0] !== 'undefined') ? myDocument['awards'][0]['items'][0]['classification']['description'] : '-';
            t.goodsCPV      = (typeof myDocument['awards'][0]['items'][0] !== 'undefined') ? myDocument['awards'][0]['items'][0]['classification']['scheme'] : '-';
        }

        db.tmp_contracts_summary.insert(t);
    });

});
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time / 1000);
print("finished Execution for Contracts.");

//mongoexport -d etenders -c tmp_contracts_summary --type=csv --fields id,title,description,status,tenderID,tenderTitle,goods,goodsCPV,contractorID,contractor,procuringAgencyID,procuringAgency,contractStartDate,contractEndDate,amount --out /Users/owner/homesteadSites/moldova-ocds/public/csv/contracts_csv.csv
