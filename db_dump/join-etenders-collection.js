/* 
To run this script, run the following command in the cli
# mongo localhost:27017/[dbname] join-etenders-collection.js
*/

//remove ocds_release collection
db.ocds_release.remove({})
// var bulk = db.ocds_release.initializeUnorderedBulkOp();

db.tender_items_collection.createIndex({"fkTenderDataId": 1});
db.contracts_collection.createIndex({"tender.id": 1});
var start = new Date().getTime();
print("starting Execution")
db.tenders_collection.find({}).forEach(function(tender){
    //prepare tendor object
    var items = []
    db.tender_items_collection.find({"fkTenderDataId": tender.tenderData.id}).forEach(function(item) {        
        items.push({
            "id": item.id,
            "description": item.goodsName + " " + item.description,
            "classification": {
                "scheme": "CPV",
                "id": item.goods.code,
                "description": item.goods.mdValue
            },
            "additionalClassifications": [],
            "quantity": item.quantity,
            "unit": {
                "name": item.unitMeasure.mdValue
            }
        });
    });

    var procuringAgency = {
        "identifier": {
            "scheme": "State Registration Chambers",
            "id": tender.stateOrg.code,
            "legalName": tender.stateOrg.orgName,
            "uri": ""
        },
        "additionalIdentifiers": {
            "scheme": "eTenders",
            "id": tender.stateOrg.id,
            "legalName": tender.stateOrg.orgName,
            "uri": ""
        },
        "name": tender.stateOrg.orgName,
        "address": {
            "streetAddress": tender.stateOrg.address,
            "locality":"",
        },
        "contactPoint": {
            "name": "",
            "email": tender.stateOrg.email,
            "telephone": tender.stateOrg.phone,
            "faxNumber": tender.stateOrg.fax,
            "url": ""
        }
    };

    var tenderObj = {
        "id": NumberLong(tender.id),
        "title": "Tender Ref " + tender.regNumber + " Bulletin " + tender.bulletin.bulletinNumb,
        "description": "",
        "status": tender.tenderStatus.mdValue,
        "procurementMethod": tender.tenderType.mdValue,
        "items": items,
        "minValue": {},
        "value": {},
        "procurementMethod":tender.tenderType.mdValue,
        "procurementMethodRationale":"",
        "awardCriteria":"",
        "awardCriteriaDetails":"",
        "submissionMethod": ["written"],
        "submissionMethodDetails":"",
        "tenderPeriod": {
            "startDate": tender.bulletin.publDate,
            "endDate": tender.tenderData.openDateTime
        },
        "enquiryPeriod": {},
        "hasEnquiries": "",
        "eligibilityCriteria": "",
        "awardPeriod": {},
        "numberOfTenderers": "",
        "tenderers": [],
        "procuringAgency": procuringAgency,
        "documents": [],
        "milestones": [],
        "amendment": {}
    };
    var awardArray = [];
    var contractArray = [];
    db.contracts_collection.find({"tender.id": tender.id}).forEach(function(contract){
        var award = {
            "id": "award-" + NumberLong(contract.id),
            "title": "Award for " + contract.tender.tenderData.goodsDescr,
            "description": "",
            "status": "",
            "date": "",
            "value": {
                "amount": contract.amount,
                "currency": "mdl"
            },
            "suppliers": [{
                "identifier": {},
                "additionalIdentifiers": [{
                    "scheme": "eTenders",
                    "id": contract.participant.id,
                    "legalName": contract.participant.fullName
                }], 
                "name": contract.participant.fullName,
            }],
            "items": [],
            "contractPeriod": {
                "startDate": contract.contractDate,
                "endDate": contract.finalDate
            },
            "documents": [],
            "amendment": {}
        };
        if(contract.goods) {
            award["items"] = [{
                "id": contract.goods.id,
                "description": "",
                "classification": {
                    "scheme": "CPV",
                    "id": contract.goods.code,
                    "description": contract.goods.mdValue
                },
                "quantity": "",
                "unit": {}
            }];
        }
        awardArray.push(award);

        var contract = {
            "id": NumberLong(contract.id),
            "awardID": award.id,
            "title": contract.contractNumber + " " + contract.tender.tenderData.goodsDescr,
            "description": "",
            "status": contract.status.mdValue,
            "period": {
                "startDate": "",
                "endDate": contract.finalDate
            },
            "value": {
                "amount": contract.amount,
                "currency": "mdl"
            },
            "items": {},
            "dateSigned": contract.contractDate,
            "documents": [],
            "amendment": {},
            "implementations": {}
        };
        contractArray.push(contract);
    });

    db.ocds_release.insert({
        "ocid": "test-ocid",
        "date": "",
        "id": NumberLong(tender.id),
        "initiationType": "tender",
        "tender": tenderObj,
        "award": awardArray,
        "contract": contractArray,
        "buyer": procuringAgency,
        "language": "md"
    });
});
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time/1000);