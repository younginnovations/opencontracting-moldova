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
            "tender": "$tender",
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

    // // var d = (JSON.stringify(docs).replace(/ISODate\(([\d]*)\)/g,"$1"));
    var d = JSON.stringify(docs);
    d = (d.replace(/NumberLong\(([\d]*)\)/g,"$1"));

    printjson(JSON.parse(d));

    // printjson(docs);
});

//printjson(cursor);
