db.adminCommand({"setParameter": 1, "internalQueryExecMaxBlockingSortBytes": 134217728});

var startDate = new Date(String(year));
var endDate = new Date(String(year + 1));

var releases = db.ocds_release.find({
    date: {"$gte": startDate, "$lt": endDate}
}).toArray();

var docs = {
    id: year,
    releases: releases
};

docs.publisher = {
    "scheme": null,
    "name": "Public Procurement Agency",
    "uri": "https://tender.gov.md",
    "uid": null
};

docs.uri = url + year;
docs.publishedDate = "2016-11-07T00:00:00.00Z";


    docs.releases.forEach(function (doc, key) {
        delete(doc._id);
        var id = (doc.tender.id.toString()).replace(/NumberLong\(([\d]*)\)/g, "$1");
        docs.releases[key].tender.id = id;
        doc.contracts.forEach(function (contract, elem) {
            docs.releases[key].contracts[elem].id = (contract.id.toString()).replace(/NumberLong\(([\d]*)\)/g, "$1");
        });
    });

    var d = (JSON.stringify(docs).replace(/ISODate\(([\d]*)\)/g, "$1"));
    var d = JSON.stringify(docs);
    printjson(JSON.parse(d));
