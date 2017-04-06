db.adminCommand({"setParameter": 1, "internalQueryExecMaxBlockingSortBytes": 134217728});


(db.ocds_release.aggregate([
    {
        "$project": {
            "year": {"$year": "$date"},
            "id": "$id",
            "ocid": "$ocid",
            "initiationType": "$initiationType",
            "date": "$date",
            "tag": "$tag",
            "tender": {
                "id": '$tender.id',
                // "title" : '$tender.title',
                // "description": '$tender.description',
                // "status": "$tender.status",
                // "items": "$tender.items",
                // "value": "$tender.value",
                // "procurementMethod": "$tender.procurementMethod",
                // "procurementMethodRationale" : "$tender.procurementMethodRationale",
                // "awardCriteria": "$tender.awardCriteria",
                // "awardCriteriaDetails": "$tender.awardCriteriaDetails",
                // "submissionMethod":"$tender.submissionMethod",
                // "submissionMethodDetails": "$tender.submissionMethodDetails",
                // "tenderPeriod": "$tender.tenderPeriod",
                // "eligibilityCriteria": "$tender.eligibilityCriteria",
                // "numberOfTenders": "$tender.numberOfTenders",
                // "tenderers": "$tender.tenderers",
                // "procuringEntity": "$tender.procuringEntity",
                // "documents" : "$tender.documents",
                // "milestones": "$tender.milestones",
                // "amendment": "$tender.amendment",
            },
            "awards": "$awards",
            "contracts": "$contracts",
            "buyer": "$buyer",
            "language": "$language"
        }
    },
    {
        $group: {
            "_id": {"year": "$year"},
            "releases": {
                $addToSet: {
                    "ocid": "$ocid",
                    "id": "$id",
                    "date": "$date",
                    "initiationType": "$initiationType",
                    "tag": "$tag",
                    "tender": "$tender",
                    "awards": "$awards",
                    'contracts': "$contracts",
                    "buyer": "$buyer",
                    "language": "$language"
                }
            },
            "count": {"$sum": 1}
        }
    },
    {
        $match: {
            "_id.year": year
        }
    }
], {
    allowDiskUse: true,
    cursor: {}
})).forEach(function (docs) {
    docs.publisher = {
        "scheme": null,
        "name": "Public Procurement Agency",
        "uri": "https://tender.gov.md",
        "uid": null
    };
    docs.uri = "http://moldova-demo.yipl.com.np/ocds-api/year/" + year;
    docs.publishedDate = "2016-11-07T00:00:00.00Z";


    docs.releases.forEach(function (doc, key) {
        var id = (doc.tender.id.toString()).replace(/NumberLong\(([\d]*)\)/g, "$1");
        var items = db.ocds_release.find({'tender.id': parseInt(id)}, {'tender': 1}).limit(1).toArray()[0];
        docs.releases[key].tender = items.tender;
        docs.releases[key].tender.id = id;
        doc.contracts.forEach(function (contract, elem) {
            docs.releases[key].contracts[elem].id = (contract.id.toString()).replace(/NumberLong\(([\d]*)\)/g, "$1");
        });
    });


    // // var d = (JSON.stringify(docs).replace(/ISODate\(([\d]*)\)/g,"$1"));
    var d = JSON.stringify(docs);

    printjson(JSON.parse(d));
    // printjson(docs);

});

