/* 
 To run this script, run the following command in the cli
 # mongo localhost:27017/etenders map_to_ocds.js
 */



//remove ocds_release collection
db.ocds_release.remove({});
// var bulk = db.ocds_release.initializeUnorderedBulkOp();

db.tender_items_collection.createIndex({"fkTenderDataId": 1});
db.contracts_collection.createIndex({"tender.id": 1});
var start = new Date().getTime();
print("starting Execution");
db.tenders_collection.find({}).forEach(function (tender) {

    //change date to UTC date format
    var changeToISO = function (dt) {
        try {
            if (dt !== '') {
                var newDt = dt.split('.');
                var tm = newDt[2].split(' ');

                if (tm.length > 1) {
                    newDt = tm[0] + '-' + newDt[1] + '-' + newDt[0] + 'T' + tm[1] + ':00Z';
                } else {
                    newDt = newDt[2] + '-' + newDt[1] + '-' + newDt[0];
                }

                var isoDate = new Date(newDt).toISOString();
                return new Date(isoDate);
            }
        } catch (err) {
        }

        return dt;

    };

    var planningObj = {
        "budget": {
        },
        "documents": [
            // {
            //     "id": "",
            //     "title": "",
            //     "url": "",
            //     "datePublished": "",
            //     "format": ""
            // }
        ]
    };

    //prepare tender object
    var items = [];

    db.tender_items_collection.find({"fkTenderDataId": tender.tenderData.id}).forEach(function (item) {
        var itm = {
            "id": item.id,
            "description": item.goodsName + " " + item.description,
            "classification": {
                "scheme": "CPV",
                "id": item.goods.code,
                "description": item.goods.mdValue
            },
            "additionalClassifications": [],
            "quantity": parseInt(item.quantity),
            "unit": {"name": item.unitMeasure.mdValue}
        };

        items.push(itm);
    });

    var procuringAgency = {
        "identifier": {
            "scheme": "State Registration Chambers",
            "id": tender.stateOrg.code,
            "legalName": tender.stateOrg.orgName
        },
        "additionalIdentifiers": [{
            "scheme": "eTenders",
            "id": tender.stateOrg.id,
            "legalName": tender.stateOrg.orgName
        }],
        "name": tender.stateOrg.orgName,
        "address": {
            "streetAddress": tender.stateOrg.address,
            "locality": ""
        },
        "contactPoint": {
            "name": tender.stateOrg.orgName,
            "email": tender.stateOrg.email,
            "telephone": tender.stateOrg.phone,
            "faxNumber": tender.stateOrg.fax
        }
    };

    var tenderers = [];
    tender.tenderers.forEach(function (tenderer) {
        var tdr = {
            "identifier": {
                "id": tenderer.id,
                "legalName": tenderer.fullName
            },
            "additionalIdentifiers": [{
                "scheme": "eTenders",
                "id": "",
                "legalName": ""
            }],
            "name": "",
            "address": {
                "streetAddress": tenderer.cAddress
            },
            contactPoint: {
                "name": tenderer.director,
                "email": tenderer.email,
                "telephone": tenderer.phone,
                "faxNumber": tenderer.fax
            }
        }

        tenderers.push(tdr);
    });

    var documents = [];
    tender.documents.forEach(function (document) {
        var doc = {
            "id": document.id,
            "title": document.docName,
            "url": document.url,
            "datePublished": changeToISO(document.currentStatusDate),
            "format": document.fileName
        };

        documents.push(doc);
    });

    var tenderObj = {
        "id": NumberLong(tender.id),
        "title": "Tender Ref " + tender.regNumber + " Bulletin " + tender.bulletin.bulletinNumb,
        "description": "",
        "status": tender.tenderStatus.mdValue,
        "items": items,
        // "value": {
        //     "amount": "",
        //     "currency": ""
        // },
        "procurementMethod": tender.tenderType.mdValue,
        "procurementMethodRationale": "",
        "awardCriteria": "",
        "awardCriteriaDetails": "",
        "submissionMethod": ["written"],
        "submissionMethodDetails": "",
        "tenderPeriod": {
            "startDate": changeToISO(tender.bulletin.publDate),
            "endDate": changeToISO(tender.tenderData.openDateTime)
        },
        "eligibilityCriteria": "",
        "numberOfTenderers": tenderers.length,
        "tenderers": tenderers,
        "procuringEntity": procuringAgency,
        "documents": documents,
        // "milestones": [{
        //     "documents": []
        // }],
        "amendment": {
            "changes": []
        }
    };

    var awardArray = [];
    var contractArray = [];
    db.contracts_collection.find({"tender.id": tender.id}).forEach(function (contract) {

        var awardItems = [];
        contract.winningPositions.forEach(function (item) {
            var itm = {
                "id": item.id,
                "description": item.offerPosition.goodsName + " " + item.description,
                "classification": {
                    "scheme": "CPV",
                    "id": item.offerPosition.goods.code,
                    "description": item.offerPosition.goods.mdValue
                },
                "additionalClassifications": [],
                "quantity": item.offerPosition.quantityAwarded,
                "unit": {
                    "name": item.offerPosition.unitMeasure.mdValue,
                    // "value": {
                    //     "amount": "",
                    //     "currency": ""
                    // }
                }
            };

            awardItems.push(itm);
        });

        var award = {
            "id": "award-" + NumberLong(contract.id),
            "title": "Award for " + contract.tender.tenderData.goodsDescr,
            "description": "",
            "status": "",
            "date": changeToISO(contract.contractDate),
            "value": {
                "amount": contract.amount,
                "currency": "mdl"
            },
            "suppliers": [{
                "identifier": {
                    "id": contract.participant.id,
                    "legalName": contract.participant.fullName
                },
                "additionalIdentifiers": [{
                    "scheme": "eTenders",
                    "id": contract.participant.id,
                    "legalName": contract.participant.fullName
                }],
                "name": contract.participant.fullName,
                "address": {
                    "streetAddress": contract.participant.address
                },
                "contactPoint": {
                    "name": contract.participant.director,
                    "email": contract.participant.email,
                    "telephone": contract.participant.phone
                }
            }],
            "items": [],
            "contractPeriod": {
                "startDate": changeToISO(contract.contractDate),
                "endDate": changeToISO(contract.finalDate)
            },
            // "documents": [{
            //     "id": "",
            //     "title": "",
            //     "url": "",
            //     "datePublished": ""
            // }]
        };
        if (contract.goods) {
            award["items"] = [{
                "id": contract.goods.id,
                "description": "",
                "classification": {
                    "scheme": "CPV",
                    "id": contract.goods.code,
                    "description": contract.goods.mdValue
                },
                // "quantity": "",
                // "unit": {
                //     "name": "",
                    // "value": {
                    //     "amount": "",
                    //     "currency": ""
                    // }
                // }
            }];
        }
        awardArray.push(award);

        // var contractItems = [];
        // contract.winningPositions.forEach(function (item) {
        //     var itm = {
        //         "id": item.id,
        //         "description": item.offerPosition.goodsName + " " + item.description,
        //         "classification": {
        //             "scheme": "CPV",
        //             "id": item.offerPosition.goods.code,
        //             "description": item.offerPosition.goods.mdValue
        //         },
        //         "additionalClassifications": [],
        //         "quantity": parseInt(item.offerPosition.quantityAwarded),
        //         "unit": {
        //             "name": item.offerPosition.unitMeasure.mdValue,
        //             // "value": {
        //             //     "amount": "",
        //             //     "currency": ""
        //             // }
        //         }
        //     };
        //
        //     contractItems.push(itm);
        // });

        var contractItem = {
            "id": NumberLong(contract.id),
            "awardID": award.id,
            "title": contract.contractNumber + " " + contract.tender.tenderData.goodsDescr,
            "description": "",
            "status": contract.status.mdValue,
            "period": {
                "startDate": changeToISO(contract.contractDate),
                "endDate": changeToISO(contract.finalDate)
            },
            "value": {
                "amount": contract.amount,
                "currency": "mdl"
            },
            "dateSigned": changeToISO(contract.contractDate),
            // "items": contractItems
            // "documents": [
                // {
                //     "id": "",
                //     "title": "",
                //     "url": "",
                //     "datePublished": ""
                // }
            // ],
            // "amendments": [
                // {
                //     "date": '',
                //     "rationale": '',
                //     "id": '',
                //     "amendsReleaseID": '',
                //     "releaseID": '',
                //     "changes": []
                // }
            // ],
            // "implementation": {
            //     "documents": [
                    // {
                    //     "id": "",
                    //     "title": "",
                    //     "url": "",
                    //     "datePublished": ""
                    // }
                // ]
            // }
        };
        contractArray.push(contractItem);
    });

    db.ocds_release.insert({
        "ocid": "ocds-ngfbwp-" + tender.id,
        "date": tenderObj.tenderPeriod.startDate,
        "id": (tender.id).toString(),
        "tag": ['tender', 'award', 'contract'],
        "initiationType": "tender",
        "planning": planningObj,
        "tender": tenderObj,
        "awards": awardArray,
        "contracts": contractArray,
        "buyer": procuringAgency,
        "language": "md"
    });
});
var end = new Date().getTime();
var time = end - start;
print("Execution Time (seconds) ", time / 1000);

// mongodump --db etenders --collection ocds_release
