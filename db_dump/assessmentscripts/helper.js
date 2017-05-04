//Function to print row lines with comma for csv file
var printCsvRow = function() {
    var args = []
    for(var i=0;i<arguments.length;i++) {
        var arg = arguments[i];
        if(typeof arg == "string" && arg.indexOf(',')>-1) {
            arg = '"' + arg.replace(/"/g, "'") + '"'
        }
        args.push(arg);
    }
    print(args);
}

var printCsvArrayRow = function(arr) {
    var args = []
    for(var i=0;i<arr.length;i++) {
        var arg = arr[i];
        if(typeof arg == "string" && arg.indexOf(',')>-1) {
            arg = '"' + arg.replace(/"/g, "'") + '"'
        }
        args.push(arg);
    }
    print(args);
}

var printBlankRow = function() {
    print(" ");
}
//end

var get_years = function() {
    return db.tmp_summary_awards.distinct("contract_start_year").sort();
}

var get_total_contracts_value = function() {
    var obj = db.tmp_summary_awards.aggregate([ 
        { $group: { _id: null, total_value: { $sum: "$value" }}}
    ]);    
    return (obj.toArray()[0]["total_value"]);
}

var get_total_procuring_entiries = function() {
    return db.tmp_summary_awards.distinct("procuring_entity").length;
}

var get_total_procuring_entiries_based_on_tenders = function() {
    return db.tmp_summary_tenders.distinct("procuring_entity").length;
}

var get_total_suppliers = function() {
    return db.tmp_summary_awards.distinct("supplier_name").length;
}

var get_total_goods = function() {
    return db.tmp_summary_awards.distinct("good_description").length;
}

// gives summary of both contracts and tenders by year 
var summarise_by_year = function(agency_name = false) {
    var summary = {}

    var query_contract_obj = [];
    if(agency_name) {
        query_contract_obj.push({"$match": {"procuring_entity": agency_name}});
    }
    query_contract_obj.push({"$group": {"_id": {"year": "$contract_start_year"}, "count_contracts": {"$sum":1 }, "total_value":{"$sum":"$value"}}});
    query_contract_obj.push({"$sort": {"_id":1}});

    var groupby_years = db.tmp_summary_awards.aggregate(query_contract_obj);
    
    groupby_years.forEach(function(obj) {
        summary[obj._id.year] = {"count_contracts":obj.count_contracts, "total_value":obj.total_value}
    });

    var query_tender_obj = [];
    if(agency_name) {
        query_tender_obj.push({"$match": {"procuring_entity": agency_name}});
    }
    query_tender_obj.push({"$group": {"_id": {"year": "$tender_start_year"}, "count_tenders": {"$sum":1 }}});
    query_tender_obj.push({"$sort": {"_id":1}});

    var groupby_years = db.tmp_summary_tenders.aggregate(query_tender_obj);

    groupby_years.forEach(function(obj) {
        summary[obj._id.year]["count_tenders"] = obj.count_tenders;
    })
    printCsvRow("Year", "Tenders", "Contracts", "Contracts Value");
    for(year in summary) {
        printCsvRow(year, summary[year]["count_tenders"], summary[year]["count_contracts"], summary[year]["total_value"]);
    }    
}

var summarize_by_supplier_contract_count = function(year, agency_name = false) {
    var query_count_obj = [];
    if(agency_name) {
        query_count_obj.push({"$match": {contract_start_year: year, "procuring_entity": agency_name}});
    } else {
        query_count_obj.push({"$match": {contract_start_year: year}});
    }
    query_count_obj.push({"$group": {_id:{year:"$contract_start_year", supplier_name:"$supplier_name"},count:{$sum:1}}});
    query_count_obj.push({"$sort":{"count":-1}});
    query_count_obj.push({"$limit":5});

    var agg_by_count = db.tmp_summary_awards.aggregate(query_count_obj);

    printCsvRow("Supplier", "Total Contracts");
    agg_by_count.forEach(function(obj){
        printCsvRow(obj._id.supplier_name, obj.count)
    });
}

var summarize_by_supplier_contract_value = function(year, agency_name = false) {
    var query_total_obj = [];
    if(agency_name) {
        query_total_obj.push({"$match": {contract_start_year: year, "procuring_entity": agency_name}});
    } else {
        query_total_obj.push({"$match": {contract_start_year: year}});
    }
    query_total_obj.push({"$group": {_id:{year:"$contract_start_year", supplier_name:"$supplier_name"},total:{$sum:"$value"}}});
    query_total_obj.push({"$sort":{"total":-1}});
    query_total_obj.push({"$limit":5});

    var agg_by_value = db.tmp_summary_awards.aggregate(query_total_obj);
    printCsvRow("Supplier", "Total Contracts Value");
    agg_by_value.forEach(function(obj){
        printCsvRow(obj._id.supplier_name, obj.total)
    });
}

var summarize_by_procuring_entity_contract_count = function(year) {
    var query_count_obj = [];
    query_count_obj.push({"$match": {contract_start_year: year}});
    query_count_obj.push({"$group": {_id:{year:"$contract_start_year", procuring_entity:"$procuring_entity"},count:{$sum:1}}});
    query_count_obj.push({"$sort":{"count":-1}});
    query_count_obj.push({"$limit":5});

    var agg_by_count = db.tmp_summary_awards.aggregate(query_count_obj);

    printCsvRow("Procuring Entity", "Total Contracts");
    agg_by_count.forEach(function(obj){
        printCsvRow(obj._id.procuring_entity, obj.count)
    });
}

var summarize_by_procuring_entity_contract_value = function(year) {
    var query_total_obj = [];
    query_total_obj.push({"$match": {contract_start_year: year}});
    query_total_obj.push({"$group": {_id:{year:"$contract_start_year", procuring_entity:"$procuring_entity"},total:{$sum:"$value"}}});
    query_total_obj.push({"$sort":{"total":-1}});
    query_total_obj.push({"$limit":5});

    var agg_by_value = db.tmp_summary_awards.aggregate(query_total_obj);
    printCsvRow("Procuring Entity", "Total Contracts Value");
    agg_by_value.forEach(function(obj){
        printCsvRow(obj._id.procuring_entity, obj.total)
    });
}

var summarize_by_goods_contract_count = function(year, agency_name = false) {
    var query_count_obj = [];
    if(agency_name) {
        query_count_obj.push({"$match": {contract_start_year: year, "procuring_entity": agency_name}});
    } else {
        query_count_obj.push({"$match": {contract_start_year: year}});
    }
    query_count_obj.push({"$group": {_id:{year:"$contract_start_year", good_description:"$good_description"},count:{$sum:1}}});
    query_count_obj.push({"$sort":{"count":-1}});
    query_count_obj.push({"$limit":5});

    var agg_by_count = db.tmp_summary_awards.aggregate(query_count_obj);

    printCsvRow("Goods", "Total Contracts");
    agg_by_count.forEach(function(obj){
        printCsvRow(obj._id.good_description, obj.count)
    });
}

var summarize_by_goods_contract_value = function(year, agency_name = false) {
    var query_total_obj = [];
    if(agency_name) {
        query_total_obj.push({"$match": {contract_start_year: year, "procuring_entity": agency_name}});
    } else {
        query_total_obj.push({"$match": {contract_start_year: year}});
    }
    query_total_obj.push({"$group": {_id:{year:"$contract_start_year", good_description:"$good_description"},total:{$sum:"$value"}}});
    query_total_obj.push({"$sort":{"total":-1}});
    query_total_obj.push({"$limit":5});

    var agg_by_value = db.tmp_summary_awards.aggregate(query_total_obj);
    printCsvRow("Goods", "Total Contracts Value");
    agg_by_value.forEach(function(obj){
        printCsvRow(obj._id.good_description, obj.total)
    });
}


////////////////////////////////////////////////////////////////////////////////
// start: to verify the random tenders and contracts from etenders site
////////////////////////////////////////////////////////////////////////////////

var get_random_ocds_tenders_ids = function() {
    var random_objs = []
    var ocds_objs = db.ocds_release.aggregate([{ $sample: { size: 10 } }])
    ocds_objs.forEach(function(obj){
        random_objs.push(obj.tender.id)
    });    

    return random_objs
}

var get_random_ocds_contracts_ids = function() {
    var random_objs = []
    var ocds_objs = db.ocds_release.aggregate([{ $sample: { size: 20 } }])
    var count = 0
    ocds_objs.forEach(function(obj){
        if(obj.contracts.length && count < 10) {
            random_objs.push(obj.contracts[0].id);
            count += 1
        }
    });
    return random_objs
}

var get_etender_tender_meta = function(tender_id) {
    var tender_data = {};
    var tender_fk_id = 0;
    db.tenders_collection.find({"id": tender_id}).forEach(function(tender) {
        tender_fk_id = tender.tenderData.id;
        tender_data = {
            id: tender.id,
            registration_number: tender.regNumber,
            bulletin_number: tender.bulletin.bulletinNumb,
            procuring_agency: tender.stateOrg.orgName,
            status: tender.tenderStatus.mdValue,
            procurement_method: tender.tenderType.mdValue,
            start_date: tender.bulletin.publDate,
            end_date: tender.tenderData.openDateTime,
            no_of_items: 0,
            items_cpv:""
        }
    });
    var item_data = []
    db.tender_items_collection.find({"fkTenderDataId": tender_fk_id}).forEach(function (item) {
        item_data.push(item.goods.code);
    });
    tender_data.no_of_items = item_data.length;  
    tender_data.items_cpv = item_data.join(";")    
    return tender_data;
}

var get_etender_contract_meta = function(contract_id) {
    var contract_data = {};
    db.contracts_collection.find({"id": contract_id}).forEach(function(contract) {
        contract_data = {
            id: contract.id,
            number: contract.contractNumber,
            amount: contract.amount,
            supplier_name: contract.participant.fullName,
            start_date: contract.contractDate,
            end_date: contract.finalDate,
            signed_date: contract.contractDate,
            status: contract.status.mdValue,
            good_name: contract.goods?contract.goods.mdValue:"" ,
            good_cpv: contract.goods?contract.goods.code:""
        }
    });
    return contract_data;
}

var get_random_etenders_tenders = function() {
    var tenders=[];
    var random_tenders = get_random_ocds_tenders_ids()
    random_tenders.forEach(function(tender_id) {
        tenders.push(get_etender_tender_meta(tender_id))
    });
    return tenders;
}

var get_random_etenders_contracts = function() {
    var contracts=[];
    var random_contracts = get_random_ocds_contracts_ids()
    random_contracts.forEach(function(contract_id) {
        contracts.push(get_etender_contract_meta(contract_id))
    })
    return contracts;
}

////////////////////////////////////////////////////////////////////////////////
// end: to verify the random tenders and contracts from etenders site
////////////////////////////////////////////////////////////////////////////////
