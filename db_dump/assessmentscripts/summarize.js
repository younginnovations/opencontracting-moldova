/////////////////////////////////////////////////////////////////////
// prepares the summary from tmp_collection prepared from ocds_release collection - the source of all the analysis in the portl
/////////////////////////////////////////////////////////////////////

load("helper.js")

var years = get_years()

printCsvRow("Total Contracts Value: ", get_total_contracts_value());

/////////////////////////////////////////////////////////////////////
// summarise by year
/////////////////////////////////////////////////////////////////////

printBlankRow();
summarise_by_year()

/////////////////////////////////////////////////////////////////////
// Group by supplier
printBlankRow();
printCsvRow("Group by Procuring Entity");
printCsvRow("Count based on Contracts ", get_total_procuring_entiries());
printCsvRow("Count based on Tenders ", get_total_procuring_entiries_based_on_tenders());
/////////////////////////////////////////////////////////////////////

years.forEach(function(year) {
    printBlankRow();
    printCsvRow("Year", year);    
    printBlankRow();
    summarize_by_procuring_entity_contract_count(year);
    printBlankRow();
    summarize_by_procuring_entity_contract_value(year);
});

/////////////////////////////////////////////////////////////////////
// Group by supplier
printBlankRow();
printCsvRow("Group by Supplier");
printCsvRow("Count", get_total_suppliers());
/////////////////////////////////////////////////////////////////////

years.forEach(function(year) {
    printBlankRow();
    printCsvRow("Year", year);    
    printBlankRow();
    summarize_by_supplier_contract_count(year);
    printBlankRow();
    summarize_by_supplier_contract_value(year);
});

/////////////////////////////////////////////////////////////////////
// Group by goods
printBlankRow();
printCsvRow("Group by Goods & Services");
printCsvRow("Count", get_total_goods());
/////////////////////////////////////////////////////////////////////

years.forEach(function(year) {
    printBlankRow();
    printCsvRow("Year", year);    
    printBlankRow();
    summarize_by_goods_contract_count(year);
    printBlankRow();
    summarize_by_goods_contract_value(year);
});

/////////////////////////////////////////////////////////////////////
// Some random tenders and contracts for verification
printBlankRow();
var tenders = get_random_etenders_tenders()
var contracts = get_random_etenders_contracts()

printCsvRow("Random Tenders from eTenders.gov.md")
printCsvArrayRow(["id"].concat(tenders.map(function(tender) { return(tender.id)})))
printCsvArrayRow(["registration_number"].concat(tenders.map(function(tender) { return(tender.registration_number)})))
printCsvArrayRow(["bulletin_number"].concat(tenders.map(function(tender) { return(tender.bulletin_number)})))
printCsvArrayRow(["procuring_agency"].concat(tenders.map(function(tender) { return(tender.procuring_agency)})))
printCsvArrayRow(["status"].concat(tenders.map(function(tender) { return(tender.status)})))
printCsvArrayRow(["start_date"].concat(tenders.map(function(tender) { return(tender.start_date)})))
printCsvArrayRow(["end_date"].concat(tenders.map(function(tender) { return(tender.end_date)})))
printCsvArrayRow(["no_of_items"].concat(tenders.map(function(tender) { return(tender.no_of_items)})))
printCsvArrayRow(["items_cpv"].concat(tenders.map(function(tender) { return(tender.items_cpv)})))

printBlankRow()
printCsvRow("Random Contracts from eTenders.gov.md")
printCsvArrayRow(["id"].concat(contracts.map(function(contract) { return(contract.id)})))
printCsvArrayRow(["number"].concat(contracts.map(function(contract) { return(contract.number)})))
printCsvArrayRow(["amount"].concat(contracts.map(function(contract) { return(contract.amount)})))
printCsvArrayRow(["supplier_name"].concat(contracts.map(function(contract) { return(contract.supplier_name)})))
printCsvArrayRow(["start_date"].concat(contracts.map(function(contract) { return(contract.start_date)})))
printCsvArrayRow(["end_date"].concat(contracts.map(function(contract) { return(contract.end_date)})))
printCsvArrayRow(["signed_date"].concat(contracts.map(function(contract) { return(contract.signed_date)})))
printCsvArrayRow(["status"].concat(contracts.map(function(contract) { return(contract.status)})))
printCsvArrayRow(["good_name"].concat(contracts.map(function(contract) { return(contract.good_name)})))
printCsvArrayRow(["good_cpv"].concat(contracts.map(function(contract) { return(contract.good_cpv)})))
/////////////////////////////////////////////////////////////////////


