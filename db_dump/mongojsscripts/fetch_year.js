var years = "";

var cursor = (db.ocds_release.aggregate([
            {
                $project: {
                    year: {$year: "$date"}
                }
            },
            {
                $group: {
                    "_id": "$year",
                    "count": {$sum: 1}
                }
            }
        ]
    ).forEach(function (doc) {
        years = years + " " + doc._id;
    })
);
print(years);