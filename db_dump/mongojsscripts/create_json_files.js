/**
 * Created by Biju on 31/1/17.
 */

db.adminCommand({"setParameter": 1, "internalQueryExecMaxBlockingSortBytes": 134217728});

(db.ocds_release.aggregate([
    {
        "$project": {
            "year": {"$year": "$date"},
            "ocid": "$ocid",
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
            "tenders": {
                $addToSet: {
                    "ocid": "$ocid",
                    "date": "$date",
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
})).forEach(function(docs){
    printjson(docs);
});

//printjson(cursor);
